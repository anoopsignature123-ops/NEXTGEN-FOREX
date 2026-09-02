<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepositController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\NetworkController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Middleware\AdminAuth;
use App\Http\Middleware\AdminGuest;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes & Security Middlewares
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    // Guest Admin Routes (Redirects to Dashboard if already logged in)
    Route::middleware(AdminGuest::class)->group(function () {
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login']);
    });

    // Authenticated Admin Routes (Requires Admin Authentication & Admin Role)
    Route::middleware(AdminAuth::class)->group(function () {
        Route::get('/', [DashboardController::class, '__invoke']);
        Route::get('dashboard', [DashboardController::class, '__invoke'])->name('dashboard');

        // Global Live Search Suggestions API
        Route::get('global-search-suggestions', [UserController::class, 'globalSearchSuggestions'])->name('global-search-suggestions');

        // Package Management Routes
        Route::get('packages', [PackageController::class, 'index'])->name('packages.index');
        Route::get('packages/create', [PackageController::class, 'create'])->name('packages.create');
        Route::post('packages', [PackageController::class, 'store'])->name('packages.store');
        Route::get('packages/{package}/edit', [PackageController::class, 'edit'])->name('packages.edit');
        Route::put('packages/{package}', [PackageController::class, 'update'])->name('packages.update');
        Route::post('packages/{package}/toggle-status', [PackageController::class, 'toggleStatus'])->name('packages.toggle-status');

        // Deposit Management Routes
        Route::get('deposits', [DepositController::class, 'index'])->name('deposits.index');
        Route::post('deposits/{deposit}/approve', [DepositController::class, 'approve'])->name('deposits.approve');
        Route::post('deposits/{deposit}/reject', [DepositController::class, 'reject'])->name('deposits.reject');

        // User Management Routes
        Route::get('users', [UserController::class, 'index'])->name('users');
        Route::get('users/directory', [UserController::class, 'index'])->name('users.index');
        Route::get('users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('users', [UserController::class, 'store'])->name('users.store');
        Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');

        // Impersonate / Login as User Route
        Route::get('users/{user}/impersonate', [UserController::class, 'impersonate'])->name('users.impersonate');

        // Network & Binary Team Tree Routes
        Route::get('network/direct', [NetworkController::class, 'directMembers'])->name('network.direct');
        Route::get('network/tree', [NetworkController::class, 'treeView'])->name('network.tree');

        // Profile & Password Management
        Route::get('profile', [ProfileController::class, 'index'])->name('profile');
        Route::put('profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
        Route::put('password', [ProfileController::class, 'updatePassword'])->name('password.update');

        // Admin Logout
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    });
});
