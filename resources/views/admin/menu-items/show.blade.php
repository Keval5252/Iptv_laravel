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
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">
                        <i class="fa fa-list mr-2"></i>Menu Item Details: {{ $menuItem->title }}
                    </h4>
                    <div>
                        <a href="{{ route('admin.menu-items.edit', $menuItem) }}" class="btn btn-warning me-2">
                            <i class="fa fa-edit"></i> Edit Menu Item
                        </a>
                        <a href="{{ route('admin.menu-items.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item">
                                <span class="info-label">Title:</span>
                                <span class="ms-2">
                                    @if($menuItem->icon)
                                        <i class="{{ $menuItem->icon }} mr-1"></i>
                                    @endif
                                    {{ $menuItem->title }}
                                </span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Menu:</span>
                                <span class="badge bg-info ms-2">{{ $menuItem->menu->name ?? 'N/A' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Parent Item:</span>
                                @if($menuItem->parent)
                                    <span class="badge bg-secondary ms-2">{{ $menuItem->parent->title }}</span>
                                @else
                                    <span class="ms-2 text-muted">No Parent (Top Level)</span>
                                @endif
                            </div>
                            <div class="info-item">
                                <span class="info-label">URL/Route:</span>
                                <span class="ms-2">
                                    @if($menuItem->route_name)
                                        <code>Route: {{ $menuItem->route_name }}</code>
                                    @elseif($menuItem->url)
                                        <code>URL: {{ $menuItem->url }}</code>
                                    @else
                                        <span class="text-muted">No URL configured</span>
                                    @endif
                                </span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Final URL:</span>
                                <span class="ms-2">
                                    <a href="{{ $menuItem->final_url }}" target="_blank" class="text-primary">
                                        {{ $menuItem->final_url ?: 'No URL' }}
                                    </a>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <span class="info-label">Status:</span>
                                @if($menuItem->is_active)
                                    <span class="badge bg-success ms-2">Active</span>
                                @else
                                    <span class="badge bg-secondary ms-2">Inactive</span>
                                @endif
                            </div>
                            <div class="info-item">
                                <span class="info-label">Target:</span>
                                <span class="ms-2">{{ $menuItem->target }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Icon:</span>
                                @if($menuItem->icon)
                                    <span class="ms-2">
                                        <i class="{{ $menuItem->icon }}"></i> {{ $menuItem->icon }}
                                    </span>
                                @else
                                    <span class="ms-2 text-muted">No icon</span>
                                @endif
                            </div>
                            <div class="info-item">
                                <span class="info-label">CSS Class:</span>
                                @if($menuItem->css_class)
                                    <span class="ms-2"><code>{{ $menuItem->css_class }}</code></span>
                                @else
                                    <span class="ms-2 text-muted">No CSS class</span>
                                @endif
                            </div>
                            <div class="info-item">
                                <span class="info-label">Sort Order:</span>
                                <span class="ms-2">{{ $menuItem->sort_order }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Created:</span>
                                <span class="ms-2">{{ $menuItem->created_at->format('M d, Y H:i') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Last Updated:</span>
                                <span class="ms-2">{{ $menuItem->updated_at->format('M d, Y H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    @if($menuItem->plan_types && count($menuItem->plan_types) > 0)
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-3">
                                    <i class="fa fa-tv mr-2"></i>Associated Plan Types
                                </h5>
                                <div class="row">
                                    @foreach($menuItem->plan_types as $planType)
                                        <div class="col-md-3">
                                            <span class="badge bg-primary me-2">{{ $planType }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($menuItem->children->count() > 0)
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-3">
                                    <i class="fa fa-level-down mr-2"></i>Child Items ({{ $menuItem->children->count() }})
                                </h5>
                                <div class="row">
                                    @foreach($menuItem->children as $child)
                                        <div class="col-md-6 col-lg-4">
                                            <div class="card border-secondary mb-3">
                                                <div class="card-body p-3">
                                                    <h6 class="card-title">
                                                        @if($child->icon)
                                                            <i class="{{ $child->icon }} mr-1"></i>
                                                        @endif
                                                        {{ $child->title }}
                                                    </h6>
                                                    <p class="card-text small text-muted">
                                                        @if($child->route_name)
                                                            Route: {{ $child->route_name }}
                                                        @elseif($child->url)
                                                            URL: {{ Str::limit($child->url, 30) }}
                                                        @else
                                                            No URL
                                                        @endif
                                                    </p>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        @if($child->is_active)
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-secondary">Inactive</span>
                                                        @endif
                                                        <a href="{{ route('admin.menu-items.edit', $child) }}" 
                                                           class="btn btn-sm btn-outline-warning">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 