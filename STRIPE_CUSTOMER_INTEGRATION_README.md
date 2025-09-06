# Stripe Customer Integration for User Registration

This document explains the Stripe customer integration that automatically creates Stripe customers when users register and manages them for subscription purposes.

## Overview

When a user registers in the system, a corresponding Stripe customer is automatically created and linked to the user account. This enables seamless subscription management and payment processing.

## Features

### ✅ Automatic Customer Creation
- **User Registration**: Stripe customers are created automatically during user registration
- **Database Integration**: Customer IDs are stored in the `stripe_customer_id` field
- **Error Handling**: Registration continues even if Stripe customer creation fails
- **Comprehensive Logging**: All operations are logged for debugging

### ✅ Customer Management
- **Get or Create**: Service automatically gets existing customer or creates new one
- **Update Support**: Customer information can be updated when user profile changes
- **Direct API Calls**: Uses cURL to avoid Stripe library compatibility issues

### ✅ Subscription Integration
- **Seamless Subscriptions**: Subscriptions are created using the linked customer ID
- **Payment Processing**: All payments are associated with the correct customer
- **Billing Management**: Customer billing information is automatically synced

## Implementation Details

### 1. Database Schema
The `users` table includes:
```sql
stripe_customer_id VARCHAR(255) NULL
```

### 2. Services

#### StripeCustomerService
Located at: `app/Services/StripeCustomerService.php`

**Key Methods:**
- `createStripeCustomer(User $user)` - Creates a new Stripe customer
- `updateStripeCustomer(User $user)` - Updates existing customer information
- `getOrCreateStripeCustomer(User $user)` - Gets existing or creates new customer

### 3. Controllers Updated

#### User AuthController
- **File**: `app/Http/Controllers/User/AuthController.php`
- **Integration**: Customer creation during user registration
- **Error Handling**: Graceful fallback if Stripe fails

#### Auth RegisterController
- **File**: `app/Http/Controllers/Auth/RegisterController.php`
- **Integration**: Customer creation for Laravel's default registration
- **Error Handling**: Registration continues even if Stripe fails

#### StripeSubscriptionController
- **File**: `app/Http/Controllers/StripeSubscriptionController.php`
- **Integration**: Uses customer service for subscription creation
- **Direct API**: Uses cURL for reliable subscription management

### 4. Commands

#### Create Stripe Customers for Existing Users
```bash
# Dry run to see what would be done
php artisan stripe:create-customers --dry-run

# Create customers for existing users
php artisan stripe:create-customers

# Limit the number of users processed
php artisan stripe:create-customers --limit=50
```

## Usage Examples

### 1. User Registration Flow
```php
// When a user registers, this happens automatically:
$user = User::create([...]);

// Stripe customer is created automatically
$stripeResult = $this->stripeCustomerService->createStripeCustomer($user);
// Customer ID is stored in $user->stripe_customer_id
```

### 2. Creating Subscriptions
```php
// Get or create customer for subscription
$customerId = $this->stripeCustomerService->getOrCreateStripeCustomer($user);

// Create subscription using customer ID
$subscription = $this->createStripeSubscriptionDirectly($customerId, $plan, $user);
```

### 3. Updating Customer Information
```php
// When user profile is updated
$user->update([...]);

// Update Stripe customer information
$result = $this->stripeCustomerService->updateStripeCustomer($user);
```

## Configuration

### Environment Variables
Make sure these are set in your `.env` file:
```env
STRIPE_KEY=pk_test_your_stripe_publishable_key_here
STRIPE_SECRET=sk_test_your_stripe_secret_key_here
STRIPE_WEBHOOK_SECRET=whsec_your_stripe_webhook_secret_here
```

### Service Provider Registration
The `StripeCustomerService` is automatically registered via Laravel's service container.

## Error Handling

### Graceful Degradation
- **Registration Continues**: If Stripe customer creation fails, user registration still succeeds
- **Logging**: All errors are logged with detailed context
- **Retry Logic**: Customers can be created later using the command

### Common Issues

1. **Stripe API Errors**
   - Check API keys in `.env`
   - Verify Stripe account status
   - Check rate limits

2. **Network Issues**
   - Service includes retry logic
   - Timeout handling
   - Fallback mechanisms

3. **Data Validation**
   - Email validation before customer creation
   - Required field checks
   - Duplicate prevention

## Monitoring and Logs

### Log Locations
- **Laravel Logs**: `storage/logs/laravel.log`
- **Stripe Logs**: Available in Stripe dashboard

### Key Log Messages
```
[INFO] Stripe customer created and linked to user
[WARNING] Failed to create Stripe customer during registration
[ERROR] Stripe customer creation failed
```

### Monitoring Commands
```bash
# Check logs for Stripe operations
tail -f storage/logs/laravel.log | grep -i stripe

# Monitor customer creation
php artisan stripe:create-customers --dry-run
```

## Testing

### Manual Testing
```bash
# Test customer creation
php artisan tinker
>>> $user = App\Models\User::first();
>>> $service = new App\Services\StripeCustomerService();
>>> $result = $service->createStripeCustomer($user);
```

### Automated Testing
- Unit tests for service methods
- Integration tests for registration flow
- API tests for Stripe integration

## Best Practices

### 1. Error Handling
- Always log Stripe operations
- Don't fail user registration if Stripe fails
- Implement retry mechanisms

### 2. Data Consistency
- Keep customer information in sync
- Update Stripe when user data changes
- Handle edge cases gracefully

### 3. Performance
- Use direct API calls to avoid library issues
- Implement rate limiting
- Cache customer data when appropriate

### 4. Security
- Never log sensitive customer data
- Validate all inputs
- Use secure API communication

## Troubleshooting

### Common Problems

1. **Customer Not Created**
   - Check Stripe API keys
   - Verify user email is valid
   - Check network connectivity

2. **Duplicate Customers**
   - Service prevents duplicates
   - Check existing customer before creating
   - Use getOrCreateStripeCustomer method

3. **Subscription Failures**
   - Ensure customer exists before subscription
   - Check plan is active
   - Verify payment method

### Debug Commands
```bash
# Check user's Stripe customer ID
php artisan tinker
>>> App\Models\User::find(1)->stripe_customer_id

# Test customer creation
php artisan stripe:create-customers --dry-run --limit=1

# Check Stripe dashboard for created customers
```

## Support

For issues or questions:
1. Check the logs for detailed error messages
2. Verify Stripe configuration
3. Test with dry-run commands
4. Check Stripe dashboard for customer status

The integration is designed to be robust and handle failures gracefully while providing comprehensive logging for debugging.
