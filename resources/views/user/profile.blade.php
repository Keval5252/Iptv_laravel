@extends('layouts.web')

@section('title', 'Profile Settings - Super IPTV')

@push('styles')
<style>
.profile-page {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    padding: 40px 0;
}

.profile-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.profile-header {
    text-align: center;
    margin-bottom: 40px;
    color: white;
}

.profile-title {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 15px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    background: linear-gradient(45deg, #fff, #f0f0f0);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.profile-subtitle {
    font-size: 1.2rem;
    opacity: 0.9;
    max-width: 500px;
    margin: 0 auto;
    line-height: 1.6;
}

.profile-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
    align-items: start;
}

.profile-card {
    background: white;
    border-radius: 25px;
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
    overflow: hidden;
    position: relative;
}

.profile-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, #667eea, #764ba2);
}

.card-header {
    padding: 30px 30px 20px;
    background: linear-gradient(135deg, #f8f9ff 0%, #e8f0ff 100%);
}

.card-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 8px;
}

.card-subtitle {
    color: #666;
    font-size: 0.95rem;
}

.card-content {
    padding: 30px;
}

.form-group {
    margin-bottom: 25px;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
    font-size: 0.95rem;
}

.form-input {
    width: 100%;
    padding: 15px 20px;
    border: 2px solid #e1e5e9;
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s ease;
    box-sizing: border-box;
    background: #fafafa;
}

.form-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    background: white;
}

.form-input::placeholder {
    color: #999;
}

.input-icon {
    position: relative;
}

.input-icon .icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #999;
    font-size: 18px;
}

.input-icon .form-input {
    padding-left: 50px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.btn-update {
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
    border: none;
    padding: 15px 30px;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
}

.btn-update:hover {
    background: linear-gradient(45deg, #764ba2, #667eea);
    transform: translateY(-2px);
    box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
}

.btn-update:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
}

.loading-spinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 2px solid #ffffff;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.password-section {
    margin-top: 30px;
    padding-top: 30px;
    border-top: 2px solid #f0f0f0;
}

.password-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 20px;
}

.password-hint {
    font-size: 0.85rem;
    color: #666;
    margin-top: 5px;
    line-height: 1.4;
}

.account-info {
    background: linear-gradient(135deg, #f8f9ff 0%, #e8f0ff 100%);
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 25px;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid rgba(102, 126, 234, 0.1);
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    font-size: 0.9rem;
    color: #666;
    font-weight: 500;
}

.info-value {
    font-size: 0.95rem;
    color: #333;
    font-weight: 600;
}

.security-tips {
    background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
    border: 1px solid #ffeaa7;
    border-radius: 15px;
    padding: 20px;
    margin-top: 25px;
}

.security-tips h4 {
    font-size: 1rem;
    font-weight: 600;
    color: #856404;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.security-tips ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.security-tips li {
    color: #856404;
    font-size: 0.9rem;
    margin-bottom: 5px;
    padding-left: 20px;
    position: relative;
}

.security-tips li::before {
    content: '🔒';
    position: absolute;
    left: 0;
    top: 0;
}

.back-button {
    margin-bottom: 30px;
}

.back-link {
    display: inline-flex;
    align-items: center;
    color: white;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.1);
    padding: 10px 20px;
    border-radius: 25px;
    backdrop-filter: blur(10px);
}

.back-link:hover {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    text-decoration: none;
    transform: translateX(-5px);
}

.back-link svg {
    margin-right: 8px;
    transition: transform 0.3s ease;
}

.back-link:hover svg {
    transform: translateX(-3px);
}

/* Subscription History Styles */
.subscription-history {
    grid-column: 1 / -1;
    margin-top: 30px;
}

