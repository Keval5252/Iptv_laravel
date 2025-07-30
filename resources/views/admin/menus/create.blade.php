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
                        <i class="fa fa-plus mr-2"></i>Create New Menu
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

                    <form action="{{ route('admin.menus.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">
                                        <i class="fa fa-bars mr-1"></i>Menu Name *
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fa fa-bars"></i>
                                        </span>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name') }}" 
                                               placeholder="Enter menu name (e.g., Main Navigation)" required>
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="location" class="form-label">
                                        <i class="fa fa-map-marker mr-1"></i>Location *
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fa fa-map-marker"></i>
                                        </span>
                                        <select class="form-control @error('location') is-invalid @enderror" 
                                                id="location" name="location" required>
                                            <option value="">Select Location</option>
                                            <option value="header" {{ old('location') == 'header' ? 'selected' : '' }}>Header Navigation</option>
                                            <option value="footer" {{ old('location') == 'footer' ? 'selected' : '' }}>Footer Menu</option>
                                            <option value="drawer" {{ old('location') == 'drawer' ? 'selected' : '' }}>Mobile Drawer</option>
                                            <option value="operation_guide" {{ old('location') == 'operation_guide' ? 'selected' : '' }}>Operation Guide</option>
                                            <option value="subscription" {{ old('location') == 'subscription' ? 'selected' : '' }}>Subscription Plans</option>
                                            <option value="custom" {{ old('location') == 'custom' ? 'selected' : '' }}>Custom Location</option>
                                        </select>
                                    </div>
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Custom Location Input -->
                                <div class="mb-3" id="customLocationDiv" style="display: none;">
                                    <label for="custom_location" class="form-label">
                                        <i class="fa fa-edit mr-1"></i>Custom Location Name *
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fa fa-edit"></i>
                                        </span>
                                        <input type="text" class="form-control @error('custom_location') is-invalid @enderror" 
                                               id="custom_location" name="custom_location" 
                                               value="{{ old('custom_location') }}" 
                                               placeholder="Enter custom location name">
                                    </div>
                                    @error('custom_location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">
                                        <i class="fa fa-info-circle mr-1"></i>Description
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fa fa-info-circle"></i>
                                        </span>
                                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                                  id="description" name="description" rows="3" 
                                                  placeholder="Enter menu description (optional)">{{ old('description') }}</textarea>
                                    </div>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
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
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check mt-4">
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
                                    <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary me-2">
                                        <i class="fa fa-arrow-left"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Create Menu
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const locationSelect = document.getElementById('location');
    const customLocationDiv = document.getElementById('customLocationDiv');
    const customLocationInput = document.getElementById('custom_location');
    
    function toggleCustomLocation() {
        if (locationSelect.value === 'custom') {
            customLocationDiv.style.display = 'block';
            customLocationInput.required = true;
        } else {
            customLocationDiv.style.display = 'none';
            customLocationInput.required = false;
            customLocationInput.value = '';
        }
    }
    
    locationSelect.addEventListener('change', toggleCustomLocation);
    
    // Initialize on page load
    toggleCustomLocation();
    
    // Form submission handling
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        if (locationSelect.value === 'custom') {
            if (!customLocationInput.value.trim()) {
                e.preventDefault();
                alert('Please enter a custom location name.');
                customLocationInput.focus();
                return false;
            }
            // Set the custom location value to the location field
            locationSelect.value = customLocationInput.value.trim();
        }
    });
});
</script>
@endsection 