<?php

namespace App\Console\Commands;

use App\Models\StripePayment;
use App\Models\UserSubscription;
use Illuminate\Console\Command;

class FixMissingPaymentRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:missing-payment-records';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create missing payment records for active subscriptions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating missing payment records for active subscriptions...');

        // Find all active subscriptions
        $activeSubscriptions = UserSubscription::where('status', 'active')->get();

        $createdCount = 0;

        foreach ($activeSubscriptions as $subscription) {
            // Check if payment record exists
            $existingPayment = StripePayment::where('user_id', $subscription->user_id)
                ->where('subscription_plan_id', $subscription->subscription_plan_id)
                ->where('status', 'succeeded')
                ->first();

            if (!$existingPayment) {
                // Create missing payment record
                StripePayment::create([
                    'user_id' => $subscription->user_id,
                    'subscription_plan_id' => $subscription->subscription_plan_id,
                    'stripe_payment_intent_id' => $subscription->stripe_payment_intent_id ?? 'manual_' . $subscription->id,
                    'stripe_customer_id' => $subscription->stripe_customer_id,
                    'stripe_subscription_id' => $subscription->stripe_subscription_id,
                    'amount' => $subscription->amount_paid,
                    'currency' => $subscription->currency ?? 'usd',
                    'status' => 'succeeded',
                    'paid_at' => $subscription->start_date ?? now(),
                    'metadata' => [
                        'plan_name' => $subscription->subscriptionPlan->name ?? 'Unknown Plan',
                        'plan_duration' => $subscription->subscriptionPlan->duration ?? 'unknown',
                        'created_by' => 'fix_command',
                    ],
                ]);
                $createdCount++;
                $this->line("Created payment record for subscription ID: {$subscription->id} (User: {$subscription->user_id})");
            }
        }

        $this->info("Created {$createdCount} missing payment records.");
        return 0;
    }
}
