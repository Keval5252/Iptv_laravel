@extends('layouts.web')

@section('title', 'Login - Super IPTV')

@push('styles')
<style>
.auth-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.auth-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    padding: 40px;
    width: 100%;
    max-width: 400px;
    position: relative;
    overflow: hidden;
}

.auth-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2);
}

.auth-header {
    text-align: center;
    margin-bottom: 30px;
}

.auth-logo {
    font-size: 28px;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
}

.auth-logo .highlight {
    color: #667eea;
}

.auth-subtitle {
    color: #666;
    font-size: 14px;
}

.auth-form {
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-label {
    display: block;
    font-weight: 500;
    color: #333;
    margin-bottom: 8px;
    font-size: 14px;
}

.form-input {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e1e5e9;
    border-radius: 10px;
    font-size: 16px;
    transition: all 0.3s ease;
    box-sizing: border-box;
}

.form-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-input::placeholder {
    color: #999;
}

.input-icon {
    position: relative;
}

.input-icon .icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #999;
    font-size: 16px;
}

.input-icon .form-input {
    padding-left: 40px;
}

.form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.checkbox-group {
    display: flex;
    align-items: center;
}

.checkbox-group input[type="checkbox"] {
    margin-right: 8px;
    transform: scale(1.1);
}

.checkbox-group label {
    font-size: 14px;
    color: #666;
    cursor: pointer;
}

.forgot-link {
    color: #667eea;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
}

.forgot-link:hover {
    color: #764ba2;
}

.btn-primary {
    width: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 14px;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
}

.btn-primary:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
}

.auth-links {
    text-align: center;
    margin-top: 20px;
}

.auth-links p {
    color: #666;
    font-size: 14px;
    margin: 5px 0;
}

.auth-links a {
    color: #667eea;
    text-decoration: none;
    font-weight: 500;
}

.auth-links a:hover {
    color: #764ba2;
}

.admin-link {
    text-align: center;
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid #eee;
}

.admin-link p {
    color: #999;
    font-size: 12px;
    margin: 0;
}

.admin-link a {
    color: #666;
    text-decoration: none;
    font-weight: 500;
}

.admin-link a:hover {
    color: #333;
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

@media (max-width: 480px) {
    .auth-container {
        padding: 10px;
    }
    
    .auth-card {
        padding: 30px 20px;
    }
    
    .auth-logo {
        font-size: 24px;
    }
}
</style>
@endpush

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo">
                Super <span class="highlight">IPTV</span>
            </div>
            <div class="auth-subtitle">Sign in to access your account</div>
        </div>

        <form id="loginForm" class="auth-form">
            @csrf
            
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <div class="input-icon">
                    <span class="icon">📧</span>
                    <input type="email" id="email" name="email" class="form-input" 
                           placeholder="Enter your email address" required>
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="input-icon">
                    <span class="icon">🔒</span>
                    <input type="password" id="password" name="password" class="form-input" 
                           placeholder="Enter your password" required>
                </div>
            </div>

            <div class="form-options">
                <div class="checkbox-group">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember me</label>
                </div>
                <a href="#" class="forgot-link">Forgot password?</a>
            </div>

            <button type="submit" class="btn-primary">
                <span class="btn-text">Sign In</span>
                <span class="loading-spinner" style="display: none;"></span>
            </button>
        </form>

        <div class="auth-links">
            <p>Don't have an account? <a href="{{ route('user.register') }}">Create one here</a></p>
        </div>

        <div class="admin-link">
            <p>Admin? <a href="{{ route('admin.login.page') }}">Access admin panel</a></p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitButton = this.querySelector('.btn-primary');
    const btnText = submitButton.querySelector('.btn-text');
    const spinner = submitButton.querySelector('.loading-spinner');
    
    // Show loading state
    submitButton.disabled = true;
    btnText.style.display = 'none';
    spinner.style.display = 'inline-block';
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    fetch('{{ route("user.login") }}', {
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
                title: 'Welcome back!',
                text: data.message,
                timer: 2000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            }).then(() => {
                window.location.href = data.redirect;
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
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
</script>
@endsection
