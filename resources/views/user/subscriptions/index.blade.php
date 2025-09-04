@extends('layouts.web')

@section('title', 'IPTV Subscription Plans - Super IPTV')

@push('styles')
<style>
.iptv-subscription-page {
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

.subscription-header {
    text-align: center;
    margin-bottom: 60px;
    color: white;
}

.subscription-title {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 20px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    background: linear-gradient(45deg, #fff, #f0f0f0);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.subscription-subtitle {
    font-size: 1.3rem;
    opacity: 0.9;
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
}

.plans-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.plans-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 30px;
    margin-bottom: 50px;
}

.plan-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: all 0.3s ease;
    position: relative;
}

.plan-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 30px 60px rgba(0,0,0,0.2);
}

.plan-card.popular {
    transform: scale(1.05);
    border: 3px solid #667eea;
}

.plan-card.popular::before {
    content: 'MOST POPULAR';
    position: absolute;
    top: 20px;
    right: -30px;
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
    padding: 8px 40px;
    font-size: 12px;
    font-weight: bold;
    transform: rotate(45deg);
    z-index: 10;
}

.plan-header {
    padding: 40px 30px 20px;
    text-align: center;
    background: linear-gradient(135deg, #f8f9ff 0%, #e8f0ff 100%);
}

.plan-name {
    font-size: 1.8rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 10px;
}

.plan-type {
    color: #666;
    font-size: 1rem;
    margin-bottom: 20px;
}

.plan-price {
    display: flex;
    align-items: baseline;
    justify-content: center;
    margin-bottom: 10px;
}

.price-current {
    font-size: 3rem;
    font-weight: 800;
    color: #667eea;
}

.price-original {
    font-size: 1.2rem;
    color: #999;
    text-decoration: line-through;
    margin-left: 15px;
}

.plan-duration {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 15px;
}

.discount-badge {
    display: inline-block;
    background: linear-gradient(45deg, #ff6b6b, #ee5a24);
    color: white;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: bold;
}

.plan-features {
    padding: 30px;
}

.features-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 20px;
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
    padding: 12px 0;
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
    width: 20px;
    height: 20px;
    background: linear-gradient(45deg, #4CAF50, #45a049);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    flex-shrink: 0;
}

.feature-icon::before {
    content: '✓';
    color: white;
    font-size: 12px;
    font-weight: bold;
}

.feature-text {
    color: #555;
    font-size: 0.95rem;
    line-height: 1.4;
    font-weight: 500;
}

.plan-button {
    margin: 30px;
    margin-top: 0;
}

.btn-subscribe {
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
    text-decoration: none;
    display: block;
    text-align: center;
}

.btn-subscribe:hover {
    background: linear-gradient(45deg, #764ba2, #667eea);
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
    color: white;
    text-decoration: none;
}

.current-subscription {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    margin-top: 40px;
}

.current-subscription h2 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 20px;
    text-align: center;
}

.subscription-info {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: linear-gradient(135deg, #f8f9ff 0%, #e8f0ff 100%);
    padding: 20px;
    border-radius: 15px;
}

.subscription-details h3 {
    font-size: 1.2rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 5px;
}

.subscription-details p {
    color: #666;
    margin: 0;
}

.status-badge {
    background: linear-gradient(45deg, #4CAF50, #45a049);
    color: white;
    padding: 8px 20px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
}

@media (max-width: 768px) {
    .subscription-title {
        font-size: 2.5rem;
    }
    
    .plans-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .plan-card.popular {
        transform: none;
    }
    
    .subscription-info {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }
}
</style>
@endpush

@section('content')
<div class="iptv-subscription-page">
    <!-- Back Button -->
    <div class="back-button">
        <a href="{{ route('user.profile') }}" class="back-link">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Profile
        </a>
    </div>

    <div class="plans-container">
        <!-- Header -->
        <div class="subscription-header">
            <h1 class="subscription-title">IPTV SUBSCRIPTION</h1>
            <p class="subscription-subtitle">
                Unlock unlimited entertainment with our premium IPTV plans. 
                Access thousands of channels, movies, and TV shows in crystal clear quality.
            </p>
        </div>

        <!-- Plans Grid -->
        <div class="plans-grid">
            @foreach($plans as $plan)
                <div class="plan-card {{ $plan->is_popular ? 'popular' : '' }}">
                    <div class="plan-header">
                        <h3 class="plan-name">{{ $plan->name }}</h3>
                        <p class="plan-type">{{ $plan->type }}</p>
                        
                        <div class="plan-price">
                            <span class="price-current">${{ number_format($plan->price, 0) }}</span>
                            @if($plan->original_price > $plan->price)
                                <span class="price-original">${{ number_format($plan->original_price, 0) }}</span>
                            @endif
                        </div>
                        
                        <p class="plan-duration">{{ $plan->duration }}</p>
                        
                        @if($plan->discount_percentage > 0)
                            <span class="discount-badge">Save {{ $plan->discount_percentage }}%</span>
                        @endif
                    </div>

                    <div class="plan-features">
                        <h4 class="features-title">What's Included</h4>
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

                    <div class="plan-button">
                        <a href="{{ route('user.subscriptions.show', $plan) }}" class="btn-subscribe">
                            Subscribe Now
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Current Subscription -->
        @if($activeSubscription)
            <div class="current-subscription">
                <h2>Your Current Subscription</h2>
                <div class="subscription-info">
                    <div class="subscription-details">
                        <h3>{{ $activeSubscription->subscriptionPlan->name }}</h3>
                        <p>Expires on {{ $activeSubscription->ends_at->format('M d, Y') }}</p>
                    </div>
                    <span class="status-badge">Active</span>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
