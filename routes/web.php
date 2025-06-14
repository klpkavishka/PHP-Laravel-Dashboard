<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PublicDashboardController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\SysAdmin;

// Public routes
Route::get('/', [PublicDashboardController::class, 'index'])->name('home');
Route::get('/sensor/{id}', [PublicDashboardController::class, 'sensorDetail'])->name('sensor.detail');
Route::get('/api/sensor/{id}/historical-data', [PublicDashboardController::class, 'getHistoricalData']);

// Authentication routes
Auth::routes();

// Admin routes - removed authentication and role middleware
Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Sensors
    Route::resource('sensors', Admin\SensorController::class);

    // Simulation
    Route::get('/simulation', [Admin\SimulationController::class, 'index'])->name('simulation.index');
    Route::post('/simulation', [Admin\SimulationController::class, 'update'])->name('simulation.update');
    Route::post('/simulation/toggle', [Admin\SimulationController::class, 'toggle'])->name('simulation.toggle');

    // Alerts
    Route::resource('alerts', Admin\AlertController::class);

    // Users
    Route::resource('users', Admin\UserController::class);
});

// System admin routes - removed authentication middleware but kept role for security
Route::prefix('sysadmin')->name('sysadmin.')->group(function () {
    Route::get('/', [SysAdmin\DashboardController::class, 'index'])->name('sysadmin.dashboard');
    Route::resource('users', SysAdmin\UserController::class);
    Route::get('/system-config', [SysAdmin\SystemConfigController::class, 'index'])->name('system-config.index');
    Route::post('/system-config', [SysAdmin\SystemConfigController::class, 'update'])->name('system-config.update');
});
