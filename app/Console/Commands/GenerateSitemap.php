<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Carbon\Carbon;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate XML sitemap for SEO';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating sitemap...');

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

        // Add operation guide pages
        $operationGuides = [
            'operation-guide-android-smartphone-android-box',
            'operation-guide-android-tv-perfect-player',
            'operation-guide-apple-iphone-ipad-apple-tv',
            'operation-guide-enigma2-dreambox-vu',
            'operation-guide-kodi-version-16-or-lower',
            'operation-guide-kodi-xbmc-version-17-et-plus',
            'operation-guide-mag-250-254-256',
            'operation-guide-pc-mac-logiciel-vlc',
            'operation-guide-smart-tv-samsung-lg',
            'operation-guide-stb-emulator'
        ];

        foreach ($operationGuides as $slug) {
            $sitemap->add(Url::create('/' . $slug)
                ->setLastModificationDate(Carbon::yesterday())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.7));
        }

        // Write sitemap to public directory
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully at: ' . public_path('sitemap.xml'));

        return Command::SUCCESS;
    }
}
