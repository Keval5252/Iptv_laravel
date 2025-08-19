<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\SeoService;

class SeoMiddleware
{
    protected $seoService;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Closure): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only process HTML responses
        if ($response->headers->get('content-type') &&
            str_contains($response->headers->get('content-type'), 'text/html')) {

            $content = $response->getContent();

            // Get current route name for SEO optimization
            $routeName = $request->route() ? $request->route()->getName() : null;
            $page = $this->getPageFromRoute($routeName);

            // Get SEO data
            $seoData = $this->seoService->getMetaTags($page);

            // Inject structured data if not already present
            if (!str_contains($content, 'application/ld+json')) {
                $structuredData = json_encode($seoData['structured_data'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                $content = str_replace(
                    '@yield(\'structured_data\', \'{}\')',
                    $structuredData,
                    $content
                );
            }

            $response->setContent($content);
        }

        return $response;
    }

    protected function getPageFromRoute($routeName)
    {
        if (!$routeName) return null;

        $pageMap = [
            'home' => 'home',
            'about-us' => 'about',
            'contact-us' => 'contact',
            'iptv-subscription' => 'subscription',
            'multi-connections' => 'subscription',
            'iptv-playlist' => 'subscription',
            'adult-channel' => 'subscription',
            'faqs' => 'faq',
        ];

        return $pageMap[$routeName] ?? null;
    }
}
