@extends('layouts.app')

@section('title', 'Test SEO Page - IPTV Service')
@section('description', 'This is a test page to verify SEO implementation including meta tags, structured data, and Open Graph tags.')
@section('keywords', 'test, SEO, IPTV, verification')
@section('author', 'IPTV Service')
@section('robots', 'index, follow')

@section('og_title', 'Test SEO Page - IPTV Service')
@section('og_description', 'This is a test page to verify SEO implementation including meta tags, structured data, and Open Graph tags.')
@section('og_type', 'website')
@section('og_url', request()->url())
@section('og_image', asset('images/test-og.jpg'))

@section('twitter_card', 'summary_large_image')
@section('twitter_title', 'Test SEO Page - IPTV Service')
@section('twitter_description', 'This is a test page to verify SEO implementation including meta tags, structured data, and Open Graph tags.')
@section('twitter_image', asset('images/test-twitter.jpg'))

@section('canonical', request()->url())

@section('structured_data')
{
    "@context": "https://schema.org",
    "@type": "WebPage",
    "name": "Test SEO Page",
    "description": "This is a test page to verify SEO implementation",
    "url": "{{ request()->url() }}",
    "mainEntity": {
        "@type": "Organization",
        "name": "IPTV Service",
        "description": "Premium IPTV streaming service"
    }
}
@endsection

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1>SEO Test Page</h1>
                </div>
                <div class="card-body">
                    <h2>SEO Features Verification</h2>

                    <div class="alert alert-success">
                        <h4>✅ SEO Implementation Complete!</h4>
                        <p>This page demonstrates all the SEO features that have been implemented:</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h3>Meta Tags</h3>
                            <ul>
                                <li>Title: {{ config('app.name') }}</li>
                                <li>Description: Set via @section</li>
                                <li>Keywords: Set via @section</li>
                                <li>Author: Set via @section</li>
                                <li>Robots: Set via @section</li>
                            </ul>
                        </div>

                        <div class="col-md-6">
                            <h3>Open Graph</h3>
                            <ul>
                                <li>OG Title: Set via @section</li>
                                <li>OG Description: Set via @section</li>
                                <li>OG Type: Set via @section</li>
                                <li>OG Image: Set via @section</li>
                            </ul>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h3>Twitter Cards</h3>
                            <ul>
                                <li>Card Type: Set via @section</li>
                                <li>Title: Set via @section</li>
                                <li>Description: Set via @section</li>
                                <li>Image: Set via @section</li>
                            </ul>
                        </div>

                        <div class="col-md-6">
                            <h3>Structured Data</h3>
                            <ul>
                                <li>Schema.org markup: Implemented</li>
                                <li>JSON-LD format: Active</li>
                                <li>Page type: WebPage</li>
                                <li>Organization data: Included</li>
                            </ul>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h3>Additional SEO Features</h3>
                            <ul>
                                <li>Canonical URL: Set via @section</li>
                                <li>Robots.txt: Created in public/robots.txt</li>
                                <li>XML Sitemap: Available at /sitemap.xml</li>
                                <li>SEO Middleware: Applied to all routes</li>
                                <li>SEO Service: Centralized SEO management</li>
                            </ul>
                        </div>
                    </div>

                    <div class="alert alert-info mt-4">
                        <h4>🔍 How to Test</h4>
                        <ol>
                            <li>View page source to see meta tags</li>
                            <li>Check browser developer tools for structured data</li>
                            <li>Test with Facebook Sharing Debugger</li>
                            <li>Test with Twitter Card Validator</li>
                            <li>Validate with Google Rich Results Test</li>
                        </ol>
                    </div>

                    <div class="mt-4">
                        <a href="/" class="btn btn-primary">Back to Home</a>
                        <a href="/sitemap.xml" class="btn btn-success">View Sitemap</a>
                        <a href="/generate-sitemap" class="btn btn-warning">Regenerate Sitemap</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
