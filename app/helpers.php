<?php

if (!function_exists('renderMenu')) {
    /**
     * Render a menu by location
     */
    function renderMenu($location)
    {
        $menu = \App\Models\Menu::active()->byLocation($location)->first();
        if (!$menu) {
            return '';
        }
        
        $menuItems = $menu->menuItems()->active()->ordered()->get();
        return view('partials.menu', compact('menuItems'))->render();
    }
}

if (!function_exists('getMenuItems')) {
    /**
     * Get menu items by location
     */
    function getMenuItems($location)
    {
        $menu = \App\Models\Menu::active()->byLocation($location)->first();
        if (!$menu) {
            return collect();
        }
        
        return $menu->menuItems()->active()->ordered()->get();
    }
}

if (!function_exists('getPlansByMenu')) {
    /**
     * Get subscription plans filtered by menu item settings
     */
    function getPlansByMenu($menuItem)
    {
        if (!$menuItem || !isset($menuItem->settings['plan_types'])) {
            return \App\Models\SubscriptionPlan::active()->ordered()->get();
        }
        
        $planTypes = $menuItem->settings['plan_types'];
        return \App\Models\SubscriptionPlan::active()
            ->whereIn('plan_type', $planTypes)
            ->ordered()
            ->get();
    }
}

if (!function_exists('isMenuActive')) {
    /**
     * Check if a menu item is active based on current route
     */
    function isMenuActive($menuItem)
    {
        if ($menuItem->route_name) {
            return request()->routeIs($menuItem->route_name);
        }
        
        if ($menuItem->url) {
            return request()->url() === $menuItem->url;
        }
        
        return false;
    }
}

if (!function_exists('getPlansByPage')) {
    /**
     * Get subscription plans filtered by display page
     */
    function getPlansByPage($page)
    {
        return \App\Models\SubscriptionPlan::active()->byPage($page)->ordered()->get();
    }
} 