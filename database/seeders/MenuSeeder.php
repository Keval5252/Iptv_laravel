<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\MenuItem;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Header Menu
        $headerMenu = Menu::create([
            'name' => 'Header Navigation',
            'location' => 'header',
            'description' => 'Main navigation menu for the header',
            'is_active' => true,
            'sort_order' => 1
        ]);

        // Create Header Menu Items
        MenuItem::create([
            'menu_id' => $headerMenu->id,
            'title' => 'IPTV SUBSCRIPTION',
            'route_name' => 'iptv-subscription',
            'target' => '_self',
            'icon' => 'fa fa-tv',
            'is_active' => true,
            'sort_order' => 1,
            'settings' => ['plan_types' => ['iptv']]
        ]);

        MenuItem::create([
            'menu_id' => $headerMenu->id,
            'title' => 'ADULT IPTV',
            'route_name' => 'adult-channel',
            'target' => '_self',
            'icon' => 'fa fa-star',
            'is_active' => true,
            'sort_order' => 2,
            'settings' => ['plan_types' => ['adult']]
        ]);

        MenuItem::create([
            'menu_id' => $headerMenu->id,
            'title' => 'ADULT IPTV MULTI',
            'route_name' => 'adult-channel',
            'target' => '_self',
            'icon' => 'fa fa-star-o',
            'is_active' => true,
            'sort_order' => 3,
            'settings' => ['plan_types' => ['adult_multi']]
        ]);

        MenuItem::create([
            'menu_id' => $headerMenu->id,
            'title' => 'MULTI CONNECTIONS SUBSCRIPTION',
            'route_name' => 'multi-connections',
            'target' => '_self',
            'icon' => 'fa fa-users',
            'is_active' => true,
            'sort_order' => 4,
            'settings' => ['plan_types' => ['multi']]
        ]);

        // Create Drawer Menu
        $drawerMenu = Menu::create([
            'name' => 'Mobile Drawer',
            'location' => 'drawer',
            'description' => 'Mobile navigation drawer menu',
            'is_active' => true,
            'sort_order' => 2
        ]);

        // Create Drawer Menu Items (same as header for mobile)
        MenuItem::create([
            'menu_id' => $drawerMenu->id,
            'title' => 'IPTV SUBSCRIPTION',
            'route_name' => 'iptv-subscription',
            'target' => '_self',
            'icon' => 'fa fa-tv',
            'is_active' => true,
            'sort_order' => 1,
            'settings' => ['plan_types' => ['iptv']]
        ]);

        MenuItem::create([
            'menu_id' => $drawerMenu->id,
            'title' => 'ADULT IPTV',
            'route_name' => 'adult-channel',
            'target' => '_self',
            'icon' => 'fa fa-star',
            'is_active' => true,
            'sort_order' => 2,
            'settings' => ['plan_types' => ['adult']]
        ]);

        MenuItem::create([
            'menu_id' => $drawerMenu->id,
            'title' => 'ADULT IPTV MULTI',
            'route_name' => 'adult-channel',
            'target' => '_self',
            'icon' => 'fa fa-star-o',
            'is_active' => true,
            'sort_order' => 3,
            'settings' => ['plan_types' => ['adult_multi']]
        ]);

        MenuItem::create([
            'menu_id' => $drawerMenu->id,
            'title' => 'MULTI CONNECTIONS SUBSCRIPTION',
            'route_name' => 'multi-connections',
            'target' => '_self',
            'icon' => 'fa fa-users',
            'is_active' => true,
            'sort_order' => 4,
            'settings' => ['plan_types' => ['multi']]
        ]);

        // Create Footer Menu
        $footerMenu = Menu::create([
            'name' => 'Footer Menu',
            'location' => 'footer',
            'description' => 'Footer navigation menu',
            'is_active' => true,
            'sort_order' => 3
        ]);

        // Create Footer Menu Items
        MenuItem::create([
            'menu_id' => $footerMenu->id,
            'title' => 'About Us',
            'route_name' => 'about-us',
            'target' => '_self',
            'is_active' => true,
            'sort_order' => 1
        ]);

        MenuItem::create([
            'menu_id' => $footerMenu->id,
            'title' => 'Contact Us',
            'route_name' => 'contact-us',
            'target' => '_self',
            'is_active' => true,
            'sort_order' => 2
        ]);

        MenuItem::create([
            'menu_id' => $footerMenu->id,
            'title' => 'Privacy Policy',
            'route_name' => 'privacy-policy',
            'target' => '_self',
            'is_active' => true,
            'sort_order' => 3
        ]);

        MenuItem::create([
            'menu_id' => $footerMenu->id,
            'title' => 'Terms of Service',
            'route_name' => 'terms-of-service',
            'target' => '_self',
            'is_active' => true,
            'sort_order' => 4
        ]);

        // Create Operation Guide Menu
        $operationGuideMenu = Menu::create([
            'name' => 'Operation Guide',
            'location' => 'operation_guide',
            'description' => 'Operation guide navigation menu',
            'is_active' => true,
            'sort_order' => 4
        ]);

        // Create Operation Guide Menu Items
        MenuItem::create([
            'menu_id' => $operationGuideMenu->id,
            'title' => 'Android Smartphone & Android Box',
            'route_name' => 'operation-guide-android',
            'target' => '_self',
            'icon' => 'fa fa-mobile',
            'is_active' => true,
            'sort_order' => 1
        ]);

        MenuItem::create([
            'menu_id' => $operationGuideMenu->id,
            'title' => 'Android TV - Perfect Player',
            'route_name' => 'operation-guide-android-tv',
            'target' => '_self',
            'icon' => 'fa fa-tv',
            'is_active' => true,
            'sort_order' => 2
        ]);

        MenuItem::create([
            'menu_id' => $operationGuideMenu->id,
            'title' => 'Apple iPhone, iPad & Apple TV',
            'route_name' => 'operation-guide-apple',
            'target' => '_self',
            'icon' => 'fa fa-apple',
            'is_active' => true,
            'sort_order' => 3
        ]);

        MenuItem::create([
            'menu_id' => $operationGuideMenu->id,
            'title' => 'Enigma2 Dreambox VU',
            'route_name' => 'operation-guide-enigma',
            'target' => '_self',
            'icon' => 'fa fa-cube',
            'is_active' => true,
            'sort_order' => 4
        ]);

        MenuItem::create([
            'menu_id' => $operationGuideMenu->id,
            'title' => 'Kodi Version 16 or Lower',
            'route_name' => 'operation-guide-kodi-old',
            'target' => '_self',
            'icon' => 'fa fa-play',
            'is_active' => true,
            'sort_order' => 5
        ]);

        MenuItem::create([
            'menu_id' => $operationGuideMenu->id,
            'title' => 'Kodi XBMC Version 17+',
            'route_name' => 'operation-guide-kodi-new',
            'target' => '_self',
            'icon' => 'fa fa-play-circle',
            'is_active' => true,
            'sort_order' => 6
        ]);

        MenuItem::create([
            'menu_id' => $operationGuideMenu->id,
            'title' => 'MAG 250, 254, 256',
            'route_name' => 'operation-guide-mag',
            'target' => '_self',
            'icon' => 'fa fa-desktop',
            'is_active' => true,
            'sort_order' => 7
        ]);

        MenuItem::create([
            'menu_id' => $operationGuideMenu->id,
            'title' => 'PC Mac Logiciel VLC',
            'route_name' => 'operation-guide-pc',
            'target' => '_self',
            'icon' => 'fa fa-laptop',
            'is_active' => true,
            'sort_order' => 8
        ]);

        MenuItem::create([
            'menu_id' => $operationGuideMenu->id,
            'title' => 'Smart TV Samsung LG',
            'route_name' => 'operation-guide-smart-tv',
            'target' => '_self',
            'icon' => 'fa fa-tv',
            'is_active' => true,
            'sort_order' => 9
        ]);

        MenuItem::create([
            'menu_id' => $operationGuideMenu->id,
            'title' => 'STB Emulator',
            'route_name' => 'operation-guide-stb',
            'target' => '_self',
            'icon' => 'fa fa-gamepad',
            'is_active' => true,
            'sort_order' => 10
        ]);

        // Create Subscription Menu
        $subscriptionMenu = Menu::create([
            'name' => 'Subscription Plans',
            'location' => 'subscription',
            'description' => 'Subscription plans navigation menu',
            'is_active' => true,
            'sort_order' => 5
        ]);

        // Create Subscription Menu Items
        MenuItem::create([
            'menu_id' => $subscriptionMenu->id,
            'title' => 'IPTV Subscription',
            'route_name' => 'iptv-subscription',
            'target' => '_self',
            'icon' => 'fa fa-tv',
            'is_active' => true,
            'sort_order' => 1,
            'settings' => ['plan_types' => ['iptv']]
        ]);

        MenuItem::create([
            'menu_id' => $subscriptionMenu->id,
            'title' => 'Adult IPTV',
            'route_name' => 'adult-channel',
            'target' => '_self',
            'icon' => 'fa fa-star',
            'is_active' => true,
            'sort_order' => 2,
            'settings' => ['plan_types' => ['adult']]
        ]);

        MenuItem::create([
            'menu_id' => $subscriptionMenu->id,
            'title' => 'Multi Connections',
            'route_name' => 'multi-connections',
            'target' => '_self',
            'icon' => 'fa fa-users',
            'is_active' => true,
            'sort_order' => 3,
            'settings' => ['plan_types' => ['multi']]
        ]);

        MenuItem::create([
            'menu_id' => $subscriptionMenu->id,
            'title' => 'Multi Connections Prices',
            'route_name' => 'multi-connections-prices',
            'target' => '_self',
            'icon' => 'fa fa-dollar',
            'is_active' => true,
            'sort_order' => 4,
            'settings' => ['plan_types' => ['multi']]
        ]);
    }
}
