<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Interface\Http\Controllers\AuthController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('auths', AuthController::class)->names('auth');
});
