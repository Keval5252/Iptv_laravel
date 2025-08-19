<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default SEO Settings
    |--------------------------------------------------------------------------
    |
    | These are the default SEO settings used throughout the application.
    | You can override these in individual views or controllers.
    |
    */

    'defaults' => [
        'title' => 'IPTV Subscription - Premium TV Streaming Service',
        'description' => 'Get the best IPTV subscription with premium channels, movies, and TV shows. High-quality streaming on all devices including Firestick, Android, Smart TV, and more.',
        'keywords' => 'IPTV, IPTV subscription, streaming TV, premium channels, Firestick IPTV, Android IPTV, Smart TV streaming',
        'author' => 'IPTV Service',
        'robots' => 'index, follow',
        'og_type' => 'website',
        'twitter_card' => 'summary_large_image',
    ],

    /*
    |--------------------------------------------------------------------------
    | Page-specific SEO Settings
    |--------------------------------------------------------------------------
    |
    | SEO settings for specific pages. These will override the defaults
    | when the corresponding page is loaded.
    |
    */

    'pages' => [
        'home' => [
            'title' => 'IPTV Subscription - Premium TV Streaming Service',
            'description' => 'Get the best IPTV subscription with premium channels, movies, and TV shows. High-quality streaming on all devices including Firestick, Android, Smart TV, and more.',
            'keywords' => 'IPTV, IPTV subscription, streaming TV, premium channels, Firestick IPTV, Android IPTV, Smart TV streaming',
        ],

        'subscription' => [
            'title' => 'IPTV Subscription Plans - Choose Your Perfect Plan',
            'description' => 'Choose from our premium IPTV subscription plans. Get access to thousands of channels, movies, and TV shows with high-quality streaming.',
            'keywords' => 'IPTV plans, subscription packages, premium channels, streaming packages',
        ],

        'about' => [
            'title' => 'About Us - Leading IPTV Service Provider',
            'description' => 'Learn about our IPTV service company. We provide premium streaming services with excellent customer support and reliable streaming.',
            'keywords' => 'about IPTV, IPTV company, streaming service provider',
        ],

        'contact' => [
            'title' => 'Contact Us - Get IPTV Support',
            'description' => 'Contact our IPTV support team for assistance with your subscription, technical issues, or general inquiries.',
            'keywords' => 'IPTV support, contact IPTV, customer service, technical support',
        ],

        'faq' => [
            'title' => 'FAQ - Frequently Asked Questions About IPTV',
            'description' => 'Find answers to common questions about IPTV services, setup, troubleshooting, and more.',
            'keywords' => 'IPTV FAQ, common questions, troubleshooting, setup guide',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Social Media Settings
    |--------------------------------------------------------------------------
    |
    | Default social media settings for Open Graph and Twitter Cards.
    |
    */

    'social' => [
        'facebook' => [
            'app_id' => env('FACEBOOK_APP_ID'),
            'page_id' => env('FACEBOOK_PAGE_ID'),
        ],

        'twitter' => [
            'creator' => env('TWITTER_CREATOR', '@iptvservice'),
            'site' => env('TWITTER_SITE', '@iptvservice'),
        ],

        'default_image' => '/images/og-image.jpg',
        'default_image_width' => 1200,
        'default_image_height' => 630,
    ],

    /*
    |--------------------------------------------------------------------------
    | Sitemap Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for XML sitemap generation.
    |
    */

    'sitemap' => [
        'auto_generate' => env('SITEMAP_AUTO_GENERATE', true),
        'cache_duration' => env('SITEMAP_CACHE_DURATION', 3600), // 1 hour
        'max_urls' => env('SITEMAP_MAX_URLS', 50000),
        'file_path' => 'sitemap.xml',
    ],

    /*
    |--------------------------------------------------------------------------
    | Analytics Settings
    |--------------------------------------------------------------------------
    |
    | Google Analytics and other tracking codes.
    |
    */

    'analytics' => [
        'google_analytics_id' => env('GOOGLE_ANALYTICS_ID'),
        'google_tag_manager_id' => env('GOOGLE_TAG_MANAGER_ID'),
        'facebook_pixel_id' => env('FACEBOOK_PIXEL_ID'),
    ],
];
