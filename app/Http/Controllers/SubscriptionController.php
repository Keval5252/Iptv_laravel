<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    public function index()
    {
        $plans = SubscriptionPlan::active()->ordered()->get();
        
        if (Auth::check()) {
            $user = Auth::user();
            $activeSubscription = $user->activeSubscription;
        } else {
            $user = null;
            $activeSubscription = null;
        }
        
        return view('subscription.plans', compact('plans', 'activeSubscription'));
    }

    public function show($id)
    {
        $plan = SubscriptionPlan::findOrFail($id);
        $user = Auth::user();
        
        if (!$plan->is_active) {
            abort(404);
        }
        
        return view('subscription.show', compact('plan', 'user'));
    }

    public function purchase($id)
    {
        $plan = SubscriptionPlan::findOrFail($id);
        $user = Auth::user();
        
        if (!$plan->is_active) {
            abort(404);
        }
        
        // Check if user already has an active subscription
        if ($user->hasActiveSubscription()) {
            return redirect()->route('subscription.plans')
                ->with('warning', 'You already have an active subscription.');
        }
        
        return view('subscription.purchase', compact('plan', 'user'));
    }

    public function dashboard()
    {
        $user = Auth::user();
        $activeSubscription = $user->activeSubscription;
        $subscriptionHistory = $user->subscriptions()->latest()->get();
        $paymentHistory = $user->stripePayments()->latest()->get();
        
        return view('subscription.dashboard', compact('user', 'activeSubscription', 'subscriptionHistory', 'paymentHistory'));
    }

    public function cancel()
    {
        $user = Auth::user();
        $subscription = $user->activeSubscription;
        
        if (!$subscription) {
            return redirect()->route("subscription.dashboard")
                ->with("error", "No active subscription found.");
        }
        
        try {
            // Cancel in Stripe if subscription has Stripe ID
            if ($subscription->stripe_subscription_id) {
                \Stripe\Stripe::setApiKey(config("services.stripe.secret"));
                $stripeSubscription = \Stripe\Subscription::retrieve($subscription->stripe_subscription_id);
                $stripeSubscription->cancel();
                \Illuminate\Support\Facades\Log::info("Stripe subscription cancelled successfully", [
                    "subscription_id" => $subscription->stripe_subscription_id,
                    "user_id" => $user->id
                ]);
            }
            
            // Update local subscription
            $subscription->update([
                "status" => "cancelled",
                "end_date" => now()
            ]);
            
            return redirect()->route("subscription.dashboard")
                ->with("success", "Your subscription has been cancelled successfully.");
                
        } catch (\Stripe\Exception\ApiErrorException $e) {
            \Illuminate\Support\Facades\Log::error("Stripe subscription cancellation failed: " . $e->getMessage(), [
                "subscription_id" => $subscription->stripe_subscription_id,
                "user_id" => $user->id
            ]);
            return redirect()->route("subscription.dashboard")
                ->with("error", "Failed to cancel subscription in Stripe. Please contact support.");
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Subscription cancellation error: " . $e->getMessage(), [
                "subscription_id" => $subscription->stripe_subscription_id,
                "user_id" => $user->id
            ]);
            return redirect()->route("subscription.dashboard")
                ->with("error", "An error occurred while cancelling your subscription.");
        }
    }
}
