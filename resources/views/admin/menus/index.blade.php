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
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">
                        <i class="fa fa-bars mr-2"></i>Menu Management
                    </h4>
                    <a href="{{ route('admin.menus.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus mr-1"></i>Create New Menu
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($menus->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="menusTable">
                                <thead>
                                    <tr>
                                        <th width="50">#</th>
                                        <th>Name</th>
                                        <th>Location</th>
                                        <th>Description</th>
                                        <th width="100">Status</th>
                                        <th width="100">Sort Order</th>
                                        <th width="200">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="sortableMenus">
                                    @foreach($menus as $menu)
                                        <tr data-id="{{ $menu->id }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <strong>{{ $menu->name }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $menu->location }}</span>
                                            </td>
                                            <td>
                                                {{ Str::limit($menu->description, 50) }}
                                            </td>
                                            <td>
                                                @if($menu->is_active)
                                                    <span class="badge bg-success status-badge">Active</span>
                                                @else
                                                    <span class="badge bg-secondary status-badge">Inactive</span>
                                                @endif
                                            </td>
                                            <td>{{ $menu->sort_order }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.menus.show', $menu) }}" 
                                                       class="btn btn-sm btn-info" title="View">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.menus.edit', $menu) }}" 
                                                       class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.menus.toggle-status', $menu) }}" 
                                                          method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-secondary" title="Toggle Status">
                                                            <i class="fa fa-toggle-on"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.menus.destroy', $menu) }}" 
                                                          method="POST" style="display: inline;" 
                                                          onsubmit="return confirm('Are you sure you want to delete this menu?')">
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
                            <i class="fa fa-bars fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No menus found</h5>
                            <p class="text-muted">Create your first menu to get started.</p>
                            <a href="{{ route('admin.menus.create') }}" class="btn btn-primary">
                                <i class="fa fa-plus mr-1"></i>Create Menu
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if($menus->count() > 0)
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$(document).ready(function() {
    $("#sortableMenus").sortable({
        handle: "td:first",
        update: function(event, ui) {
            var orders = [];
            $("#sortableMenus tr").each(function(index) {
                orders.push($(this).data('id'));
            });
            
            $.ajax({
                url: '{{ route("admin.menus.update-order") }}',
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