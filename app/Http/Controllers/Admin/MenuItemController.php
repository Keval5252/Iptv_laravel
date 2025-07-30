<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menuItems = MenuItem::with(['menu', 'parent'])->ordered()->get();
        return view('admin.menu-items.index', compact('menuItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menus = Menu::active()->ordered()->get();
        $parentItems = MenuItem::active()->ordered()->get();
        return view('admin.menu-items.create', compact('menus', 'parentItems'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'menu_id' => 'required|exists:menus,id',
            'parent_id' => 'nullable|exists:menu_items,id',
            'title' => 'required|string|max:255',
            'url' => 'nullable|string|max:500',
            'route_name' => 'nullable|string|max:255',
            'target' => 'nullable|string|max:50',
            'icon' => 'nullable|string|max:100',
            'css_class' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'plan_types' => 'nullable|array',
            'plan_types.*' => 'string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        
        // Handle plan types
        if ($request->has('plan_types')) {
            $data['settings'] = ['plan_types' => $request->plan_types];
        }

        MenuItem::create($data);

        return redirect()->route('admin.menu-items.index')
            ->with('success', 'Menu item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MenuItem $menuItem)
    {
        $menuItem->load(['menu', 'parent', 'children']);
        return view('admin.menu-items.show', compact('menuItem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MenuItem $menuItem)
    {
        $menus = Menu::active()->ordered()->get();
        $parentItems = MenuItem::where('id', '!=', $menuItem->id)->active()->ordered()->get();
        return view('admin.menu-items.edit', compact('menuItem', 'menus', 'parentItems'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MenuItem $menuItem)
    {
        $validator = Validator::make($request->all(), [
            'menu_id' => 'required|exists:menus,id',
            'parent_id' => 'nullable|exists:menu_items,id',
            'title' => 'required|string|max:255',
            'url' => 'nullable|string|max:500',
            'route_name' => 'nullable|string|max:255',
            'target' => 'nullable|string|max:50',
            'icon' => 'nullable|string|max:100',
            'css_class' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'plan_types' => 'nullable|array',
            'plan_types.*' => 'string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        
        // Handle plan types
        if ($request->has('plan_types')) {
            $data['settings'] = ['plan_types' => $request->plan_types];
        }

        $menuItem->update($data);

        return redirect()->route('admin.menu-items.index')
            ->with('success', 'Menu item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();

        return redirect()->route('admin.menu-items.index')
            ->with('success', 'Menu item deleted successfully.');
    }

    /**
     * Toggle the active status of a menu item
     */
    public function toggleStatus(MenuItem $menuItem)
    {
        $menuItem->update(['is_active' => !$menuItem->is_active]);

        return redirect()->route('admin.menu-items.index')
            ->with('success', 'Menu item status updated successfully.');
    }

    /**
     * Update the sort order of menu items
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*' => 'required|integer|exists:menu_items,id'
        ]);

        foreach ($request->orders as $index => $id) {
            MenuItem::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Get menu items by menu
     */
    public function getByMenu(Menu $menu)
    {
        $menuItems = $menu->menuItems()->with('children')->get();
        return response()->json($menuItems);
    }
}