.history-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.history-table th {
    background: linear-gradient(135deg, #f8f9ff 0%, #e8f0ff 100%);
    padding: 20px 15px;
    text-align: left;
    font-weight: 600;
    color: #333;
    border-bottom: 2px solid #e9ecef;
    font-size: 0.95rem;
}

.history-table td {
    padding: 20px 15px;
    border-bottom: 1px solid #e9ecef;
    color: #555;
    font-size: 0.9rem;
}

.history-table tr:hover {
    background: rgba(102, 126, 234, 0.05);
}

.history-table tr:last-child td {
    border-bottom: none;
}

.status-badge {
    display: inline-block;
    padding: 6px 15px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: capitalize;
}

.status-active {
    background: linear-gradient(45deg, #28a745, #20c997);
    color: white;
}

.status-cancelled {
    background: linear-gradient(45deg, #dc3545, #c82333);
    color: white;
}

.status-expired {
    background: linear-gradient(45deg, #6c757d, #5a6268);
    color: white;
}

.status-pending {
    background: linear-gradient(45deg, #ffc107, #e0a800);
    color: white;
}

.no-history {
    text-align: center;
    padding: 60px 30px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 15px;
    color: #666;
}

.no-history-icon {
    font-size: 3rem;
    margin-bottom: 20px;
    opacity: 0.5;
}

.no-history h3 {
    font-size: 1.3rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 10px;
}

.no-history p {
    margin: 0;
    font-size: 1rem;
}

@media (max-width: 768px) {
    .profile-title {
        font-size: 2.2rem;
    }
    
    .profile-grid {
        grid-template-columns: 1fr;
        gap: 25px;
    }
    
    .form-row {
        grid-template-columns: 1fr;
        gap: 0;
    }
    
    .card-header, .card-content {
        padding: 25px 20px;
    }
    
    .history-table {
        font-size: 0.8rem;
    }
    
    .history-table th,
    .history-table td {
        padding: 15px 10px;
    }
}
</style>
@endpush

@section('content')
<div class="profile-page">
    <!-- Back Button -->
    <div class="profile-container">
        <div class="back-button">
            <a href="{{ route('user.dashboard') }}" class="back-link">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Dashboard
            </a>
        </div>

        <!-- Header -->
        <div class="profile-header">
            <h1 class="profile-title">Profile Settings</h1>
            <p class="profile-subtitle">
                Manage your personal information, account security, and view your subscription history
            </p>
        </div>

        <div class="profile-grid">
            <!-- Personal Information -->
            <div class="profile-card">
                <div class="card-header">
                    <h2 class="card-title">Personal Information</h2>
                    <p class="card-subtitle">Update your personal details</p>
                </div>
                <div class="card-content">
                    <form id="profile-form">
                        @csrf
                        <div class="form-row">
                            <div class="form-group">
                                <label for="first_name" class="form-label">First Name</label>
                                <div class="input-icon">
                                    <span class="icon">👤</span>
                                    <input type="text" id="first_name" name="first_name" 
                                           value="{{ $user->first_name }}" 
                                           class="form-input" placeholder="Enter your first name" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="last_name" class="form-label">Last Name</label>
                                <div class="input-icon">
                                    <span class="icon">👤</span>
                                    <input type="text" id="last_name" name="last_name" 
                                           value="{{ $user->last_name }}" 
                                           class="form-input" placeholder="Enter your last name" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="form-label">Email Address</label>
                            <div class="input-icon">
                                <span class="icon">📧</span>
                                <input type="email" id="email" name="email" 
                                       value="{{ $user->email }}" 
                                       class="form-input" placeholder="Enter your email address" required>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn-update">
                            <span class="btn-text">Update Profile</span>
                            <span class="loading-spinner" style="display: none;"></span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Account Security -->
            <div class="profile-card">
                <div class="card-header">
                    <h2 class="card-title">Account Security</h2>
                    <p class="card-subtitle">Change your password and security settings</p>
                </div>
                <div class="card-content">
                    <!-- Account Information -->
                    <div class="account-info">
                        <div class="info-item">
                            <span class="info-label">Username</span>
                            <span class="info-value">{{ $user->user_name }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Member Since</span>
                            <span class="info-value">{{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Last Updated</span>
                            <span class="info-value">{{ $user->updated_at->format('M d, Y') }}</span>
                        </div>
                    </div>

                    <!-- Password Change Form -->
                    <form id="password-form">
                        @csrf
                        <div class="password-section">
                            <h3 class="password-title">Change Password</h3>
                            
                            <div class="form-group">
                                <label for="current_password" class="form-label">Current Password</label>
                                <div class="input-icon">
                                    <span class="icon">🔒</span>
                                    <input type="password" id="current_password" name="current_password" 
                                           class="form-input" placeholder="Enter current password" required>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="new_password" class="form-label">New Password</label>
                                <div class="input-icon">
                                    <span class="icon">🔑</span>
                                    <input type="password" id="new_password" name="new_password" 
                                           class="form-input" placeholder="Enter new password" required>
                                </div>
                                <div class="password-hint">
                                    Password must be at least 8 characters long and include uppercase, lowercase, and numbers.
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                                <div class="input-icon">
                                    <span class="icon">✅</span>
                                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" 
                                           class="form-input" placeholder="Confirm new password" required>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn-update">
                                <span class="btn-text">Change Password</span>
                                <span class="loading-spinner" style="display: none;"></span>
                            </button>
                        </div>
                    </form>

                    <!-- Security Tips -->
                    <div class="security-tips">
                        <h4>
                            <span>🛡️</span>
                            Security Tips
                        </h4>
                        <ul>
                            <li>Use a strong, unique password</li>
                            <li>Never share your login credentials</li>
                            <li>Log out from shared devices</li>
                            <li>Keep your email address updated</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Subscription History -->
            <div class="subscription-history">
                <div class="profile-card">
                    <div class="card-header">
                        <h2 class="card-title">Subscription History</h2>
                        <p class="card-subtitle">View your past and current subscriptions</p>
                    </div>
                    <div class="card-content">
                        @if($subscriptionHistory && $subscriptionHistory->count() > 0)
                            <table class="history-table">
                                <thead>
                                    <tr>
                                        <th>Plan</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subscriptionHistory as $subscription)
                                        <tr>
                                            <td>
                                                <strong>{{ $subscription->subscriptionPlan->name }}</strong>
                                                <br>
                                                <small style="color: #666;">{{ $subscription->subscriptionPlan->duration }}</small>
                                            </td>
                                            <td>
                                                <span class="status-badge status-{{ $subscription->status }}">
                                                    {{ ucfirst($subscription->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <strong>${{ number_format($subscription->subscriptionPlan->price, 2) }}</strong>
                                            </td>
                                            <td>{{ $subscription->starts_at ? $subscription->starts_at->format('M d, Y') : 'N/A' }}</td>
                                            <td>{{ $subscription->ends_at ? $subscription->ends_at->format('M d, Y') : 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="no-history">
                                <div class="no-history-icon">📺</div>
                                <h3>No Subscription History</h3>
                                <p>You haven't made any subscriptions yet. Start your IPTV journey today!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Profile Update Form
document.getElementById('profile-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitButton = this.querySelector('.btn-update');
    const btnText = submitButton.querySelector('.btn-text');
    const spinner = submitButton.querySelector('.loading-spinner');
    
    // Show loading state
    submitButton.disabled = true;
    btnText.style.display = 'none';
    spinner.style.display = 'inline-block';
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    fetch('{{ route("user.profile.update") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Profile Updated!',
                text: data.message,
                timer: 2000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Update Failed',
                text: data.message,
                confirmButtonColor: '#667eea'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Something went wrong. Please try again.',
            confirmButtonColor: '#667eea'
        });
    })
    .finally(() => {
        // Reset button state
        submitButton.disabled = false;
        btnText.style.display = 'inline';
        spinner.style.display = 'none';
    });
});

// Password Change Form
document.getElementById('password-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitButton = this.querySelector('.btn-update');
    const btnText = submitButton.querySelector('.btn-text');
    const spinner = submitButton.querySelector('.loading-spinner');
    
    // Validate password confirmation
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = document.getElementById('new_password_confirmation').value;
    
    if (newPassword !== confirmPassword) {
        Swal.fire({
            icon: 'error',
            title: 'Password Mismatch',
            text: 'New password and confirmation do not match.',
            confirmButtonColor: '#667eea'
        });
        return;
    }
    
    // Show loading state
    submitButton.disabled = true;
    btnText.style.display = 'none';
    spinner.style.display = 'inline-block';
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    fetch('{{ route("user.password.change") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Password Changed!',
                text: data.message,
                timer: 2000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            }).then(() => {
                // Clear password fields
                document.getElementById('current_password').value = '';
                document.getElementById('new_password').value = '';
                document.getElementById('new_password_confirmation').value = '';
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Password Change Failed',
                text: data.message,
                confirmButtonColor: '#667eea'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Something went wrong. Please try again.',
            confirmButtonColor: '#667eea'
        });
    })
    .finally(() => {
        // Reset button state
        submitButton.disabled = false;
        btnText.style.display = 'inline';
        spinner.style.display = 'none';
    });
});

// Password confirmation validation
document.getElementById('new_password_confirmation').addEventListener('input', function() {
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = this.value;
    
    if (confirmPassword && newPassword !== confirmPassword) {
        this.setCustomValidity('Passwords do not match');
        this.style.borderColor = '#e53e3e';
    } else {
        this.setCustomValidity('');
        this.style.borderColor = '#e1e5e9';
    }
});
</script>
@endsection
