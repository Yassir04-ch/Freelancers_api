<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CandidatureController;
use App\Http\Controllers\Api\ExperienceController;
use App\Http\Controllers\Api\MissionController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);
 
Route::middleware('auth:sanctum')->group(function () {
     Route::get('/missions',[MissionController::class, 'index']);
     Route::get('/missions/{mission}',[MissionController::class, 'show']);

     Route::get('/candidatures',[CandidatureController::class, 'index']);
     Route::get('/candidatures/{candidature}',[CandidatureController::class, 'show']);
 
     Route::get('/experiences/{freelancer}',[ExperienceController::class, 'index']);
 }); 

 
Route::middleware(['auth:sanctum','admin'])->group(function(){
    Route::get('/dashboard',[AdminController::class, 'dashboard']);
    Route::get('/users',[AdminController::class, 'users']);
    Route::put('/users/{user}/activate',[AdminController::class, 'activerUser']);
    Route::put('/users/{user}/deactivate',[AdminController::class, 'deactiverUser']);
    Route::delete('/users/{user}',[AdminController::class, 'deleteUser']);
    Route::get('/missions',[AdminController::class, 'missions']);
    Route::delete('/missions/{mission}',[AdminController::class, 'deleteMission']);
});

Route::middleware(['auth:sanctum','freelancer'])->group(function(){
    Route::post('/candidatures',[CandidatureController::class, 'store']);
    Route::put('/candidatures/{candidature}',[CandidatureController::class, 'update']);
    Route::delete('/candidatures/{candidature}',[CandidatureController::class, 'destroy']);

    Route::post('/experiences',[ExperienceController::class, 'store']);
    Route::put('/experiences/{experience}',[ExperienceController::class, 'update']);
    Route::delete('/experiences/{experience}',[ExperienceController::class, 'destroy']);
});

Route::middleware(['auth:sanctum','client'])->group(function(){
    Route::post('/missions',[MissionController::class, 'store']);
    Route::put('/missions/{mission}',[MissionController::class, 'update']);
    Route::delete('/missions/{mission}',[MissionController::class, 'destroy']);

    Route::put('/candidatures/{candidature}/accept',[CandidatureController::class, 'accept']);
    Route::put('/candidatures/{candidature}/refuse',[CandidatureController::class, 'refuse']);
 
});