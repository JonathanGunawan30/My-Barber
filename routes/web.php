<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\Client\DashboardController::class, 'index'])->name('home');
Route::get('/hairstyles', [\App\Http\Controllers\Client\DashboardController::class, 'hairstyles'])->name('hairstyles');

Route::get('/auth/google/redirect', [\App\Http\Controllers\Auth\OAuthController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [\App\Http\Controllers\Auth\OAuthController::class, 'handleGoogleCallback'])->name('google.callback');
Route::get('/auth/login', [\App\Http\Controllers\Auth\OAuthController::class, 'loginManually'])->name('login.customer');
Route::post('/auth/login', [\App\Http\Controllers\Auth\OAuthController::class, 'loginManually'])->name('login.customer.post');
Route::post('/auth/register', [\App\Http\Controllers\Auth\OAuthController::class, 'registerManually'])->name('register.customer');
Route::post('/logout', [\App\Http\Controllers\Auth\OAuthController::class, 'logout'])->name('logout.customer');

Route::middleware(['customer.auth'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Client\DashboardController::class, 'dashboard'])->name('customer.dashboard');

    Route::get('/booking/create', [\App\Http\Controllers\BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [\App\Http\Controllers\BookingController::class, 'store'])->name('booking.store');
    Route::post('/bookings/{booking}/testimonials', [\App\Http\Controllers\BookingController::class, 'review'])->name('reviews.store');

});
Route::post('/midtrans/callback', [App\Http\Controllers\BookingController::class, 'handleCallback']);
Route::get('/booking/finish', [App\Http\Controllers\BookingController::class, 'finish'])->name('booking.finish');
Route::post('/booking/update-status', [App\Http\Controllers\BookingController::class, 'updateStatus']);



Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('branches', \App\Http\Controllers\Admin\BranchController::class);
    Route::patch('/branches/{branch}/status', [\App\Http\Controllers\Admin\BranchController::class, 'updateStatus']);

    Route::resource('services', \App\Http\Controllers\Admin\ServiceController::class);

    Route::resource('barbers', \App\Http\Controllers\Admin\BarberController::class);
    Route::patch('/barbers/{barber}/status', [\App\Http\Controllers\Admin\BarberController::class, 'updateStatus']);

    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::patch('/users/{user}/status', [\App\Http\Controllers\Admin\UserController::class, 'updateStatus']);

    Route::resource('customers', \App\Http\Controllers\Admin\CustomerController::class);

    Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class);

    Route::resource('hairstyles', \App\Http\Controllers\Admin\HairstyleController::class);
    Route::patch('/hairstyles/{hairstyle}/toggle-featured', [\App\Http\Controllers\Admin\HairstyleController::class, 'updateStatus']);

    Route::get('/profile', [\App\Http\Controllers\Admin\ProfileAdminController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\Admin\ProfileAdminController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\Admin\ProfileAdminController::class, 'updatePassword'])->name('profile.password');

    Route::get("/dashboard", [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/bookings', [\App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings.index');
    Route::put('/bookings/{booking}/status', [\App\Http\Controllers\Admin\BookingController::class, 'updateStatus'])->name('bookings.updateStatus');
    Route::delete('/bookings/{booking}', [\App\Http\Controllers\Admin\BookingController::class, 'destroy'])->name('bookings.destroy');

});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
