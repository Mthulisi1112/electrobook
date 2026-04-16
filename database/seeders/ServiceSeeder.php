<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        // Get all categories for reference
        $categories = Category::all()->keyBy('name');
        
        if ($categories->isEmpty()) {
            $this->command->error('No categories found! Please run CategorySeeder first.');
            return;
        }
        
        // Define services with their categories and image paths
        $services = [
            // Emergency Services
            [
                'name' => 'Emergency Electrical Repair',
                'description' => '24/7 emergency service for electrical failures, outages, and hazards.',
                'base_price' => 150.00,
                'category_name' => 'Emergency Services',
                'icon' => 'fa-bolt',
                'estimated_duration_minutes' => 60,
                'is_active' => true,
                'is_popular' => true,
                'usage_count' => 345,
                'image' => 'images/services/emergency-repair2.jpg', 
            ],
            [
                'name' => 'Emergency Power Outage',
                'description' => 'Rapid response to power outages, including diagnosis and restoration.',
                'base_price' => 180.00,
                'category_name' => 'Emergency Services',
                'icon' => 'fa-exclamation-triangle',
                'estimated_duration_minutes' => 90,
                'is_active' => true,
                'is_popular' => true,
                'usage_count' => 278,
                'image' => 'images/services/panel-upgrade2.webp',
            ],
            
            // Installation Services
            [
                'name' => 'Wiring Installation',
                'description' => 'Complete wiring installation for new construction or renovation projects.',
                'base_price' => 200.00,
                'category_name' => 'Installation Services',
                'icon' => 'fa-plug',
                'estimated_duration_minutes' => 240,
                'is_active' => true,
                'is_popular' => true,
                'usage_count' => 156,
                'image' => 'images/services/lighting-installation1.jpg',
            ],
            [
                'name' => 'Lighting Installation',
                'description' => 'Installation of indoor and outdoor lighting fixtures.',
                'base_price' => 120.00,
                'category_name' => 'Installation Services',
                'icon' => 'fa-lightbulb',
                'estimated_duration_minutes' => 120,
                'is_active' => true,
                'is_popular' => true,
                'usage_count' => 234,
                'image' => 'images/services/lighting-installation2.webp',
            ],
            // ... rest of your services array
        ];

        // Create services and associate with categories
        foreach ($services as $serviceData) {
            $categoryName = $serviceData['category_name'];
            unset($serviceData['category_name']);
            
            $category = Category::where('name', $categoryName)->first();
            
            if ($category) {
                $serviceData['category_id'] = $category->id;
                $slug = Str::slug($serviceData['name']);
                
                // Use updateOrCreate to avoid duplicates
                Service::updateOrCreate(
                    ['slug' => $slug],
                    $serviceData
                );
            } else {
                $this->command->warn("Category '{$categoryName}' not found for service '{$serviceData['name']}'");
            }
        }

        $this->command->info('Services seeded successfully! Total: ' . Service::count());
    }
}