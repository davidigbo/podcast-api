<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PodcastController;
use App\Http\Controllers\Api\EpisodeController;
use App\Http\Controllers\Api\AuthController;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::prefix('v1')->group(function () {
    Route::middleware('auth:sanctum')->apiResource('categories', CategoryController::class);
    Route::middleware('auth:sanctum')->apiResource('podcasts', PodcastController::class);
    Route::middleware('auth:sanctum')->apiResource('episodes', EpisodeController::class);
});


