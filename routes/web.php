<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OLTController;
use App\Http\Controllers\OutageController;
use App\Http\Controllers\SLAController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::redirect('/', '/dashboard');


Route::middleware(['auth', 'verified']) ->group(function() {
    Route::get('/dashboard', fn() => Inertia::render('Dashboard'))->name('dashboard');
    Route::resource('team', TeamController::class);
    Route::resource('customer', CustomerController::class);
    Route::resource('olt', OLTController::class);
    Route::resource('outage', OutageController::class);
    Route::resource('sla', SLAController::class);

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
