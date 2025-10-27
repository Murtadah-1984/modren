<?php

use App\Http\Controllers\Api\V1\UserBaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::middleware(['web', 'auth'])->group(function () {

    Route::get('/', [\App\Http\Controllers\DashboardBaseController::class, 'index'])->name('home');

    Route::prefix('users')->group(function () {
        Route::get('/', [\App\Http\Controllers\UserDataTableBaseController::class, 'index'])->name('users.index')->middleware('permission:users.view');
    });
    Route::prefix('roles')->group(function () {
        Route::get('/', [\App\Http\Controllers\RoleDataTableBaseController::class, 'index'])->name('roles.index')->middleware('permission:View Roles');
    });
    Route::prefix('permissions')->group(function () {
        Route::get('/', [\App\Http\Controllers\PermissionDataTableBaseController::class, 'index'])->name('permissions.index')->middleware('permission:View Permissions');
    });

});
