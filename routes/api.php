<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\AuthBaseController;
use App\Http\Controllers\Api\V1\UserBaseController;
use Illuminate\Support\Facades\Route;
use Modules\RBAC\Interface\Http\Controllers\PermissionBaseController;
use Modules\RBAC\Interface\Http\Controllers\RoleBaseController;

Route::prefix('v1')->as('api.')->group(function () {
    // Public routes
    Route::post('/register', [AuthBaseController::class, 'register']);
    Route::post('/login', [AuthBaseController::class, 'login']);
    Route::post('/password/email', [AuthBaseController::class, 'sendResetLinkEmail']);
    Route::post('/password/reset', [AuthBaseController::class, 'resetPassword']);

    // Email verification
    Route::get('/email/verify/{id}/{hash}', [AuthBaseController::class, 'verifyEmail'])
        ->name('verification.verify');

});
Route::prefix('v1')->as('api.')->middleware(['api', 'auth:sanctum'])->group(function () {

    Route::get('/user', [AuthBaseController::class, 'user']);
    Route::post('/logout', [AuthBaseController::class, 'logout']);
    Route::post('/refresh', [AuthBaseController::class, 'refresh']);

    /*


    /*
    |--------------------------------------------------------------------------
    | Role Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('roles')->name('roles.')->middleware('permission:roles.view')->group(function () {

        Route::resource('/', RoleBaseController::class)->parameters(['' => 'id']);

        Route::post('/{id}/permissions/give', [RoleBaseController::class, 'givePermission'])
            ->name('give-permission')
            ->middleware('permission:roles.edit');

        Route::delete('/{id}/permissions/revoke', [RoleBaseController::class, 'revokePermission'])
            ->name('revoke-permission')
            ->middleware('permission:roles.edit');

        Route::put('/{id}/permissions/sync', [RoleBaseController::class, 'syncPermissions'])
            ->name('sync-permissions')
            ->middleware('permission:roles.edit');

        Route::get('/{id}/permissions', [RoleBaseController::class, 'getPermissions'])->name('permissions');
        Route::get('/{id}/users', [RoleBaseController::class, 'getUsers'])->name('users');
        Route::get('/by-guard/{guardName}', [RoleBaseController::class, 'getByGuard'])->name('by-guard');
        Route::get('/guards', [RoleBaseController::class, 'getGuards'])->name('guards');
    });

    /*
    |--------------------------------------------------------------------------
    | Permission Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('permissions')->name('permissions.')->middleware('permission:permissions.view')->group(function () {

        Route::resource('/', PermissionBaseController::class)->parameters(['' => 'id']);

        Route::get('/by-role/{roleName}', [PermissionBaseController::class, 'getByRole'])->name('by-role');
        Route::get('/by-guard/{guardName}', [PermissionBaseController::class, 'getByGuard'])->name('by-guard');
        Route::get('/guards', [PermissionBaseController::class, 'getGuards'])->name('guards');
        Route::get('/exists', [PermissionBaseController::class, 'exists'])->name('exists');
    });
});
