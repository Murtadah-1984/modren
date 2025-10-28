<?php

use Illuminate\Support\Facades\Route;
use Modules\Theme\Interface\Http\Controllers\ThemeController;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/', [ThemeController::class, 'index'])->name('home');
});
