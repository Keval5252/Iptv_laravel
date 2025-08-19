<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CheckSeoStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seo:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the current SEO implementation status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Checking SEO Implementation Status...');
        $this->newLine();

        $status = [];

        // Check if SEO service exists
        $status['SEO Service'] = File::exists(app_path('Services/SeoService.php')) ? '✅' : '❌';

        // Check if Sitemap controller exists
        $status['Sitemap Controller'] = File::exists(app_path('Http/Controllers/SitemapController.php')) ? '✅' : '❌';

        // Check if SEO middleware exists
        $status['SEO Middleware'] = File::exists(app_path('Http/Middleware/SeoMiddleware.php')) ? '✅' : '❌';

        // Check if robots.txt exists
        $status['Robots.txt'] = File::exists(public_path('robots.txt')) ? '✅' : '❌';

        // Check if sitemap.xml exists
        $status['Sitemap XML'] = File::exists(public_path('sitemap.xml')) ? '✅' : '❌';

        // Check if SEO config exists
        $status['SEO Config'] = File::exists(config_path('seo.php')) ? '✅' : '❌';

        // Check if SEO component exists
        $status['SEO Component'] = File::exists(app_path('View/Components/SeoMeta.php')) ? '✅' : '❌';

        // Check if SEO component view exists
        $status['SEO Component View'] = File::exists(base_path('resources/views/components/seo-meta.blade.php')) ? '✅' : '❌';

        // Check if test page exists
        $status['SEO Test Page'] = File::exists(base_path('resources/views/test-seo.blade.php')) ? '✅' : '❌';

        // Display status
        foreach ($status as $component => $statusIcon) {
            $this->line("{$statusIcon} {$component}");
        }

        $this->newLine();

        // Check routes
        $this->info('🌐 SEO Routes Status:');
        $routes = [
            '/sitemap.xml' => 'XML Sitemap',
            '/generate-sitemap' => 'Sitemap Generation',
            '/test-seo' => 'SEO Test Page'
        ];

        foreach ($routes as $route => $description) {
            $this->line("  {$route} - {$description}");
        }

        $this->newLine();

        // Check commands
        $this->info('⚡ Available SEO Commands:');
        $this->line("  php artisan sitemap:generate - Generate XML sitemap");
        $this->line("  php artisan seo:status - Check SEO status (this command)");

        $this->newLine();

        // Summary
        $totalComponents = count($status);
        $implementedComponents = count(array_filter($status, fn($s) => $s === '✅'));

        if ($implementedComponents === $totalComponents) {
            $this->info("🎉 All SEO components are implemented successfully!");
        } else {
            $this->warn("⚠️  {$implementedComponents}/{$totalComponents} SEO components are implemented.");
        }

        $this->newLine();
        $this->info('📚 Next Steps:');
        $this->line('1. Update robots.txt with your actual domain');
        $this->line('2. Add social media images to public/images/');
        $this->line('3. Test your pages with Google Rich Results Test');
        $this->line('4. Submit sitemap to Google Search Console');
        $this->line('5. Monitor your SEO performance');

        return Command::SUCCESS;
    }
}
