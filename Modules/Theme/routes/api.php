<?php

use Illuminate\Support\Facades\Route;
use Modules\Theme\Interface\Http\Controllers\ThemeController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('themes', ThemeController::class)->names('theme');
});
