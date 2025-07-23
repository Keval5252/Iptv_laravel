@extends('layouts.app')

@section('title', 'IPTV Subscription - Super IPTV')

@section('content')
<div class="mt-16 container">
    <h1 class="text-3xl font-bold text-black text-center mb-12 uppercase">IPTV SUBSCRIPTION</h1>
    <h2 class="text-2xl sm:text-3xl font-medium text-black text-center mb-2 uppercase">7-DAY MONEY BACK GUARANTEE</h2>
    <div class="text-center font-semibold mb-2">50% OFF TODAY</div>
    <div class="flex justify-center gap-8 text-center mb-8">
        <div>
            <div class="text-3xl font-bold">00</div>
            <div class="text-sm">Days</div>
        </div>
        <div>
            <div class="text-3xl font-bold">00</div>
            <div class="text-sm">Hours</div>
        </div>
        <div>
            <div class="text-3xl font-bold">00</div>
            <div class="text-sm">Minutes</div>
        </div>
        <div>
            <div class="text-3xl font-bold">00</div>
            <div class="text-sm">Seconds</div>
        </div>
    </div>
    @include('partials.pricing-section')
</div>
@endsection
