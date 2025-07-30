@extends('layouts.admin.master')

@section('content')
<style>
    .card-header h4 {
        color: #495057;
        font-weight: 600;
    }
    .table th {
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }
    .status-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
    .menu-item-indent {
        padding-left: 20px;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">
                        <i class="fa fa-list mr-2"></i>Menu Items Management
                    </h4>
                    <a href="{{ route('admin.menu-items.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus mr-1"></i>Create New Menu Item
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($menuItems->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="menuItemsTable">
                                <thead>
                                    <tr>
                                        <th width="50">#</th>
                                        <th>Title</th>
                                        <th>Menu</th>
                                        <th>Parent</th>
                                        <th>URL/Route</th>
                                        <th>Icon</th>
                                        <th width="100">Status</th>
                                        <th width="100">Sort Order</th>
                                        <th width="200">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="sortableMenuItems">
                                    @foreach($menuItems as $menuItem)
                                        <tr data-id="{{ $menuItem->id }}" class="{{ $menuItem->parent_id ? 'menu-item-indent' : '' }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <strong>
                                                    @if($menuItem->icon)
                                                        <i class="{{ $menuItem->icon }} mr-1"></i>
                                                    @endif
                                                    {{ $menuItem->title }}
                                                </strong>
                                                @if($menuItem->parent_id)
                                                    <small class="text-muted d-block">↳ Sub-item</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $menuItem->menu->name ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                @if($menuItem->parent)
                                                    <span class="badge bg-secondary">{{ $menuItem->parent->title }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    @if($menuItem->route_name)
                                                        Route: {{ $menuItem->route_name }}
                                                    @elseif($menuItem->url)
                                                        URL: {{ Str::limit($menuItem->url, 30) }}
                                                    @else
                                                        No URL
                                                    @endif
                                                </small>
                                            </td>
                                            <td>
                                                @if($menuItem->icon)
                                                    <i class="{{ $menuItem->icon }}"></i>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($menuItem->is_active)
                                                    <span class="badge bg-success status-badge">Active</span>
                                                @else
                                                    <span class="badge bg-secondary status-badge">Inactive</span>
                                                @endif
                                            </td>
                                            <td>{{ $menuItem->sort_order }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.menu-items.show', $menuItem) }}" 
                                                       class="btn btn-sm btn-info" title="View">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.menu-items.edit', $menuItem) }}" 
                                                       class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.menu-items.toggle-status', $menuItem) }}" 
                                                          method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-secondary" title="Toggle Status">
                                                            <i class="fa fa-toggle-on"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.menu-items.destroy', $menuItem) }}" 
                                                          method="POST" style="display: inline;" 
                                                          onsubmit="return confirm('Are you sure you want to delete this menu item?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fa fa-list fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No menu items found</h5>
                            <p class="text-muted">Create your first menu item to get started.</p>
                            <a href="{{ route('admin.menu-items.create') }}" class="btn btn-primary">
                                <i class="fa fa-plus mr-1"></i>Create Menu Item
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if($menuItems->count() > 0)
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$(document).ready(function() {
    $("#sortableMenuItems").sortable({
        handle: "td:first",
        update: function(event, ui) {
            var orders = [];
            $("#sortableMenuItems tr").each(function(index) {
                orders.push($(this).data('id'));
            });
            
            $.ajax({
                url: '{{ route("admin.menu-items.update-order") }}',
                method: 'POST',
                data: {
                    orders: orders,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    }
                }
            });
        }
    });
});
</script>
@endif
@endsection 