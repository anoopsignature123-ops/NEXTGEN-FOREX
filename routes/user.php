<?php

use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\RegisterController;
use App\Http\Middleware\UserAuth;
use App\Http\Middleware\UserGuest;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User Member Routes & Security Middlewares
|--------------------------------------------------------------------------
*/

Route::prefix('user')->name('user.')->group(function () {

    // Guest User Routes (Redirects to User Dashboard if already logged in)
    Route::middleware(UserGuest::class)->group(function () {
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login']);
        Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('register', [RegisterController::class, 'register']);
    });

    // Authenticated User Routes (Requires User Authentication)
    Route::middleware(UserAuth::class)->group(function () {
        Route::get('/', [DashboardController::class, '__invoke']);
        Route::get('dashboard', [DashboardController::class, '__invoke'])->name('dashboard');
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    });
});
