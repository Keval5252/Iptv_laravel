# IPTV Subscription System Setup Guide

This guide will help you set up the complete user authentication and subscription system with Stripe payment integration.

## Features Implemented

- ✅ User Registration and Login System
- ✅ Subscription Plan Management
- ✅ Stripe Payment Integration
- ✅ User Dashboard
- ✅ Payment History Tracking
- ✅ Subscription Status Management

## Prerequisites

- Laravel 10.x
- PHP 8.1+
- MySQL/PostgreSQL Database
- Stripe Account

## Installation Steps

### 1. Install Dependencies

```bash
composer install
```

### 2. Environment Configuration

Add the following Stripe configuration to your `.env` file:

```env
# Stripe Configuration
STRIPE_KEY=pk_test_your_stripe_publishable_key_here
STRIPE_SECRET=sk_test_your_stripe_secret_key_here
STRIPE_WEBHOOK_SECRET=whsec_your_stripe_webhook_secret_here
```

### 3. Run Migrations

```bash
php artisan migrate
```

### 4. Stripe Setup

1. Create a Stripe account at [stripe.com](https://stripe.com)
2. Get your API keys from the Stripe Dashboard
3. Set up webhook endpoints for payment events
4. Update your `.env` file with the Stripe credentials

### 5. Webhook Configuration

In your Stripe Dashboard, create a webhook endpoint:
- URL: `https://yourdomain.com/stripe/webhook`
- Events to listen for:
  - `payment_intent.succeeded`
  - `payment_intent.payment_failed`
  - `customer.subscription.deleted`

## Usage

### User Registration

Users can register at `/user/register` with:
- First Name
- Last Name
- Email
- Password
- Optional: Phone, Address, City, State, Country, Postal Code

### User Login

Users can login at `/user/login` with their email and password.

### Subscription Plans

- View available plans at `/subscription-plans`
- Purchase plans with Stripe payment
- Manage subscriptions from the dashboard

### Admin Management

Admins can manage subscription plans from `/admin/subscription-plans`:
- Create new plans
- Set pricing and features
- Toggle plan availability
- Manage plan ordering

## Routes

### Public Routes
- `GET /user/login` - User login form
- `GET /user/register` - User registration form
- `POST /user/login` - User login submission
- `POST /user/register` - User registration submission

### Protected Routes (Require Authentication)
- `GET /subscription-plans` - View available plans
- `GET /subscription-plans/{id}` - View specific plan
- `GET /subscription-plans/{id}/purchase` - Purchase plan page
- `GET /dashboard` - User dashboard
- `POST /subscription/cancel` - Cancel subscription

### Stripe Routes
- `POST /stripe/create-payment-intent` - Create payment intent
- `POST /stripe/confirm-payment` - Confirm payment
- `POST /stripe/webhook` - Stripe webhook handler

## Database Tables

### users
- Standard user fields + `stripe_customer_id`

### subscription_plans
- Plan details, pricing, features, status

### user_subscriptions
- User subscription records with status and dates

### stripe_payments
- Payment transaction records

## Models

- `User` - User model with subscription relationships
- `SubscriptionPlan` - Plan management
- `UserSubscription` - User subscription tracking
- `StripePayment` - Payment history

## Controllers

- `UserAuthController` - User authentication
- `SubscriptionController` - Subscription management
- `StripeController` - Stripe payment handling

## Views

- `auth/user-login.blade.php` - User login form
- `auth/user-register.blade.php` - User registration form
- `subscription/plans.blade.php` - Subscription plans listing
- `subscription/purchase.blade.php` - Plan purchase with Stripe
- `subscription/dashboard.blade.php` - User dashboard
- `layouts/app.blade.php` - Main application layout

## Testing

### Test Cards (Stripe Test Mode)

Use these test card numbers for testing:

- **Success**: 4242 4242 4242 4242
- **Decline**: 4000 0000 0000 0002
- **Requires Authentication**: 4000 0025 0000 3155

### Test Scenarios

1. **Successful Payment**: Use 4242 4242 4242 4242
2. **Failed Payment**: Use 4000 0000 0000 0002
3. **3D Secure**: Use 4000 0025 0000 3155

## Security Features

- CSRF protection on all forms
- Input validation and sanitization
- Secure password hashing
- Stripe webhook signature verification
- Authentication middleware protection

## Customization

### Styling
- Modify CSS in the view files
- Update Bootstrap theme colors
- Customize Font Awesome icons

### Features
- Add more subscription plan types
- Implement recurring billing
- Add discount codes
- Create referral system

### Payment Methods
- Add PayPal integration
- Support for multiple currencies
- Implement Apple Pay/Google Pay

## Troubleshooting

### Common Issues

1. **Stripe Keys Not Working**
   - Verify keys are correct in `.env`
   - Check if using test/live keys appropriately

2. **Webhook Not Working**
   - Verify webhook URL is accessible
   - Check webhook secret in `.env`
   - Ensure proper SSL certificate

3. **Payment Not Processing**
   - Check browser console for JavaScript errors
   - Verify Stripe Elements are loading
   - Check server logs for errors

### Debug Mode

Enable debug mode in `.env`:
```env
APP_DEBUG=true
LOG_LEVEL=debug
```

## Support

For issues or questions:
1. Check Laravel logs in `storage/logs/`
2. Verify Stripe Dashboard for payment status
3. Check browser console for frontend errors
4. Review database for data consistency

## License

This system is part of the IPTV Laravel application. 