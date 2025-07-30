@extends('layouts.admin.master')

@section('content')
<style>
    .card-header h4 {
        color: #495057;
        font-weight: 600;
    }
    .form-label {
        font-weight: 600;
        color: #495057;
    }
    .input-group-text {
        background-color: #f8f9fa;
        border-color: #ced4da;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fa fa-plus mr-2"></i>Create New Menu Item
                    </h4>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.menu-items.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="menu_id" class="form-label">
                                        <i class="fa fa-bars mr-1"></i>Menu *
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fa fa-bars"></i>
                                        </span>
                                        <select class="form-control @error('menu_id') is-invalid @enderror" 
                                                id="menu_id" name="menu_id" required>
                                            <option value="">Select Menu</option>
                                            @foreach($menus as $menu)
                                                <option value="{{ $menu->id }}" {{ old('menu_id') == $menu->id ? 'selected' : '' }}>
                                                    {{ $menu->name }} ({{ $menu->location }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('menu_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="parent_id" class="form-label">
                                        <i class="fa fa-level-up mr-1"></i>Parent Item
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fa fa-level-up"></i>
                                        </span>
                                        <select class="form-control @error('parent_id') is-invalid @enderror" 
                                                id="parent_id" name="parent_id">
                                            <option value="">No Parent (Top Level)</option>
                                            @foreach($parentItems as $parentItem)
                                                <option value="{{ $parentItem->id }}" {{ old('parent_id') == $parentItem->id ? 'selected' : '' }}>
                                                    {{ $parentItem->title }} ({{ $parentItem->menu->name }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('parent_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">
                                        <i class="fa fa-tag mr-1"></i>Title *
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fa fa-tag"></i>
                                        </span>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                               id="title" name="title" value="{{ old('title') }}" 
                                               placeholder="Enter menu item title" required>
                                    </div>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="icon" class="form-label">
                                        <i class="fa fa-star mr-1"></i>Icon
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fa fa-star"></i>
                                        </span>
                                        <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                                               id="icon" name="icon" value="{{ old('icon') }}" 
                                               placeholder="fa fa-home (FontAwesome class)">
                                    </div>
                                    @error('icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="route_name" class="form-label">
                                        <i class="fa fa-link mr-1"></i>Route Name
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fa fa-link"></i>
                                        </span>
                                        <input type="text" class="form-control @error('route_name') is-invalid @enderror" 
                                               id="route_name" name="route_name" value="{{ old('route_name') }}" 
                                               placeholder="home (Laravel route name)">
                                    </div>
                                    @error('route_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="url" class="form-label">
                                        <i class="fa fa-globe mr-1"></i>Custom URL
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fa fa-globe"></i>
                                        </span>
                                        <input type="text" class="form-control @error('url') is-invalid @enderror" 
                                               id="url" name="url" value="{{ old('url') }}" 
                                               placeholder="https://example.com or /about-us">
                                    </div>
                                    @error('url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="target" class="form-label">
                                        <i class="fa fa-external-link mr-1"></i>Target
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fa fa-external-link"></i>
                                        </span>
                                        <select class="form-control @error('target') is-invalid @enderror" 
                                                id="target" name="target">
                                            <option value="_self" {{ old('target', '_self') == '_self' ? 'selected' : '' }}>Same Window</option>
                                            <option value="_blank" {{ old('target') == '_blank' ? 'selected' : '' }}>New Window</option>
                                            <option value="_parent" {{ old('target') == '_parent' ? 'selected' : '' }}>Parent Frame</option>
                                            <option value="_top" {{ old('target') == '_top' ? 'selected' : '' }}>Top Frame</option>
                                        </select>
                                    </div>
                                    @error('target')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="css_class" class="form-label">
                                        <i class="fa fa-paint-brush mr-1"></i>CSS Class
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fa fa-paint-brush"></i>
                                        </span>
                                        <input type="text" class="form-control @error('css_class') is-invalid @enderror" 
                                               id="css_class" name="css_class" value="{{ old('css_class') }}" 
                                               placeholder="custom-class">
                                    </div>
                                    @error('css_class')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="sort_order" class="form-label">
                                        <i class="fa fa-sort mr-1"></i>Sort Order
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fa fa-sort"></i>
                                        </span>
                                        <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                               id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" 
                                               min="0" placeholder="0">
                                    </div>
                                    @error('sort_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">
                                        <i class="fa fa-tv mr-1"></i>Plan Types (Optional)
                                    </label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="plan_type_iptv" 
                                                       name="plan_types[]" value="iptv" {{ in_array('iptv', old('plan_types', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="plan_type_iptv">
                                                    IPTV
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="plan_type_adult" 
                                                       name="plan_types[]" value="adult" {{ in_array('adult', old('plan_types', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="plan_type_adult">
                                                    Adult IPTV
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="plan_type_adult_multi" 
                                                       name="plan_types[]" value="adult_multi" {{ in_array('adult_multi', old('plan_types', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="plan_type_adult_multi">
                                                    Adult IPTV Multi
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="plan_type_multi" 
                                                       name="plan_types[]" value="multi" {{ in_array('multi', old('plan_types', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="plan_type_multi">
                                                    Multi Connections
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                               value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            <i class="fa fa-check-circle mr-1"></i>Active
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('admin.menu-items.index') }}" class="btn btn-secondary me-2">
                                        <i class="fa fa-arrow-left"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Create Menu Item
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 