<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // client, electrician, admin
        'phone',
        'profile_photo_path',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relationships
     */

    public function electrician()
    {
        return $this->hasOne(Electrician::class);
    }

    public function clientBookings()
    {
        return $this->hasMany(Booking::class, 'client_id');
    }

    public function electricianBookings()
    {
        return $this->hasManyThrough(Booking::class, Electrician::class, 'user_id', 'electrician_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'client_id');
    }

      /**
     * Role check methods
     */

    public function isElectrician()
    {
        return $this->role === 'electrician' && $this->electrician !== null;
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    /**
 * Send the email verification notification.
 *
 * @return void
 */
    public function sendEmailVerificationNotification()
        {
            // This will use Laravel's built-in notification
            $this->notify(new \Illuminate\Auth\Notifications\VerifyEmail);
        }

    /**
     * Get the email address that should be used for verification.
     *
     * @return string
     */
    public function getEmailForVerification()
        {
            return $this->email;
        }

    /**
     * Determine if the user has verified their email address.
     *
     * @return bool
     */
    public function hasVerifiedEmail()
        {
            return !is_null($this->email_verified_at);
        }

    /**
     * Mark the given user's email as verified.
     *
     * @return bool
     */
    public function markEmailAsVerified()
        {
            return $this->forceFill([
                'email_verified_at' => $this->freshTimestamp(),
            ])->save();
        }
    public function getAvatarUrlAttribute()
    {
        // For electricians, prefer their professional photo
        if ($this->isElectrician() && $this->electrician && $this->electrician->profile_photo) {
            return Storage::url($this->electrician->profile_photo);
        }
        
        // For regular users or fallback
        if ($this->profile_photo_path && Storage::disk('public')->exists($this->profile_photo_path)) {
            return Storage::url($this->profile_photo_path);
        }
        
        // Default avatar
        return "https://ui-avatars.com/api/?background=2b6e9e&color=fff&name=" . urlencode($this->name);
    }

    
}