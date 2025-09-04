@extends('layouts.web')

@section('title', 'IPTV Subscription - MULTI CONNECTIONS SUBSCRIPTION')

@section('content')
    <div class="mt-16 container">
        <h1 class="text-3xl font-bold text-black text-center mb-12 uppercase">MULTI CONNECTIONS SUBSCRIPTION</h1>
        <div class="mt-16">
            @php
                $plans = getPlansByPage('multi-connections-prices');
            @endphp
            
            @if($plans && $plans->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($plans as $plan)
                        <div class="border border-gray-200 rounded-sm shadow-sm p-8 flex flex-col items-center bg-white w-full max-w-md mx-auto">
                            <div class="text-primary text-lg font-medium mb-2">
                                {{ $plan->name }}
                                @if($plan->is_popular)
                                    <span class="block text-xs text-primary font-bold">MOST POPULAR</span>
                                @endif
                            </div>
                            <div class="text-5xl font-bold mb-2">${{ number_format($plan->price, 2) }}</div>
                            @if($plan->original_price > $plan->price)
                                <div class="text-gray-500 mb-4">Original price ${{ number_format($plan->original_price, 2) }}</div>
                            @endif
                            <hr class="w-full mb-4 text-gray-200" />
                            @if($plan->features && count($plan->features) > 0)
                                <ul class="text-left text-gray-700 space-y-1 mb-6">
                                    @foreach($plan->features as $feature)
                                        <li>• {{ $feature }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <ul class="text-left text-gray-700 space-y-1 mb-6">
                                    <li>• 12,000 Channels</li>
                                    <li><b>• With Adult Channels & Movies</b></li>
                                    <li>• Over 86,000 Movies & TV Shows</li>
                                    <li>• 14,000 TV Shows & Series</li>
                                    <li>• 4K,2K,FHD,HD & SD Channels</li>
                                    <li>• Premium Channels</li>
                                    <li>• All Applications</li>
                                    <li>• Watch Online Live TV 24/7</li>
                                    <li>• Free Updates</li>
                                    <li>• TV Guide (EPG)</li>
                                    <li>• Support All Devices</li>
                                    <li>• 24/7 support</li>
                                    <li>• AntiFreeze Technology</li>
                                    <li>• 99.9% Uptime</li>
                                    <li>• 2024 Best IPTV Service</li>
                                </ul>
                            @endif
                            <a href="{{ route('user.login') }}"
                                class="bg-amber-500 text-white font-medium px-8 py-3 rounded hover:bg-amber-600 transition">
                                Login to Subscribe
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <h3 class="text-xl font-semibold text-gray-600 mb-4">No subscription plans available at the moment.</h3>
                    <p class="text-gray-500">Please check back later for our latest offers.</p>
                </div>
            @endif
        </div>
    </div>
@endsection 