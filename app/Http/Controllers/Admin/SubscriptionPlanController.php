<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionPlanController extends Controller
{
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

        SubscriptionPlan::create($data);

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

        $subscriptionPlan->update($data);

        return redirect()->route('admin.subscription-plans.index')
            ->with('success', 'Subscription plan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubscriptionPlan $subscriptionPlan)
    {
        $subscriptionPlan->delete();

        return redirect()->route('admin.subscription-plans.index')
            ->with('success', 'Subscription plan deleted successfully.');
    }

    /**
     * Toggle the active status of a subscription plan
     */
    public function toggleStatus(SubscriptionPlan $subscriptionPlan)
    {
        $subscriptionPlan->update(['is_active' => !$subscriptionPlan->is_active]);

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
}
