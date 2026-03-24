<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory, HasSlug;

    protected static function boot()
{
    parent::boot();
    
    static::creating(function ($service) {
        if (empty($service->slug)) {
            $service->slug = Str::slug($service->name);
        }
    });
}

    protected $fillable = [
        'name',
        'slug',
        'description',
        'base_price',
        'category',
        'icon',
        'estimated_duration_minutes',
        'is_active'
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'is_active' => 'boolean',
        'estimated_duration_minutes' => 'integer'
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function electricians()
    {
        return $this->belongsToMany(Electrician::class, 'electrician_services')
                    ->withPivot('price', 'duration_minutes')
                    ->withTimestamps();
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasManyThrough(Review::class, Booking::class);
    }

    /**
 * The categories that belong to the service.
 */
    public function categories()
    {
        return $this->belongsToMany(Category::class)
                    ->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}