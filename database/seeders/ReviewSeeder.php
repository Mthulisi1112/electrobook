<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all completed bookings that don't have reviews yet
        $completedBookings = Booking::where('status', 'completed')
            ->whereDoesntHave('review')
            ->get();

        $reviews = [
            [
                'min_rating' => 5,
                'max_rating' => 5,
                'comments' => [
                    'Excellent service! The electrician arrived on time, was very professional, and fixed the issue quickly. Highly recommend!',
                    'Amazing work! Very knowledgeable and explained everything clearly. Will definitely use again.',
                    'Top notch professional! Did a fantastic job with our panel upgrade. Very reasonable pricing too.',
                    'Could not be happier with the service. Professional, courteous, and got the job done right the first time.',
                    'Absolutely outstanding! Went above and beyond to ensure everything was working perfectly.',
                ]
            ],
            [
                'min_rating' => 4,
                'max_rating' => 4,
                'comments' => [
                    'Great service overall. A bit pricey but quality work. Would recommend.',
                    'Good electrician, did quality work. Communication could be a bit better but satisfied.',
                    'Very capable electrician. Took a bit longer than expected but the result was perfect.',
                    'Solid work. Professional and clean. Would hire again.',
                    'Good job, fair price. The electrician was friendly and explained everything.',
                ]
            ],
            [
                'min_rating' => 3,
                'max_rating' => 3,
                'comments' => [
                    'Decent service. Got the job done but there were some minor issues.',
                    'Average experience. Work was satisfactory but communication was lacking.',
                    'The work was okay, but I expected more attention to detail.',
                    'Fair service for the price. Would consider using again.',
                    'It was alright. The electrician was nice but the job took longer than expected.',
                ]
            ]
        ];

        $reviewCount = 0;
        
        foreach ($completedBookings as $booking) {
            // Only create reviews for some bookings (about 70% of completed bookings)
            if (rand(1, 100) > 70) {
                continue;
            }

            // Determine rating tier (70% 5-star, 20% 4-star, 10% 3-star)
            $ratingRand = rand(1, 100);
            
            if ($ratingRand <= 70) {
                $tier = 0; // 5-star tier
            } elseif ($ratingRand <= 90) {
                $tier = 1; // 4-star tier
            } else {
                $tier = 2; // 3-star tier
            }
            
            $rating = rand($reviews[$tier]['min_rating'], $reviews[$tier]['max_rating']);
            $comment = $reviews[$tier]['comments'][array_rand($reviews[$tier]['comments'])];
            
            // Create the review
            Review::firstOrCreate(
                [
                    'booking_id' => $booking->id,
                ],
                [
                    'client_id' => $booking->client_id,
                    'electrician_id' => $booking->electrician_id,
                    'rating' => $rating,
                    'comment' => $comment,
                    'created_at' => $booking->booking_date->addDays(rand(1, 14)),
                    'updated_at' => now(),
                ]
            );
            
            $reviewCount++;
            
            // Limit to avoid too many reviews
            if ($reviewCount >= 50) {
                break;
            }
        }
        
        // If we don't have enough reviews, create some additional ones from random completed bookings
        if ($reviewCount < 20) {
            $additionalBookings = Booking::where('status', 'completed')
                ->whereDoesntHave('review')
                ->inRandomOrder()
                ->limit(20 - $reviewCount)
                ->get();
                
            foreach ($additionalBookings as $booking) {
                $rating = rand(3, 5);
                $comments = [
                    5 => [
                        'Fantastic service! Very professional and efficient.',
                        'Best electrician I\'ve ever hired! Highly recommend.',
                        'Excellent work! Will definitely use again.',
                    ],
                    4 => [
                        'Great job! Very satisfied with the work.',
                        'Good service, fair price. Would recommend.',
                        'Professional and knowledgeable. Happy with the results.',
                    ],
                    3 => [
                        'Good work, but communication could be better.',
                        'Satisfied with the job. Would consider using again.',
                        'The work was done correctly. Average experience.',
                    ],
                ];
                
                $comment = $comments[$rating][array_rand($comments[$rating])];
                
                Review::firstOrCreate(
                    ['booking_id' => $booking->id],
                    [
                        'client_id' => $booking->client_id,
                        'electrician_id' => $booking->electrician_id,
                        'rating' => $rating,
                        'comment' => $comment,
                        'created_at' => $booking->booking_date->addDays(rand(1, 14)),
                        'updated_at' => now(),
                    ]
                );
            }
        }
        
        $this->command->info('Reviews seeded successfully!');
    }
}