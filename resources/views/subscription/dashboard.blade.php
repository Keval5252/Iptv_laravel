@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h2 mb-0">Dashboard</h1>
                <div>
                    <a href="{{ route('subscription.plans') }}" class="btn btn-outline-primary me-2">
                        <i class="fas fa-plus me-2"></i>Upgrade Plan
                    </a>
                    <form action="{{ route('user.logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Current Subscription -->
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-tv me-2"></i>Current Subscription</h5>
                </div>
                <div class="card-body">
                    @if($activeSubscription)
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h4 class="text-primary mb-2">{{ $activeSubscription->subscriptionPlan->name }}</h4>
                                <p class="text-muted mb-2">
                                    <i class="fas fa-calendar me-2"></i>
                                    Started: {{ $activeSubscription->start_date->format('M d, Y') }}
                                </p>
                                <p class="text-muted mb-2">
                                    <i class="fas fa-calendar-check me-2"></i>
                                    Expires: {{ $activeSubscription->end_date->format('M d, Y') }}
                                </p>
                                <p class="text-muted mb-3">
                                    <i class="fas fa-clock me-2"></i>
                                    {{ $activeSubscription->daysRemaining() }} days remaining
                                </p>
                                
                                @if($activeSubscription->isExpiringSoon())
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        Your subscription expires soon! Consider renewing to avoid service interruption.
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="display-6 fw-bold text-primary mb-2">
                                    {{ $activeSubscription->subscriptionPlan->formatted_price }}
                                </div>
                                <small class="text-muted">per {{ $activeSubscription->subscriptionPlan->duration }}</small>
                                
                                <div class="mt-3">
                                    <form action="{{ route('subscription.cancel') }}" method="POST" 
                                          onsubmit="return confirm('Are you sure you want to cancel your subscription?')">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="fas fa-times me-2"></i>Cancel Subscription
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-tv fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Active Subscription</h5>
                            <p class="text-muted">You don't have an active subscription plan.</p>
                            <a href="{{ route('subscription.plans') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Choose a Plan
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Account Info -->
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-user me-2"></i>Account Info</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-user fa-2x text-white"></i>
                        </div>
                    </div>
                    
                    <h6 class="text-center mb-3">{{ $user->full_name }}</h6>
                    
                    <div class="mb-2">
                        <small class="text-muted">Email:</small><br>
                        <strong>{{ $user->email }}</strong>
                    </div>
                    
                    @if($user->phone)
                        <div class="mb-2">
                            <small class="text-muted">Phone:</small><br>
                            <strong>{{ $user->phone }}</strong>
                        </div>
                    @endif
                    
                    @if($user->address)
                        <div class="mb-2">
                            <small class="text-muted">Address:</small><br>
                            <strong>{{ $user->address }}</strong><br>
                            <strong>{{ $user->city }}, {{ $user->state }} {{ $user->postal_code }}</strong><br>
                            <strong>{{ $user->country }}</strong>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Payment History -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-credit-card me-2"></i>Payment History</h5>
                </div>
                <div class="card-body">
                    @if($paymentHistory->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Plan</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Payment ID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($paymentHistory as $payment)
                                        <tr>
                                            <td>{{ $payment->created_at->format('M d, Y') }}</td>
                                            <td>{{ $payment->subscriptionPlan->name }}</td>
                                            <td>
                                                <span class="badge bg-primary">{{ $payment->formatted_amount }}</span>
                                            </td>
                                            <td>
                                                @if($payment->status === 'succeeded')
                                                    <span class="badge bg-success">Success</span>
                                                @elseif($payment->status === 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @else
                                                    <span class="badge bg-danger">Failed</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $payment->stripe_payment_intent_id }}</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-credit-card fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">No Payment History</h6>
                            <p class="text-muted">Your payment history will appear here once you make a purchase.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Subscription History -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Subscription History</h5>
                </div>
                <div class="card-body">
                    @if($subscriptionHistory->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Plan</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subscriptionHistory as $subscription)
                                        <tr>
                                            <td>{{ $subscription->subscriptionPlan->name }}</td>
                                            <td>{{ $subscription->start_date->format('M d, Y') }}</td>
                                            <td>{{ $subscription->end_date ? $subscription->end_date->format('M d, Y') : 'N/A' }}</td>
                                            <td>
                                                @if($subscription->status === 'active')
                                                    <span class="badge bg-success">Active</span>
                                                @elseif($subscription->status === 'expired')
                                                    <span class="badge bg-danger">Expired</span>
                                                @elseif($subscription->status === 'cancelled')
                                                    <span class="badge bg-secondary">Cancelled</span>
                                                @else
                                                    <span class="badge bg-warning">{{ ucfirst($subscription->status) }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $subscription->amount_paid }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-history fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">No Subscription History</h6>
                            <p class="text-muted">Your subscription history will appear here once you subscribe to a plan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 