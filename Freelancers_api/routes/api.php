<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MissionController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);
 
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/missions',[MissionController::class, 'store']);
    Route::put('/missions/{mission}',[MissionController::class, 'update']);
    Route::delete('/missions/{mission}',[MissionController::class, 'destroy']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
 