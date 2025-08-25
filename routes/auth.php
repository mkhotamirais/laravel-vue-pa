<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::inertia('/register', 'Auth/Register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::inertia('/login', 'Auth/Login', ['msg' => session('msg')])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Password Reset
    Route::get('/forgot-password', [ResetPasswordController::class, 'request'])->middleware('guest')->name('password.request');
    Route::post('/forgot-password', [ResetPasswordController::class, 'email'])->middleware('guest')->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'reset'])->middleware('guest')->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'update'])->middleware('guest')->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Email Verification
    Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->middleware('signed')->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'send'])->middleware('throttle:6,1')->name('verification.send');

    // // Password Confirmation
    // Route::get('/confirm-password', [ConfirmPasswordController::class, 'create'])->name('password.confirm');
    // Route::post('/confirm-password', [ConfirmPasswordController::class, 'store'])->middleware('throttle:6,1');
});
