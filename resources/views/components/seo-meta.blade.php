{{-- SEO Meta Tags --}}
@if($title)
    <title>{{ $title }}</title>
@endif

@if($description)
    <meta name="description" content="{{ $description }}">
@endif

@if($keywords)
    <meta name="keywords" content="{{ $keywords }}">
@endif

@if($author)
    <meta name="author" content="{{ $author }}">
@endif

@if($robots)
    <meta name="robots" content="{{ $robots }}">
@endif

{{-- Open Graph Meta Tags --}}
@if($ogTitle)
    <meta property="og:title" content="{{ $ogTitle }}">
@endif

@if($ogDescription)
    <meta property="og:description" content="{{ $ogDescription }}">
@endif

@if($ogType)
    <meta property="og:type" content="{{ $ogType }}">
@endif

@if($ogUrl)
    <meta property="og:url" content="{{ $ogUrl }}">
@endif

@if($ogImage)
    <meta property="og:image" content="{{ $ogImage }}">
@endif

{{-- Twitter Card Meta Tags --}}
@if($twitterCard)
    <meta name="twitter:card" content="{{ $twitterCard }}">
@endif

@if($twitterTitle)
    <meta name="twitter:title" content="{{ $twitterTitle }}">
@endif

@if($twitterDescription)
    <meta name="twitter:description" content="{{ $twitterDescription }}">
@endif

@if($twitterImage)
    <meta name="twitter:image" content="{{ $twitterImage }}">
@endif

{{-- Canonical URL --}}
@if($canonical)
    <link rel="canonical" href="{{ $canonical }}">
@endif

{{-- Structured Data --}}
@if($structuredData)
    <script type="application/ld+json">
    {!! json_encode($structuredData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endif
