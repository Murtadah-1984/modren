<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthenticatedSessionBaseController;
use App\Http\Controllers\Auth\EmailVerificationNotificationBaseController;
use App\Http\Controllers\Auth\NewPasswordBaseController;
use App\Http\Controllers\Auth\PasswordResetLinkBaseController;
use App\Http\Controllers\Auth\RegisteredUserBaseController;
use App\Http\Controllers\Auth\VerifyEmailBaseController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisteredUserBaseController::class, 'store'])
    ->middleware('guest')
    ->name('register');

Route::post('/login', [AuthenticatedSessionBaseController::class, 'store'])
    ->middleware('guest')
    ->name('login');

Route::post('/forgot-password', [PasswordResetLinkBaseController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::post('/reset-password', [NewPasswordBaseController::class, 'store'])
    ->middleware('guest')
    ->name('password.store');

Route::get('/verify-email/{id}/{hash}', VerifyEmailBaseController::class)
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationBaseController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::post('/logout', [AuthenticatedSessionBaseController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');
