@extends('layouts.admin.master')

@section('content')
<style>
    .card-header h4 {
        color: #495057;
        font-weight: 600;
    }
    .info-item {
        margin-bottom: 1rem;
    }
    .info-label {
        font-weight: 600;
        color: #495057;
    }
    .menu-item-card {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        margin-bottom: 1rem;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">
                        <i class="fa fa-bars mr-2"></i>Menu Details: {{ $menu->name }}
                    </h4>
                    <div>
                        <a href="{{ route('admin.menus.edit', $menu) }}" class="btn btn-warning me-2">
                            <i class="fa fa-edit"></i> Edit Menu
                        </a>
                        <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item">
                                <span class="info-label">Menu Name:</span>
                                <span class="ms-2">{{ $menu->name }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Location:</span>
                                <span class="badge bg-info ms-2">{{ $menu->location }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Description:</span>
                                <span class="ms-2">{{ $menu->description ?: 'No description provided' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <span class="info-label">Status:</span>
                                @if($menu->is_active)
                                    <span class="badge bg-success ms-2">Active</span>
                                @else
                                    <span class="badge bg-secondary ms-2">Inactive</span>
                                @endif
                            </div>
                            <div class="info-item">
                                <span class="info-label">Sort Order:</span>
                                <span class="ms-2">{{ $menu->sort_order }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Created:</span>
                                <span class="ms-2">{{ $menu->created_at->format('M d, Y H:i') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Last Updated:</span>
                                <span class="ms-2">{{ $menu->updated_at->format('M d, Y H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-12">
                            <h5 class="mb-3">
                                <i class="fa fa-list mr-2"></i>Menu Items ({{ $menu->menuItems->count() }})
                            </h5>
                            
                            @if($menu->menuItems->count() > 0)
                                <div class="row">
                                    @foreach($menu->menuItems as $menuItem)
                                        <div class="col-md-6 col-lg-4">
                                            <div class="menu-item-card p-3">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <h6 class="mb-0">
                                                        @if($menuItem->icon)
                                                            <i class="{{ $menuItem->icon }} mr-1"></i>
                                                        @endif
                                                        {{ $menuItem->title }}
                                                    </h6>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('admin.menu-items.edit', $menuItem) }}" 
                                                           class="btn btn-outline-warning btn-sm" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <a href="{{ route('admin.menu-items.show', $menuItem) }}" 
                                                           class="btn btn-outline-info btn-sm" title="View">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                
                                                <div class="small text-muted mb-2">
                                                    <strong>URL:</strong> {{ $menuItem->final_url ?: 'No URL' }}
                                                </div>
                                                
                                                <div class="small text-muted mb-2">
                                                    <strong>Target:</strong> {{ $menuItem->target }}
                                                </div>
                                                
                                                <div class="small text-muted mb-2">
                                                    <strong>Sort Order:</strong> {{ $menuItem->sort_order }}
                                                </div>
                                                
                                                <div class="mb-2">
                                                    @if($menuItem->is_active)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-secondary">Inactive</span>
                                                    @endif
                                                </div>
                                                
                                                @if($menuItem->children->count() > 0)
                                                    <div class="small">
                                                        <strong>Sub-items:</strong> {{ $menuItem->children->count() }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fa fa-list fa-2x text-muted mb-3"></i>
                                    <h6 class="text-muted">No menu items found</h6>
                                    <p class="text-muted">This menu doesn't have any items yet.</p>
                                    <a href="{{ route('admin.menu-items.create') }}" class="btn btn-primary">
                                        <i class="fa fa-plus mr-1"></i>Add Menu Item
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 