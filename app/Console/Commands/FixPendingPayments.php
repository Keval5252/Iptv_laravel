<?php

namespace App\Console\Commands;

use App\Models\StripePayment;
use App\Models\UserSubscription;
use Illuminate\Console\Command;

class FixPendingPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:pending-payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix pending payments for active subscriptions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fixing pending payments for active subscriptions...');

        // Find all active subscriptions
        $activeSubscriptions = UserSubscription::where('status', 'active')->get();

        $fixedCount = 0;

        foreach ($activeSubscriptions as $subscription) {
            // Find pending payments for this user and plan
            $pendingPayments = StripePayment::where('user_id', $subscription->user_id)
                ->where('subscription_plan_id', $subscription->subscription_plan_id)
                ->where('status', 'pending')
                ->get();

            foreach ($pendingPayments as $payment) {
                $payment->update([
                    'status' => 'succeeded',
                    'paid_at' => $subscription->start_date ?? now(),
                ]);
                $fixedCount++;
                $this->line("Fixed payment ID: {$payment->id} for user {$subscription->user_id}");
            }
        }

        $this->info("Fixed {$fixedCount} pending payments.");
        return 0;
    }
}
