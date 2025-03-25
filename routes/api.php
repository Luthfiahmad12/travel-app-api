<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', function () {
    return response()->json([
        'message' => 'welcome to travel app api'
    ], 200);
});

Route::apiResource('/schedules', ScheduleController::class)->middleware('auth:sanctum');
Route::apiResource('/bookings', BookingController::class)->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('logout/{user}', [AuthController::class, 'logout']);
    Route::get('booking/getdatabypassenger', [BookingController::class, 'getDataByPassenger']);

    Route::get('payment/callback', [TransactionController::class, 'callback']);
});
