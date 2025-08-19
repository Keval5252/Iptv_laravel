@extends('layouts.app')

@section('title', 'IPTV Subscription Plans - Choose Your Perfect Plan')
@section('description', 'Choose from our premium IPTV subscription plans. Get access to thousands of channels, movies, and TV shows with high-quality streaming.')
@section('keywords', 'IPTV plans, subscription packages, premium channels, streaming packages')
@section('author', 'IPTV Service')
@section('robots', 'index, follow')

@section('og_title', 'IPTV Subscription Plans - Choose Your Perfect Plan')
@section('og_description', 'Choose from our premium IPTV subscription plans. Get access to thousands of channels, movies, and TV shows.')
@section('og_type', 'website')
@section('og_url', request()->url())
@section('og_image', asset('images/subscription-og.jpg'))

@section('twitter_card', 'summary_large_image')
@section('twitter_title', 'IPTV Subscription Plans - Choose Your Perfect Plan')
@section('twitter_description', 'Choose from our premium IPTV subscription plans. Get access to thousands of channels, movies, and TV shows.')
@section('twitter_image', asset('images/subscription-twitter.jpg'))

@section('canonical', request()->url())

@section('structured_data')
{
    "@context": "https://schema.org",
    "@type": "Service",
    "name": "IPTV Subscription Plans",
    "description": "Premium IPTV subscription plans with thousands of channels and movies",
    "provider": {
        "@type": "Organization",
        "name": "IPTV Service",
        "url": "{{ config('app.url') }}"
    },
    "offers": {
        "@type": "Offer",
        "priceCurrency": "USD",
        "price": "9.99",
        "description": "Monthly IPTV subscription"
    }
}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>IPTV Subscription Plans</h1>
            <p>Choose from our premium IPTV subscription plans and get access to thousands of channels, movies, and TV shows.</p>

            <!-- Your subscription plans content here -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Basic Plan</h5>
                            <p class="card-text">Perfect for individual users</p>
                            <ul>
                                <li>1000+ Channels</li>
                                <li>Movies & TV Shows</li>
                                <li>HD Quality</li>
                                <li>24/7 Support</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Premium Plan</h5>
                            <p class="card-text">Best value for families</p>
                            <ul>
                                <li>3000+ Channels</li>
                                <li>Movies & TV Shows</li>
                                <li>4K Quality</li>
                                <li>Multi-device support</li>
                                <li>24/7 Support</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Ultimate Plan</h5>
                            <p class="card-text">For power users</p>
                            <ul>
                                <li>5000+ Channels</li>
                                <li>Movies & TV Shows</li>
                                <li>4K & HDR Quality</li>
                                <li>Unlimited devices</li>
                                <li>Priority support</li>
                                <li>24/7 Support</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
