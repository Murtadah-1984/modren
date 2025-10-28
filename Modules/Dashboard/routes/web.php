<?php

use Illuminate\Support\Facades\Route;
use Modules\Dashboard\Interface\Http\Controllers\DashboardController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('dashboards', DashboardController::class)->names('dashboard');
});
