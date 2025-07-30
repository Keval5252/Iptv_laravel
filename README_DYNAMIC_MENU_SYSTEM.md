# Dynamic Menu Management System

## Overview

The Dynamic Menu Management System allows administrators to create, edit, and manage website menus through the admin panel. This system provides complete control over navigation menus, including their structure, content, and display locations.

## Features

### 🎯 Core Features
- **Dynamic Menu Creation**: Create menus for different locations (header, footer, drawer, etc.)
- **Menu Item Management**: Add, edit, and organize menu items with hierarchical support
- **Location-based Menus**: Different menus for different areas of the website
- **Active/Inactive Toggle**: Enable or disable menus and menu items
- **Sort Order Control**: Drag-and-drop reordering of menus and menu items
- **Icon Support**: Add FontAwesome icons to menu items
- **Custom URLs & Routes**: Support for both custom URLs and Laravel route names
- **Target Window Control**: Open links in same window, new tab, etc.
- **CSS Class Support**: Add custom CSS classes to menu items
- **Plan Type Integration**: Associate menu items with specific subscription plan types

### 🎨 Admin Interface
- **User-friendly Forms**: Intuitive create and edit forms
- **Real-time Validation**: Form validation with error messages
- **Drag & Drop Sorting**: Visual reordering of menus and items
- **Status Indicators**: Clear visual status for active/inactive items
- **Bulk Operations**: Toggle status, delete, and manage multiple items

## Database Structure

### Menus Table
```sql
menus
├── id (Primary Key)
├── name (Menu name)
├── location (Menu location: header, footer, drawer, etc.)
├── description (Optional description)
├── is_active (Boolean status)
├── sort_order (Display order)
├── created_at
└── updated_at
```

### Menu Items Table
```sql
menu_items
├── id (Primary Key)
├── menu_id (Foreign Key to menus)
├── parent_id (Self-referencing for hierarchy)
├── title (Display text)
├── url (Custom URL)
├── route_name (Laravel route name)
├── target (Link target: _self, _blank, etc.)
├── icon (FontAwesome icon class)
├── css_class (Custom CSS classes)
├── is_active (Boolean status)
├── sort_order (Display order)
├── settings (JSON for additional data)
├── created_at
└── updated_at
```

## Menu Locations

### Predefined Locations
1. **header** - Main navigation menu
2. **footer** - Footer navigation menu
3. **drawer** - Mobile drawer menu
4. **operation_guide** - Operation guide navigation
5. **subscription** - Subscription plans navigation

### Custom Locations
- Support for custom location names
- Dynamic form field for custom location input

## Menu Item Types

### Standard Menu Items
- **Title**: Display text for the menu item
- **URL/Route**: Link destination
- **Icon**: FontAwesome icon class
- **Target**: How the link opens (_self, _blank, etc.)
- **CSS Class**: Additional styling classes

### Hierarchical Support
- **Parent Items**: Main menu items
- **Child Items**: Sub-menu items
- **Unlimited Nesting**: Support for multiple levels

### Plan Type Integration
- **Plan Types**: Associate menu items with subscription plan types
- **Dynamic Filtering**: Show relevant plans based on menu item settings
- **Settings JSON**: Flexible storage for plan type associations

## Admin Panel Usage

### Accessing Menu Management
1. Login to admin panel
2. Navigate to **Menu Management** in the sidebar
3. Access menu creation, editing, and management tools

### Creating a New Menu
1. Click **"Create New Menu"** button
2. Fill in the form:
   - **Menu Name**: Descriptive name for the menu
   - **Location**: Select predefined or custom location
   - **Description**: Optional description
   - **Sort Order**: Display order (optional)
   - **Active**: Check to enable the menu
3. Click **"Create Menu"** to save

### Managing Menu Items
1. Navigate to **Menu Items** in the sidebar
2. Click **"Create New Menu Item"**
3. Fill in the form:
   - **Menu**: Select the parent menu
   - **Parent Item**: Select parent item for sub-menus (optional)
   - **Title**: Display text
   - **URL/Route**: Link destination
   - **Target**: How link opens
   - **Icon**: FontAwesome icon class
   - **CSS Class**: Custom styling
   - **Plan Types**: Associated subscription plan types
   - **Sort Order**: Display order
   - **Active**: Enable/disable item
4. Click **"Create Menu Item"** to save

### Editing Menus and Items
1. Click the **Edit** button (pencil icon) next to any menu or item
2. Modify the desired fields
3. Click **"Update"** to save changes

### Reordering Items
1. Use drag-and-drop functionality in the admin tables
2. Items automatically reorder based on visual position
3. Changes are saved automatically

### Toggling Status
1. Click the **Toggle Status** button (toggle icon)
2. Items switch between active and inactive states
3. Inactive items are hidden from the frontend

## Frontend Integration

### Helper Functions

#### `getMenuItems($location)`
Retrieves menu items for a specific location.

```php
$headerItems = getMenuItems('header');
```

#### `renderMenu($location)`
Renders a complete menu for a specific location.

```php
echo renderMenu('header');
```

