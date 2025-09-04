@extends('layouts.app')

@section('styles')
<style>
/* Modern Professional Subscription Plans */
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    --dark-bg: #0f1419;
    --dark-card: #1a202c;
    --text-light: #e2e8f0;
    --text-muted: #a0aec0;
    --accent-gold: #ffd700;
    --border-color: rgba(255, 255, 255, 0.1);
}

body {
    background: var(--dark-bg);
    color: var(--text-light);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    line-height: 1.6;
}

.hero-section {
    background: linear-gradient(135deg, #0f1419 0%, #1a202c 100%);
    padding: 100px 0 80px;
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 20% 80%, rgba(102, 126, 234, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(118, 75, 162, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 40% 40%, rgba(240, 147, 251, 0.05) 0%, transparent 50%);
}

.hero-content {
    position: relative;
    z-index: 1;
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 1.5rem;
    line-height: 1.1;
    text-align: center;
}

.hero-subtitle {
    font-size: 1.25rem;
    color: var(--text-muted);
    font-weight: 400;
    max-width: 700px;
    margin: 0 auto 3rem;
    text-align: center;
    line-height: 1.7;
}

.plans-container {
    margin-top: -40px;
    position: relative;
    z-index: 2;
    padding-bottom: 60px;
}

.plan-card {
    background: var(--dark-card);
    border: 1px solid var(--border-color);
    border-radius: 24px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    position: relative;
    backdrop-filter: blur(20px);
    height: 100%;
}

.plan-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 25px 50px rgba(102, 126, 234, 0.25);
    border-color: rgba(102, 126, 234, 0.4);
}

.plan-card.featured {
    background: linear-gradient(145deg, var(--dark-card) 0%, #2d1b69 100%);
    border: 2px solid var(--accent-gold);
    transform: scale(1.05);
    box-shadow: 0 20px 40px rgba(255, 215, 0, 0.2);
}

.plan-card.featured:hover {
    transform: translateY(-12px) scale(1.05);
    box-shadow: 0 35px 70px rgba(255, 215, 0, 0.3);
}

.featured-badge {
    position: absolute;
    top: -12px;
    left: 50%;
    transform: translateX(-50%);
    background: var(--accent-gold);
    color: var(--dark-bg);
    padding: 10px 28px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    box-shadow: 0 8px 25px rgba(255, 215, 0, 0.4);
    z-index: 3;
}

.plan-icon {
    width: 90px;
    height: 90px;
    margin: 0 auto 2rem;
    background: var(--primary-gradient);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.2rem;
    color: white;
    box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
    position: relative;
}

.plan-icon::before {
    content: '';
    position: absolute;
    inset: -2px;
    background: var(--primary-gradient);
    border-radius: 50%;
    z-index: -1;
    opacity: 0.3;
    filter: blur(8px);
}

.plan-name {
    font-size: 1.8rem;
    font-weight: 700;
    color: white;
    margin-bottom: 1rem;
    text-align: center;
}

.plan-price {
    font-size: 4.5rem;
    font-weight: 900;
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    line-height: 1;
    margin-bottom: 0.5rem;
    text-align: center;
}

.plan-duration {
    color: var(--text-muted);
    font-size: 1.1rem;
    margin-bottom: 2.5rem;
    text-align: center;
    font-weight: 500;
}

.plan-features {
    list-style: none;
    padding: 0;
    margin: 2rem 0;
}

.plan-features li {
    padding: 1rem 0;
    display: flex;
    align-items: center;
    color: var(--text-light);
    font-weight: 500;
    font-size: 1rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}

.plan-features li:last-child {
    border-bottom: none;
}

.plan-features li::before {
    content: "✓";
    background: var(--success-gradient);
    color: white;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1.2rem;
    font-weight: 700;
    font-size: 1rem;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(79, 172, 254, 0.3);
}

.plan-button {
    background: var(--primary-gradient);
    border: none;
    color: white;
    padding: 18px 45px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1.1rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    position: relative;
    overflow: hidden;
    width: 100%;
    text-align: center;
}

.plan-button:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
    color: white;
}

.plan-button.featured {
    background: linear-gradient(135deg, var(--accent-gold) 0%, #ffed4e 100%);
    color: var(--dark-bg);
}

.plan-button.featured:hover {
    box-shadow: 0 15px 35px rgba(255, 215, 0, 0.5);
    color: var(--dark-bg);
}

.plan-button:disabled {
    background: #4a5568;
    color: #a0aec0;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.features-section {
    background: linear-gradient(135deg, #1a202c 0%, #0f1419 100%);
    padding: 100px 0;
    margin-top: 60px;
}

.feature-card {
    background: var(--dark-card);
    border: 1px solid var(--border-color);
    border-radius: 20px;
    padding: 3rem 2rem;
    text-align: center;
    transition: all 0.3s ease;
    backdrop-filter: blur(20px);
    height: 100%;
}

.feature-card:hover {
    transform: translateY(-8px);
    border-color: rgba(102, 126, 234, 0.3);
    box-shadow: 0 20px 40px rgba(102, 126, 234, 0.15);
}

.feature-icon {
    width: 70px;
    height: 70px;
    margin: 0 auto 2rem;
    background: var(--secondary-gradient);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    color: white;
    box-shadow: 0 10px 25px rgba(240, 147, 251, 0.3);
}

.feature-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: white;
    margin-bottom: 1.2rem;
}

.feature-description {
    color: var(--text-muted);
    line-height: 1.7;
    font-size: 1rem;
}

.alert-custom {
    background: rgba(102, 126, 234, 0.1);
    border: 1px solid rgba(102, 126, 234, 0.3);
    border-radius: 15px;
    color: var(--text-light);
    backdrop-filter: blur(10px);
    margin-bottom: 2rem;
}

.section-title {
    font-size: 2.8rem;
    font-weight: 800;
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 1.5rem;
    text-align: center;
}

.section-subtitle {
    font-size: 1.2rem;
    color: var(--text-muted);
    text-align: center;
    max-width: 600px;
    margin: 0 auto 4rem;
    line-height: 1.7;
}

@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .plan-price {
        font-size: 3.5rem;
    }
    
    .plan-card.featured {
        transform: none;
        margin-bottom: 2rem;
    }
    
    .plan-card.featured:hover {
        transform: translateY(-8px);
    }
    
    .section-title {
        font-size: 2.2rem;
    }
    
    .feature-card {
        padding: 2rem 1.5rem;
    }
}

@media (max-width: 576px) {
    .hero-section {
        padding: 80px 0 60px;
    }
    
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-subtitle {
        font-size: 1.1rem;
    }
    
    .plan-price {
        font-size: 3rem;
    }
    
    .plan-button {
        padding: 15px 35px;
        font-size: 1rem;
    }
}
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">Choose Your Perfect Plan</h1>
            <p class="hero-subtitle">Experience premium IPTV streaming with crystal-clear quality, unlimited channels, and unmatched reliability. Select the plan that fits your entertainment needs.</p>
        </div>
    </div>
</section>

<!-- Alerts Section -->
<div class="container">
    @if(session('success'))
        <div class="alert alert-custom alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-custom alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(isset($activeSubscription) && $activeSubscription)
        <div class="alert alert-custom alert-dismissible fade show" role="alert">
            <i class="fas fa-info-circle me-2"></i>
            You currently have an active subscription: <strong>{{ $activeSubscription->subscriptionPlan->name }}</strong>
            <a href="{{ route('subscription.dashboard') }}" class="btn btn-sm btn-outline-light ms-3">View Dashboard</a>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

<!-- Plans Section -->
<div class="container plans-container">
    <div class="row g-4 justify-content-center">
        @php
            $samplePlans = [
                [
                    'id' => 1,
                    'name' => 'Basic',
                    'price' => 9.99,
                    'duration' => 'month',
                    'icon' => 'fas fa-play-circle',
                    'features' => ['HD Quality Streaming', '500+ Live Channels', '7-Day EPG Guide', 'Mobile App Access', '24/7 Support'],
                    'featured' => false
                ],
                [
                    'id' => 2,
                    'name' => 'Premium',
                    'price' => 19.99,
                    'duration' => 'month',
                    'icon' => 'fas fa-crown',
                    'features' => ['4K Ultra HD Quality', '1000+ Live Channels', '14-Day EPG Guide', 'Multi-Device Access', 'VOD Library', 'Premium Support'],
                    'featured' => true
                ],
                [
                    'id' => 3,
                    'name' => 'Ultimate',
                    'price' => 29.99,
                    'duration' => 'month',
                    'icon' => 'fas fa-gem',
                    'features' => ['8K Quality Streaming', '2000+ Live Channels', '30-Day EPG Guide', 'Unlimited Devices', 'Exclusive Content', 'Priority Support'],
                    'featured' => false
                ]
            ];
        @endphp
        
        @if(isset($plans) && count($plans) > 0)
            @foreach($plans as $index => $plan)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="plan-card {{ isset($plan->is_popular) && $plan->is_popular ? 'featured' : '' }} h-100">
                        @if(isset($plan->is_popular) && $plan->is_popular)
                            <div class="featured-badge">Most Popular</div>
                        @endif
                        
                        <div class="card-body p-5 text-center d-flex flex-column">
                            <div class="plan-icon">
                                <i class="{{ $samplePlans[$index % 3]['icon'] ?? 'fas fa-tv' }}"></i>
                            </div>
                            
                            <h3 class="plan-name">{{ $plan->name }}</h3>
                            
                            <div class="pricing-section mb-4">
                                <div class="plan-price">${{ number_format($plan->price, 2) }}</div>
                                <div class="plan-duration">per {{ $plan->duration ?? 'month' }}</div>
                            </div>

                            <ul class="plan-features">
                                @if(isset($plan->features) && is_array($plan->features))
                                    @foreach($plan->features as $feature)
                                        <li>{{ $feature }}</li>
                                    @endforeach
                                @else
                                    @foreach($samplePlans[$index % 3]['features'] as $feature)
                                        <li>{{ $feature }}</li>
                                    @endforeach
                                @endif
                            </ul>

                            <div class="mt-auto">
                                @if(isset($activeSubscription) && $activeSubscription)
                                    <button class="plan-button" disabled>
                                        <i class="fas fa-check me-2"></i>Current Plan
                                    </button>
                                @else
                                    <a href="{{ route('subscription.purchase', $plan->id) }}" class="plan-button {{ isset($plan->is_popular) && $plan->is_popular ? 'featured' : '' }}">
                                        <i class="fas fa-rocket me-2"></i>Get Started
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            @foreach($samplePlans as $plan)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="plan-card {{ $plan['featured'] ? 'featured' : '' }} h-100">
                        @if($plan['featured'])
                            <div class="featured-badge">Most Popular</div>
                        @endif
                        
                        <div class="card-body p-5 text-center d-flex flex-column">
                            <div class="plan-icon">
                                <i class="{{ $plan['icon'] }}"></i>
                            </div>
                            
                            <h3 class="plan-name">{{ $plan['name'] }}</h3>
                            
                            <div class="pricing-section mb-4">
                                <div class="plan-price">${{ number_format($plan['price'], 2) }}</div>
                                <div class="plan-duration">per {{ $plan['duration'] }}</div>
                            </div>

                            <ul class="plan-features">
                                @foreach($plan['features'] as $feature)
                                    <li>{{ $feature }}</li>
                                @endforeach
                            </ul>

                            <div class="mt-auto">
                                <a href="#" class="plan-button {{ $plan['featured'] ? 'featured' : '' }}">
                                    <i class="fas fa-rocket me-2"></i>Get Started
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

<!-- Features Section -->
<section class="features-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Why Choose Our IPTV Service?</h2>
            <p class="section-subtitle">Experience the future of television with our cutting-edge technology and premium features</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-tv"></i>
                    </div>
                    <h4 class="feature-title">Ultra HD Quality</h4>
                    <p class="feature-description">Experience stunning 4K and 8K quality streaming with crystal-clear picture and immersive sound.</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <h4 class="feature-title">Global Content</h4>
                    <p class="feature-description">Access thousands of channels from around the world with international and local programming.</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h4 class="feature-title">Multi-Device</h4>
                    <p class="feature-description">Watch on any device - Smart TV, mobile, tablet, computer, or streaming device.</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h4 class="feature-title">Secure & Reliable</h4>
                    <p class="feature-description">99.9% uptime guarantee with enterprise-grade security and 24/7 technical support.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
