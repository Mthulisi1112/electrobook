<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_number',
        'client_id',
        'electrician_id',
        'service_id',
        'availability_slot_id',
        'booking_date',
        'start_time',
        'end_time',
        'status',
        'description',
        'address',
        'city',
        'postal_code',
        'total_amount',
        'payment_status',
        'cancellation_reason',
        'cancelled_at',
        'booking_reference',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'total_amount' => 'decimal:2',
        'cancelled_at' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            $booking->booking_number = 'BK-' . strtoupper(uniqid());
        });
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function electrician()
    {
        return $this->belongsTo(Electrician::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function availabilitySlot()
    {
        return $this->belongsTo(AvailabilitySlot::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('booking_date', '>=', now())
                     ->whereIn('status', ['pending', 'confirmed']);
    }

    // Methods
    public function canBeCancelled()
    {
        // Check if booking is in pending or confirmed status
        if (!in_array($this->status, ['pending', 'confirmed'])) {
            return false;
        }
        
        // Parse the date to ensure it's a Carbon instance
        $bookingDate = $this->booking_date instanceof Carbon 
            ? $this->booking_date 
            : Carbon::parse($this->booking_date);
        
        // Check if booking date is in the future
        return $bookingDate->isFuture();
    }
}