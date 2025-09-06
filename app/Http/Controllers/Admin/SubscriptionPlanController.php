<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Services\StripePlanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class SubscriptionPlanController extends Controller
{
    protected $stripePlanService;

    public function __construct(StripePlanService $stripePlanService)
    {
        $this->stripePlanService = $stripePlanService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plans = SubscriptionPlan::ordered()->get();
        return view('admin.subscription-plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.subscription-plans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'original_price' => 'required|numeric|min:0',
            'features' => 'nullable|array',
            'display_pages' => 'required|array|min:1',
            'display_pages.*' => 'string|in:home,iptv-subscription,adult-channel,multi-connections,multi-connections-prices',
            'is_popular' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['features'] = $request->input('features', []);
        $data['display_pages'] = $request->input('display_pages', []);
        $data['is_popular'] = $request->has('is_popular');
        $data['is_active'] = $request->has('is_active');

        // Create the subscription plan first
        $subscriptionPlan = SubscriptionPlan::create($data);

        // Create Stripe plan
        if ($subscriptionPlan->is_active) {
            $stripeResult = $this->stripePlanService->createStripePlan($subscriptionPlan);
            
            if ($stripeResult['success']) {
                $subscriptionPlan->update([
                    'stripe_product_id' => $stripeResult['product_id'],
                    'stripe_plan_id' => $stripeResult['price_id'],
                ]);
                
                return redirect()->route('admin.subscription-plans.index')
                    ->with('success', 'Subscription plan created successfully with Stripe integration.');
            } else {
                Log::error('Stripe plan creation failed for plan: ' . $subscriptionPlan->id, [
                    'error' => $stripeResult['error']
                ]);
                
                return redirect()->route('admin.subscription-plans.index')
                    ->with('warning', 'Subscription plan created but Stripe integration failed. Please check logs and update manually.');
            }
        }

        return redirect()->route('admin.subscription-plans.index')
            ->with('success', 'Subscription plan created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubscriptionPlan $subscriptionPlan)
    {
        return view('admin.subscription-plans.show', compact('subscriptionPlan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubscriptionPlan $subscriptionPlan)
    {
        return view('admin.subscription-plans.edit', compact('subscriptionPlan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubscriptionPlan $subscriptionPlan)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'original_price' => 'required|numeric|min:0',
            'features' => 'nullable|array',
            'display_pages' => 'required|array|min:1',
            'display_pages.*' => 'string|in:home,iptv-subscription,adult-channel,multi-connections,multi-connections-prices',
            'is_popular' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['features'] = $request->input('features', []);
        $data['display_pages'] = $request->input('display_pages', []);
        $data['is_popular'] = $request->has('is_popular');
        $data['is_active'] = $request->has('is_active');

        // Update the subscription plan
        $subscriptionPlan->update($data);

        // Update Stripe plan if plan is active
        if ($subscriptionPlan->is_active) {
            $stripeResult = $this->stripePlanService->updateStripePlan($subscriptionPlan);
            
            if ($stripeResult['success']) {
                $subscriptionPlan->update([
                    'stripe_product_id' => $stripeResult['product_id'],
                    'stripe_plan_id' => $stripeResult['price_id'],
                ]);
                
                return redirect()->route('admin.subscription-plans.index')
                    ->with('success', 'Subscription plan updated successfully with Stripe integration.');
            } else {
                Log::error('Stripe plan update failed for plan: ' . $subscriptionPlan->id, [
                    'error' => $stripeResult['error']
                ]);
                
                return redirect()->route('admin.subscription-plans.index')
                    ->with('warning', 'Subscription plan updated but Stripe integration failed. Please check logs and update manually.');
            }
        }

        return redirect()->route('admin.subscription-plans.index')
            ->with('success', 'Subscription plan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubscriptionPlan $subscriptionPlan)
    {
        try {
            // Log the plan data before deletion for debugging
            Log::info('Deleting subscription plan', [
                'plan_id' => $subscriptionPlan->id,
                'stripe_product_id' => $subscriptionPlan->stripe_product_id,
                'stripe_plan_id' => $subscriptionPlan->stripe_plan_id,
                'stripe_product_id_type' => gettype($subscriptionPlan->stripe_product_id),
                'stripe_plan_id_type' => gettype($subscriptionPlan->stripe_plan_id),
            ]);

            // Ensure Stripe IDs are strings before using them
            $stripeProductId = is_array($subscriptionPlan->stripe_product_id) 
                ? (isset($subscriptionPlan->stripe_product_id[0]) ? $subscriptionPlan->stripe_product_id[0] : null)
                : $subscriptionPlan->stripe_product_id;
                
            $stripePlanId = is_array($subscriptionPlan->stripe_plan_id) 
                ? (isset($subscriptionPlan->stripe_plan_id[0]) ? $subscriptionPlan->stripe_plan_id[0] : null)
                : $subscriptionPlan->stripe_plan_id;

            // Delete from Stripe first if we have valid IDs
            if ($stripeProductId && $stripePlanId) {
                // Create a temporary plan object with corrected IDs
                $tempPlan = clone $subscriptionPlan;
                $tempPlan->stripe_product_id = $stripeProductId;
                $tempPlan->stripe_plan_id = $stripePlanId;
                
                $this->stripePlanService->deleteStripePlan($tempPlan);
            }

            $subscriptionPlan->delete();

            return redirect()->route('admin.subscription-plans.index')
                ->with('success', 'Subscription plan deleted successfully.');

        } catch (\Exception $e) {
            Log::error('Subscription plan deletion failed: ' . $e->getMessage(), [
                'plan_id' => $subscriptionPlan->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('admin.subscription-plans.index')
                ->with('error', 'Failed to delete subscription plan: ' . $e->getMessage());
        }
    }

    /**
     * Toggle the active status of a subscription plan
     */
    public function toggleStatus(SubscriptionPlan $subscriptionPlan)
    {
        $newStatus = !$subscriptionPlan->is_active;
        $subscriptionPlan->update(['is_active' => $newStatus]);

        // If activating, create Stripe plan
        if ($newStatus && !$subscriptionPlan->stripe_plan_id) {
            $stripeResult = $this->stripePlanService->createStripePlan($subscriptionPlan);
            
            if ($stripeResult['success']) {
                $subscriptionPlan->update([
                    'stripe_product_id' => $stripeResult['product_id'],
                    'stripe_plan_id' => $stripeResult['price_id'],
                ]);
            }
        }

        return redirect()->route('admin.subscription-plans.index')
            ->with('success', 'Subscription plan status updated successfully.');
    }

    /**
     * Update the sort order of subscription plans
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*' => 'required|integer|exists:subscription_plans,id'
        ]);

        foreach ($request->orders as $index => $id) {
            SubscriptionPlan::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Sync a plan with Stripe (create if doesn't exist)
     */
    public function syncWithStripe(SubscriptionPlan $subscriptionPlan)
    {
        if (!$subscriptionPlan->is_active) {
            return redirect()->back()
                ->with('error', 'Cannot sync inactive plans with Stripe.');
        }

        $stripeResult = $this->stripePlanService->createStripePlan($subscriptionPlan);
        
        if ($stripeResult['success']) {
            $subscriptionPlan->update([
                'stripe_product_id' => $stripeResult['product_id'],
                'stripe_plan_id' => $stripeResult['price_id'],
            ]);
            
            return redirect()->back()
                ->with('success', 'Plan synced with Stripe successfully.');
        } else {
            return redirect()->back()
                ->with('error', 'Failed to sync with Stripe: ' . $stripeResult['error']);
        }
    }
}
