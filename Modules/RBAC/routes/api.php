<?php

use Illuminate\Support\Facades\Route;
use Modules\RBAC\Interface\Http\Controllers\RBACController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('rbacs', RBACController::class)->names('rbac');
});
