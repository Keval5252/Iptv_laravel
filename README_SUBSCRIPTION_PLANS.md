# IPTV Subscription Plans Management System

## Overview
This system provides a complete dynamic management solution for IPTV subscription plans. The subscription plans are now managed through the admin panel and displayed dynamically on the website.

## Features

### Admin Panel Features
- **Complete CRUD Operations**: Create, Read, Update, Delete subscription plans
- **Dynamic Management**: All plans are managed through the database
- **Sort Order**: Drag and drop functionality to reorder plans
- **Status Toggle**: Activate/deactivate plans easily
- **Popular Marking**: Mark plans as "Most Popular"
- **Feature Management**: Add/remove features for each plan
- **Price Management**: Set current and original prices with automatic discount calculation
- **Buy Links**: Add custom purchase links for each plan

### Website Features
- **Dynamic Display**: All subscription plans are loaded from the database
- **Responsive Design**: Works on all devices
- **Popular Badges**: Automatically shows "MOST POPULAR" for marked plans
- **Discount Display**: Shows original price and discount percentage
- **Feature Lists**: Displays custom features for each plan

## Database Structure

### Subscription Plans Table
- `id` - Primary key
- `name` - Plan name (e.g., "XXX-1 Year")
- `type` - Plan type (xxx, standard, premium)
- `duration` - Duration (1 Month, 3 Months, etc.)
- `price` - Current price
- `original_price` - Original price for discount calculation
- `features` - JSON array of features
- `is_popular` - Boolean for "Most Popular" badge
- `is_active` - Boolean for plan visibility
- `sort_order` - Integer for ordering
- `buy_link` - URL for purchase link
- `created_at` / `updated_at` - Timestamps

## Admin Panel Access

### Routes
- **List Plans**: `/admin/subscription-plans`
- **Create Plan**: `/admin/subscription-plans/create`
- **Edit Plan**: `/admin/subscription-plans/{id}/edit`
- **View Plan**: `/admin/subscription-plans/{id}`
- **Delete Plan**: `/admin/subscription-plans/{id}` (DELETE)
- **Toggle Status**: `/admin/subscription-plans/{id}/toggle-status` (POST)
- **Update Order**: `/admin/subscription-plans/update-order` (POST)

### Navigation
The subscription plans management is accessible from the admin sidebar under "Subscription Plans".

## API Endpoints

### Public API
- `GET /api/subscription-plans` - Get all active plans
- `GET /api/subscription-plans/{type}` - Get plans by type (xxx, standard, etc.)

## Usage Instructions

### Adding a New Plan
1. Go to Admin Panel → Subscription Plans
2. Click "Add New Plan"
3. Fill in the required fields:
   - **Name**: Plan name (e.g., "XXX-1 Year")
   - **Type**: Select plan type (XXX, Standard, Premium)
   - **Duration**: Select duration
   - **Price**: Current selling price
   - **Original Price**: Original price for discount display
   - **Features**: Add custom features (optional)
   - **Buy Link**: Purchase URL (optional)
   - **Popular**: Check if this is the most popular plan
   - **Active**: Check to make plan visible on website
4. Click "Create Plan"

### Editing a Plan
1. Go to Admin Panel → Subscription Plans
2. Click the edit icon next to the plan
3. Modify the fields as needed
4. Click "Update Plan"

### Managing Plan Order
1. Go to Admin Panel → Subscription Plans
2. Drag and drop plans to reorder them
3. The order is automatically saved

### Toggling Plan Status
1. Go to Admin Panel → Subscription Plans
2. Click the toggle icon to activate/deactivate a plan
3. Inactive plans won't appear on the website

## Sample Data
The system comes with pre-populated sample data including:
- XXX plans (with adult content)
- Standard plans (without adult content)
- Various durations (1 Month to 2 Years)
- Different price points
- Sample features

## Customization

### Adding New Plan Types
1. Add new type options in the create/edit forms
2. Update the database if needed
3. Add corresponding features for the new type

### Modifying Features
Features are stored as JSON arrays and can be customized per plan. Default features are shown if no custom features are set.

### Styling
The website uses Tailwind CSS classes and can be customized by modifying the blade templates.

## Security
- All admin routes are protected by authentication
- CSRF protection is enabled
- Input validation is implemented
- SQL injection protection through Eloquent ORM

## Future Enhancements
- Multi-language support
- Advanced pricing tiers
- Integration with payment gateways
- Analytics and reporting
- Bulk import/export functionality
- Plan comparison features 