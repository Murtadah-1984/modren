<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\User\Interface\Http\Controllers\UserApiController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | User Routes (with permissions)
    |--------------------------------------------------------------------------
    */
    Route::prefix('users')->name('users.')->group(function () {

        // Index / View users
        Route::get('/', [UserApiController::class, 'index'])
            ->name('index')
            ->middleware('permission:users.view');

        // Create user
        Route::get('/create', [UserApiController::class, 'create'])
            ->name('create')
            ->middleware('permission:users.create');

        Route::post('/', [UserApiController::class, 'store'])
            ->name('store')
            ->middleware('permission:users.create');

        // Edit user
        Route::get('/{id}/edit', [UserApiController::class, 'edit'])
            ->name('edit')
            ->middleware('permission:users.edit');

        Route::put('/{id}', [UserApiController::class, 'update'])
            ->name('update')
            ->middleware('permission:users.edit');

        // Delete user
        Route::delete('/{id}', [UserApiController::class, 'destroy'])
            ->name('destroy')
            ->middleware('permission:users.delete');

        // Restore / Force Delete
        Route::post('/{id}/restore', [UserApiController::class, 'restore'])
            ->name('restore')
            ->middleware('permission:users.restore');

        Route::delete('/{id}/force-delete', [UserApiController::class, 'forceDelete'])
            ->name('force-delete')
            ->middleware('permission:users.force-delete');

        // Password / Avatar
        Route::put('/{id}/password', [UserApiController::class, 'updatePassword'])
            ->name('update-password')
            ->middleware('permission:users.edit');

        Route::post('/{id}/avatar', [UserApiController::class, 'updateAvatar'])
            ->name('update-avatar')
            ->middleware('permission:users.edit');

        Route::delete('/{id}/avatar', [UserApiController::class, 'removeAvatar'])
            ->name('remove-avatar')
            ->middleware('permission:users.edit');

        // Roles and Permissions Management
        Route::post('/{id}/roles/assign', [UserApiController::class, 'assignRole'])
            ->name('assign-role')
            ->middleware('permission:users.edit');

        Route::delete('/{id}/roles/remove', [UserApiController::class, 'removeRole'])
            ->name('remove-role')
            ->middleware('permission:users.edit');

        Route::put('/{id}/roles/sync', [UserApiController::class, 'syncRoles'])
            ->name('sync-roles')
            ->middleware('permission:users.edit');

        Route::post('/{id}/permissions/give', [UserApiController::class, 'givePermission'])
            ->name('give-permission')
            ->middleware('permission:users.edit');

        Route::delete('/{id}/permissions/revoke', [UserApiController::class, 'revokePermission'])
            ->name('revoke-permission')
            ->middleware('permission:users.edit');

        Route::put('/{id}/permissions/sync', [UserApiController::class, 'syncPermissions'])
            ->name('sync-permissions')
            ->middleware('permission:users.edit');

        // Query routes
        Route::get('/by-role/{roleName}', [UserApiController::class, 'getUsersByRole'])
            ->name('by-role')
            ->middleware('permission:users.view');

        Route::get('/by-permission/{permissionName}', [UserApiController::class, 'getUsersWithPermission'])
            ->name('by-permission')
            ->middleware('permission:users.view');
    });
});
