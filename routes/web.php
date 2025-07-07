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

});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
