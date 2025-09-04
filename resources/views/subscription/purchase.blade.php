@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h3 class="mb-0"><i class="fas fa-credit-card me-2"></i>Complete Your Purchase</h3>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-primary mb-3">Plan Details</h5>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h4 class="text-primary">{{ $plan->name }}</h4>
                                    <div class="display-6 fw-bold text-primary mb-2">
                                        {{ $plan->formatted_price }}
                                    </div>
                                    <p class="text-muted mb-3">per {{ $plan->duration }}</p>
                                    
                                    @if($plan->features)
                                        <h6>Features:</h6>
                                        <ul class="list-unstyled">
                                            @foreach($plan->features as $feature)
                                                <li><i class="fas fa-check text-success me-2"></i>{{ $feature }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <h5 class="text-primary mb-3">Payment Information</h5>
                            <form id="payment-form">
                                <div class="mb-3">
                                    <label for="card-element" class="form-label">Credit or debit card</label>
                                    <div id="card-element" class="form-control">
                                        <!-- Stripe Elements will create input elements here -->
                                    </div>
                                    <div id="card-errors" class="invalid-feedback d-block" role="alert"></div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email for receipt</label>
                                    <input type="email" id="email" class="form-control" value="{{ $user->email }}" readonly>
                                </div>
                                
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg" id="submit-button">
                                        <i class="fas fa-lock me-2"></i>Pay {{ $plan->formatted_price }}
                                    </button>
                                </div>
                                
                                <div class="text-center mt-3">
                                    <small class="text-muted">
                                        <i class="fas fa-shield-alt me-1"></i>
                                        Your payment is secure and encrypted
                                    </small>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <a href="{{ route('subscription.plans') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Plans
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Stripe.js -->
<script src="https://js.stripe.com/v3/"></script>

<script>
// Initialize Stripe
const stripe = Stripe('{{ config("services.stripe.key") }}');
const elements = stripe.elements();

// Create card element
const cardElement = elements.create('card', {
    style: {
        base: {
            fontSize: '16px',
            color: '#424770',
            '::placeholder': {
                color: '#aab7c4',
            },
        },
        invalid: {
            color: '#9e2146',
        },
    },
});

// Mount card element
cardElement.mount('#card-element');

// Handle form submission
const form = document.getElementById('payment-form');
const submitButton = document.getElementById('submit-button');

form.addEventListener('submit', async (event) => {
    event.preventDefault();
    
    // Disable submit button
    submitButton.disabled = true;
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
    
    try {
        // Create payment intent
        const response = await fetch('{{ route("stripe.create-payment-intent") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                plan_id: {{ $plan->id }}
            })
        });
        
        const data = await response.json();
        
        if (data.error) {
            throw new Error(data.error);
        }
        
        // Confirm payment
        const { error, paymentIntent } = await stripe.confirmCardPayment(data.client_secret, {
            payment_method: {
                card: cardElement,
                billing_details: {
                    email: '{{ $user->email }}',
                    name: '{{ $user->full_name }}'
                }
            }
        });
        
        if (error) {
            throw new Error(error.message);
        }
        
        // Payment successful
        if (paymentIntent.status === 'succeeded') {
            // Confirm payment on server
            const confirmResponse = await fetch('{{ route("stripe.confirm-payment") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    payment_intent_id: paymentIntent.id
                })
            });
            
            const confirmData = await confirmResponse.json();
            
            if (confirmData.success) {
                // Redirect to dashboard
                window.location.href = '{{ route("subscription.dashboard") }}';
            } else {
                throw new Error(confirmData.error || 'Payment confirmation failed');
            }
        }
        
    } catch (error) {
        console.error('Payment error:', error);
        
        // Show error message
        const errorElement = document.getElementById('card-errors');
        errorElement.textContent = error.message;
        errorElement.style.display = 'block';
        
        // Re-enable submit button
        submitButton.disabled = false;
        submitButton.innerHTML = '<i class="fas fa-lock me-2"></i>Pay {{ $plan->formatted_price }}';
    }
});

// Handle card element errors
cardElement.addEventListener('change', ({error}) => {
    const displayError = document.getElementById('card-errors');
    if (error) {
        displayError.textContent = error.message;
        displayError.style.display = 'block';
    } else {
        displayError.textContent = '';
        displayError.style.display = 'none';
    }
});
</script>

<style>
#card-element {
    padding: 12px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    background: white;
}

#card-element.StripeElement--focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

#card-element.StripeElement--invalid {
    border-color: #dc3545;
}

#card-errors {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}
</style>
@endsection 