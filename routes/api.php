<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\SensorController;
use App\Models\Sensor;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public sensor API endpoints - re-enabled
Route::get('/sensors', function () {
    return Sensor::with('latestReading')->where('status', 'active')->get();
});

Route::get('/sensors/{id}', function ($id) {
    return Sensor::with('latestReading')->findOrFail($id);
});
