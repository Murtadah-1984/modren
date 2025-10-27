<?php

use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::middleware(['web', 'auth'])->group(function () {

    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('home');

    Route::prefix('users')->group(function () {
        Route::get('/', [\App\Http\Controllers\UserDataTableController::class, 'index'])->name('users.index')->middleware('permission:users.view');
    });
    Route::prefix('roles')->group(function () {
        Route::get('/', [\App\Http\Controllers\RoleDataTableController::class, 'index'])->name('roles.index')->middleware('permission:View Roles');
    });
    Route::prefix('permissions')->group(function () {
        Route::get('/', [\App\Http\Controllers\PermissionDataTableController::class, 'index'])->name('permissions.index')->middleware('permission:View Permissions');
    });

});
