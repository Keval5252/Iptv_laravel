# Subscription Plan Seeding with Stripe Integration

This document explains how to use the subscription plan seeders that create both database records and Stripe products/prices.

## Available Commands

### 1. Artisan Command (Recommended)
```bash
# Seed with Stripe integration
php artisan seed:subscription-plans-stripe

# Skip Stripe integration (database only)
php artisan seed:subscription-plans-stripe --skip-stripe

# Force recreate all plans (deletes existing ones)
php artisan seed:subscription-plans-stripe --force

# Force recreate with database only
php artisan seed:subscription-plans-stripe --force --skip-stripe
```

### 2. Database Seeder
```bash
# Run the seeder directly
php artisan db:seed --class=SubscriptionPlanSeeder

# Run all seeders (includes subscription plans)
php artisan db:seed
```

## What Gets Created

### Database Records
- 7 subscription plans with different durations and types
- Features, pricing, and metadata
- Display page configurations
- Sort order and popularity settings

### Stripe Integration (when enabled)
- **Products**: One for each subscription plan
- **Prices**: Recurring prices based on plan duration
- **Metadata**: Plan ID, type, and duration for tracking

## Plan Types Created

1. **XXX-2 Year** - $109.99 (2 years, XXX type)
2. **XXX-1 Year** - $65.99 (1 year, XXX type, Popular)
3. **XXX-6 Month** - $49.99 (6 months, XXX type)
4. **XXX-3 Month** - $29.99 (3 months, XXX type)
5. **Standard-1 Month** - $10.99 (1 month, Standard type)
6. **Standard-3 Month** - $24.99 (3 months, Standard type)
7. **XXX-1 Month** - $13.99 (1 month, XXX type)

## Prerequisites

### Stripe Configuration
Make sure your `.env` file has the correct Stripe keys:
```env
STRIPE_KEY=pk_test_your_stripe_publishable_key_here
STRIPE_SECRET=sk_test_your_stripe_secret_key_here
STRIPE_WEBHOOK_SECRET=whsec_your_stripe_webhook_secret_here
```

### Database
Ensure your database is migrated:
```bash
php artisan migrate
```

## Features

### Command Features
- ✅ **Progress bar** - Visual progress indication
- ✅ **Error handling** - Graceful error handling with detailed messages
- ✅ **Duplicate prevention** - Skips existing plans unless `--force` is used
- ✅ **Rate limiting** - 1-second delay between Stripe API calls
- ✅ **Detailed logging** - All operations are logged
- ✅ **Summary report** - Shows success/failure counts

### Stripe Integration Features
- ✅ **Product creation** - Creates Stripe products with descriptions
- ✅ **Price creation** - Creates recurring prices based on plan duration
- ✅ **Metadata tracking** - Links Stripe resources to database records
- ✅ **Error recovery** - Continues if Stripe operations fail
- ✅ **Direct API calls** - Uses cURL to avoid library compatibility issues

## Usage Examples

### Development Setup
```bash
# Clear existing data and recreate everything
php artisan seed:subscription-plans-stripe --force
```

### Production Setup (with Stripe)
```bash
# Create plans with Stripe integration
php artisan seed:subscription-plans-stripe
```

### Testing (without Stripe)
```bash
# Create plans without Stripe integration
php artisan seed:subscription-plans-stripe --skip-stripe
```

### Adding New Plans
To add new plans, edit the `$plans` array in:
- `database/seeders/SubscriptionPlanSeeder.php`
- `app/Console/Commands/SeedSubscriptionPlansWithStripe.php`

## Troubleshooting

### Common Issues

1. **Stripe API Errors**
   - Check your Stripe API keys in `.env`
   - Ensure you have sufficient permissions
   - Check Stripe dashboard for rate limits

2. **Database Errors**
   - Run `php artisan migrate` first
   - Check database connection
   - Verify table structure

3. **Duplicate Plans**
   - Use `--force` to recreate existing plans
   - Or manually delete existing plans first

### Logs
Check the Laravel logs for detailed error information:
```bash
tail -f storage/logs/laravel.log
```

## Verification

### Database Verification
```bash
# Check created plans
php artisan tinker
>>> App\Models\SubscriptionPlan::all()->pluck('name', 'stripe_plan_id')
```

### Stripe Verification
1. Log into your Stripe dashboard
2. Go to Products section
3. Verify all 7 products are created
4. Check that prices are set correctly

## Support

If you encounter issues:
1. Check the logs for detailed error messages
2. Verify Stripe API keys and permissions
3. Ensure database is properly migrated
4. Check network connectivity for Stripe API calls
