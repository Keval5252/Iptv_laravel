@extends('layouts.app')

@section('title', 'Super IPTV - Home')

@section('content')
<div class="space-y-4">
    <div class="bg-secondary text-black py-12 px-4">
        <div class="container grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 text-center items-center">
            <div class="flex-shrink-0">
                <img src="https://www.superiptvs.com/wp-content/uploads/2024/01/cropped-IPTV-150x150.png" alt="Smart IPTV Logo" class="h-20 w-auto mx-auto" />
            </div>
            <div>
                <h2 class="text-3xl font-semibold">OFFICIAL LEGAL</h2>
                <h3 class="text-3xl font-semibold">CERTIFICATION</h3>
            </div>
            <div>
                <h2 class="text-3xl font-semibold">EXTRA 50% OFF</h2>
                <p class="text-sm">ONLINE ONLY, HURRY UP END IN:</p>
            </div>
            <div class="flex space-x-4 justify-center">
                <div>
                    <div class="text-3xl font-semibold">00</div>
                    <div class="text-sm">Days</div>
                </div>
                <div>
                    <div class="text-3xl font-semibold">00</div>
                    <div class="text-sm">Hours</div>
                </div>
                <div>
                    <div class="text-3xl font-semibold">00</div>
                    <div class="text-sm">Minutes</div>
                </div>
                <div>
                    <div class="text-3xl font-semibold">00</div>
                    <div class="text-sm">Seconds</div>
                </div>
            </div>
        </div>
    </div>
    <figure>
        <img src="https://www.superiptvs.com/wp-content/uploads/2024/01/IPTV-Provider-Service-_2_.webp" alt="Smart IPTV Logo" class="w-full max-h-[70vh] object-cover" />
    </figure>
