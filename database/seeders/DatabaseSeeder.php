<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Order matters due to foreign key constraints
        $this->call(CategorySeeder::class);      // 1. Categories first
        $this->call(ServiceSeeder::class);        // 2. Services depend on categories
        $this->call(UserSeeder::class);           // 3. Users (clients) 
        $this->call(ElectricianSeeder::class);    // 4. Electricians (creates their own users and profiles)
        $this->call(ReviewSeeder::class);         // 5. Reviews depend on bookings
        
        $this->command->info('All database seeders completed successfully!');
    }
}