<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


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

});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
