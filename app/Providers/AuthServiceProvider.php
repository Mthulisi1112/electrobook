<?php

namespace App\Providers;

use App\Models\Booking;
use App\Models\Electrician;
use App\Models\Review;
use App\Models\Service;
use App\Models\AvailabilitySlot;
use App\Policies\BookingPolicy;
use App\Policies\ElectricianPolicy;
use App\Policies\ReviewPolicy;
use App\Policies\ServicePolicy;
use App\Policies\AvailabilitySlotPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Booking::class => BookingPolicy::class,
        Electrician::class => ElectricianPolicy::class,
        Service::class => ServicePolicy::class,
        Review::class => ReviewPolicy::class,
        AvailabilitySlot::class => AvailabilitySlotPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define gates for role checks
        Gate::define('isAdmin', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('isElectrician', function ($user) {
            return $user->role === 'electrician';
        });

        Gate::define('isClient', function ($user) {
            return $user->role === 'client';
        });

        // Optional: Define a gate for viewing reports
        Gate::define('viewReports', function ($user) {
            return $user->role === 'admin';
        });
    }
}