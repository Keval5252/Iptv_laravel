@extends('layouts.admin.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">
                        <i class="fa fa-eye mr-2"></i>Subscription Plan Details
                    </h4>
                    <div>
                        <a href="{{ route('admin.subscription-plans.edit', $subscriptionPlan->id) }}" class="btn btn-primary">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.subscription-plans.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="150">Plan Name:</th>
                                    <td><strong>{{ $subscriptionPlan->name }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Type:</th>
                                    <td>
                                        <span class="badge bg-info">{{ ucfirst($subscriptionPlan->type) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Duration:</th>
                                    <td>{{ $subscriptionPlan->duration }}</td>
                                </tr>
                                <tr>
                                    <th>Price:</th>
                                    <td>
                                        <span class="text-success fw-bold fs-5">{{ $subscriptionPlan->formatted_price }}</span>
                                        @if($subscriptionPlan->original_price > $subscriptionPlan->price)
                                            <span class="text-muted text-decoration-line-through ms-2">{{ $subscriptionPlan->formatted_original_price }}</span>
                                            <span class="badge bg-danger ms-2">{{ $subscriptionPlan->discount_percentage }}% OFF</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        @if($subscriptionPlan->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Popular:</th>
                                    <td>
                                        @if($subscriptionPlan->is_popular)
                                            <span class="badge bg-warning">Yes</span>
                                        @else
                                            <span class="badge bg-light text-dark">No</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Sort Order:</th>
                                    <td>{{ $subscriptionPlan->sort_order }}</td>
                                </tr>
                                        </a>
                                    </td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Features</h5>
                                                                @if($subscriptionPlan->features && count($subscriptionPlan->features) > 0)
                                        <ul class="list-group">
                                            @foreach($subscriptionPlan->features as $feature)
                                                <li class="list-group-item">
                                                    <i class="fa fa-check text-success me-2"></i>
                                                    {{ $feature }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <div class="alert alert-info">
                                            <i class="fa fa-info-circle"></i> No features added for this plan.
                                        </div>
                                    @endif
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Plan Preview</h5>
                            <div class="border rounded p-4 bg-light">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <h6 class="card-title text-primary">{{ $subscriptionPlan->name }}</h6>
                                                <div class="fs-2 fw-bold text-success mb-2">{{ $subscriptionPlan->formatted_price }}</div>
                                                @if($subscriptionPlan->original_price > $subscriptionPlan->price)
                                                    <div class="text-muted text-decoration-line-through">{{ $subscriptionPlan->formatted_original_price }}</div>
                                                @endif
                                                @if($subscriptionPlan->is_popular)
                                                    <span class="badge bg-warning mt-2">MOST POPULAR</span>
                                                @endif
                                                <hr>
                                                @if($subscriptionPlan->features && count($subscriptionPlan->features) > 0)
                                                    <ul class="list-unstyled text-start">
                                                        @foreach(array_slice($subscriptionPlan->features, 0, 5) as $feature)
                                                            <li class="mb-1">
                                                                <i class="fas fa-check text-success me-2"></i>
                                                                {{ $feature }}
                                                            </li>
                                                        @endforeach
                                                        @if(count($subscriptionPlan->features) > 5)
                                                            <li class="text-muted">... and {{ count($subscriptionPlan->features) - 5 }} more</li>
                                                        @endif
                                                    </ul>
                                                @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 