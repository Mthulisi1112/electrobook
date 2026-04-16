<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    public function getProfilePhotoUrlAttribute()
    {
        // Check if profile_photo exists and is not null
        if (!empty($this->profile_photo)) {
            // Check if the file actually exists in storage
            if (Storage::disk('public')->exists($this->profile_photo)) {
                return Storage::url($this->profile_photo);
            }
        }
        
        // Fallback to UI Avatars if file doesn't exist
        $businessName = $this->business_name ?? 'Electrician';
        $initials = '';
        $nameParts = explode(' ', $businessName);
        foreach ($nameParts as $part) {
            if (!empty($part)) {
                $initials .= strtoupper(substr($part, 0, 1));
            }
        }
        
        if (empty($initials)) {
            $initials = strtoupper(substr($businessName, 0, 1));
        }
        
        return "https://ui-avatars.com/api/?background=009FD9&color=fff&bold=true&size=200&name=" . urlencode($initials);
    }
        
}
