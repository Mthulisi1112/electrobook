<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Electrician extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_name',
        'phone',
        'bio',
        'profile_photo',
        'license_number',
        'is_verified',
        'hourly_rate',
        'service_areas',
        'years_experience'
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'service_areas' => 'array', 
        'hourly_rate' => 'decimal:2'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function availabilitySlots()
    {
        return $this->hasMany(AvailabilitySlot::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'electrician_services')
                    ->withPivot('price', 'duration_minutes')
                    ->withTimestamps();
    }

    // Scopes
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeHasAvailability($query)
    {
        return $query->whereHas('availabilitySlots', function ($q) {
            $q->where('date', '>=', now())
              ->where('is_booked', false);
        });
    }

    // Accessors
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function getReviewCountAttribute()
    {
        return $this->reviews()->count();
    }

    public function getUpcomingBookingsAttribute()
    {
        return $this->bookings()
                    ->where('booking_date', '>=', now())
                    ->where('status', 'confirmed')
                    ->count();
    }

    public function scopeOwnedBy($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    
}
