<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Volt::route('/', 'welcome')
    ->name('welcome');

Route::middleware(['guest'])->group(function () {
    Volt::route('login', 'auth.login')
        ->name('auth.login');

    Volt::route('register', 'auth.register')
        ->name('auth.register');

    Volt::route('forgot-password', 'auth.forgot-password')
        ->name('auth.password.request');
});

Route::middleware('auth')->group(function () {
    Volt::route('verify-email', 'auth.verify-email')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Volt::route('admin/dashboard', 'admin.dashboard')
        ->name('admin.dashboard');
});
