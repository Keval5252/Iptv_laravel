<?php

namespace App\Services;

class SeoService
{
    protected $defaultMeta = [
        'title' => 'IPTV Subscription - Premium TV Streaming Service',
        'description' => 'Get the best IPTV subscription with premium channels, movies, and TV shows. High-quality streaming on all devices including Firestick, Android, Smart TV, and more.',
        'keywords' => 'IPTV, IPTV subscription, streaming TV, premium channels, Firestick IPTV, Android IPTV, Smart TV streaming',
        'author' => 'IPTV Service',
        'robots' => 'index, follow',
        'og_type' => 'website',
        'twitter_card' => 'summary_large_image'
    ];

    public function getMetaTags($page = null, $customMeta = [])
    {
        $meta = array_merge($this->defaultMeta, $customMeta);

        // Generate structured data
        $structuredData = $this->generateStructuredData($page, $meta);

        return [
            'meta' => $meta,
            'structured_data' => $structuredData
        ];
    }

    public function generateStructuredData($page = null, $meta = [])
    {
        $baseUrl = config('app.url');

        $structuredData = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => config('app.name', 'IPTV Service'),
            'url' => $baseUrl,
            'logo' => $baseUrl . '/images/logo.png',
            'description' => $meta['description'] ?? $this->defaultMeta['description'],
            'sameAs' => [
                'https://www.facebook.com/iptvservice',
                'https://twitter.com/iptvservice',
                'https://www.instagram.com/iptvservice'
            ]
        ];

        // Add page-specific structured data
        if ($page) {
            switch ($page) {
                case 'home':
                    $structuredData['@type'] = 'WebSite';
                    $structuredData['potentialAction'] = [
                        '@type' => 'SearchAction',
                        'target' => $baseUrl . '/search?q={search_term_string}',
                        'query-input' => 'required name=search_term_string'
                    ];
                    break;

                case 'subscription':
                    $structuredData['@type'] = 'Service';
                    $structuredData['serviceType'] = 'IPTV Subscription';
                    $structuredData['provider'] = [
                        '@type' => 'Organization',
                        'name' => config('app.name', 'IPTV Service')
                    ];
                    break;

                case 'contact':
                    $structuredData['@type'] = 'ContactPage';
                    $structuredData['mainEntity'] = [
                        '@type' => 'Organization',
                        'name' => config('app.name', 'IPTV Service'),
                        'contactPoint' => [
                            '@type' => 'ContactPoint',
                            'telephone' => '+1-800-IPTV-123',
                            'contactType' => 'customer service'
                        ]
                    ];
                    break;
            }
        }

        return $structuredData;
    }

    public function generateBreadcrumbs($items)
    {
        $breadcrumbs = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => []
        ];

        foreach ($items as $index => $item) {
            $breadcrumbs['itemListElement'][] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['name'],
                'item' => $item['url']
            ];
        }

        return $breadcrumbs;
    }

    public function generateFaqStructuredData($faqs)
    {
        $faqData = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => []
        ];

        foreach ($faqs as $faq) {
            $faqData['mainEntity'][] = [
                '@type' => 'Question',
                'name' => $faq['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['answer']
                ]
            ];
        }

        return $faqData;
    }
}
