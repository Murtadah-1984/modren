<?php

use App\Http\Controllers\Api\V1\AuthBaseController;
use App\Http\Controllers\Api\V1\PermissionBaseController;
use App\Http\Controllers\Api\V1\RoleBaseController;
use App\Http\Controllers\Api\V1\UserBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
|--------------------------------------------------------------------------
| User Routes (with permissions)
|--------------------------------------------------------------------------
*/
    Route::prefix('users')->name('users.')->group(function () {

        // Index / View users
        Route::get('/', [UserBaseController::class, 'index'])
            ->name('index')
            ->middleware('permission:users.view');

        // Create user
        Route::get('/create', [UserBaseController::class, 'create'])
            ->name('create')
            ->middleware('permission:users.create');

        Route::post('/', [UserBaseController::class, 'store'])
            ->name('store')
            ->middleware('permission:users.create');

        // Edit user
        Route::get('/{id}/edit', [UserBaseController::class, 'edit'])
            ->name('edit')
            ->middleware('permission:users.edit');

        Route::put('/{id}', [UserBaseController::class, 'update'])
            ->name('update')
            ->middleware('permission:users.edit');

        // Delete user
        Route::delete('/{id}', [UserBaseController::class, 'destroy'])
            ->name('destroy')
            ->middleware('permission:users.delete');

        // Restore / Force Delete
        Route::post('/{id}/restore', [UserBaseController::class, 'restore'])
            ->name('restore')
            ->middleware('permission:users.restore');

        Route::delete('/{id}/force-delete', [UserBaseController::class, 'forceDelete'])
            ->name('force-delete')
            ->middleware('permission:users.force-delete');

        // Password / Avatar
        Route::put('/{id}/password', [UserBaseController::class, 'updatePassword'])
            ->name('update-password')
            ->middleware('permission:users.edit');

        Route::post('/{id}/avatar', [UserBaseController::class, 'updateAvatar'])
            ->name('update-avatar')
            ->middleware('permission:users.edit');

        Route::delete('/{id}/avatar', [UserBaseController::class, 'removeAvatar'])
            ->name('remove-avatar')
            ->middleware('permission:users.edit');

        // Roles and Permissions Management
        Route::post('/{id}/roles/assign', [UserBaseController::class, 'assignRole'])
            ->name('assign-role')
            ->middleware('permission:users.edit');

        Route::delete('/{id}/roles/remove', [UserBaseController::class, 'removeRole'])
            ->name('remove-role')
            ->middleware('permission:users.edit');

        Route::put('/{id}/roles/sync', [UserBaseController::class, 'syncRoles'])
            ->name('sync-roles')
            ->middleware('permission:users.edit');

        Route::post('/{id}/permissions/give', [UserBaseController::class, 'givePermission'])
            ->name('give-permission')
            ->middleware('permission:users.edit');

        Route::delete('/{id}/permissions/revoke', [UserBaseController::class, 'revokePermission'])
            ->name('revoke-permission')
            ->middleware('permission:users.edit');

        Route::put('/{id}/permissions/sync', [UserBaseController::class, 'syncPermissions'])
            ->name('sync-permissions')
            ->middleware('permission:users.edit');

        // Query routes
        Route::get('/by-role/{roleName}', [UserBaseController::class, 'getUsersByRole'])
            ->name('by-role')
            ->middleware('permission:users.view');

        Route::get('/by-permission/{permissionName}', [UserBaseController::class, 'getUsersWithPermission'])
            ->name('by-permission')
            ->middleware('permission:users.view');
    });

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
