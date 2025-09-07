<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use App\Models\StripePayment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Customer;
use Stripe\Subscription;
use Stripe\Exception\ApiErrorException;

class StripeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function createPaymentIntent(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
        ]);

        $plan = SubscriptionPlan::findOrFail($request->plan_id);
        $user = Auth::user();

        try {
            // Create or retrieve Stripe customer
            $customer = $this->getOrCreateCustomer($user);

            // Create payment intent
            $paymentIntent = PaymentIntent::create([
                'amount' => (int)($plan->price * 100), // Convert to cents
                'currency' => 'usd',
                'customer' => $customer->id,
                'metadata' => [
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'plan_name' => $plan->name,
                ],
            ]);

            // Create payment record
            StripePayment::create([
                'user_id' => $user->id,
                'subscription_plan_id' => $plan->id,
                'stripe_payment_intent_id' => $paymentIntent->id,
                'stripe_customer_id' => $customer->id,
                'amount' => $plan->price,
                'currency' => 'usd',
                'status' => 'pending',
                'metadata' => [
                    'plan_name' => $plan->name,
                    'plan_duration' => $plan->duration,
                ],
            ]);

            return response()->json([
                'client_secret' => $paymentIntent->client_secret,
                'payment_intent_id' => $paymentIntent->id,
            ]);

        } catch (ApiErrorException $e) {
            Log::error('Stripe payment intent creation failed: ' . $e->getMessage());
            return response()->json(['error' => 'Payment setup failed'], 500);
        }
    }

    public function confirmPayment(Request $request)
    {
        $request->validate([
            'payment_intent_id' => 'required|string',
        ]);

        $payment = StripePayment::where('stripe_payment_intent_id', $request->payment_intent_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        try {
            $paymentIntent = PaymentIntent::retrieve($request->payment_intent_id);
            
            if ($paymentIntent->status === 'succeeded') {
                // Update payment status
                $payment->update([
                    'status' => 'succeeded',
                    'paid_at' => now(),
                ]);

                // Create or update user subscription
                $this->createUserSubscription($payment);

                return response()->json(['success' => true, 'message' => 'Payment successful']);
            } else {
                $payment->update(['status' => 'failed']);
                return response()->json(['error' => 'Payment failed'], 400);
            }

        } catch (ApiErrorException $e) {
            Log::error('Stripe payment confirmation failed: ' . $e->getMessage());
            return response()->json(['error' => 'Payment confirmation failed'], 500);
        }
    }

    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\Exception $e) {
            Log::error('Webhook signature verification failed: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        switch ($event->type) {
            case 'payment_intent.succeeded':
                $this->handlePaymentSucceeded($event->data->object);
                break;
            case 'payment_intent.payment_failed':
                $this->handlePaymentFailed($event->data->object);
                break;
            case 'customer.subscription.deleted':
            case "customer.subscription.updated":
                $this->handleSubscriptionUpdated($event->data->object);
                break;
                $this->handleSubscriptionDeleted($event->data->object);
                break;
        }

        return response()->json(['status' => 'success']);
    }

    private function getOrCreateCustomer(User $user)
    {
        if ($user->stripe_customer_id) {
            try {
                return Customer::retrieve($user->stripe_customer_id);
            } catch (ApiErrorException $e) {
                // Customer not found, create new one
            }
        }

        $customer = Customer::create([
            'email' => $user->email,
            'name' => $user->full_name,
            'metadata' => [
                'user_id' => $user->id,
            ],
        ]);

        $user->update(['stripe_customer_id' => $customer->id]);
        return $customer;
    }

    private function createUserSubscription(StripePayment $payment)
    {
        $plan = $payment->subscriptionPlan;
        $user = $payment->user;

        // Calculate subscription dates
        $startDate = now();
        $endDate = $this->calculateEndDate($startDate, $plan->duration);

        // Create user subscription
        UserSubscription::create([
            'user_id' => $user->id,
            'subscription_plan_id' => $plan->id,
            'stripe_customer_id' => $payment->stripe_customer_id,
            'status' => 'active',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'amount_paid' => $payment->amount,
            'currency' => $payment->currency,
            'metadata' => [
                'payment_id' => $payment->id,
                'plan_name' => $plan->name,
                'plan_duration' => $plan->duration,
            ],
        ]);
    }

    private function calculateEndDate($startDate, $duration)
    {
        switch ($duration) {
            case 'monthly':
                return $startDate->addMonth();
            case 'yearly':
                return $startDate->addYear();
            case 'weekly':
                return $startDate->addWeek();
            default:
                return $startDate->addMonth();
        }
    }

    private function handlePaymentSucceeded($paymentIntent)
    {
        $payment = StripePayment::where('stripe_payment_intent_id', $paymentIntent->id)->first();
        
        if ($payment) {
            $payment->update([
                'status' => 'succeeded',
                'paid_at' => now(),
            ]);

            $this->createUserSubscription($payment);
        }
    }

    private function handlePaymentFailed($paymentIntent)
    {
        $payment = StripePayment::where('stripe_payment_intent_id', $paymentIntent->id)->first();
        
        if ($payment) {
            $payment->update(['status' => 'failed']);
        }
    }

    private function handleSubscriptionDeleted($subscription)
    {
        $userSubscription = UserSubscription::where('stripe_subscription_id', $subscription->id)->first();
        
        if ($userSubscription) {
            $userSubscription->update([
                'status' => 'cancelled',
                'end_date' => now(),
            ]);
        }
    }

    private function handleSubscriptionUpdated($subscription)
    {
        $userSubscription = UserSubscription::where("stripe_subscription_id", $subscription->id)->first();
        
        if ($userSubscription && $subscription->status === "active") {
            // Update subscription status
            $userSubscription->update([
                "status" => "active",
            ]);
            
            // Update any pending payments for this subscription
            StripePayment::where("stripe_subscription_id", $subscription->id)
                ->where("status", "pending")
                ->update([
                    "status" => "succeeded",
                    "paid_at" => now(),
                ]);
        }
    }
    }
