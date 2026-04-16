<?php

use Illuminate\Support\Facades\Route;

// Public Controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReviewController;

// Public Namespace Controllers
use App\Http\Controllers\Public\ElectricianController as PublicElectricianController;
use App\Http\Controllers\Public\ServiceController as PublicServiceController;
use App\Http\Controllers\Public\SearchController; // Add this import

// Authenticated Electrician Controllers
use App\Http\Controllers\Electrician\AvailabilityController;
use App\Http\Controllers\Electrician\DashboardController as ElectricianDashboardController;
use App\Http\Controllers\Electrician\ProfileController as ElectricianProfileController;
use App\Http\Controllers\Electrician\BookingController as ElectricianBookingController;

// Admin Controllers
use App\Http\Controllers\Admin\ElectricianController as AdminElectricianController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ReportController;

// Contact Controllers
use App\Http\Controllers\ContactController;


/*
|--------------------------------------------------------------------------
| Home Route
|--------------------------------------------------------------------------
*/
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Contact Route
|--------------------------------------------------------------------------
*/

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');


/*
|--------------------------------------------------------------------------
| Public Routes (Guest Access)
|--------------------------------------------------------------------------
*/
Route::resource('electricians', PublicElectricianController::class)
    ->only(['index', 'show'])
    ->names('electricians');

Route::resource('services', PublicServiceController::class)
    ->only(['index', 'show'])
    ->names('services');

// Search Route with service filtering
Route::get('/search/{service?}', [SearchController::class, 'search'])->name('search');

// Reviews
Route::get('/reviews', [App\Http\Controllers\Public\ReviewController::class, 'index'])->name('reviews.index');
Route::get('/reviews/{review}', [App\Http\Controllers\Public\ReviewController::class, 'show'])->name('reviews.show');

// Category Routes 
Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('/', [App\Http\Controllers\Public\CategoryController::class, 'index'])->name('index');
    Route::get('/{category:slug}', [App\Http\Controllers\Public\CategoryController::class, 'show'])->name('show');
    Route::get('/{category}/subcategories', [App\Http\Controllers\Public\CategoryController::class, 'subcategories'])->name('subcategories');
});


Route::prefix('s')->name('service.')->group(function () {
    // This will handle /s/electrical/electricians
    Route::get('/{service:slug}/electricians', [App\Http\Controllers\Public\ServiceElectricianController::class, 'index'])->name('electricians');
});
/*
|--------------------------------------------------------------------------
| Authenticated Routes (All logged-in users)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Main Dashboard (redirects based on role)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User Profile (for all authenticated users)
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
        Route::post('/photo', [ProfileController::class, 'updatePhoto'])->name('photo.update');
        Route::delete('/photo', [ProfileController::class, 'deletePhoto'])->name('photo.delete');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    });

    // Client Bookings (for clients)
    Route::resource('bookings', BookingController::class)->except(['edit', 'update']);
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::get('/bookings/{booking}/success', [BookingController::class, 'success'])->name('bookings.success');    
    // Reviews (for clients)
    Route::post('/bookings/{booking}/review', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    /*
    |--------------------------------------------------------------------------
    | Electrician Only Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('can:isElectrician')
        ->prefix('electrician')
        ->name('electrician.')
        ->group(function () {

            // Electrician Dashboard
            Route::get('/dashboard', [ElectricianDashboardController::class, 'index'])->name('dashboard');

            // Availability Management
            Route::resource('availability', AvailabilityController::class)->except(['show']);
            Route::post('/availability/bulk', [AvailabilityController::class, 'bulkStore'])->name('availability.bulk');
            Route::get('/availability/calendar', [AvailabilityController::class, 'calendar'])->name('availability.calendar');

            // Booking Management
            Route::get('/bookings', [ElectricianBookingController::class, 'index'])->name('bookings.index');
            Route::get('/bookings/{booking}', [ElectricianBookingController::class, 'show'])->name('bookings.show');
            Route::post('/bookings/{booking}/confirm', [ElectricianBookingController::class, 'confirm'])->name('bookings.confirm');
            Route::post('/bookings/{booking}/complete', [ElectricianBookingController::class, 'complete'])->name('bookings.complete');
            Route::post('/bookings/{booking}/cancel', [ElectricianBookingController::class, 'cancel'])->name('bookings.cancel');

            // Business Profile
            Route::get('/profile/edit', [ElectricianProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ElectricianProfileController::class, 'update'])->name('profile.update');
            Route::get('/services', [ElectricianProfileController::class, 'services'])->name('services');
            Route::post('/services/{service}/toggle', [ElectricianProfileController::class, 'toggleService'])->name('services.toggle');

            // Earnings & Reports
            Route::get('/earnings', [ElectricianDashboardController::class, 'earnings'])->name('earnings');
            Route::get('/reviews', [ElectricianDashboardController::class, 'reviews'])->name('reviews');
        });

    /*
    |--------------------------------------------------------------------------
    | Admin Only Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('can:isAdmin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            // Admin Dashboard
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

            // Electrician Management
            Route::resource('electricians', AdminElectricianController::class);
            Route::post('/electricians/{electrician}/verify', [AdminElectricianController::class, 'verify'])->name('electricians.verify');
            Route::post('/electricians/{electrician}/suspend', [AdminElectricianController::class, 'suspend'])->name('electricians.suspend');
            Route::post('/electricians/{electrician}/reinstate', [AdminElectricianController::class, 'reinstate'])->name('electricians.reinstate');
            Route::get('/electricians/verification-requests', [AdminElectricianController::class, 'verificationRequests'])->name('electricians.verification-requests');
            Route::post('/electricians/bulk-verify', [AdminElectricianController::class, 'bulkVerify'])->name('electricians.bulk-verify');
            Route::get('/electricians/export', [AdminElectricianController::class, 'export'])->name('electricians.export');

            // Service Management
            Route::resource('services', AdminServiceController::class);
            Route::post('/services/{service}/toggle', [AdminServiceController::class, 'toggleActive'])->name('services.toggle');

            // User Management
            Route::resource('users', AdminUserController::class);
            Route::post('/users/{user}/verify-email', [AdminUserController::class, 'verifyEmail'])->name('users.verify-email');
            Route::post('/users/{user}/unverify-email', [AdminUserController::class, 'unverifyEmail'])->name('users.unverify-email');
            Route::post('/users/{user}/change-role', [AdminUserController::class, 'changeRole'])->name('users.change-role');
            Route::post('/users/bulk-delete', [AdminUserController::class, 'bulkDelete'])->name('users.bulk-delete');
            Route::post('/users/bulk-verify', [AdminUserController::class, 'bulkVerifyEmails'])->name('users.bulk-verify');
            Route::post('/users/{user}/impersonate', [AdminUserController::class, 'impersonate'])->name('users.impersonate');
            Route::post('/users/stop-impersonate', [AdminUserController::class, 'stopImpersonate'])->name('users.stop-impersonate');
            Route::get('/users/export', [AdminUserController::class, 'export'])->name('users.export');
            Route::get('/users/{user}/activity', [AdminUserController::class, 'activityLog'])->name('users.activity');

            // Reports
            Route::get('/reports', [ReportController::class, 'index'])->name('reports');
            Route::get('/reports/export/{type}', [ReportController::class, 'export'])->name('reports.export');
            Route::get('/reports/analytics', [ReportController::class, 'analytics'])->name('reports.analytics');
        });
});

// Authentication Routes
require __DIR__.'/auth.php';