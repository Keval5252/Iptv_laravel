<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $plans = SubscriptionPlan::active()->ordered()->get();
        $user = Auth::user();
        $activeSubscription = $user->getActiveSubscription();

        return view('user.subscriptions.index', compact('plans', 'activeSubscription'));
    }

    public function show(SubscriptionPlan $plan)
    {
        $user = Auth::user();
        $activeSubscription = $user->getActiveSubscription();

        return view('user.subscriptions.show', compact('plan', 'activeSubscription'));
    }

    public function createPaymentIntent(Request $request, SubscriptionPlan $plan)
    {
        $user = Auth::user();

        try {
            // Create or get Stripe customer
            if (!$user->stripe_customer_id) {
                $customerResponse = Http::withHeaders([
                    'Authorization' => 'Bearer ' . config('services.stripe.secret'),
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ])->post('https://api.stripe.com/v1/customers', [
                    'email' => $user->email,
                    'name' => $user->full_name,
                    'metadata[user_id]' => $user->id,
                ]);

                if ($customerResponse->successful()) {
                    $customer = $customerResponse->json();
                    $user->update(['stripe_customer_id' => $customer['id']]);
                } else {
                    throw new \Exception('Failed to create Stripe customer');
                }
            }

            // Create payment intent
            $paymentIntentResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.stripe.secret'),
                'Content-Type' => 'application/x-www-form-urlencoded',
            ])->post('https://api.stripe.com/v1/payment_intents', [
                'amount' => $plan->price * 100, // Convert to cents
                'currency' => 'usd',
                'customer' => $user->stripe_customer_id,
                'metadata[user_id]' => $user->id,
                'metadata[plan_id]' => $plan->id,
            ]);

            if ($paymentIntentResponse->successful()) {
                $paymentIntent = $paymentIntentResponse->json();
                return response()->json([
                    'status' => 'success',
                    'client_secret' => $paymentIntent['client_secret'],
                    'payment_intent_id' => $paymentIntent['id'],
                ]);
            } else {
                throw new \Exception('Failed to create payment intent');
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create payment intent: ' . $e->getMessage()
            ]);
        }
    }

    public function confirmPayment(Request $request, SubscriptionPlan $plan)
    {
        $request->validate([
            'payment_intent_id' => 'required|string',
        ]);

        $user = Auth::user();

        try {
            // Retrieve payment intent from Stripe
            $paymentIntentResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.stripe.secret'),
            ])->get('https://api.stripe.com/v1/payment_intents/' . $request->payment_intent_id);

            if (!$paymentIntentResponse->successful()) {
                throw new \Exception('Failed to retrieve payment intent');
            }

            $paymentIntent = $paymentIntentResponse->json();

            if ($paymentIntent['status'] === 'succeeded') {
                // Create user subscription
                $subscription = UserSubscription::create([
                    'user_id' => $user->id,
                    'subscription_plan_id' => $plan->id,
                    'stripe_payment_intent_id' => $paymentIntent['id'],
                    'status' => 'active',
                    'starts_at' => now(),
                    'ends_at' => now()->addMonths($this->getDurationInMonths($plan->duration)),
                    'amount_paid' => $plan->price,
                    'metadata' => [
                        'stripe_payment_intent' => $paymentIntent['id'],
                        'plan_name' => $plan->name,
                    ],
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Subscription activated successfully',
                    'subscription' => $subscription,
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Payment not completed'
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to confirm payment: ' . $e->getMessage()
            ]);
        }
    }

    public function cancel(Request $request)
    {
        $user = Auth::user();
        $subscription = $user->getActiveSubscription();

        if (!$subscription) {
            return response()->json([
                'status' => 'error',
                'message' => 'No active subscription found'
            ]);
        }

        try {
            $subscription->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Subscription cancelled successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to cancel subscription: ' . $e->getMessage()
            ]);
        }
    }

    private function getDurationInMonths($duration)
    {
        switch (strtolower($duration)) {
            case '1 month':
            case 'monthly':
                return 1;
            case '3 months':
            case 'quarterly':
                return 3;
            case '6 months':
            case 'semi-annually':
                return 6;
            case '12 months':
            case 'yearly':
            case 'annual':
                return 12;
            default:
                return 1;
        }
    }
}
