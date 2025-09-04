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
        $this->middleware('auth');
    }

    public function index()
    {
        $plans = SubscriptionPlan::active()->ordered()->get();
        $user = Auth::user();
        $activeSubscription = $user->activeSubscription;
        
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
            return redirect()->route('subscription.dashboard')
                ->with('error', 'No active subscription found.');
        }
        
        // Update subscription status to cancelled
        $subscription->update([
            'status' => 'cancelled',
            'end_date' => now()
        ]);
        
        return redirect()->route('subscription.dashboard')
            ->with('success', 'Your subscription has been cancelled successfully.');
    }
}
