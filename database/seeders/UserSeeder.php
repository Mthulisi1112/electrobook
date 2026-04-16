<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@electrobook.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
                'profile_photo_path' => 'images/admins/admin.jpg',
            ]
        );

        // Create client users with local photo paths
        $clients = [
            ['email' => 'client@example.com', 'name' => 'Client User', 'photo' => 'client-user.jpg'],
            ['email' => 'alice.johnson@example.com', 'name' => 'Alice Johnson', 'photo' => 'alice-johnson.jpg'],
            ['email' => 'bob.williams@example.com', 'name' => 'Bob Williams', 'photo' => 'bob-williams.jpg'],
            ['email' => 'carol.davis@example.com', 'name' => 'Carol Davis', 'photo' => 'carol-davis.jpg'],
            ['email' => 'david.brown@example.com', 'name' => 'David Brown', 'photo' => 'david-brown.jpg'],
            ['email' => 'emma.wilson@example.com', 'name' => 'Emma Wilson', 'photo' => 'emma-wilson.jpg'],
            ['email' => 'frank.miller@example.com', 'name' => 'Frank Miller', 'photo' => 'frank-miller.jpg'],
            ['email' => 'grace.taylor@example.com', 'name' => 'Grace Taylor', 'photo' => 'grace-taylor.jpg'],
            ['email' => 'henry.anderson@example.com', 'name' => 'Henry Anderson', 'photo' => 'henry-anderson.jpg'],
        ];

        foreach ($clients as $clientData) {
            User::updateOrCreate(
                ['email' => $clientData['email']],
                [
                    'name' => $clientData['name'],
                    'password' => Hash::make('password'),
                    'role' => 'client',
                    'email_verified_at' => now(),
                    'profile_photo_path' => "images/clients/{$clientData['photo']}",
                ]
            );
        }

        $this->command->info('Users seeded successfully! Total users: ' . User::count());
    }
}