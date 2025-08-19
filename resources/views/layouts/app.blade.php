<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <title>@yield('title', 'IPTV Subscription - Premium TV Streaming Service')</title>
    <meta name="description" content="@yield('description', 'Get the best IPTV subscription with premium channels, movies, and TV shows. High-quality streaming on all devices including Firestick, Android, Smart TV, and more.')">
    <meta name="keywords" content="@yield('keywords', 'IPTV, IPTV subscription, streaming TV, premium channels, Firestick IPTV, Android IPTV, Smart TV streaming')">
    <meta name="author" content="@yield('author', 'IPTV Service')">
    <meta name="robots" content="@yield('robots', 'index, follow')">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('og_title', 'IPTV Subscription - Premium TV Streaming Service')">
    <meta property="og:description" content="@yield('og_description', 'Get the best IPTV subscription with premium channels, movies, and TV shows. High-quality streaming on all devices.')">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="@yield('og_url', request()->url())">
    <meta property="og:image" content="@yield('og_image', asset('images/og-image.jpg'))">
    <meta property="og:site_name" content="{{ config('app.name', 'IPTV Service') }}">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="@yield('twitter_card', 'summary_large_image')">
    <meta name="twitter:title" content="@yield('twitter_title', 'IPTV Subscription - Premium TV Streaming Service')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Get the best IPTV subscription with premium channels, movies, and TV shows.')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('images/twitter-image.jpg'))">

    <!-- Canonical URL -->
    <link rel="canonical" href="@yield('canonical', request()->url())">

    <!-- Additional SEO Meta Tags -->
    <meta name="language" content="{{ str_replace('_', '-', app()->getLocale()) }}">
    <meta name="revisit-after" content="7 days">
    <meta name="distribution" content="global">
    <meta name="rating" content="general">

    <!-- Structured Data -->
    <script type="application/ld+json">
    @yield('structured_data', '{}')
    </script>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        {{-- <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav> --}}

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
