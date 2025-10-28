<?php

use Illuminate\Support\Facades\Route;
use Modules\RBAC\Interface\Http\Controllers\PermissionApiController;
use Modules\RBAC\Interface\Http\Controllers\RBACController;
use Modules\RBAC\Interface\Http\Controllers\RoleApiController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    /*
   |--------------------------------------------------------------------------
   | Role Routes
   |--------------------------------------------------------------------------
   */
    Route::prefix('roles')->name('roles.')->middleware('permission:roles.view')->group(function () {

        Route::resource('/', RoleApiController::class)->parameters(['' => 'id']);

        Route::post('/{id}/permissions/give', [RoleApiController::class, 'givePermission'])
            ->name('give-permission')
            ->middleware('permission:roles.edit');

        Route::delete('/{id}/permissions/revoke', [RoleApiController::class, 'revokePermission'])
            ->name('revoke-permission')
            ->middleware('permission:roles.edit');

        Route::put('/{id}/permissions/sync', [RoleApiController::class, 'syncPermissions'])
            ->name('sync-permissions')
            ->middleware('permission:roles.edit');

        Route::get('/{id}/permissions', [RoleApiController::class, 'getPermissions'])->name('permissions');
        Route::get('/{id}/users', [RoleApiController::class, 'getUsers'])->name('users');
        Route::get('/by-guard/{guardName}', [RoleApiController::class, 'getByGuard'])->name('by-guard');
        Route::get('/guards', [RoleApiController::class, 'getGuards'])->name('guards');
    });


    /*
    |--------------------------------------------------------------------------
    | Permission Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('permissions')->name('permissions.')->middleware('permission:permissions.view')->group(function () {

        Route::resource('/', PermissionApiController::class)->parameters(['' => 'id']);

        Route::get('/by-role/{roleName}', [PermissionApiController::class, 'getByRole'])->name('by-role');
        Route::get('/by-guard/{guardName}', [PermissionApiController::class, 'getByGuard'])->name('by-guard');
        Route::get('/guards', [PermissionApiController::class, 'getGuards'])->name('guards');
        Route::get('/exists', [PermissionApiController::class, 'exists'])->name('exists');
    });
});
