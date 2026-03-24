<?php

if (!function_exists('format_currency')) {
    function format_currency($amount)
    {
        return '$' . number_format($amount, 2);
    }
}

if (!function_exists('get_status_badge_class')) {
    function get_status_badge_class($status)
    {
        return match($status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'confirmed' => 'bg-blue-100 text-blue-800',
            'completed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }
}

if (!function_exists('get_rating_stars')) {
    function get_rating_stars($rating)
    {
        $fullStars = floor($rating);
        $halfStar = $rating - $fullStars >= 0.5;
        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
        
        return [
            'full' => $fullStars,
            'half' => $halfStar,
            'empty' => $emptyStars
        ];
    }
}