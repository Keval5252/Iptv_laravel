<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Carbon\Carbon;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = Sitemap::create()
            ->add(Url::create('/')
                ->setLastModificationDate(Carbon::yesterday())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(1.0))
            ->add(Url::create('/about-us')
                ->setLastModificationDate(Carbon::yesterday())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.8))
            ->add(Url::create('/contact-us')
                ->setLastModificationDate(Carbon::yesterday())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.8))
            ->add(Url::create('/iptv-subscription')
                ->setLastModificationDate(Carbon::yesterday())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.9))
            ->add(Url::create('/multi-connections')
                ->setLastModificationDate(Carbon::yesterday())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.9))
            ->add(Url::create('/iptv-playlist')
                ->setLastModificationDate(Carbon::yesterday())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.8))
            ->add(Url::create('/adult-channel')
                ->setLastModificationDate(Carbon::yesterday())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.7))
            ->add(Url::create('/best-iptv-for-firestick-2022')
                ->setLastModificationDate(Carbon::yesterday())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.8))
            ->add(Url::create('/shipping-policy')
                ->setLastModificationDate(Carbon::yesterday())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.6))
            ->add(Url::create('/privacy-policy')
                ->setLastModificationDate(Carbon::yesterday())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.6))
            ->add(Url::create('/refund-policy')
                ->setLastModificationDate(Carbon::yesterday())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.6))
            ->add(Url::create('/terms-of-service')
                ->setLastModificationDate(Carbon::yesterday())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.6))
            ->add(Url::create('/faqs')
                ->setLastModificationDate(Carbon::yesterday())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.7));

        // Add operation guide pages
        $operationGuides = [
            'operation-guide-android-smartphone-android-box' => 'Android Guide',
            'operation-guide-android-tv-perfect-player' => 'Android TV Guide',
            'operation-guide-apple-iphone-ipad-apple-tv' => 'Apple Guide',
            'operation-guide-enigma2-dreambox-vu' => 'Enigma2 Guide',
            'operation-guide-kodi-version-16-or-lower' => 'Kodi Old Guide',
            'operation-guide-kodi-xbmc-version-17-et-plus' => 'Kodi New Guide',
            'operation-guide-mag-250-254-256' => 'MAG Guide',
            'operation-guide-pc-mac-logiciel-vlc' => 'PC/Mac Guide',
            'operation-guide-smart-tv-samsung-lg' => 'Smart TV Guide',
            'operation-guide-stb-emulator' => 'STB Emulator Guide'
        ];

        foreach ($operationGuides as $slug => $title) {
            $sitemap->add(Url::create('/' . $slug)
                ->setLastModificationDate(Carbon::yesterday())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.7));
        }

        return $sitemap->toResponse(request());
    }

    public function generateSitemap()
    {
        $sitemap = Sitemap::create();

        // Add all your routes here
        $routes = [
            '/' => ['priority' => 1.0, 'change_frequency' => Url::CHANGE_FREQUENCY_DAILY],
            '/about-us' => ['priority' => 0.8, 'change_frequency' => Url::CHANGE_FREQUENCY_MONTHLY],
            '/contact-us' => ['priority' => 0.8, 'change_frequency' => Url::CHANGE_FREQUENCY_MONTHLY],
            '/iptv-subscription' => ['priority' => 0.9, 'change_frequency' => Url::CHANGE_FREQUENCY_WEEKLY],
            '/multi-connections' => ['priority' => 0.9, 'change_frequency' => Url::CHANGE_FREQUENCY_WEEKLY],
            '/iptv-playlist' => ['priority' => 0.8, 'change_frequency' => Url::CHANGE_FREQUENCY_WEEKLY],
            '/adult-channel' => ['priority' => 0.7, 'change_frequency' => Url::CHANGE_FREQUENCY_WEEKLY],
            '/best-iptv-for-firestick-2022' => ['priority' => 0.8, 'change_frequency' => Url::CHANGE_FREQUENCY_MONTHLY],
            '/shipping-policy' => ['priority' => 0.6, 'change_frequency' => Url::CHANGE_FREQUENCY_MONTHLY],
            '/privacy-policy' => ['priority' => 0.6, 'change_frequency' => Url::CHANGE_FREQUENCY_MONTHLY],
            '/refund-policy' => ['priority' => 0.6, 'change_frequency' => Url::CHANGE_FREQUENCY_MONTHLY],
            '/terms-of-service' => ['priority' => 0.6, 'change_frequency' => Url::CHANGE_FREQUENCY_MONTHLY],
            '/faqs' => ['priority' => 0.7, 'change_frequency' => Url::CHANGE_FREQUENCY_MONTHLY],
        ];

        foreach ($routes as $route => $settings) {
            $sitemap->add(Url::create($route)
                ->setLastModificationDate(Carbon::yesterday())
                ->setChangeFrequency($settings['change_frequency'])
                ->setPriority($settings['priority']));
        }

        // Write sitemap to public directory
        $sitemap->writeToFile(public_path('sitemap.xml'));

        return response()->json(['message' => 'Sitemap generated successfully']);
    }
}
