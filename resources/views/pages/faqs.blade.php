@extends('layouts.app')

@section('title', 'FAQs - Super IPTV')

@section('content')
<div class="mt-16 container">
    <div class="max-w-5xl mx-auto">
        <h1 class="text-2xl sm:text-3xl font-bold text-black uppercase text-center mb-8">
            FAQs
        </h1>

        <div class="space-y-6">
            <div>
                <h2 class="font-semibold text-gray-900">Can I buy IPTV even if I don't have access to satellite services?</h2>
                <p class="text-gray-700">Yes, IPTV streams international programs via the Internet, so no satellite dish is needed. A broadband internet connection of at least 4.0 Mbps is required.</p>
            </div>

            <div>
                <h2 class="font-semibold text-gray-900">Can I use my subscription on multiple devices?</h2>
                <p class="text-gray-700">Yes, but you can only watch on one device at a time using a single subscription.</p>
            </div>

            <div>
                <h2 class="font-semibold text-gray-900">Can I use IPTV even if I live in an apartment?</h2>
                <p class="text-gray-700">IPTV works anywhere with high-speed internet — even in apartments or places where satellite dishes aren't allowed.</p>
            </div>

            <div>
                <h2 class="font-semibold text-gray-900">I can't watch any channels, what should I do?</h2>
                <p class="text-gray-700">Please contact our technical support team for assistance.</p>
            </div>

            <div>
                <h2 class="font-semibold text-gray-900">Do you have an electronic program guide (EPG)?</h2>
                <p class="text-gray-700">Yes, most subscriptions include EPG. Please check the product description to confirm.</p>
            </div>

            <div>
                <h2 class="font-semibold text-gray-900">Do you offer a trial or free trial account?</h2>
                <p class="text-gray-700">We offer a 48-hour test for only 5 Euros. This is to avoid spam and non-serious users.</p>
            </div>

            <div>
                <h2 class="font-semibold text-gray-900">Does my subscription start to be active right after payment?</h2>
                <p class="text-gray-700">No, it starts when you receive your activation credentials by email. For example, if you receive them on April 3 at 3:00 p.m., your subscription begins then.</p>
            </div>

            <div>
                <h2 class="font-semibold text-gray-900">How do I check my internet speed and quality?</h2>
                <p class="text-gray-700">Use <a href="https://www.speedtest.net/" class="text-blue-600 underline" target="_blank">speedtest.net</a> multiple times a day to evaluate your connection. A minimum of 4.0 Mbps is required.</p>
            </div>

            <div>
                <h2 class="font-semibold text-gray-900">How long before I can use the service?</h2>
                <p class="text-gray-700">Most subscriptions are delivered within 12 hours, but please allow up to 24 hours.</p>
            </div>
        </div>
    </div>
</div>
@endsection
