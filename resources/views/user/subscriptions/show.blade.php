@extends('layouts.web')

@section('title', $plan->name . ' - IPTV Subscription - Super IPTV')

@push('styles')
<style>
.subscription-detail-page {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    padding: 40px 0;
}

.back-button {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
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

.subscription-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.subscription-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    align-items: start;
}

.plan-details-card {
    background: white;
    border-radius: 25px;
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
    overflow: hidden;
    position: relative;
}

.plan-details-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, #667eea, #764ba2);
}

.plan-header {
    padding: 40px 40px 20px;
    text-align: center;
    background: linear-gradient(135deg, #f8f9ff 0%, #e8f0ff 100%);
}

.popular-badge {
    display: inline-block;
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
    padding: 8px 20px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 20px;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

.plan-title {
    font-size: 2.2rem;
    font-weight: 800;
    color: #333;
    margin-bottom: 10px;
}

.plan-type {
    color: #666;
    font-size: 1.1rem;
    margin-bottom: 25px;
}

.plan-pricing {
    margin-bottom: 20px;
}

.price-display {
    display: flex;
    align-items: baseline;
    justify-content: center;
    margin-bottom: 10px;
}

.current-price {
    font-size: 3.5rem;
    font-weight: 800;
    color: #667eea;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
}

.original-price {
    font-size: 1.3rem;
    color: #999;
    text-decoration: line-through;
    margin-left: 15px;
}

.plan-duration {
    color: #666;
    font-size: 1rem;
    margin-bottom: 15px;
}

.discount-badge {
    display: inline-block;
    background: linear-gradient(45deg, #ff6b6b, #ee5a24);
    color: white;
    padding: 6px 18px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: bold;
    box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3);
}

.plan-features {
    padding: 40px;
}

.features-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 25px;
    text-align: center;
}

.features-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.feature-item {
    display: flex;
    align-items: center;
    padding: 15px 0;
    border-bottom: 1px solid #f0f0f0;
    transition: all 0.3s ease;
}

.feature-item:last-child {
    border-bottom: none;
}

.feature-item:hover {
    background: rgba(102, 126, 234, 0.05);
    padding-left: 10px;
    border-radius: 10px;
}

.feature-icon {
    width: 24px;
    height: 24px;
    background: linear-gradient(45deg, #4CAF50, #45a049);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    flex-shrink: 0;
    box-shadow: 0 3px 10px rgba(76, 175, 80, 0.3);
}

.feature-icon::before {
    content: '✓';
    color: white;
    font-size: 14px;
    font-weight: bold;
}

.feature-text {
    color: #555;
    font-size: 1rem;
    line-height: 1.5;
    font-weight: 500;
}

.payment-card {
    background: white;
    border-radius: 25px;
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
    overflow: hidden;
    position: relative;
}

.payment-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, #667eea, #764ba2);
}

.payment-header {
    padding: 40px 40px 20px;
    background: linear-gradient(135deg, #f8f9ff 0%, #e8f0ff 100%);
}

.payment-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #333;
    text-align: center;
    margin-bottom: 10px;
}

.payment-subtitle {
    color: #666;
    text-align: center;
    font-size: 1rem;
}

.active-subscription-warning {
    margin: 20px 40px;
    background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
    border: 1px solid #ffeaa7;
    border-radius: 15px;
    padding: 20px;
    display: flex;
    align-items: center;
}

.warning-icon {
    width: 24px;
    height: 24px;
    background: #ffc107;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    flex-shrink: 0;
}

.warning-icon::before {
    content: '⚠';
    color: white;
    font-size: 14px;
    font-weight: bold;
}

.warning-content h3 {
    font-size: 1rem;
    font-weight: 600;
    color: #856404;
    margin-bottom: 5px;
}

.warning-content p {
    font-size: 0.9rem;
    color: #856404;
    margin: 0;
    line-height: 1.4;
}

.payment-form {
    padding: 40px;
}

.payment-method {
    margin-bottom: 30px;
}

.payment-method label {
    display: block;
    font-weight: 600;
    color: #333;
    margin-bottom: 10px;
    font-size: 1rem;
}

.card-element-container {
    border: 2px solid #e1e5e9;
    border-radius: 12px;
    padding: 15px;
    transition: all 0.3s ease;
    background: #fafafa;
}

.card-element-container:focus-within {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    background: white;
}

.card-errors {
    color: #e53e3e;
    font-size: 0.9rem;
    margin-top: 8px;
    font-weight: 500;
}

.order-summary {
    background: linear-gradient(135deg, #f8f9ff 0%, #e8f0ff 100%);
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 30px;
}

.summary-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 20px;
    text-align: center;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid rgba(102, 126, 234, 0.1);
}

.summary-item:last-child {
    border-bottom: none;
    font-weight: 700;
    font-size: 1.1rem;
    color: #333;
    padding-top: 15px;
    border-top: 2px solid #667eea;
}

.summary-label {
    color: #666;
    font-weight: 500;
}

.summary-value {
    color: #333;
    font-weight: 600;
}

.pay-button {
    width: 100%;
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
    border: none;
    padding: 18px 30px;
    border-radius: 15px;
    font-size: 1.2rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
}

.pay-button:hover {
    background: linear-gradient(45deg, #764ba2, #667eea);
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
}

.pay-button:disabled {
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

@media (max-width: 768px) {
    .subscription-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .plan-title {
        font-size: 1.8rem;
    }
    
    .current-price {
        font-size: 2.8rem;
    }
    
    .plan-header, .payment-header, .plan-features, .payment-form {
        padding: 30px 25px;
    }
    
    .active-subscription-warning {
        margin: 20px 25px;
    }
}
</style>
@endpush

@section('content')
<div class="subscription-detail-page">
    <!-- Back Button -->
    <div class="back-button">
        <a href="{{ route('user.subscriptions') }}" class="back-link">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Plans
        </a>
    </div>

    <div class="subscription-container">
        <div class="subscription-grid">
            <!-- Plan Details -->
            <div class="plan-details-card">
                <div class="plan-header">
                    @if($plan->is_popular)
                        <div class="popular-badge">Most Popular</div>
                    @endif
                    <h1 class="plan-title">{{ $plan->name }}</h1>
                    <p class="plan-type">{{ $plan->type }}</p>
                    
                    <div class="plan-pricing">
                        <div class="price-display">
                            <span class="current-price">${{ number_format($plan->price, 0) }}</span>
                            @if($plan->original_price > $plan->price)
                                <span class="original-price">${{ number_format($plan->original_price, 0) }}</span>
                            @endif
                        </div>
                        <p class="plan-duration">{{ $plan->duration }}</p>
                        @if($plan->discount_percentage > 0)
                            <span class="discount-badge">Save {{ $plan->discount_percentage }}%</span>
                        @endif
                    </div>
                </div>

                <div class="plan-features">
                    <h3 class="features-title">What's Included</h3>
                    @if($plan->features)
                        <ul class="features-list">
                            @foreach($plan->features as $feature)
                                <li class="feature-item">
                                    <span class="feature-icon"></span>
                                    <span class="feature-text">{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <!-- Payment Form -->
            <div class="payment-card">
                <div class="payment-header">
                    <h2 class="payment-title">Complete Your Purchase</h2>
                    <p class="payment-subtitle">Secure payment powered by Stripe</p>
                </div>
                
                @if($activeSubscription)
                    <div class="active-subscription-warning">
                        <div class="warning-icon"></div>
                        <div class="warning-content">
                            <h3>Active Subscription</h3>
                            <p>You already have an active subscription. This purchase will replace your current plan.</p>
                        </div>
                    </div>
                @endif

                <div class="payment-form">
                    <form id="payment-form">
                        <div class="payment-method">
                            <label for="card-element">Credit or Debit Card</label>
                            <div class="card-element-container">
                                <div id="card-element">
                                    <!-- Stripe Elements will create form elements here -->
                                </div>
                            </div>
                            <div id="card-errors" class="card-errors"></div>
                        </div>

                        <div class="order-summary">
                            <h3 class="summary-title">Order Summary</h3>
                            <div class="summary-item">
                                <span class="summary-label">Plan:</span>
                                <span class="summary-value">{{ $plan->name }}</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Duration:</span>
                                <span class="summary-value">{{ $plan->duration }}</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Subtotal:</span>
                                <span class="summary-value">${{ number_format($plan->price, 2) }}</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Total:</span>
                                <span class="summary-value">${{ number_format($plan->price, 2) }}</span>
                            </div>
                        </div>

                        <button id="submit-button" class="pay-button">
                            <span id="button-text">Pay ${{ number_format($plan->price, 2) }}</span>
                            <span id="spinner" class="loading-spinner" style="display: none;"></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const stripe = Stripe('{{ config("services.stripe.key") }}');
const elements = stripe.elements();

const cardElement = elements.create('card', {
    style: {
        base: {
            fontSize: '16px',
            color: '#424770',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            '::placeholder': {
                color: '#aab7c4',
            },
        },
        invalid: {
            color: '#e53e3e',
        },
    },
});

cardElement.mount('#card-element');

const cardErrors = document.getElementById('card-errors');
const submitButton = document.getElementById('submit-button');
const buttonText = document.getElementById('button-text');
const spinner = document.getElementById('spinner');

cardElement.on('change', function(event) {
    if (event.error) {
        cardErrors.textContent = event.error.message;
        cardErrors.style.display = 'block';
    } else {
        cardErrors.style.display = 'none';
    }
});

document.getElementById('payment-form').addEventListener('submit', async function(event) {
    event.preventDefault();
    
    // Show loading state
    submitButton.disabled = true;
    buttonText.style.display = 'none';
    spinner.style.display = 'inline-block';
    
    try {
        // Create payment intent
        const response = await fetch('{{ route("user.subscriptions.payment-intent", $plan) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        const { clientSecret } = await response.json();
        
        // Confirm payment
        const { error, paymentIntent } = await stripe.confirmCardPayment(clientSecret, {
            payment_method: {
                card: cardElement,
            }
        });
        
        if (error) {
            Swal.fire({
                icon: 'error',
                title: 'Payment Failed',
                text: error.message,
                confirmButtonColor: '#667eea'
            });
        } else if (paymentIntent.status === 'succeeded') {
            // Confirm payment on server
            const confirmResponse = await fetch('{{ route("user.subscriptions.confirm-payment", $plan) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    payment_intent_id: paymentIntent.id
                })
            });
            
            const result = await confirmResponse.json();
            
            if (result.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Payment Successful!',
                    text: 'Your subscription has been activated.',
                    confirmButtonColor: '#667eea'
                }).then(() => {
                    window.location.href = '{{ route("user.dashboard") }}';
                });
            } else {
                throw new Error(result.error || 'Payment confirmation failed');
            }
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'Something went wrong. Please try again.',
            confirmButtonColor: '#667eea'
        });
    } finally {
        // Reset button state
        submitButton.disabled = false;
        buttonText.style.display = 'inline';
        spinner.style.display = 'none';
    }
});
</script>
@endsection
