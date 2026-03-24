<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Electrician;
use App\Models\Service;
use App\Models\Booking;
use App\Models\AvailabilitySlot;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@electrobook.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
                'profile_photo_path' => $this->getAvatarUrl('Admin User', 'admin'),
            ]
        );

        // Create sample electricians with avatars
        $electrician1 = User::firstOrCreate(
            ['email' => 'john@electrobook.com'],
            [
                'name' => 'John Smith',
                'password' => Hash::make('password'),
                'role' => 'electrician',
                'email_verified_at' => now(),
                'profile_photo_path' => $this->getAvatarUrl('John Smith', 'electrician'),
            ]
        );

        $electrician1Profile = Electrician::firstOrCreate(
            ['user_id' => $electrician1->id],
            [
                'business_name' => 'Smith Electrical Services',
                'phone' => '555-0101',
                'bio' => 'Licensed master electrician with over 15 years of experience in residential and commercial electrical work.',
                'license_number' => 'ELC-12345',
                'is_verified' => true,
                'hourly_rate' => 85.00,
                'service_areas' => json_encode(['Downtown', 'Suburbs']),
                'years_experience' => 15,
            ]
        );

        $electrician2 = User::firstOrCreate(
            ['email' => 'sarah@electrobook.com'],
            [
                'name' => 'Sarah Johnson',
                'password' => Hash::make('password'),
                'role' => 'electrician',
                'email_verified_at' => now(),
                'profile_photo_path' => $this->getAvatarUrl('Sarah Johnson', 'electrician', 'female'),
            ]
        );

        $electrician2Profile = Electrician::firstOrCreate(
            ['user_id' => $electrician2->id],
            [
                'business_name' => 'Johnson Electric',
                'phone' => '555-0102',
                'bio' => 'Specializing in smart home installations and energy-efficient solutions. Certified and insured.',
                'license_number' => 'ELC-67890',
                'is_verified' => true,
                'hourly_rate' => 95.00,
                'service_areas' => json_encode(['Northside', 'Eastside']),
                'years_experience' => 8,
            ]
        );

        // Create more electricians
        $moreElectricians = [
            [
                'email' => 'michael@electrobook.com',
                'name' => 'Michael Chen',
                'business_name' => 'Chen Electric',
                'bio' => 'Expert in solar panel installation and energy-efficient upgrades.',
                'hourly_rate' => 90.00,
                'years_experience' => 12,
                'gender' => 'male',
            ],
            [
                'email' => 'jessica@electrobook.com',
                'name' => 'Jessica Martinez',
                'business_name' => 'Martinez Electrical Services',
                'bio' => 'Residential and commercial specialist. Fast, reliable, and affordable.',
                'hourly_rate' => 80.00,
                'years_experience' => 7,
                'gender' => 'female',
            ],
            [
                'email' => 'david@electrobook.com',
                'name' => 'David Wilson',
                'business_name' => 'Wilson Electric Co',
                'bio' => '30+ years experience in industrial and commercial electrical systems.',
                'hourly_rate' => 110.00,
                'years_experience' => 30,
                'gender' => 'male',
            ],
            [
                'email' => 'emily@electrobook.com',
                'name' => 'Emily Thompson',
                'business_name' => 'Thompson Electric',
                'bio' => 'Specializing in home automation, lighting design, and electrical safety inspections.',
                'hourly_rate' => 88.00,
                'years_experience' => 10,
                'gender' => 'female',
            ],
            [
                'email' => 'robert@electrobook.com',
                'name' => 'Robert Garcia',
                'business_name' => 'Garcia & Sons Electric',
                'bio' => 'Family-owned business serving the community for over 20 years.',
                'hourly_rate' => 75.00,
                'years_experience' => 20,
                'gender' => 'male',
            ],
            [
                'email' => 'lisa@electrobook.com',
                'name' => 'Lisa Anderson',
                'business_name' => 'Anderson Electrical Solutions',
                'bio' => 'Certified electrician specializing in sustainable energy solutions.',
                'hourly_rate' => 92.00,
                'years_experience' => 9,
                'gender' => 'female',
            ],
        ];

        $createdElectricians = [];
        foreach ($moreElectricians as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'role' => 'electrician',
                    'email_verified_at' => now(),
                    'profile_photo_path' => $this->getAvatarUrl($data['name'], 'electrician', $data['gender']),
                ]
            );

            $electrician = Electrician::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'business_name' => $data['business_name'],
                    'phone' => '555-' . rand(1000, 9999),
                    'bio' => $data['bio'],
                    'license_number' => 'ELC-' . rand(10000, 99999),
                    'is_verified' => true,
                    'hourly_rate' => $data['hourly_rate'],
                    'service_areas' => json_encode(['Downtown', 'Suburbs', 'Westside']),
                    'years_experience' => $data['years_experience'],
                ]
            );
            
            $createdElectricians[] = $electrician;
        }

        // Create sample client
        $client = User::firstOrCreate(
            ['email' => 'client@example.com'],
            [
                'name' => 'Client User',
                'password' => Hash::make('password'),
                'role' => 'client',
                'email_verified_at' => now(),
                'profile_photo_path' => $this->getAvatarUrl('Client User', 'client'),
            ]
        );

        // Create additional clients
        $clientNames = [
            ['email' => 'alice.johnson@example.com', 'name' => 'Alice Johnson', 'gender' => 'female'],
            ['email' => 'bob.williams@example.com', 'name' => 'Bob Williams', 'gender' => 'male'],
            ['email' => 'carol.davis@example.com', 'name' => 'Carol Davis', 'gender' => 'female'],
            ['email' => 'david.brown@example.com', 'name' => 'David Brown', 'gender' => 'male'],
            ['email' => 'emma.wilson@example.com', 'name' => 'Emma Wilson', 'gender' => 'female'],
            ['email' => 'frank.miller@example.com', 'name' => 'Frank Miller', 'gender' => 'male'],
            ['email' => 'grace.taylor@example.com', 'name' => 'Grace Taylor', 'gender' => 'female'],
            ['email' => 'henry.anderson@example.com', 'name' => 'Henry Anderson', 'gender' => 'male']
        ];
        
        $clients = [];
        foreach ($clientNames as $clientData) {
            $clients[] = User::firstOrCreate(
                ['email' => $clientData['email']],
                [
                    'name' => $clientData['name'],
                    'password' => Hash::make('password'),
                    'role' => 'client',
                    'email_verified_at' => now(),
                    'profile_photo_path' => $this->getAvatarUrl($clientData['name'], 'client', $clientData['gender']),
                ]
            );
        }

        // Create services
        $services = [
            [
                'name' => 'Emergency Electrical Repair',
                'slug' => 'emergency-electrical-repair',
                'description' => '24/7 emergency service for electrical failures, outages, and hazards.',
                'base_price' => 150.00,
                'category' => 'Emergency',
                'icon' => 'fa-bolt',
                'estimated_duration_minutes' => 60,
            ],
            [
                'name' => 'Wiring Installation',
                'slug' => 'wiring-installation',
                'description' => 'Complete wiring installation for new construction or renovation projects.',
                'base_price' => 200.00,
                'category' => 'Installation',
                'icon' => 'fa-plug',
                'estimated_duration_minutes' => 240,
            ],
            [
                'name' => 'Lighting Installation',
                'slug' => 'lighting-installation',
                'description' => 'Installation of indoor and outdoor lighting fixtures, including smart lighting.',
                'base_price' => 120.00,
                'category' => 'Installation',
                'icon' => 'fa-lightbulb',
                'estimated_duration_minutes' => 120,
            ],
            [
                'name' => 'Panel Upgrade',
                'slug' => 'panel-upgrade',
                'description' => 'Electrical panel upgrades for increased capacity and safety.',
                'base_price' => 500.00,
                'category' => 'Upgrade',
                'icon' => 'fa-microchip',
                'estimated_duration_minutes' => 360,
            ],
            [
                'name' => 'Outlet & Switch Repair',
                'slug' => 'outlet-switch-repair',
                'description' => 'Repair or replacement of faulty outlets, switches, and receptacles.',
                'base_price' => 80.00,
                'category' => 'Repair',
                'icon' => 'fa-plug',
                'estimated_duration_minutes' => 45,
            ],
            [
                'name' => 'Home Safety Inspection',
                'slug' => 'home-safety-inspection',
                'description' => 'Comprehensive electrical safety inspection for your home.',
                'base_price' => 175.00,
                'category' => 'Inspection',
                'icon' => 'fa-shield-hal',
                'estimated_duration_minutes' => 120,
            ],
        ];

        $createdServices = [];
        foreach ($services as $serviceData) {
            $createdServices[] = Service::firstOrCreate(
                ['slug' => $serviceData['slug']],
                $serviceData
            );
        }

        // Combine all electricians
        $allElectricians = collect([$electrician1Profile, $electrician2Profile])->concat($createdElectricians);
        
        // Attach services to electricians
        $allServices = Service::all();
        
        foreach ($allElectricians as $electrician) {
            $randomServices = $allServices->random(rand(3, 5));
            foreach ($randomServices as $service) {
                if (!$electrician->services()->where('service_id', $service->id)->exists()) {
                    $electrician->services()->attach($service->id, [
                        'price' => $service->base_price * (rand(90, 110) / 100),
                        'duration_minutes' => $service->estimated_duration_minutes
                    ]);
                }
            }
        }

        // Create availability slots
        $allSlots = [];
        foreach ($allElectricians as $electrician) {
            for ($i = 1; $i <= 14; $i++) {
                $date = now()->addDays($i);
                
                if ($date->isWeekend()) {
                    continue;
                }
                
                $slot1 = AvailabilitySlot::firstOrCreate(
                    [
                        'electrician_id' => $electrician->id,
                        'date' => $date->format('Y-m-d'),
                        'start_time' => '09:00:00',
                    ],
                    [
                        'end_time' => '12:00:00',
                        'is_booked' => false,
                    ]
                );
                $allSlots[] = $slot1;
                
                $slot2 = AvailabilitySlot::firstOrCreate(
                    [
                        'electrician_id' => $electrician->id,
                        'date' => $date->format('Y-m-d'),
                        'start_time' => '13:00:00',
                    ],
                    [
                        'end_time' => '17:00:00',
                        'is_booked' => false,
                    ]
                );
                $allSlots[] = $slot2;
            }
        }

        // Create sample bookings
        $this->createSampleBookings($allElectricians, $clients, $client, $allServices, $allSlots);
        
        // ✅ ADD THIS LINE: Create sample reviews
        $this->call(ReviewSeeder::class);
        
        $this->command->info('Database seeding completed successfully!');
    }

    /**
     * Generate UI Avatar URL
     */
    private function getAvatarUrl($name, $role = 'client', $gender = null)
    {
        // Extract initials from name
        $initials = '';
        $nameParts = explode(' ', $name);
        foreach ($nameParts as $part) {
            if (!empty($part)) {
                $initials .= strtoupper(substr($part, 0, 1));
            }
        }
        
        // Use UI Avatars service with different background colors based on role
        $colors = [
            'electrician' => '1e3a5f', // Dark blue
            'client' => '2b6e9e',      // Medium blue
            'admin' => 'dc2626',        // Red
        ];
        
        $bgColor = $colors[$role] ?? '1e3a5f';
        
        // Generate avatar URL with customizations
        return "https://ui-avatars.com/api/?background={$bgColor}&color=fff&bold=true&size=128&name=" . urlencode($initials);
    }

    /**
     * Create sample bookings for testing
     */
    private function createSampleBookings($electricians, $clients, $mainClient, $services, $slots)
    {
        $addresses = [
            '123 Main St', '456 Oak Ave', '789 Pine Rd', '321 Elm St', 
            '654 Maple Dr', '987 Cedar Ln', '147 Birch Blvd', '258 Spruce Way'
        ];
        $cities = ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix'];
        $postalCodes = ['10001', '90001', '60601', '77001', '85001'];

        foreach ($electricians as $electrician) {
            $electricianServices = $electrician->services()->get();
            
            if ($electricianServices->isEmpty()) {
                continue;
            }

            $numBookings = rand(15, 25);
            
            for ($i = 0; $i < $numBookings; $i++) {
                $dateOffset = rand(-180, 30);
                $bookingDate = Carbon::now()->addDays($dateOffset);
                $service = $electricianServices->random();
                $allClients = array_merge([$mainClient], $clients);
                $bookingClient = $allClients[array_rand($allClients)];
                
                if ($bookingDate->isPast()) {
                    $status = rand(0, 10) < 8 ? 'completed' : 'cancelled';
                    $paymentStatus = $status === 'completed' ? 'paid' : 'pending';
                } else {
                    $status = rand(0, 10) < 6 ? 'confirmed' : 'pending';
                    $paymentStatus = 'pending';
                }

                $startHour = rand(9, 16);
                $startTime = sprintf('%02d:00:00', $startHour);
                $endTime = sprintf('%02d:00:00', $startHour + 1);
                
                $amount = $service->pivot->price ?? $service->base_price;
                $uniqueId = uniqid();
                $bookingNumber = 'BK-' . strtoupper(substr($uniqueId, -8));
                $bookingReference = 'REF-' . strtoupper($uniqueId) . '-' . rand(1000, 9999);

                Booking::firstOrCreate(
                    ['booking_reference' => $bookingReference],
                    [
                        'booking_number' => $bookingNumber,
                        'client_id' => $bookingClient->id,
                        'electrician_id' => $electrician->id,
                        'service_id' => $service->id,
                        'availability_slot_id' => $slots[array_rand($slots)]->id,
                        'booking_date' => $bookingDate->format('Y-m-d'),
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                        'status' => $status,
                        'description' => 'Booking for ' . $service->name,
                        'address' => $addresses[array_rand($addresses)],
                        'city' => $cities[array_rand($cities)],
                        'postal_code' => $postalCodes[array_rand($postalCodes)],
                        'total_amount' => $amount,
                        'payment_status' => $paymentStatus,
                        'payment_method' => $paymentStatus === 'paid' ? 'credit_card' : null,
                        'cancellation_reason' => $status === 'cancelled' ? 'Customer cancelled' : null,
                        'cancelled_at' => $status === 'cancelled' ? now() : null,
                        'created_at' => $bookingDate->copy()->subDays(rand(1, 10)),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}