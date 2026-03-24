<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailabilitySlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'electrician_id',
        'date',
        'start_time',
        'end_time',
        'is_booked',
        'is_recurring',
        'recurring_pattern'
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
        'is_booked' => 'boolean',
        'is_recurring' => 'boolean'
    ];

    // Accessor for formatted start time
    public function getFormattedStartTimeAttribute()
    {
        return $this->start_time->format('g:i A');
    }

    // Accessor for formatted end time
    public function getFormattedEndTimeAttribute()
    {
        return $this->end_time->format('g:i A');
    }

    // Accessor for formatted time range
    public function getFormattedTimeRangeAttribute()
    {
        return $this->formatted_start_time . ' - ' . $this->formatted_end_time;
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('is_booked', false);
    }

    public function scopeForDate($query, $date)
    {
        return $query->whereDate('date', $date);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('date', '>=', now()->toDateString());
    }
}