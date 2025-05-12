<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SpotifyController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('i18n')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register'])->name('register');
        Route::post('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');
    });

    Route::prefix('spotify')->middleware('auth:sanctum')->group(function () {
        Route::get('/search', [SpotifyController::class, 'search'])->name('search');
        Route::get('/album/{id}', [SpotifyController::class, 'album'])->name('album');
        Route::get('/track/{id}', [SpotifyController::class, 'track'])->name('track');
        Route::get('/artists/{id}', [SpotifyController::class, 'artist'])->name('artist');
        Route::get('/artists/{id}/top-tracks', [SpotifyController::class, 'topTracks'])->name('artists.top-tracks');
    });
});
