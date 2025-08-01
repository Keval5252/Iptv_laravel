<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(defaultAdmin::class);
        $this->call(PermissionSeeder::class);
        $this->call(SubscriptionPlanSeeder::class);
        $this->call(MenuSeeder::class);
    }
}
