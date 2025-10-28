<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\DashboardBaseController::class, 'index'])->name('home');
});
