<?php

use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\DepositController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\NetworkController as UserNetworkController;
use App\Http\Controllers\User\PackageController;
use App\Http\Controllers\User\ProfileController;
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

    // Public Live Sponsor Check API Endpoint
    Route::get('check-sponsor', [RegisterController::class, 'checkSponsor'])->name('check-sponsor');

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

        // Add Fund / Deposit Wallet Routes
        Route::get('deposits', [DepositController::class, 'index'])->name('deposits.index');
        Route::post('deposits', [DepositController::class, 'store'])->name('deposits.store');
        Route::get('deposits/history', [DepositController::class, 'history'])->name('deposits.history');

        // Buy Package & Investment History Routes
        Route::get('packages', [PackageController::class, 'index'])->name('packages.index');
        Route::post('packages/buy', [PackageController::class, 'buy'])->name('packages.buy');
        Route::get('packages/history', [PackageController::class, 'history'])->name('packages.history');

        // My Network Module Routes
        Route::get('network/direct', [UserNetworkController::class, 'directMembers'])->name('network.direct');
        Route::get('network/tree', [UserNetworkController::class, 'treeView'])->name('network.tree');

        // My Profile & Account Settings Routes
        Route::get('profile', [ProfileController::class, 'index'])->name('profile');
        Route::put('profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
        Route::put('password', [ProfileController::class, 'updatePassword'])->name('password.update');

        Route::get('stop-impersonate', [AdminUserController::class, 'stopImpersonating'])->name('stop-impersonate');
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    });
});