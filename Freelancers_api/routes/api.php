<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CandidatureController;
use App\Http\Controllers\Api\MissionController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);
 
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/missions',[MissionController::class, 'store']);
    Route::get('/missions',[MissionController::class, 'index']);
    Route::put('/missions/{mission}',[MissionController::class, 'update']);
    Route::get('/missions/{mission}',[MissionController::class, 'show']);
    Route::delete('/missions/{mission}',[MissionController::class, 'destroy']);

    Route::get('/candidatures',[CandidatureController::class, 'index']);
    Route::post('/candidatures',[CandidatureController::class, 'store']);
    Route::get('/candidatures/{candidature}',[CandidatureController::class, 'show']);
    Route::put('/candidatures/{candidature}',[CandidatureController::class, 'update']);
    Route::put('/candidatures/{candidature}/accept',[CandidatureController::class, 'accept']);
    Route::put('/candidatures/{candidature}/refuse',[CandidatureController::class, 'refuse']);
    Route::delete('/candidatures/{candidature}',[CandidatureController::class, 'destroy']);
});
 