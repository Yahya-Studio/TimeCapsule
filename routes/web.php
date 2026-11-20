<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CapsuleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

// Public Visitor Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Guest Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    Route::get('/reset-password/{token?}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Capsules Routes
    Route::prefix('capsules')->name('capsules.')->group(function () {
        Route::get('/', [CapsuleController::class, 'index'])->name('index');
        Route::get('/closed', [CapsuleController::class, 'closed'])->name('closed');
        Route::get('/ready', [CapsuleController::class, 'ready'])->name('ready');
        Route::get('/create', [CapsuleController::class, 'create'])->name('create');
        Route::post('/', [CapsuleController::class, 'store'])->name('store');
        Route::get('/{capsule}', [CapsuleController::class, 'show'])->name('show');
        Route::post('/{capsule}/open', [CapsuleController::class, 'open'])->name('open');
        Route::get('/{capsule}/edit', [CapsuleController::class, 'edit'])->name('edit');
        Route::put('/{capsule}', [CapsuleController::class, 'update'])->name('update');
        Route::delete('/{capsule}', [CapsuleController::class, 'destroy'])->name('destroy');
    });

    // Profile & Settings
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
});
