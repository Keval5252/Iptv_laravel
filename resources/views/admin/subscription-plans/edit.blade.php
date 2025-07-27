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
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fa fa-edit mr-2"></i>Edit Subscription Plan
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

                    <form action="{{ route('admin.subscription-plans.update', $subscriptionPlan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">
                                        <i class="fa fa-tv mr-1"></i>Plan Name *
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fa fa-tv"></i>
                                        </span>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name', $subscriptionPlan->name) }}" 
                                               placeholder="Enter plan name (e.g., XXX-1 Year)" required>
                                    </div>
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
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fa fa-tag"></i>
                                        </span>
                                        <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                                            <option value="">Select Plan Type</option>
                                            <option value="xxx" {{ old('type', $subscriptionPlan->type) == 'xxx' ? 'selected' : '' }}>
                                                XXX (Adult Content)
                                            </option>
                                            <option value="standard" {{ old('type', $subscriptionPlan->type) == 'standard' ? 'selected' : '' }}>
                                                Standard
                                            </option>
                                            <option value="premium" {{ old('type', $subscriptionPlan->type) == 'premium' ? 'selected' : '' }}>
                                                Premium
                                            </option>
                                        </select>
                                    </div>
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
                                        <i class="fa fa-clock-o mr-1"></i>Duration *
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fa fa-clock-o"></i>
                                        </span>
                                        <select class="form-control @error('duration') is-invalid @enderror" id="duration" name="duration" required>
                                            <option value="">Select Duration</option>
                                            <option value="1 Month" {{ old('duration', $subscriptionPlan->duration) == '1 Month' ? 'selected' : '' }}>
                                                1 Month
                                            </option>
                                            <option value="3 Months" {{ old('duration', $subscriptionPlan->duration) == '3 Months' ? 'selected' : '' }}>
                                                3 Months
                                            </option>
                                            <option value="6 Months" {{ old('duration', $subscriptionPlan->duration) == '6 Months' ? 'selected' : '' }}>
                                                6 Months
                                            </option>
                                            <option value="1 Year" {{ old('duration', $subscriptionPlan->duration) == '1 Year' ? 'selected' : '' }}>
                                                1 Year
                                            </option>
                                            <option value="2 Years" {{ old('duration', $subscriptionPlan->duration) == '2 Years' ? 'selected' : '' }}>
                                                2 Years
                                            </option>
                                        </select>
                                    </div>
                                    @error('duration')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sort_order" class="form-label">Sort Order</label>
                                    <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                           id="sort_order" name="sort_order" value="{{ old('sort_order', $subscriptionPlan->sort_order) }}" min="0">
                                    @error('sort_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                               id="price" name="price" value="{{ old('price', $subscriptionPlan->price) }}" step="0.01" min="0" required>
                                    </div>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="original_price" class="form-label">Original Price *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control @error('original_price') is-invalid @enderror" 
                                               id="original_price" name="original_price" value="{{ old('original_price', $subscriptionPlan->original_price) }}" step="0.01" min="0" required>
                                    </div>
                                    @error('original_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="buy_link" class="form-label">Buy Link</label>
                            <input type="url" class="form-control @error('buy_link') is-invalid @enderror" 
                                   id="buy_link" name="buy_link" value="{{ old('buy_link', $subscriptionPlan->buy_link) }}" placeholder="https://...">
                            @error('buy_link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Features</label>
                            <div id="features-container">
                                @if($subscriptionPlan->features && count($subscriptionPlan->features) > 0)
                                    @foreach($subscriptionPlan->features as $feature)
                                        <div class="feature-item mb-2">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="features[]" value="{{ $feature }}" placeholder="Enter feature (e.g., 12,000 Channels)">
                                                <button type="button" class="btn btn-outline-danger remove-feature">Remove</button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="feature-item mb-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="features[]" placeholder="Enter feature (e.g., 12,000 Channels)">
                                            <button type="button" class="btn btn-outline-danger remove-feature">Remove</button>
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
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_popular" name="is_popular" 
                                               value="1" {{ old('is_popular', $subscriptionPlan->is_popular) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_popular">
                                            Mark as Popular
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                               value="1" {{ old('is_active', $subscriptionPlan->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Active
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.subscription-plans.index') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Back to List
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Update Plan
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
                <input type="text" class="form-control" name="features[]" placeholder="Enter feature (e.g., 12,000 Channels)">
                <button type="button" class="btn btn-outline-danger remove-feature">Remove</button>
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