<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\DTOs\Users\CreateUserDTO;
use App\DTOs\Users\UpdateUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\AssignRoleRequest;
use App\Http\Requests\Users\GivePermissionRequest;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateAvatarRequest;
use App\Http\Requests\Users\UpdatePasswordRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {
        // Permission middleware
        $this->middleware('permission:view users')->only(['index', 'show', 'getUsersByRole', 'getUsersWithPermission']);
        $this->middleware('permission:create users')->only(['store']);
        $this->middleware('permission:edit users')->only(['update', 'updatePassword', 'updateAvatar']);
        $this->middleware('permission:delete users')->only(['destroy', 'removeAvatar']);
        $this->middleware('permission:manage user roles')->only(['assignRole', 'removeRole', 'syncRoles']);
        $this->middleware('permission:manage user permissions')->only(['givePermission', 'revokePermission', 'syncPermissions']);
    }

    /**
     * Display a listing of users
     */
    public function index(Request $request): JsonResponse
    {
        try {
            if ($request->has('search')) {
                $users = $this->userService->searchUsers($request->input('search'));
            } elseif ($request->has('paginate')) {
                $users = $this->userService->getPaginatedUsers($request->input('per_page', 15));
            } elseif ($request->has('scopes')) {
                return Response()->json($this->getModelScopes('User'));
            } else {
                $users = $this->userService->getAllUsers();
            }

            return $this->success($users);

        } catch (Exception $e) {

            return $this->error($e);

        }
    }

    /**
     * Store a newly created user
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        try {
            $dto = CreateUserDTO::fromArray($request->validated());

            $user = $this->userService->createUser($dto);

            return $this->success($user);

        } catch (Exception $e) {

            return $this->error($e);

        }
    }

    /**
     * Display the specified user
     */
    public function show(int $id): JsonResponse
    {
        try {
            $user = $this->userService->findUserById($id);

            return $this->success($user);

        } catch (Exception $e) {

            return $this->error($e);

        }
    }

    /**
     * Update the specified user
     */
    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        try {
            $dto = UpdateUserDTO::fromArray($request->validated());
            $user = $this->userService->updateUser($id, $dto);

            return $this->success($user);

        } catch (Exception $e) {

            return $this->error($e);

        }
    }

    /**
     * Remove the specified user
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->userService->deleteUser($id);

            return $this->success('User Deleted Successfully');

        } catch (Exception $e) {

            return $this->error($e);

        }
    }

    /**
     * Update user's password
     */
    public function updatePassword(UpdatePasswordRequest $request, int $id): JsonResponse
    {
        try {
            $user = $this->userService->updatePassword($id, $request->input('password'));

            return $this->success($user);

        } catch (Exception $e) {

            return $this->error($e);

        }
    }

    /**
     * Update user's avatar
     */
    public function updateAvatar(UpdateAvatarRequest $request, int $id): JsonResponse
    {
        try {
            $user = $this->userService->updateAvatar($id, $request->file('avatar'));

            return $this->success($user);

        } catch (Exception $e) {

            return $this->error($e);

        }
    }

    /**
     * Remove user's avatar
     */
    public function removeAvatar(int $id): JsonResponse
    {
        try {
            $user = $this->userService->removeAvatar($id);

            return $this->success($user);

        } catch (Exception $e) {

            return $this->error($e);

        }
    }

    /**
     * Assign role(s) to user
     */
    public function assignRole(AssignRoleRequest $request, int $id): JsonResponse
    {
        try {
            $user = $this->userService->assignRole($id, $request->input('roles'));

            return $this->success($user);

        } catch (Exception $e) {

            return $this->error($e);

        }
    }

    /**
     * Remove role(s) from user
     */
    public function removeRole(AssignRoleRequest $request, int $id): JsonResponse
    {
        try {
            $user = $this->userService->removeRole($id, $request->input('roles'));

            return $this->success($user->load('roles'));

        } catch (Exception $e) {

            return $this->error($e);

        }
    }

    /**
     * Sync user roles
     */
    public function syncRoles(AssignRoleRequest $request, int $id): JsonResponse
    {
        try {
            $user = $this->userService->syncRoles($id, $request->input('roles'));

            return $this->success($user->load('roles'));

        } catch (Exception $e) {

            return $this->error($e);

        }
    }

    /**
     * Give permission(s) to user
     */
    public function givePermission(GivePermissionRequest $request, int $id): JsonResponse
    {
        try {
            $user = $this->userService->givePermission($id, $request->input('permissions'));

            return $this->success($user->load('permissions'));

        } catch (Exception $e) {

            return $this->error($e);

        }
    }

    /**
     * Revoke permission(s) from user
     */
    public function revokePermission(GivePermissionRequest $request, int $id): JsonResponse
    {
        try {
            $user = $this->userService->revokePermission($id, $request->input('permissions'));

            return $this->success($user->load('permissions'));

        } catch (Exception $e) {

            return $this->error($e);

        }
    }

    /**
     * Sync user permissions
     */
    public function syncPermissions(GivePermissionRequest $request, int $id): JsonResponse
    {
        try {
            $user = $this->userService->syncPermissions($id, $request->input('permissions'));

            return $this->success($user->load('permissions'));

        } catch (Exception $e) {

            return $this->error($e);

        }
    }

    /**
     * Get users by role
     */
    public function getUsersByRole(string $roleName): JsonResponse
    {
        try {
            $users = $this->userService->getUsersByRole($roleName);

            return $this->success($users);

        } catch (Exception $e) {

            return $this->error($e);

        }
    }

    /**
     * Get users with specific permission
     */
    public function getUsersWithPermission(string $permissionName): JsonResponse
    {
        try {
            $users = $this->userService->getUsersWithPermission($permissionName);

            return $this->success($users);

        } catch (Exception $e) {

            return $this->error($e);

        }
    }
}
