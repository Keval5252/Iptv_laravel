<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Services\StripeCustomerService;
use Illuminate\Support\Facades\Log;

class CreateStripeCustomersForExistingUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stripe:create-customers 
                            {--dry-run : Show what would be done without making changes}
                            {--limit=50 : Limit the number of users to process}
                            {--user-type=* : Specific user types to process (default: all)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Stripe customers for existing users who don\'t have them';

    protected $stripeCustomerService;

    /**
     * Create a new command instance.
     */
    public function __construct(StripeCustomerService $stripeCustomerService)
    {
        parent::__construct();
        $this->stripeCustomerService = $stripeCustomerService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $limit = (int) $this->option('limit');
        $userTypes = $this->option('user-type');

        $this->info('🚀 Starting Stripe customer creation for existing users...');
        $this->newLine();

        if ($dryRun) {
            $this->warn('⚠️  DRY RUN MODE - No changes will be made');
            $this->newLine();
        }

        // Get users without Stripe customer IDs
        $query = User::whereNull('stripe_customer_id');
        
        // Filter by user types if specified
        if (!empty($userTypes)) {
            $query->whereIn('user_type', $userTypes);
        }
        
        $users = $query->limit($limit)->get();

        if ($users->isEmpty()) {
            $this->info('✅ All users already have Stripe customer IDs!');
            return;
        }

        $this->info("Found {$users->count()} users without Stripe customer IDs");
        $this->newLine();

        $successCount = 0;
        $errorCount = 0;

        $progressBar = $this->output->createProgressBar($users->count());
        $progressBar->start();

        foreach ($users as $user) {
            try {
                if ($dryRun) {
                    $this->line("Would create Stripe customer for: {$user->name} ({$user->email}) - User Type: {$user->user_type}");
                } else {
                    $result = $this->stripeCustomerService->createStripeCustomer($user);
                    
                    if ($result['success']) {
                        $successCount++;
                        $this->line("✅ Created customer for: {$user->name} (Type: {$user->user_type})");
                    } else {
                        $errorCount++;
                        $this->error("❌ Failed for {$user->name}: {$result['error']}");
                    }
                }

            } catch (\Exception $e) {
                $errorCount++;
                $this->error("❌ Exception for {$user->name}: {$e->getMessage()}");
                
                Log::error('Stripe customer creation command failed', [
                    'user_id' => $user->id,
                    'user_email' => $user->email,
                    'user_type' => $user->user_type,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }

            $progressBar->advance();

            // Add a small delay to avoid rate limiting
            sleep(1);
        }

        $progressBar->finish();
        $this->newLine(2);

        // Display results
        $this->info('📊 Results:');
        $this->table(
            ['Metric', 'Count'],
            [
                ['Users Processed', $users->count()],
                ['Successful', $successCount],
                ['Failed', $errorCount],
            ]
        );

        if ($successCount > 0) {
            $this->info('✅ Check your Stripe dashboard to see the created customers.');
        }

        if ($errorCount > 0) {
            $this->warn('⚠️  Some customers failed to create. Check the logs for details.');
        }

        $this->newLine();
        $this->info('�� Stripe customer creation completed!');
    }
}
