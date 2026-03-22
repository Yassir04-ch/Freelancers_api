<?php
 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\MissionController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);
 
Route::middleware('auth:sanctum')->prefix('auth')->group(function () {
    Route::post('/missions',[MissionController::class, 'store']);
    Route::put('/missions/{mission}',[MissionController::class, 'update']);
    Route::delete('/missions/{mission}',[MissionController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
 