<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use App\Models\StripePayment;
use App\Models\User;
use App\Services\StripeCustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Subscription;
use Stripe\Exception\ApiErrorException;

class StripeSubscriptionController extends Controller
{
    protected $stripeCustomerService;

    public function __construct(StripeCustomerService $stripeCustomerService)
    {
        $this->middleware('auth');
        $this->stripeCustomerService = $stripeCustomerService;
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Create a Stripe subscription for a plan
     */
    public function createSubscription(Request $request, SubscriptionPlan $plan)
    {
        $user = Auth::user();
        
        if (!$plan->is_active || !$plan->stripe_plan_id) {
            return redirect()->route('subscription.plans')
                ->with('error', 'This plan is not available for subscription.');
        }
        
        // Check if user already has an active subscription
        if ($user->hasActiveSubscription()) {
            return redirect()->route('subscription.plans')
                ->with('warning', 'You already have an active subscription.');
        }

        try {
            // Get or create Stripe customer using the service
            $customerId = $this->stripeCustomerService->getOrCreateStripeCustomer($user);

            // Create Stripe subscription using direct API call to avoid library issues
            $subscriptionData = $this->createStripeSubscriptionDirectly($customerId, $plan, $user);

            // Create local subscription record
            $userSubscription = UserSubscription::create([
                'user_id' => $user->id,
                'subscription_plan_id' => $plan->id,
                'stripe_subscription_id' => $subscriptionData['subscription_id'],
                'status' => 'pending',
                'start_date' => now(),
                'end_date' => $this->calculateEndDate($plan),
                'amount_paid' => $plan->price,
                'currency' => 'usd',
            ]);

            // Create payment record
            StripePayment::create([
                'user_id' => $user->id,
                'subscription_plan_id' => $plan->id,
                'stripe_payment_intent_id' => $subscriptionData['payment_intent_id'],
                'stripe_customer_id' => $customerId,
                'stripe_subscription_id' => $subscriptionData['subscription_id'],
                'amount' => $plan->price,
                'currency' => 'usd',
                'status' => 'pending',
                'metadata' => [
                    'plan_name' => $plan->name,
                    'plan_duration' => $plan->duration,
                ],
            ]);

            return response()->json([
                'subscription_id' => $subscriptionData['subscription_id'],
                'client_secret' => $subscriptionData['client_secret'],
            ]);

        } catch (\Exception $e) {
            Log::error('Stripe subscription creation failed: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json(['error' => 'Subscription setup failed'], 500);
        }
    }

    /**
     * Create Stripe subscription using direct API call
     */
    private function createStripeSubscriptionDirectly(string $customerId, SubscriptionPlan $plan, User $user): array
    {
        $stripeSecret = config('services.stripe.secret');
        if (!$stripeSecret) {
            throw new \Exception('Stripe secret key not configured');
        }

        $url = "https://api.stripe.com/v1/subscriptions";
        
        $postData = http_build_query([
            'customer' => $customerId,
            'items[0][price]' => $plan->stripe_plan_id,
            'payment_behavior' => 'default_incomplete',
            'payment_settings[save_default_payment_method]' => 'on_subscription',
            'expand[0]' => 'latest_invoice.payment_intent',
            'metadata[user_id]' => $user->id,
            'metadata[plan_id]' => $plan->id,
            'metadata[plan_name]' => $plan->name,
        ]);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_USERPWD, $stripeSecret . ':');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new \Exception("cURL error: {$error}");
        }

        if ($httpCode >= 400) {
            $responseData = json_decode($response, true);
            $errorMessage = $responseData['error']['message'] ?? 'Unknown error';
            throw new \Exception("Stripe API error ({$httpCode}): {$errorMessage}");
        }

        $responseData = json_decode($response, true);
        
        if (!isset($responseData['id'])) {
            throw new \Exception("Failed to get subscription ID from Stripe response");
        }

        Log::info("Stripe subscription created successfully via direct API call", [
            'subscription_id' => $responseData['id'],
            'customer_id' => $customerId,
            'plan_id' => $plan->id,
            'http_code' => $httpCode,
        ]);

        return [
            'subscription_id' => $responseData['id'],
            'client_secret' => $responseData['latest_invoice']['payment_intent']['client_secret'],
            'payment_intent_id' => $responseData['latest_invoice']['payment_intent']['id'],
        ];
    }

