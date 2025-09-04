@include('layouts.admin.loginHeader')
<style>
    .page-wrapper {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    
    .login-container {
        background: white;
        border-radius: 20px;
        box-shadow: 0 25px 50px rgba(0,0,0,0.2);
        padding: 50px;
        width: 100%;
        max-width: 450px;
        position: relative;
        overflow: hidden;
    }
    
    .login-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, #667eea, #764ba2);
    }
    
    .login-header {
        text-align: center;
        margin-bottom: 40px;
    }
    
    .admin-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        color: white;
        font-size: 32px;
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    }
    
    .login-title {
        font-size: 2rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 8px;
    }
    
    .login-subtitle {
        color: #666;
        font-size: 1rem;
        font-weight: 500;
    }
    
    .form-group {
        margin-bottom: 25px;
        position: relative;
    }
    
    .form-label {
        display: block;
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }
    
    .input-group {
        position: relative;
    }
    
    .input-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
        font-size: 18px;
        z-index: 2;
    }
    
    .form-control {
        width: 100%;
        padding: 15px 20px 15px 50px;
        border: 2px solid #e1e5e9;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #fafafa;
        box-sizing: border-box;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        background: white;
    }
    
    .form-control::placeholder {
        color: #999;
    }
    
    .btn-login {
        width: 100%;
        background: linear-gradient(45deg, #667eea, #764ba2);
        color: white;
        border: none;
        padding: 15px 30px;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        margin-top: 10px;
    }
    
    .btn-login:hover {
        background: linear-gradient(45deg, #764ba2, #667eea);
        transform: translateY(-2px);
        box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
    }
    
    .btn-login:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }
    
    .loading-spinner {
        display: none;
        border: 3px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: #fff;
        width: 20px;
        height: 20px;
        animation: spin 1s ease-in-out infinite;
        margin-right: 10px;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    .footer-link {
        text-align: center;
        margin-top: 30px;
        padding-top: 25px;
        border-top: 1px solid #e9ecef;
    }
    
    .footer-link p {
        color: #666;
        font-size: 0.95rem;
        margin: 0;
    }
    
    .footer-link a {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }
    
    .footer-link a:hover {
        color: #764ba2;
        text-decoration: none;
    }
    
    .error-message {
        color: #dc3545;
        font-size: 0.9rem;
        margin-top: 5px;
        display: none;
    }
    
    @media (max-width: 768px) {
        .login-container {
            padding: 40px 30px;
            margin: 20px;
        }
        
        .login-title {
            font-size: 1.7rem;
        }
        
        .admin-icon {
            width: 70px;
            height: 70px;
            font-size: 28px;
        }
    }
</style>

<div class="page-wrapper">
    <div class="login-container">
        <div class="login-header">
            <div class="admin-icon">
                🛡️
            </div>
            <h1 class="login-title">Admin Panel</h1>
            <p class="login-subtitle">Super IPTV Management System</p>
        </div>
        
        <form id="adminLoginForm" method="POST">
            @csrf
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <div class="input-group">
                    <span class="input-icon">👤</span>
                    <input type="email" id="email" name="email" class="form-control" 
                           placeholder="keval@grr.la" required>
                </div>
                <div class="error-message" id="email-error"></div>
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-icon">🔒</span>
                    <input type="password" id="password" name="password" class="form-control" 
                           placeholder="Enter your password" required>
                </div>
                <div class="error-message" id="password-error"></div>
            </div>
            
            <button type="submit" class="btn-login">
                <span class="loading-spinner"></span>
                <span class="btn-text">Sign In to Admin Panel</span>
            </button>
        </form>
        
        <div class="footer-link">
            <p>Regular user? <a href="{{ route('user.login') }}">Access user portal</a></p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('adminLoginForm');
    const submitButton = form.querySelector('.btn-login');
    const btnText = submitButton.querySelector('.btn-text');
    const spinner = submitButton.querySelector('.loading-spinner');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Clear previous errors
        clearErrors();
        
        // Show loading state
        submitButton.disabled = true;
        btnText.style.display = 'none';
        spinner.style.display = 'inline-block';
        
        // Get form data
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        
        // Make AJAX request
        fetch('{{ route("admin.login") }}', {
            method: 'POST',
            credentials: 'same-origin', // include session cookie on same-origin requests
            headers: {
                'Accept': 'application/json',
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
                    title: 'Login Successful!',
                    text: 'Redirecting to admin dashboard...',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = '{{ route("admin.home") }}';
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Login Failed',
                    text: data.message || 'Invalid credentials. Please try again.',
                    confirmButtonColor: '#667eea'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
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
    
    function clearErrors() {
        const errorElements = document.querySelectorAll('.error-message');
        errorElements.forEach(element => {
            element.style.display = 'none';
            element.textContent = '';
        });
    }
    
    // Form validation
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    
    emailInput.addEventListener('blur', function() {
        if (!this.value) {
            showError('email-error', 'Email is required');
        } else if (!isValidEmail(this.value)) {
            showError('email-error', 'Please enter a valid email address');
        }
    });
    
    passwordInput.addEventListener('blur', function() {
        if (!this.value) {
            showError('password-error', 'Password is required');
        }
    });
    
    function showError(elementId, message) {
        const errorElement = document.getElementById(elementId);
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }
    
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
});
</script>

@include('layouts.admin.loginFooter')
