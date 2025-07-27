<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
                'buy_link' => '#'
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
                'buy_link' => '#'
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
                'buy_link' => '#'
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
                'buy_link' => '#'
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
                'buy_link' => '#'
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
                'buy_link' => '#'
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
                'buy_link' => '#'
            ]
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::create($plan);
        }
    }
}
