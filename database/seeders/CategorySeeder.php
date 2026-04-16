<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks for SQLite
        if (\DB::connection()->getDriverName() === 'sqlite') {
            \DB::statement('PRAGMA foreign_keys=OFF;');
        }
        
        try {
            // First, delete all services that depend on categories
            Service::query()->delete();
            
            // Clear existing categories
            Category::truncate();
            
            // Create main parent categories
            $mainCategories = [
                [
                    'name' => 'Emergency Services',
                    'type' => 'service',
                    'description' => '24/7 emergency electrical services for urgent situations',
                    'icon' => 'fa-bolt',
                    'order' => 1,
                    'is_active' => true,
                ],
                [
                    'name' => 'Installation Services',
                    'type' => 'service',
                    'description' => 'Professional installation of electrical systems and components',
                    'icon' => 'fa-tools',
                    'order' => 2,
                    'is_active' => true,
                ],
                [
                    'name' => 'Repair Services',
                    'type' => 'service',
                    'description' => 'Expert repair and maintenance of electrical systems',
                    'icon' => 'fa-wrench',
                    'order' => 3,
                    'is_active' => true,
                ],
                [
                    'name' => 'Inspection Services',
                    'type' => 'service',
                    'description' => 'Comprehensive electrical safety inspections and audits',
                    'icon' => 'fa-clipboard-list',
                    'order' => 4,
                    'is_active' => true,
                ],
                [
                    'name' => 'Upgrade Services',
                    'type' => 'service',
                    'description' => 'Upgrade your electrical systems for better performance and safety',
                    'icon' => 'fa-chart-line',
                    'order' => 5,
                    'is_active' => true,
                ],
                [
                    'name' => 'Smart Home Solutions',
                    'type' => 'service',
                    'description' => 'Smart home automation and integration services',
                    'icon' => 'fa-microchip',
                    'order' => 6,
                    'is_active' => true,
                ],
            ];

            $createdCategories = [];
            
            foreach ($mainCategories as $categoryData) {
                $category = Category::create($categoryData);
                $createdCategories[$categoryData['name']] = $category;
            }

            // Create subcategories under Installation Services
            if (isset($createdCategories['Installation Services'])) {
                $installationSubcategories = [
                    [
                        'name' => 'Wiring Installation',
                        'parent_id' => $createdCategories['Installation Services']->id,
                        'type' => 'service',
                        'description' => 'Complete wiring installation for residential and commercial properties',
                        'icon' => 'fa-plug',
                        'order' => 1,
                        'is_active' => true,
                    ],
                    [
                        'name' => 'Lighting Installation',
                        'parent_id' => $createdCategories['Installation Services']->id,
                        'type' => 'service',
                        'description' => 'Indoor and outdoor lighting fixture installation',
                        'icon' => 'fa-lightbulb',
                        'order' => 2,
                        'is_active' => true,
                    ],
                    [
                        'name' => 'Ceiling Fan Installation',
                        'parent_id' => $createdCategories['Installation Services']->id,
                        'type' => 'service',
                        'description' => 'Professional ceiling fan installation and balancing',
                        'icon' => 'fa-fan',
                        'order' => 3,
                        'is_active' => true,
                    ],
                    [
                        'name' => 'Appliance Installation',
                        'parent_id' => $createdCategories['Installation Services']->id,
                        'type' => 'service',
                        'description' => 'Installation of major electrical appliances',
                        'icon' => 'fa-oven',
                        'order' => 4,
                        'is_active' => true,
                    ],
                ];

                foreach ($installationSubcategories as $subcategory) {
                    Category::create($subcategory);
                }
            }

            // Create subcategories under Repair Services
            if (isset($createdCategories['Repair Services'])) {
                $repairSubcategories = [
                    [
                        'name' => 'Outlet & Switch Repair',
                        'parent_id' => $createdCategories['Repair Services']->id,
                        'type' => 'service',
                        'description' => 'Repair or replacement of faulty outlets and switches',
                        'icon' => 'fa-plug',
                        'order' => 1,
                        'is_active' => true,
                    ],
                    [
                        'name' => 'Circuit Breaker Repair',
                        'parent_id' => $createdCategories['Repair Services']->id,
                        'type' => 'service',
                        'description' => 'Diagnose and repair circuit breaker issues',
                        'icon' => 'fa-shield-alt',
                        'order' => 2,
                        'is_active' => true,
                    ],
                    [
                        'name' => 'Electrical Panel Repair',
                        'parent_id' => $createdCategories['Repair Services']->id,
                        'type' => 'service',
                        'description' => 'Repair and maintenance of electrical panels',
                        'icon' => 'fa-microchip',
                        'order' => 3,
                        'is_active' => true,
                    ],
                    [
                        'name' => 'Light Fixture Repair',
                        'parent_id' => $createdCategories['Repair Services']->id,
                        'type' => 'service',
                        'description' => 'Repair of malfunctioning light fixtures',
                        'icon' => 'fa-lightbulb',
                        'order' => 4,
                        'is_active' => true,
                    ],
                ];

                foreach ($repairSubcategories as $subcategory) {
                    Category::create($subcategory);
                }
            }

            // Create subcategories under Inspection Services
            if (isset($createdCategories['Inspection Services'])) {
                $inspectionSubcategories = [
                    [
                        'name' => 'Home Safety Inspection',
                        'parent_id' => $createdCategories['Inspection Services']->id,
                        'type' => 'service',
                        'description' => 'Comprehensive electrical safety inspection for homes',
                        'icon' => 'fa-home',
                        'order' => 1,
                        'is_active' => true,
                    ],
                    [
                        'name' => 'Commercial Inspection',
                        'parent_id' => $createdCategories['Inspection Services']->id,
                        'type' => 'service',
                        'description' => 'Electrical inspection for commercial properties',
                        'icon' => 'fa-building',
                        'order' => 2,
                        'is_active' => true,
                    ],
                    [
                        'name' => 'Code Compliance Check',
                        'parent_id' => $createdCategories['Inspection Services']->id,
                        'type' => 'service',
                        'description' => 'Verify compliance with electrical codes and regulations',
                        'icon' => 'fa-check-circle',
                        'order' => 3,
                        'is_active' => true,
                    ],
                    [
                        'name' => 'Thermal Imaging Inspection',
                        'parent_id' => $createdCategories['Inspection Services']->id,
                        'type' => 'service',
                        'description' => 'Infrared thermal imaging to detect electrical issues',
                        'icon' => 'fa-thermometer',
                        'order' => 4,
                        'is_active' => true,
                    ],
                ];

                foreach ($inspectionSubcategories as $subcategory) {
                    Category::create($subcategory);
                }
            }

            // Create subcategories under Upgrade Services
            if (isset($createdCategories['Upgrade Services'])) {
                $upgradeSubcategories = [
                    [
                        'name' => 'Panel Upgrade',
                        'parent_id' => $createdCategories['Upgrade Services']->id,
                        'type' => 'service',
                        'description' => 'Upgrade electrical panel for increased capacity',
                        'icon' => 'fa-microchip',
                        'order' => 1,
                        'is_active' => true,
                    ],
                    [
                        'name' => 'Wiring Upgrade',
                        'parent_id' => $createdCategories['Upgrade Services']->id,
                        'type' => 'service',
                        'description' => 'Upgrade outdated wiring for safety and efficiency',
                        'icon' => 'fa-code-branch',
                        'order' => 2,
                        'is_active' => true,
                    ],
                    [
                        'name' => 'Energy Efficiency Upgrade',
                        'parent_id' => $createdCategories['Upgrade Services']->id,
                        'type' => 'service',
                        'description' => 'Upgrade to energy-efficient electrical systems',
                        'icon' => 'fa-leaf',
                        'order' => 3,
                        'is_active' => true,
                    ],
                    [
                        'name' => 'Surge Protection Installation',
                        'parent_id' => $createdCategories['Upgrade Services']->id,
                        'type' => 'service',
                        'description' => 'Whole-home surge protection systems',
                        'icon' => 'fa-bolt',
                        'order' => 4,
                        'is_active' => true,
                    ],
                ];

                foreach ($upgradeSubcategories as $subcategory) {
                    Category::create($subcategory);
                }
            }

            // Create subcategories under Smart Home Solutions
            if (isset($createdCategories['Smart Home Solutions'])) {
                $smartHomeSubcategories = [
                    [
                        'name' => 'Smart Lighting Installation',
                        'parent_id' => $createdCategories['Smart Home Solutions']->id,
                        'type' => 'service',
                        'description' => 'Install smart lighting systems and controls',
                        'icon' => 'fa-lightbulb',
                        'order' => 1,
                        'is_active' => true,
                    ],
                    [
                        'name' => 'Home Automation Setup',
                        'parent_id' => $createdCategories['Smart Home Solutions']->id,
                        'type' => 'service',
                        'description' => 'Complete home automation system installation',
                        'icon' => 'fa-home',
                        'order' => 2,
                        'is_active' => true,
                    ],
                    [
                        'name' => 'Smart Thermostat Installation',
                        'parent_id' => $createdCategories['Smart Home Solutions']->id,
                        'type' => 'service',
                        'description' => 'Install and configure smart thermostats',
                        'icon' => 'fa-temperature-low',
                        'order' => 3,
                        'is_active' => true,
                    ],
                    [
                        'name' => 'Security System Installation',
                        'parent_id' => $createdCategories['Smart Home Solutions']->id,
                        'type' => 'service',
                        'description' => 'Install electrical security systems and cameras',
                        'icon' => 'fa-shield-alt',
                        'order' => 4,
                        'is_active' => true,
                    ],
                ];

                foreach ($smartHomeSubcategories as $subcategory) {
                    Category::create($subcategory);
                }
            }
            
            $this->command->info('Categories seeded successfully! Total: ' . Category::count());
            
        } catch (\Exception $e) {
            $this->command->error('Error seeding categories: ' . $e->getMessage());
            throw $e;
        } finally {
            // Re-enable foreign key checks
            if (\DB::connection()->getDriverName() === 'sqlite') {
                \DB::statement('PRAGMA foreign_keys=ON;');
            }
        }
    }
}