    /**
     * Handle successful subscription payment
     */
    public function confirmSubscription(Request $request)
    {
        try {
            // Get subscription_id from query parameter
            $subscriptionId = $request->query('subscription_id');
            
            if (!$subscriptionId) {
                return redirect()->route('subscription.plans')
                    ->with('error', 'No subscription ID provided.');
            }

            // Get the user
            $user = Auth::user();
            
            // Find the user subscription by plan ID (since we're passing plan ID as subscription_id)
            $userSubscription = UserSubscription::where('user_id', $user->id)
                ->where('subscription_plan_id', $subscriptionId)
                ->where('status', 'pending')
                ->first();
            
            if (!$userSubscription) {
                return redirect()->route('subscription.plans')
                    ->with('error', 'No pending subscription found.');
            }

            // Retrieve the Stripe subscription
            $stripeSubscription = Subscription::retrieve($userSubscription->stripe_subscription_id);
            
            Log::info('Subscription confirmation check', [
                'subscription_id' => $stripeSubscription->id,
                'status' => $stripeSubscription->status,
                'latest_invoice_status' => $stripeSubscription->latest_invoice->status ?? 'unknown'
            ]);
            
            if ($stripeSubscription->status === "active") {
                // Update local subscription
                $userSubscription->update([
                    "status" => "active",
                    "stripe_subscription_id" => $stripeSubscription->id,
                ]);

                // Update payment status to succeeded
                StripePayment::where("user_id", $user->id)
                    ->where("subscription_plan_id", $userSubscription->subscription_plan_id)
                    ->where("status", "pending")
                    ->update([
                        "status" => "succeeded",
                        "paid_at" => now(),
                    ]);

                return redirect()->route("subscription.dashboard")
                    ->with("success", "Your subscription has been activated successfully!");
            } else {
                // Update status based on Stripe status
                $userSubscription->update([
                    'status' => $stripeSubscription->status,
                ]);
                
                return redirect()->route('subscription.plans')
                    ->with('error', 'Subscription payment was not successful. Status: ' . $stripeSubscription->status);
            }

        } catch (ApiErrorException $e) {
            Log::error('Stripe subscription confirmation failed: ' . $e->getMessage());
            return redirect()->route('subscription.plans')
                ->with('error', 'Failed to confirm subscription: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Subscription confirmation error: ' . $e->getMessage());
            return redirect()->route('subscription.plans')
                ->with('error', 'An error occurred while confirming your subscription.');
        }
    }

    /**
     * Cancel a Stripe subscription
     */
    public function cancelSubscription(Request $request)
    {
        $user = Auth::user();
        $subscription = $user->activeSubscription;
        
        if (!$subscription) {
            return redirect()->route('subscription.dashboard')
                ->with('error', 'No active subscription found.');
        }

        try {
            $stripeSubscription = Subscription::retrieve($subscription->stripe_subscription_id);
            $stripeSubscription->cancel();
            
            $subscription->update(['status' => 'cancelled']);
            
            return redirect()->route('subscription.dashboard')
                ->with('success', 'Your subscription has been cancelled successfully.');
                
        } catch (ApiErrorException $e) {
            Log::error('Stripe subscription cancellation failed: ' . $e->getMessage());
            return redirect()->route('subscription.dashboard')
                ->with('error', 'Failed to cancel subscription.');
        }
    }

    /**
     * Calculate subscription end date based on plan duration
     */
    private function calculateEndDate(SubscriptionPlan $plan): \Carbon\Carbon
    {
        $duration = $plan->duration;
        
        if (strpos($duration, 'Year') !== false) {
            $years = (int) $duration;
            return now()->addYears($years);
        } elseif (strpos($duration, 'Month') !== false) {
            $months = (int) $duration;
            return now()->addMonths($months);
        } elseif (strpos($duration, 'Week') !== false) {
            $weeks = (int) $duration;
            return now()->addWeeks($weeks);
        } elseif (strpos($duration, 'Day') !== false) {
            $days = (int) $duration;
            return now()->addDays($days);
        }
        
        // Default to 1 month if duration format is not recognized
        return now()->addMonth();
    }
}
