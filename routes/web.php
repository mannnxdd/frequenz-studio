<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PublicBookingController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\PortfolioController as AdminPortfolioController;

/*
|--------------------------------------------------------------------------
| Public Routes (Guest)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/layanan', [ServiceController::class, 'index'])
    ->name('services.index');

Route::get('/booking', [PublicBookingController::class, 'create'])
    ->name('booking.create');

Route::post('/booking', [PublicBookingController::class, 'store'])
    ->name('booking.store');

Route::get('/cek-booking', [PublicBookingController::class, 'checkForm'])
    ->name('booking.check.form');

Route::post('/cek-booking', [PublicBookingController::class, 'check'])
    ->name('booking.check');

Route::get('/portofolio', [PortfolioController::class, 'index'])
    ->name('portfolios.index');

Route::get('/portofolio/{portfolio}', [PortfolioController::class, 'show'])
    ->name('portfolios.show');

/*
|--------------------------------------------------------------------------
| Admin Routes (Auth + Admin Middleware)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', fn () => redirect()->route('admin.bookings.index'))
            ->name('dashboard');

        Route::resource('bookings', AdminBookingController::class)
            ->only(['index','show','update']);

        Route::resource('portfolios', AdminPortfolioController::class)
            ->except(['destroy']);

        Route::delete('portfolios/{portfolio}',
            [AdminPortfolioController::class, 'destroy'])
            ->name('portfolios.destroy');

        Route::post('portfolios/{portfolio}/media',
            [AdminPortfolioController::class, 'storeMedia'])
            ->name('portfolios.media.store');

        Route::delete('portfolios/{portfolio}/media/{media}',
            [AdminPortfolioController::class, 'destroyMedia'])
            ->name('portfolios.media.destroy');
});

/*
|--------------------------------------------------------------------------
| Dashboard Redirect (Optional)
|--------------------------------------------------------------------------
| Karena tidak ada dashboard user, kita redirect saja.
*/
Route::get('/dashboard', fn () => redirect()->route('home'))
    ->middleware('auth')
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Breeze Auth Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