#### `isMenuActive($menuItem)`
Checks if a menu item is currently active.

```php
$isActive = isMenuActive($menuItem);
```

#### `getPlansByMenu($menuItem)`
Gets subscription plans filtered by menu item settings.

```php
$plans = getPlansByMenu($menuItem);
```

### Blade Templates

#### Menu Partial
```blade
@include('partials.menu', ['menuItems' => getMenuItems('header')])
```

#### Dynamic Menu Rendering
```blade
{!! renderMenu('header') !!}
```

#### Active State Checking
```blade
<li class="{{ isMenuActive($menuItem) ? 'active' : '' }}">
    <a href="{{ $menuItem->final_url }}">{{ $menuItem->title }}</a>
</li>
```

## API Endpoints

### Menu Management
- `GET /admin/menus` - List all menus
- `POST /admin/menus` - Create new menu
- `GET /admin/menus/{id}` - Show menu details
- `PUT /admin/menus/{id}` - Update menu
- `DELETE /admin/menus/{id}` - Delete menu
- `POST /admin/menus/{id}/toggle-status` - Toggle menu status
- `POST /admin/menus/update-order` - Update menu order

### Menu Items Management
- `GET /admin/menu-items` - List all menu items
- `POST /admin/menu-items` - Create new menu item
- `GET /admin/menu-items/{id}` - Show menu item details
- `PUT /admin/menu-items/{id}` - Update menu item
- `DELETE /admin/menu-items/{id}` - Delete menu item
- `POST /admin/menu-items/{id}/toggle-status` - Toggle item status
- `POST /admin/menu-items/update-order` - Update item order
- `GET /admin/menu-items/by-menu/{menu}` - Get items by menu

## Default Menus

The system comes with pre-configured menus:

### Header Navigation
- IPTV SUBSCRIPTION
- ADULT IPTV
- ADULT IPTV MULTI
- MULTI CONNECTIONS SUBSCRIPTION

### Footer Menu
- About Us
- Contact Us
- Privacy Policy
- Terms of Service

### Operation Guide
- Android Smartphone & Android Box
- Android TV - Perfect Player
- Apple iPhone, iPad & Apple TV
- Enigma2 Dreambox VU
- Kodi Version 16 or Lower
- Kodi XBMC Version 17+
- MAG 250, 254, 256
- PC Mac Logiciel VLC
- Smart TV Samsung LG
- STB Emulator

### Subscription Plans
- IPTV Subscription
- Adult IPTV
- Multi Connections
- Multi Connections Prices

## Customization

### Adding New Menu Locations
1. Create a new menu with custom location
2. Add menu items to the new location
3. Use `getMenuItems('custom_location')` in templates

### Custom Styling
1. Add CSS classes to menu items
2. Style menu items using the `css_class` field
3. Customize the menu partial template

### Plan Type Integration
1. Set plan types in menu item settings
2. Use `getPlansByMenu($menuItem)` to filter plans
3. Display relevant plans on pages

## Best Practices

### Menu Organization
- Use descriptive menu names
- Group related items together
- Maintain logical hierarchy
- Keep menu items concise

### Performance
- Cache menu data when possible
- Use eager loading for menu relationships
- Optimize database queries

### User Experience
- Provide clear navigation labels
- Use appropriate icons
- Maintain consistent styling
- Test on different devices

## Troubleshooting

### Common Issues

#### Menu Not Displaying
- Check if menu is active
- Verify menu location is correct
- Ensure menu items are active
- Check template integration

#### Menu Items Not Showing
- Verify menu item is active
- Check parent menu is active
- Ensure proper route/URL configuration
- Validate template syntax

#### Order Not Saving
- Check JavaScript is loaded
- Verify AJAX requests are working
- Check server-side validation
- Review browser console for errors

### Debugging
- Use `dd(getMenuItems('location'))` to debug menu data
- Check database for menu/item status
- Review admin panel for configuration
- Test helper functions directly

## Security

### Access Control
- Admin-only access to menu management
- CSRF protection on all forms
- Input validation and sanitization
- SQL injection prevention

### Data Validation
- Required field validation
- URL format validation
- Route name verification
- XSS prevention

## Future Enhancements

### Planned Features
- **Menu Templates**: Pre-built menu layouts
- **Menu Analytics**: Usage tracking and statistics
- **Multi-language Support**: Internationalization
- **Menu Caching**: Performance optimization
- **Menu Import/Export**: Bulk operations
- **Menu Versioning**: Change tracking
- **Menu Preview**: Live preview functionality

### Integration Possibilities
- **SEO Optimization**: Meta tags and structured data
- **A/B Testing**: Menu performance testing
- **User Preferences**: Personalized menus
- **Mobile Optimization**: Responsive menu design
- **Search Integration**: Menu search functionality

## Support

For technical support or questions about the Dynamic Menu Management System:

1. Check the troubleshooting section
2. Review the admin panel documentation
3. Contact the development team
4. Submit bug reports with detailed information

---

**Version**: 1.0.0  
**Last Updated**: July 30, 2025  
**Compatibility**: Laravel 10.x, PHP 8.1+ 