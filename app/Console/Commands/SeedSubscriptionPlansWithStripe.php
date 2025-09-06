<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SubscriptionPlan;
use App\Services\StripePlanService;
use Illuminate\Support\Facades\Log;

class SeedSubscriptionPlansWithStripe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:subscription-plans-stripe 
                            {--force : Force recreate all plans even if they exist}
                            {--skip-stripe : Skip Stripe integration and only create database records}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed subscription plans with Stripe integration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Starting subscription plan seeding with Stripe integration...');
        $this->newLine();

        $force = $this->option('force');
        $skipStripe = $this->option('skip-stripe');

        if ($force) {
            $this->warn('⚠️  Force mode enabled - existing plans will be deleted!');
            if (!$this->confirm('Are you sure you want to continue?')) {
                $this->info('Operation cancelled.');
                return;
            }
            
            // Delete existing plans
            $this->info('🗑️  Deleting existing subscription plans...');
            $existingPlans = SubscriptionPlan::all();
            foreach ($existingPlans as $plan) {
                $this->info("  Deleting: {$plan->name}");
                $plan->delete();
            }
            $this->info('✓ Existing plans deleted.');
            $this->newLine();
        }

        $stripeService = new StripePlanService();
        
        $plans = [
            [
                'name' => 'XXX-2 Year',
                'type' => 'xxx',
                'duration' => '2 Years',
                'price' => 109.99,
                'original_price' => 219.98,
                'features' => [
                    '12,000 Channels',
                    'With Adult Channels & Movies',
                    'Over 86,000 Movies & TV Shows',
                    '14,000 TV Shows & Series',
                    '4K,2K,FHD,HD & SD Channels',
                    'Premium Channels',
                    'All Applications',
                    'Watch Online Live TV 24/7',
                    'Free Updates',
                    'TV Guide (EPG)',
                    'Support All Devices',
                    '24/7 support',
                    'AntiFreeze Technology',
                    '99.9% Uptime',
                    '2024 Best IPTV Service'
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 0,
                'display_pages' => ['home', 'pricing', 'subscription']
            ],
            [
                'name' => 'XXX-1 Year',
                'type' => 'xxx',
                'duration' => '1 Year',
                'price' => 65.99,
                'original_price' => 131.98,
                'features' => [
                    '12,000 Channels',
                    'With Adult Channels & Movies',
                    'Over 86,000 Movies & TV Shows',
                    '14,000 TV Shows & Series',
                    '4K,2K,FHD,HD & SD Channels',
                    'Premium Channels',
                    'All Applications',
                    'Watch Online Live TV 24/7',
                    'Free Updates',
                    'TV Guide (EPG)',
                    'Support All Devices',
                    '24/7 support',
                    'AntiFreeze Technology',
                    '99.9% Uptime',
                    '2024 Best IPTV Service'
                ],
                'is_popular' => true,
                'is_active' => true,
                'sort_order' => 1,
                'display_pages' => ['home', 'pricing', 'subscription']
            ],
            [
                'name' => 'XXX-6 Month',
                'type' => 'xxx',
                'duration' => '6 Months',
                'price' => 49.99,
                'original_price' => 99.98,
                'features' => [
                    '12,000 Channels',
                    'With Adult Channels & Movies',
                    'Over 86,000 Movies & TV Shows',
                    '14,000 TV Shows & Series',
                    '4K,2K,FHD,HD & SD Channels',
                    'Premium Channels',
                    'All Applications',
                    'Watch Online Live TV 24/7',
                    'Free Updates',
                    'TV Guide (EPG)',
                    'Support All Devices',
                    '24/7 support',
                    'AntiFreeze Technology',
                    '99.9% Uptime',
                    '2024 Best IPTV Service'
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 2,
                'display_pages' => ['home', 'pricing', 'subscription']
            ],
            [
                'name' => 'XXX-3 Month',
                'type' => 'xxx',
                'duration' => '3 Months',
                'price' => 29.99,
                'original_price' => 59.98,
                'features' => [
                    '12,000 Channels',
                    'With Adult Channels & Movies',
                    'Over 86,000 Movies & TV Shows',
                    '14,000 TV Shows & Series',
                    '4K,2K,FHD,HD & SD Channels',
                    'Premium Channels',
                    'All Applications',
                    'Watch Online Live TV 24/7',
                    'Free Updates',
                    'TV Guide (EPG)',
                    'Support All Devices',
                    '24/7 support',
                    'AntiFreeze Technology',
                    '99.9% Uptime',
                    '2024 Best IPTV Service'
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 3,
                'display_pages' => ['home', 'pricing', 'subscription']
            ],
            [
                'name' => 'Standard-1 Month',
                'type' => 'standard',
                'duration' => '1 Month',
                'price' => 10.99,
                'original_price' => 21.98,
                'features' => [
                    '12,000 Channels',
                    'Over 86,000 Movies & TV Shows',
                    '14,000 TV Shows & Series',
                    '4K,2K,FHD,HD & SD Channels',
                    'Premium Channels',
                    'All Applications',
                    'Watch Online Live TV 24/7',
                    'Free Updates',
                    'TV Guide (EPG)',
                    'Support All Devices',
                    '24/7 support',
                    'AntiFreeze Technology',
                    '99.9% Uptime',
                    '2024 Best IPTV Service'
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 4,
                'display_pages' => ['home', 'pricing', 'subscription']
            ],
            [
                'name' => 'Standard-3 Month',
                'type' => 'standard',
                'duration' => '3 Months',
                'price' => 24.99,
                'original_price' => 49.98,
                'features' => [
                    '12,000 Channels',
                    'Over 86,000 Movies & TV Shows',
                    '14,000 TV Shows & Series',
                    '4K,2K,FHD,HD & SD Channels',
                    'Premium Channels',
                    'All Applications',
                    'Watch Online Live TV 24/7',
                    'Free Updates',
                    'TV Guide (EPG)',
                    'Support All Devices',
                    '24/7 support',
                    'AntiFreeze Technology',
                    '99.9% Uptime',
                    '2024 Best IPTV Service'
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 5,
                'display_pages' => ['home', 'pricing', 'subscription']
            ],
            [
                'name' => 'XXX-1 Month',
                'type' => 'xxx',
                'duration' => '1 Month',
                'price' => 13.99,
                'original_price' => 27.98,
                'features' => [
                    '12,000 Channels',
                    'With Adult Channels/Movies',
                    'Over 86,000 Movies & TV Shows',
                    '14,000 TV Shows & Series',
                    '4K,2K,FHD,HD & SD Channels',
                    'Premium Channels',
                    'All Applications',
                    'Watch Online Live TV 24/7',
                    'Free Updates',
                    'TV Guide (EPG)',
                    'Support All Devices',
                    '24/7 support',
                    'AntiFreeze Technology',
                    '99.9% Uptime',
                    '2024 Best IPTV Service'
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 6,
                'display_pages' => ['home', 'pricing', 'subscription']
            ]
        ];

        $successCount = 0;
        $errorCount = 0;
        $stripeSuccessCount = 0;
        $stripeErrorCount = 0;

        $progressBar = $this->output->createProgressBar(count($plans));
        $progressBar->start();

        foreach ($plans as $index => $planData) {
            try {
                // Check if plan already exists (unless force mode)
                if (!$force && SubscriptionPlan::where('name', $planData['name'])->exists()) {
                    $this->warn("⚠️  Plan '{$planData['name']}' already exists. Skipping...");
                    $progressBar->advance();
                    continue;
                }

                // Create the plan in the database
                $plan = SubscriptionPlan::create($planData);
                $successCount++;

                // Create Stripe integration (unless skipped)
                if (!$skipStripe) {
                    $stripeResult = $stripeService->createStripePlan($plan);
                    
                    if ($stripeResult['success']) {
                        // Update the plan with Stripe IDs
                        $plan->update([
                            'stripe_product_id' => $stripeResult['product_id'],
                            'stripe_plan_id' => $stripeResult['price_id']
                        ]);
                        $stripeSuccessCount++;
                    } else {
                        $stripeErrorCount++;
                        $this->error("❌ Stripe integration failed for: {$plan->name}");
                        $this->error("   Error: {$stripeResult['error']}");
                    }
                }

            } catch (\Exception $e) {
                $errorCount++;
                $this->error("❌ Failed to create plan: {$planData['name']}");
                $this->error("   Error: {$e->getMessage()}");
                
                Log::error("Subscription plan command failed for plan: {$planData['name']}", [
                    'plan_data' => $planData,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }

            $progressBar->advance();

            // Add a small delay to avoid rate limiting
            if ($index < count($plans) - 1) {
                sleep(1);
            }
        }

        $progressBar->finish();
        $this->newLine(2);

        // Display results
        $this->info('📊 Seeding Results:');
        $this->table(
            ['Metric', 'Count'],
            [
                ['Database Records Created', $successCount],
                ['Database Errors', $errorCount],
                ['Stripe Integrations Success', $stripeSuccessCount],
                ['Stripe Integrations Failed', $stripeErrorCount],
            ]
        );

        if ($stripeSuccessCount > 0) {
            $this->info('✅ Check your Stripe dashboard to see the created products and prices.');
        }

        if ($stripeErrorCount > 0) {
            $this->warn('⚠️  Some Stripe integrations failed. Check the logs for details.');
        }

        $this->newLine();
        $this->info('🎉 Subscription plan seeding completed!');
    }
}
