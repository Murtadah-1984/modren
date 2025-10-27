<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\PermissionController;
use App\Http\Controllers\Api\V1\RoleController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->as('api.')->group(function () {
    // Public routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/password/email', [AuthController::class, 'sendResetLinkEmail']);
    Route::post('/password/reset', [AuthController::class, 'resetPassword']);

    // Email verification
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
        ->name('verification.verify');

});
Route::prefix('v1')->as('api.')->middleware(['api', 'auth:sanctum'])->group(function () {

    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);

    /*
|--------------------------------------------------------------------------
| User Routes (with permissions)
|--------------------------------------------------------------------------
*/
    Route::prefix('users')->name('users.')->group(function () {

        // Index / View users
        Route::get('/', [UserController::class, 'index'])
            ->name('index')
            ->middleware('permission:users.view');

        // Create user
        Route::get('/create', [UserController::class, 'create'])
            ->name('create')
            ->middleware('permission:users.create');

        Route::post('/', [UserController::class, 'store'])
            ->name('store')
            ->middleware('permission:users.create');

        // Edit user
        Route::get('/{id}/edit', [UserController::class, 'edit'])
            ->name('edit')
            ->middleware('permission:users.edit');

        Route::put('/{id}', [UserController::class, 'update'])
            ->name('update')
            ->middleware('permission:users.edit');

        // Delete user
        Route::delete('/{id}', [UserController::class, 'destroy'])
            ->name('destroy')
            ->middleware('permission:users.delete');

        // Restore / Force Delete
        Route::post('/{id}/restore', [UserController::class, 'restore'])
            ->name('restore')
            ->middleware('permission:users.restore');

        Route::delete('/{id}/force-delete', [UserController::class, 'forceDelete'])
            ->name('force-delete')
            ->middleware('permission:users.force-delete');

        // Password / Avatar
        Route::put('/{id}/password', [UserController::class, 'updatePassword'])
            ->name('update-password')
            ->middleware('permission:users.edit');

        Route::post('/{id}/avatar', [UserController::class, 'updateAvatar'])
            ->name('update-avatar')
            ->middleware('permission:users.edit');

        Route::delete('/{id}/avatar', [UserController::class, 'removeAvatar'])
            ->name('remove-avatar')
            ->middleware('permission:users.edit');

        // Roles and Permissions Management
        Route::post('/{id}/roles/assign', [UserController::class, 'assignRole'])
            ->name('assign-role')
            ->middleware('permission:users.edit');

        Route::delete('/{id}/roles/remove', [UserController::class, 'removeRole'])
            ->name('remove-role')
            ->middleware('permission:users.edit');

        Route::put('/{id}/roles/sync', [UserController::class, 'syncRoles'])
            ->name('sync-roles')
            ->middleware('permission:users.edit');

        Route::post('/{id}/permissions/give', [UserController::class, 'givePermission'])
            ->name('give-permission')
            ->middleware('permission:users.edit');

        Route::delete('/{id}/permissions/revoke', [UserController::class, 'revokePermission'])
            ->name('revoke-permission')
            ->middleware('permission:users.edit');

        Route::put('/{id}/permissions/sync', [UserController::class, 'syncPermissions'])
            ->name('sync-permissions')
            ->middleware('permission:users.edit');

        // Query routes
        Route::get('/by-role/{roleName}', [UserController::class, 'getUsersByRole'])
            ->name('by-role')
            ->middleware('permission:users.view');

        Route::get('/by-permission/{permissionName}', [UserController::class, 'getUsersWithPermission'])
            ->name('by-permission')
            ->middleware('permission:users.view');
    });

    /*
    |--------------------------------------------------------------------------
    | Role Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('roles')->name('roles.')->middleware('permission:roles.view')->group(function () {

        Route::resource('/', RoleController::class)->parameters(['' => 'id']);

        Route::post('/{id}/permissions/give', [RoleController::class, 'givePermission'])
            ->name('give-permission')
            ->middleware('permission:roles.edit');

        Route::delete('/{id}/permissions/revoke', [RoleController::class, 'revokePermission'])
            ->name('revoke-permission')
            ->middleware('permission:roles.edit');

        Route::put('/{id}/permissions/sync', [RoleController::class, 'syncPermissions'])
            ->name('sync-permissions')
            ->middleware('permission:roles.edit');

        Route::get('/{id}/permissions', [RoleController::class, 'getPermissions'])->name('permissions');
        Route::get('/{id}/users', [RoleController::class, 'getUsers'])->name('users');
        Route::get('/by-guard/{guardName}', [RoleController::class, 'getByGuard'])->name('by-guard');
        Route::get('/guards', [RoleController::class, 'getGuards'])->name('guards');
    });

    /*
    |--------------------------------------------------------------------------
    | Permission Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('permissions')->name('permissions.')->middleware('permission:permissions.view')->group(function () {

        Route::resource('/', PermissionController::class)->parameters(['' => 'id']);

        Route::get('/by-role/{roleName}', [PermissionController::class, 'getByRole'])->name('by-role');
        Route::get('/by-guard/{guardName}', [PermissionController::class, 'getByGuard'])->name('by-guard');
        Route::get('/guards', [PermissionController::class, 'getGuards'])->name('guards');
        Route::get('/exists', [PermissionController::class, 'exists'])->name('exists');
    });
});
