<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EntryController;
use App\Http\Controllers\Api\FoodController;   // ← add this
use App\Http\Controllers\Api\GoalController;
use App\Http\Controllers\Api\SettingsController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth');
    })->name('login');

    // New registration page
    Route::get('/register', function () {
        return view('register');
    })->name('register');
});

Route::post('/api/register', [AuthController::class, 'register']);
Route::post('/api/login', [AuthController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('app', [
            'currentUser' => auth()->user(),
        ]);
    })->name('dashboard');
    Route::post('/api/logout', [AuthController::class, 'logout']);
    Route::get('/api/user', [AuthController::class, 'user']);

    Route::get('/api/goals', [GoalController::class, 'show']);
    Route::post('/api/goals', [GoalController::class, 'update']);

    Route::get('/api/foods/search', [FoodController::class, 'search']);   // ← add this

    Route::get('/api/entries', [EntryController::class, 'index']);
    Route::get('/api/entries/{entry}', [EntryController::class, 'show']);
    Route::post('/api/entries', [EntryController::class, 'store']);
    Route::put('/api/entries/{entry}', [EntryController::class, 'update']);
    Route::delete('/api/entries/{entry}', [EntryController::class, 'destroy']);

    Route::post('/api/settings/profile', [SettingsController::class, 'updateProfile']);
    Route::post('/api/settings/password', [SettingsController::class, 'updatePassword']);
    Route::get('/api/physique-photos', [SettingsController::class, 'physiquePhotos']);
    Route::post('/api/physique-photos', [SettingsController::class, 'storePhysiquePhoto']);
    Route::delete('/api/physique-photos/{physiquePhoto}', [SettingsController::class, 'destroyPhysiquePhoto']);
});
