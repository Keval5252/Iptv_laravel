@extends('layouts.admin.master')

@section('content')
<style>
    .form-label i {
        color: #007bff;
    }
    .input-group-text i {
        color: #6c757d;
    }
    .btn i {
        margin-right: 5px;
    }
    .feature-item .input-group-text {
        background-color: #f8f9fa;
        border-color: #ced4da;
    }
    .card-header h4 {
        color: #495057;
        font-weight: 600;
    }
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    .form-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    /* Perfect dropdown styling to match input fields exactly */
    .form-select {
        display: block;
        width: 100%;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        background-color: #fff;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 7 7 7-7'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px 12px;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        appearance: none;
        height: calc(1.5em + 0.75rem + 2px);
    }
    .form-select:hover {
        border-color: #86b7fe;
    }
    .form-select:focus {
        border-color: #86b7fe;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    .form-select option {
        padding: 0.5rem;
        color: #212529;
    }
    .form-select option:first-child {
        color: #6c757d;
        font-style: italic;
    }
    /* Ensure input and select have identical height and appearance */
    .form-control, .form-select {
        height: calc(1.5em + 0.75rem + 2px) !important;
        padding: 0.375rem 0.75rem !important;
        font-size: 1rem !important;
        line-height: 1.5 !important;
        border: 1px solid #ced4da !important;
        border-radius: 0.375rem !important;
        background-color: #fff !important;
        color: #212529 !important;
    }
    /* Override any existing select2 or other plugin styles */
    .form-select:not([multiple]):not([size]) {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 7 7 7-7'/%3e%3c/svg%3e") !important;
        background-repeat: no-repeat !important;
        background-position: right 0.75rem center !important;
        background-size: 16px 12px !important;
        padding-right: 2.25rem !important;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fa fa-plus-circle mr-2"></i>Create New Subscription Plan
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

                    <form action="{{ route('admin.subscription-plans.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">
                                        <i class="fa fa-tag mr-1"></i>Plan Name *
                                    </label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" 
                                           placeholder="e.g., Basic Plan" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="type" class="form-label">
                                        <i class="fa fa-tag mr-1"></i>Plan Type *
                                    </label>
                                    <select class="form-select @error('type') is-invalid @enderror" 
                                            id="type" name="type" required>
                                        <option value="" disabled {{ old('type') == '' ? 'selected' : '' }}>Select Plan Type</option>
                                        <option value="monthly" {{ old('type') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                        <option value="yearly" {{ old('type') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                        <option value="lifetime" {{ old('type') == 'lifetime' ? 'selected' : '' }}>Lifetime</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="duration" class="form-label">
                                        <i class="fa fa-clock mr-1"></i>Duration *
                                    </label>
                                    <input type="text" class="form-control @error('duration') is-invalid @enderror" 
                                           id="duration" name="duration" value="{{ old('duration') }}" 
                                           placeholder="e.g., 1 Month, 1 Year" required>
                                    @error('duration')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sort_order" class="form-label">
                                        <i class="fa fa-sort mr-1"></i>Sort Order
                                    </label>
                                    <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                           id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" 
                                           placeholder="0" min="0">
                                    @error('sort_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">
                                        <i class="fa fa-dollar-sign mr-1"></i>Price *
                                    </label>
                                    <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                                           id="price" name="price" value="{{ old('price') }}" 
                                           placeholder="0.00" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="original_price" class="form-label">
                                        <i class="fa fa-tag mr-1"></i>Original Price
                                    </label>
                                    <input type="number" step="0.01" class="form-control @error('original_price') is-invalid @enderror" 
                                           id="original_price" name="original_price" value="{{ old('original_price') }}" 
                                           placeholder="0.00">
                                    @error('original_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fa fa-globe mr-1"></i>Display Pages *
                            </label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="display_home" name="display_pages[]" 
                                               value="home" {{ in_array('home', old('display_pages', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="display_home">
                                            Home Page
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="display_iptv_subscription" name="display_pages[]" 
                                               value="iptv-subscription" {{ in_array('iptv-subscription', old('display_pages', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="display_iptv_subscription">
                                            IPTV SUBSCRIPTION Page
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="display_adult_iptv" name="display_pages[]" 
                                               value="adult-channel" {{ in_array('adult-channel', old('display_pages', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="display_adult_iptv">
                                            ADULT IPTV Page
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="display_adult_iptv_multi" name="display_pages[]" 
                                               value="multi-connections" {{ in_array('multi-connections', old('display_pages', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="display_adult_iptv_multi">
                                            ADULT IPTV MULTI Page
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="display_multi_connections" name="display_pages[]" 
                                               value="multi-connections-prices" {{ in_array('multi-connections-prices', old('display_pages', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="display_multi_connections">
                                            MULTI CONNECTIONS SUBSCRIPTION Page
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @error('display_pages')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fa fa-list mr-1"></i>Features
                            </label>
                            <div id="features-container">
                                @if(old('features'))
                                    @foreach(old('features') as $index => $feature)
                                        <div class="feature-item mb-2">
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fa fa-check"></i>
                                                </span>
                                                <input type="text" class="form-control" name="features[]" 
                                                       value="{{ $feature }}" placeholder="Enter feature (e.g., 12,000 Channels)">
                                                <button type="button" class="btn btn-outline-danger remove-feature">
                                                    <i class="fa fa-times"></i> Remove
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="feature-item mb-2">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fa fa-check"></i>
                                            </span>
                                            <input type="text" class="form-control" name="features[]" 
                                                   placeholder="Enter feature (e.g., 12,000 Channels)">
                                            <button type="button" class="btn btn-outline-danger remove-feature">
                                                <i class="fa fa-times"></i> Remove
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm" id="add-feature">
                                <i class="fa fa-plus"></i> Add Feature
                            </button>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_popular" name="is_popular" 
                                           value="1" {{ old('is_popular') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_popular">
                                        <i class="fa fa-star mr-1"></i>Mark as Popular
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                           value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        <i class="fa fa-toggle-on mr-1"></i>Active
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.subscription-plans.index') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Back to List
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Create Plan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page_js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addFeatureBtn = document.getElementById('add-feature');
    const featuresContainer = document.getElementById('features-container');

    addFeatureBtn.addEventListener('click', function() {
        const featureItem = document.createElement('div');
        featureItem.className = 'feature-item mb-2';
        featureItem.innerHTML = `
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fa fa-check"></i>
                </span>
                <input type="text" class="form-control" name="features[]" placeholder="Enter feature (e.g., 12,000 Channels)">
                <button type="button" class="btn btn-outline-danger remove-feature">
                    <i class="fa fa-times"></i> Remove
                </button>
            </div>
        `;
        featuresContainer.appendChild(featureItem);
    });

    featuresContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-feature')) {
            e.target.closest('.feature-item').remove();
        }
    });
});
</script>
@endsection
