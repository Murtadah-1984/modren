<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Interface\Http\Controllers\Web\ForgotPasswordController;
use Modules\Auth\Interface\Http\Controllers\Web\LoginController;
use Modules\Auth\Interface\Http\Controllers\Web\RegisterController;
use Modules\Auth\Interface\Http\Controllers\Web\ResetPasswordController;
use Modules\Auth\Interface\Http\Controllers\Web\VerificationController;


Route::middleware(['web'])->group(function () {

    // Login
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Register
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    // Password Reset
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

    // Email Verification
    Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
        ->middleware(['signed'])
        ->name('verification.verify');
    Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
});
