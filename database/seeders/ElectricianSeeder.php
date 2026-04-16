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

class ElectricianSeeder extends Seeder
{
    public function run(): void
    {
        // Create electrician users (with their user account photos)
        $electrician1 = User::firstOrCreate(
            ['email' => 'john@electrobook.com'],
            [
                'name' => 'John Smith',
                'password' => Hash::make('password'),
                'role' => 'electrician',
                'email_verified_at' => now(),
                'profile_photo' => null, // User photo can be null or generic avatar
            ]
        );

        // Create electrician profile with professional photo
        $electrician1Profile = Electrician::firstOrCreate(
            ['user_id' => $electrician1->id],
            [
                'business_name' => 'Smith Electrical Services',
                'phone' => '555-0101',
                'bio' => 'Licensed master electrician with over 15 years of experience in residential and commercial electrical work.',
                'profile_photo' => 'images/electricians/john-smith.jpg', // Professional photo
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
                'profile_photo' => null,
            ]
        );

        $electrician2Profile = Electrician::firstOrCreate(
            ['user_id' => $electrician2->id],
            [
                'business_name' => 'Johnson Electric',
                'phone' => '555-0102',
                'bio' => 'Specializing in smart home installations and energy-efficient solutions. Certified and insured.',
                'profile_photo' => 'images/electricians/sarah-johnson.jpg', // Professional photo
                'license_number' => 'ELC-67890',
                'is_verified' => true,
                'hourly_rate' => 95.00,
                'service_areas' => json_encode(['Northside', 'Eastside']),
                'years_experience' => 8,
            ]
        );

        // Create more electricians with professional photos
        $moreElectricians = [
            [
                'email' => 'michael@electrobook.com',
                'name' => 'Michael Chen',
                'business_name' => 'Chen Electric',
                'bio' => 'Expert in solar panel installation and energy-efficient upgrades.',
                'profile_photo' => 'images/electricians/michael-chen.jpg',
                'hourly_rate' => 90.00,
                'years_experience' => 12,
            ],
            [
                'email' => 'jessica@electrobook.com',
                'name' => 'Jessica Martinez',
                'business_name' => 'Martinez Electrical Services',
                'bio' => 'Residential and commercial specialist. Fast, reliable, and affordable.',
                'profile_photo' => 'images/electricians/jessica-martinez.jpg',
                'hourly_rate' => 80.00,
                'years_experience' => 7,
            ],
            [
                'email' => 'david@electrobook.com',
                'name' => 'David Wilson',
                'business_name' => 'Wilson Electric Co',
                'bio' => '30+ years experience in industrial and commercial electrical systems.',
                'profile_photo' => 'images/electricians/david-wilson.jpg',
                'hourly_rate' => 110.00,
                'years_experience' => 30,
            ],
            [
                'email' => 'emily@electrobook.com',
                'name' => 'Emily Thompson',
                'business_name' => 'Thompson Electric',
                'bio' => 'Specializing in home automation, lighting design, and electrical safety inspections.',
                'profile_photo' => 'images/electricians/emily-thompson.jpg',
                'hourly_rate' => 88.00,
                'years_experience' => 10,
            ],
            [
                'email' => 'robert@electrobook.com',
                'name' => 'Robert Garcia',
                'business_name' => 'Garcia & Sons Electric',
                'bio' => 'Family-owned business serving the community for over 20 years.',
                'profile_photo' => 'images/electricians/robert-garcia.jpg',
                'hourly_rate' => 75.00,
                'years_experience' => 20,
            ],
            [
                'email' => 'lisa@electrobook.com',
                'name' => 'Lisa Anderson',
                'business_name' => 'Anderson Electrical Solutions',
                'bio' => 'Certified electrician specializing in sustainable energy solutions.',
                'profile_photo' => 'images/electricians/lisa-anderson.jpg',
                'hourly_rate' => 92.00,
                'years_experience' => 9,
            ],
        ];

        $createdElectricians = [];
        foreach ($moreElectricians as $data) {
            // Create user account (with no photo or generic photo)
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'role' => 'electrician',
                    'email_verified_at' => now(),
                    'profile_photo' => null, // User account photo (can be separate)
                ]
            );

            // Create electrician profile with professional photo
            $electrician = Electrician::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'business_name' => $data['business_name'],
                    'phone' => '555-' . rand(1000, 9999),
                    'bio' => $data['bio'],
                    'profile_photo' => $data['profile_photo'], // Professional electrician photo
                    'license_number' => 'ELC-' . rand(10000, 99999),
                    'is_verified' => true,
                    'hourly_rate' => $data['hourly_rate'],
                    'service_areas' => json_encode(['Downtown', 'Suburbs', 'Westside']),
                    'years_experience' => $data['years_experience'],
                ]
            );
            
            $createdElectricians[] = $electrician;
        }

        // Get all services
        $allServices = Service::all();
       
        // Combine all electricians
        $allElectricians = collect([$electrician1Profile, $electrician2Profile])->concat($createdElectricians);
        
        // Attach services to electricians
        foreach ($allElectricians as $electrician) {
            $randomServices = $allServices->random(min(rand(3, 5), $allServices->count()));
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

        // Get clients from UserSeeder
        $clients = User::where('role', 'client')->get();
        $mainClient = User::where('email', 'client@example.com')->first();
        
        // Create sample bookings
        $this->createSampleBookings($allElectricians, $clients, $mainClient, $allServices, $allSlots);
        
        $this->command->info('Electricians, and bookings seeded successfully!');
        $this->command->info('Total electricians: ' . $allElectricians->count());
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
                $allClients = array_merge([$mainClient], $clients->toArray());
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
                        'client_id' => $bookingClient['id'] ?? $bookingClient->id,
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
        
        $this->command->info('Bookings created successfully!');
    }
}