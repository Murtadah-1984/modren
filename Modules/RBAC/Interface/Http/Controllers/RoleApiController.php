<?php

declare(strict_types=1);

namespace Modules\RBAC\Interface\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Core\Interface\Http\Controllers\CoreApiController;
use Modules\RBAC\Application\Services\RoleService;
use Modules\RBAC\Interface\Http\Requests\Roles\AssignPermissionRequest;
use Modules\RBAC\Interface\Http\Requests\Roles\StoreRoleRequest;
use Modules\RBAC\Interface\Http\Requests\Roles\UpdateRoleRequest;

final class RoleApiController extends CoreApiController
{
    public function __construct(
        protected RoleService $roleService
    ) {
        $this->middleware('permission:view roles')->only(['index', 'show', 'getPermissions', 'getUsers', 'getByGuard', 'getGuards']);
        $this->middleware('permission:create roles')->only(['store']);
        $this->middleware('permission:edit roles')->only(['update']);
        $this->middleware('permission:delete roles')->only(['destroy']);
        $this->middleware('permission:manage role permissions')->only(['givePermission', 'revokePermission', 'syncPermissions']);
    }

    /**
     * Display a listing of roles
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $guardName = $request->input('guard_name');

            if ($request->has('search')) {

                $roles = $this->roleService->searchRoles($request->input('search'), $guardName);

            } elseif ($request->has('scopes')) {
                return Response()->json($this->getModelScopes('Role'));
            } else {

                $roles = $this->roleService->getAllRoles($guardName);

            }

            return $this->success($roles);

        } catch (Exception $e) {

            return $this->error($e->getMessage());

        }
    }

    /**
     * Store a newly created role
     */
    public function store(StoreRoleRequest $request): JsonResponse
    {
        try {

            $role = $this->roleService->createRole($request->validated());

            return $this->success($role);

        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Display the specified role
     */
    public function show(int $id, Request $request): JsonResponse
    {
        try {
            $role = $this->roleService->findRoleById($id, $request->input('guard_name'));

            return $this->success($role);

        } catch (Exception $e) {

            return $this->error($e->getMessage());

        }
    }

    /**
     * Update the specified role
     */
    public function update(UpdateRoleRequest $request, int $id): JsonResponse
    {
        try {
            $role = $this->roleService->updateRole($id, $request->validated(), $request->input('guard_name'));

            return $this->success($role);

        } catch (Exception $e) {

            return $this->error($e->getMessage());

        }
    }

    /**
     * Remove the specified role
     */
    public function destroy(int $id, Request $request): JsonResponse
    {
        try {
            $this->roleService->deleteRole($id, $request->input('guard_name'));

            return $this->success('Role deleted successfully');

        } catch (Exception $e) {

            return $this->error($e->getMessage());

        }
    }

    /**
     * Give permission(s) to role
     */
    public function givePermission(AssignPermissionRequest $request, int $id): JsonResponse
    {
        try {
            $role = $this->roleService->givePermission(
                $id,
                $request->input('permissions'),
                $request->input('guard_name')
            );

            return $this->success($role->load('permissions'));

        } catch (Exception $e) {

            return $this->error($e->getMessage());

        }
    }

    /**
     * Revoke permission(s) from role
     */
    public function revokePermission(AssignPermissionRequest $request, int $id): JsonResponse
    {
        try {
            $role = $this->roleService->revokePermission(
                $id,
                $request->input('permissions'),
                $request->input('guard_name')
            );

            return $this->success($role->load('permissions'));

        } catch (Exception $e) {

            return $this->error($e->getMessage());

        }
    }

    /**
     * Sync permissions to role
     */
    public function syncPermissions(AssignPermissionRequest $request, int $id): JsonResponse
    {
        try {
            $role = $this->roleService->syncPermissions(
                $id,
                $request->input('permissions'),
                $request->input('guard_name')
            );

            return $this->success($role->load('permissions'));

        } catch (Exception $e) {

            return $this->error($e->getMessage());

        }
    }

    /**
     * Get all permissions for a role
     */
    public function getPermissions(int $id, Request $request): JsonResponse
    {
        try {
            $permissions = $this->roleService->getRolePermissions($id, $request->input('guard_name'));

            return $this->success($permissions);

        } catch (Exception $e) {

            return $this->error($e->getMessage());

        }
    }

    /**
     * Get all users with this role
     */
    public function getUsers(int $id, Request $request): JsonResponse
    {
        try {
            $users = $this->roleService->getRoleUsers($id, $request->input('guard_name'));

            return $this->success($users);

        } catch (Exception $e) {

            return $this->error($e->getMessage());

        }
    }

    /**
     * Get roles by guard
     */
    public function getByGuard(string $guardName): JsonResponse
    {
        try {
            $roles = $this->roleService->getRolesByGuard($guardName);

            return $this->success($roles);

        } catch (Exception $e) {

            return $this->error($e->getMessage());

        }
    }

    /**
     * Get all guard names
     */
    public function getGuards(): JsonResponse
    {
        try {
            $guards = $this->roleService->getAllGuards();

            return $this->success($guards);

        } catch (Exception $e) {

            return $this->error($e->getMessage());

        }
    }
}
