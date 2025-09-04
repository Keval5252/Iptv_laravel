@extends('layouts.web')

@section('title', 'Dashboard - Super IPTV')

@push('styles')
<style>
.user-dashboard {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    padding: 30px 0;
}

.dashboard-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.dashboard-header {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    padding: 30px;
    margin-bottom: 30px;
    position: relative;
    overflow: hidden;
}

.dashboard-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, #667eea, #764ba2);
}

.header-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 20px;
}

.welcome-section h1 {
    font-size: 2.2rem;
    font-weight: 800;
    color: #333;
    margin-bottom: 8px;
    background: linear-gradient(45deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.welcome-section p {
    color: #666;
    font-size: 1.1rem;
    margin: 0;
}

.header-actions {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.btn-primary {
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-primary:hover {
    background: linear-gradient(45deg, #764ba2, #667eea);
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
    color: white;
    text-decoration: none;
}

.btn-secondary {
    background: #f8f9fa;
    color: #666;
    border: 2px solid #e9ecef;
    padding: 10px 25px;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-secondary:hover {
    background: #e9ecef;
    color: #333;
    text-decoration: none;
}

.dashboard-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 30px;
}

.main-content {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.subscription-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    overflow: hidden;
    position: relative;
}

.subscription-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, #667eea, #764ba2);
}

.subscription-header {
    padding: 30px 30px 20px;
    background: linear-gradient(135deg, #f8f9ff 0%, #e8f0ff 100%);
}

.subscription-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 15px;
}

.subscription-content {
    padding: 30px;
}

.active-subscription {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    border: 2px solid #28a745;
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 20px;
}

.subscription-info {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 15px;
}

.subscription-name {
    font-size: 1.3rem;
    font-weight: 700;
    color: #333;
}

.status-badge {
    background: linear-gradient(45deg, #28a745, #20c997);
    color: white;
    padding: 8px 20px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
}

.subscription-details {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
}

.detail-item {
    background: white;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.detail-label {
    font-size: 0.9rem;
    color: #666;
    font-weight: 500;
    margin-bottom: 5px;
}

.detail-value {
    font-size: 1rem;
    color: #333;
    font-weight: 600;
}

.features-section {
    margin-top: 20px;
}

.features-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 15px;
}

.features-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 10px;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 0;
}

.feature-icon {
    width: 16px;
    height: 16px;
    background: linear-gradient(45deg, #28a745, #20c997);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.feature-icon::before {
    content: '✓';
    color: white;
    font-size: 10px;
    font-weight: bold;
}

.feature-text {
    color: #555;
    font-size: 0.9rem;
}

.subscription-actions {
    display: flex;
    gap: 15px;
    margin-top: 20px;
    flex-wrap: wrap;
}

.btn-danger {
    background: linear-gradient(45deg, #dc3545, #c82333);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-danger:hover {
    background: linear-gradient(45deg, #c82333, #dc3545);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(220, 53, 69, 0.3);
}

.no-subscription {
    text-align: center;
    padding: 60px 30px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 15px;
}

.no-subscription-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(45deg, #667eea, #764ba2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    color: white;
    font-size: 2rem;
}

.no-subscription h3 {
    font-size: 1.3rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 10px;
}

.no-subscription p {
    color: #666;
    margin-bottom: 25px;
}

.history-section {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    overflow: hidden;
}

.history-header {
    padding: 30px 30px 20px;
    background: linear-gradient(135deg, #f8f9ff 0%, #e8f0ff 100%);
}

.history-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #333;
}

.history-content {
    padding: 30px;
}

.history-table {
    width: 100%;
    border-collapse: collapse;
}

.history-table th {
    background: #f8f9fa;
    padding: 15px;
    text-align: left;
    font-weight: 600;
    color: #333;
    border-bottom: 2px solid #e9ecef;
}

.history-table td {
    padding: 15px;
    border-bottom: 1px solid #e9ecef;
    color: #555;
}

.history-table tr:hover {
    background: #f8f9fa;
}

.sidebar {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.profile-summary {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    overflow: hidden;
}

.profile-header {
    padding: 25px 25px 15px;
    background: linear-gradient(135deg, #f8f9ff 0%, #e8f0ff 100%);
}

.profile-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #333;
}

.profile-content {
    padding: 25px;
}

.profile-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #f0f0f0;
}

.profile-item:last-child {
    border-bottom: none;
}

.profile-label {
    font-size: 0.9rem;
    color: #666;
    font-weight: 500;
}

.profile-value {
    font-size: 0.95rem;
    color: #333;
    font-weight: 600;
}

.quick-actions {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    overflow: hidden;
}

.actions-header {
    padding: 25px 25px 15px;
    background: linear-gradient(135deg, #f8f9ff 0%, #e8f0ff 100%);
}

.actions-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #333;
}

.actions-content {
    padding: 25px;
}

.action-item {
    display: block;
    width: 100%;
    text-align: left;
    background: none;
    border: none;
    padding: 15px 20px;
    margin-bottom: 10px;
    border-radius: 12px;
    color: #555;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 12px;
}

.action-item:hover {
    background: linear-gradient(135deg, #f8f9ff 0%, #e8f0ff 100%);
    color: #667eea;
    text-decoration: none;
    transform: translateX(5px);
}

.action-item:last-child {
    margin-bottom: 0;
}

.action-icon {
    width: 20px;
    height: 20px;
    background: linear-gradient(45deg, #667eea, #764ba2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 12px;
    flex-shrink: 0;
}

@media (max-width: 768px) {
    .dashboard-grid {
        grid-template-columns: 1fr;
    }
    
    .header-content {
        flex-direction: column;
        text-align: center;
    }
    
    .welcome-section h1 {
        font-size: 1.8rem;
    }
    
    .subscription-details {
        grid-template-columns: 1fr;
    }
    
    .subscription-info {
        flex-direction: column;
        text-align: center;
    }
    
    .features-list {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@section('content')
<div class="user-dashboard">
    <div class="dashboard-container">
        <!-- Header -->
        <div class="dashboard-header">
            <div class="header-content">
                <div class="welcome-section">
                    <h1>Welcome back, {{ $user->first_name }}!</h1>
                    <p>Manage your IPTV subscription and account settings</p>
                </div>
                <div class="header-actions">
                    <a href="{{ route('user.profile') }}" class="btn-primary">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Edit Profile
                    </a>
                    <form action="{{ route('user.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="btn-secondary">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="dashboard-grid">
            <!-- Main Content -->
            <div class="main-content">
                <!-- Current Subscription -->
                <div class="subscription-card">
                    <div class="subscription-header">
                        <h2 class="subscription-title">Current Subscription</h2>
                    </div>
                    <div class="subscription-content">
                        @if($activeSubscription)
                            <div class="active-subscription">
                                <div class="subscription-info">
                                    <h3 class="subscription-name">{{ $activeSubscription->subscriptionPlan->name }}</h3>
                                    <span class="status-badge">Active</span>
                                </div>
                                
                                <div class="subscription-details">
                                    <div class="detail-item">
                                        <div class="detail-label">Duration</div>
                                        <div class="detail-value">{{ $activeSubscription->subscriptionPlan->duration }}</div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-label">Price</div>
                                        <div class="detail-value">${{ number_format($activeSubscription->subscriptionPlan->price, 2) }}</div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-label">Started</div>
                                        <div class="detail-value">{{ $activeSubscription->starts_at->format('M d, Y') }}</div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-label">Expires</div>
                                        <div class="detail-value">{{ $activeSubscription->ends_at->format('M d, Y') }}</div>
                                    </div>
                                </div>

                                @if($activeSubscription->subscriptionPlan->features)
                                    <div class="features-section">
                                        <h4 class="features-title">Included Features</h4>
                                        <div class="features-list">
                                            @foreach($activeSubscription->subscriptionPlan->features as $feature)
                                                <div class="feature-item">
                                                    <span class="feature-icon"></span>
                                                    <span class="feature-text">{{ $feature }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <div class="subscription-actions">
                                    <button onclick="cancelSubscription()" class="btn-danger">
                                        Cancel Subscription
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="no-subscription">
                                <div class="no-subscription-icon">📺</div>
                                <h3>No Active Subscription</h3>
                                <p>Get started by choosing a subscription plan to unlock unlimited entertainment.</p>
                                <a href="{{ route('user.subscriptions') }}" class="btn-primary">
                                    View Plans
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Subscription History -->
                @if($subscriptionHistory->count() > 0)
                    <div class="history-section">
                        <div class="history-header">
                            <h2 class="history-title">Subscription History</h2>
                        </div>
                        <div class="history-content">
                            <table class="history-table">
                                <thead>
                                    <tr>
                                        <th>Plan</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subscriptionHistory as $subscription)
                                        <tr>
                                            <td>{{ $subscription->subscriptionPlan->name }}</td>
                                            <td>
                                                <span class="status-badge" style="
                                                    @if($subscription->status === 'active') background: linear-gradient(45deg, #28a745, #20c997);
                                                    @elseif($subscription->status === 'cancelled') background: linear-gradient(45deg, #dc3545, #c82333);
                                                    @elseif($subscription->status === 'expired') background: linear-gradient(45deg, #6c757d, #5a6268);
                                                    @else background: linear-gradient(45deg, #ffc107, #e0a800); @endif
                                                ">
                                                    {{ ucfirst($subscription->status) }}
                                                </span>
                                            </td>
                                            <td>${{ number_format($subscription->subscriptionPlan->price, 2) }}</td>
                                            <td>{{ $subscription->created_at->format('M d, Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Profile Summary -->
                <div class="profile-summary">
                    <div class="profile-header">
                        <h3 class="profile-title">Profile Summary</h3>
                    </div>
                    <div class="profile-content">
                        <div class="profile-item">
                            <span class="profile-label">Name</span>
                            <span class="profile-value">{{ $user->first_name }} {{ $user->last_name }}</span>
                        </div>
                        <div class="profile-item">
                            <span class="profile-label">Email</span>
                            <span class="profile-value">{{ $user->email }}</span>
                        </div>
                        <div class="profile-item">
                            <span class="profile-label">Member Since</span>
                            <span class="profile-value">{{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="quick-actions">
                    <div class="actions-header">
                        <h3 class="actions-title">Quick Actions</h3>
                    </div>
                    <div class="actions-content">
                        <a href="{{ route('user.subscriptions') }}" class="action-item">
                            <span class="action-icon">📋</span>
                            View All Plans
                        </a>
                        <a href="{{ route('user.profile') }}" class="action-item">
                            <span class="action-icon">⚙️</span>
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function cancelSubscription() {
    Swal.fire({
        title: 'Cancel Subscription?',
        text: "Are you sure you want to cancel your subscription? This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#667eea',
        confirmButtonText: 'Yes, cancel it!',
        cancelButtonText: 'Keep Subscription'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('{{ route("user.subscriptions.cancel") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Cancelled!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.error || 'Something went wrong. Please try again.'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Something went wrong. Please try again.'
                });
            });
        }
    });
}
</script>
@endsection