</div>
<div class="container">
    <div class="py-12 px-4 text-center">
        <h1 class="text-2xl sm:text-3xl font-bold text-black uppercase">
            THE BEST IPTV SUBSCRIPTION PROVIDER
        </h1>
        <h2 class="text-xl sm:text-2xl font-semibold text-orange-600 mt-2">
            Customer Renewal Rate Is As high As 99%
        </h2>

        <div class="mt-8 flex justify-center">
            <img
                    src="https://www.superiptvs.com/wp-content/uploads/2023/03/best-iptv.webp"
                    alt="Best IPTV"
                    class="w-72 sm:w-80"
            />
        </div>

        <p class="mt-6 text-gray-800 text-base sm:text-lg">
            Super IPTV is proud to partner with the Government's Affordable Connectivity Program.
        </p>

        <p class="mt-4 text-gray-700 text-sm sm:text-base">
            Enjoy the best IPTV Service at affordable prices! Sign up now and get access to over 16000<br />
            Live TV Channels + VOD that works on all of your favorite devices.
        </p>

        <ul class="mt-6 text-left inline-block text-gray-800 text-sm sm:text-base leading-relaxed">
            <li>✓ Thousands of HD Television Channels</li>
            <li>✓ Movies and TV Shows Update weekly</li>
            <li>✓ High-Quality Video Streaming</li>
            <li>✓ 24/7 Customer Support</li>
        </ul>

        <div class="mt-6">
            <a href="{{ route('iptv-subscription') }}"
               class="bg-amber-500 text-white font-medium px-6 py-4 rounded hover:bg-amber-600 transition">
                Subscribe Now
            </a>
        </div>
    </div>
    <div class="mt-12">
        <h2 class="text-2xl sm:text-3xl font-bold text-black mb-8 text-center uppercase">MORE THAN 100,000 PEOPLE SUBSCRIBED AND HAPPY WITH IT</h2>
        <div class="border-t border-gray-200 mb-8"></div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 text-center">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-send-icon lucide-send w-14 mx-auto"><path d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z"/><path d="m21.854 2.147-10.94 10.939"/></svg>
                <h3 class="mt-4 text-xl font-semibold">Anti Freeze™ 3.0</h3>
                <p class="mt-2 text-gray-700">Using Anti-Freeze Technology, You do not need to worry about the stability of the server.</p>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-smartphone-icon lucide-smartphone w-14 mx-auto"><rect width="14" height="20" x="5" y="2" rx="2" ry="2"/><path d="M12 18h.01"/></svg>
                <h3 class="mt-4 text-xl font-semibold">Watch Any Device!</h3>
                <p class="mt-2 text-gray-700">Our IPTV service works on any device such as TVs, Smartphones, FireStick, Mag…</p>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-messages-square-icon lucide-messages-square w-14 mx-auto"><path d="M14 9a2 2 0 0 1-2 2H6l-4 4V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2z"/><path d="M18 9h2a2 2 0 0 1 2 2v11l-4-4h-6a2 2 0 0 1-2-2v-1"/></svg>
                <h3 class="mt-4 text-xl font-semibold">Live Support 24/7</h3>
                <p class="mt-2 text-gray-700">We offer in-depth tutorials and client support to make installation, quick and simple.</p>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-laptop-icon lucide-laptop w-14 mx-auto"><path d="M18 5a2 2 0 0 1 2 2v8.526a2 2 0 0 0 .212.897l1.068 2.127a1 1 0 0 1-.9 1.45H3.62a1 1 0 0 1-.9-1.45l1.068-2.127A2 2 0 0 0 4 15.526V7a2 2 0 0 1 2-2z"/><path d="M20.054 15.987H3.946"/></svg>
                <h3 class="mt-4 text-xl font-semibold">FULL 4K/HD/FHD QUALITY</h3>
                <p class="mt-2 text-gray-700">Most our TV channels are available in HD quality and some of them are in 4K.</p>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-atom-icon lucide-atom w-14 mx-auto"><circle cx="12" cy="12" r="1"/><path d="M20.2 20.2c2.04-2.03.02-7.36-4.5-11.9-4.54-4.52-9.87-6.54-11.9-4.5-2.04 2.03-.02 7.36 4.5 11.9 4.54 4.52 9.87 6.54 11.9 4.5Z"/><path d="M15.7 15.7c4.52-4.54 6.54-9.87 4.5-11.9-2.03-2.04-7.36-.02-11.9 4.5-4.52 4.54-6.54 9.87-4.5 11.9 2.03 2.04 7.36.02 11.9-4.5Z"/></svg>
                <h3 class="mt-4 text-xl font-semibold">Thousands Of Channels</h3>
                <p class="mt-2 text-gray-700">Your IPTV subscription offers you international IPTV Channels from around the world, including all major channels from the world.</p>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock9-icon lucide-clock-9 w-14 mx-auto"><path d="M12 6v6H8"/><circle cx="12" cy="12" r="10"/></svg>
                <h3 class="mt-4 text-xl font-semibold">Auto and Free Update</h3>
                <p class="mt-2 text-gray-700">We usually update and add new TV Channels and VODs to the service. Once you subscribe, you will receive any update for free during your service.</p>
            </div>
        </div>
    </div>
    @include('partials.pricing-section')
    <div class="container my-16">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        <div>
          <img src="https://www.superiptvs.com/wp-content/uploads/2023/03/iptv-subscription.webp" alt="Why Choose Us" class="w-full h-auto rounded-md object-cover" />
        </div>
        <div>
          <h2 class="text-3xl font-semibold mb-6">Why Choose Us?</h2>
          <ul class="space-y-3 text-lg text-gray-800">
            <li>✔ Most stable app server and engineer team over 4 years.</li>
            <li>✔ You Get 16,000 Ordinary & Premium Channels Instantly.</li>
            <li>✔ You Get Over 86,000 Movies & 14,000 TV Shows (VOD's).</li>
            <li>✔ No More Expensive Cable Bills.</li>
            <li>✔ Solid IPTV Service, Without Buffering and Freezing (Stable Internet Required).</li>
            <li>✔ Our IPTV Service is Always Up 99,99 % of the Time!</li>
            <li>✔ Solid IPTV Service, Without Buffering and Freezing (Stable Internet Required).</li>
            <li>✔ You Get 100% Satisfaction Guarantee.</li>
            <li>✔ You Get the Best IPTV Quality/Price In The Market.</li>
            <li>✔ You Get 24/7 Customer Service Via WhatsApp or Ticketing System.</li>
          </ul>
        </div>
      </div>
    </div>
    <div class="container my-16">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        <div>
          <img src="https://www.superiptvs.com/wp-content/uploads/2023/03/multidevices-Xnet-iptv-1.webp" alt="Multi Devices" class="w-full h-auto rounded-md object-contain" />
        </div>
        <div>
          <h2 class="text-3xl font-semibold mb-4">Advantages of Multi Connections</h2>
          <p class="text-gray-800 mb-6">Many of our competitors have their Servers based in India. With a multiScreen account, you will be able to enjoy TV on many devices at the same time without any interruption. Our MultiScreen accounts are not IP locked, which means you even can have one account in one house and another in a different house or country. You can set up an account on a smart TV and set up the same account with the same features on your smartphone and enjoy watching your favorite programmes or games.<br><br>&amp; other Asian markets – our Servers are all based in Europe, to give you the fastest stream times and consistently high quality of service.</p>
          <div class="flex flex-col sm:flex-row gap-2">
            <a href="{{ route('multi-connections') }}" class="bg-amber-500 text-white font-medium px-6 py-3 rounded hover:bg-amber-600 transition">MULTI CONNECTIONS ADULT IPTV</a>
            <a href="{{ route('multi-connections-prices') }}" class="bg-amber-500 text-white font-medium px-6 py-3 rounded hover:bg-amber-600 transition">Multi Connections Standard</a>
          </div>
        </div>
      </div>
    </div>
    <div class="container my-16">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        <div class="order-2 md:order-1">
          <h2 class="text-3xl font-semibold mb-4">USA & European-based Servers</h2>
          <p class="text-gray-800 mb-6">USA &amp; European-based Servers<br>Many of our competitors have their servers based in India &amp; other Asian markets – our servers are all based in Europe and some of them are based in the USA, to give you the fastest stream time and a high quality of service.</p>
          <a href="{{ route('iptv-playlist') }}" class="bg-amber-500 text-white font-medium px-6 py-3 rounded hover:bg-amber-600 transition">LIST OF CHANNELS</a>
        </div>
        <div class="order-1 md:order-2">
          <img src="https://www.superiptvs.com/wp-content/uploads/2022/12/image0.webp" alt="Servers" class="w-full h-auto rounded-md object-contain" />
        </div>
      </div>
    </div>
</div>
@endsection
