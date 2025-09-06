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
                'amount' => $plan->price,
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
        $request->validate([
            'subscription_id' => 'required|string',
        ]);

        try {
            $subscription = Subscription::retrieve($request->subscription_id);
            
            if ($subscription->status === 'active') {
                // Update local subscription
                $userSubscription = UserSubscription::where('stripe_subscription_id', $subscription->id)->first();
                
                if ($userSubscription) {
                    $userSubscription->update([
                        'status' => 'active',
                        'stripe_subscription_id' => $subscription->id,
                    ]);
                }

                return redirect()->route('subscription.dashboard')
                    ->with('success', 'Your subscription has been activated successfully!');
            } else {
                return redirect()->route('subscription.plans')
                    ->with('error', 'Subscription payment was not successful.');
            }

        } catch (ApiErrorException $e) {
            Log::error('Stripe subscription confirmation failed: ' . $e->getMessage());
            return redirect()->route('subscription.plans')
                ->with('error', 'Failed to confirm subscription.');
        }
    }

    /**
     * Cancel a Stripe subscription
     */
    public function cancelSubscription(Request $request)
    {
        $user = Auth::user();
        $subscription = $user->activeSubscription;
        
        if (!$subscription || !$subscription->stripe_subscription_id) {
            return redirect()->route('subscription.dashboard')
                ->with('error', 'No active subscription found.');
        }

        try {
            // Cancel in Stripe using direct API call
            $this->cancelStripeSubscriptionDirectly($subscription->stripe_subscription_id);

            // Update local subscription
            $subscription->update([
                'status' => 'cancelled',
                'end_date' => now(),
            ]);

            return redirect()->route('subscription.dashboard')
                ->with('success', 'Your subscription has been cancelled successfully.');

        } catch (\Exception $e) {
            Log::error('Stripe subscription cancellation failed: ' . $e->getMessage());
            return redirect()->route('subscription.dashboard')
                ->with('error', 'Failed to cancel subscription.');
        }
    }

    /**
     * Cancel Stripe subscription using direct API call
     */
    private function cancelStripeSubscriptionDirectly(string $subscriptionId): void
    {
        $stripeSecret = config('services.stripe.secret');
        if (!$stripeSecret) {
            throw new \Exception('Stripe secret key not configured');
        }

        $url = "https://api.stripe.com/v1/subscriptions/{$subscriptionId}";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_USERPWD, $stripeSecret . ':');
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

        Log::info("Stripe subscription cancelled successfully via direct API call", [
            'subscription_id' => $subscriptionId,
            'http_code' => $httpCode,
        ]);
    }

    /**
     * Calculate subscription end date based on plan type
     */
    private function calculateEndDate(SubscriptionPlan $plan)
    {
        return match($plan->type) {
            'monthly' => now()->addMonth(),
            'yearly' => now()->addYear(),
            'lifetime' => now()->addYears(100), // Effectively lifetime
            default => now()->addMonth(),
        };
    }
}
