<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OLTController;
use App\Http\Controllers\OutageController;
use App\Http\Controllers\SLAController;
use App\Http\Controllers\DashboardController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::redirect('/', '/dashboard');


Route::middleware(['auth', 'verified']) ->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('team', TeamController::class);
    Route::resource('customer', CustomerController::class);
    Route::get('customers/export', [CustomerController::class, 'export'])->name('customers.export');
    Route::resource('olt', OLTController::class);
    Route::resource('outage', OutageController::class);
    Route::resource('sla', SLAController::class);
    Route::post('/outages/generate', [OutageController::class, 'generateOutage'])->name('outages.generate');
    Route::post('/outages/stop-all', [OutageController::class, 'stopAllOutages'])->name('outages.stopAll');
    Route::get('/outages/report', [OutageController::class, 'generateOutageReport'])->name('outages.report');


});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
