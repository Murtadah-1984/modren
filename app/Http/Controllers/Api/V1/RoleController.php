<?php

namespace App\Http\Controllers\Api\V1;

use App\DTOs\Roles\CreateRoleDTO;
use App\DTOs\Roles\UpdateRoleDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\AssignPermissionRequest;
use App\Http\Requests\Roles\StoreRoleRequest;
use App\Http\Requests\Roles\UpdateRoleRequest;
use App\Services\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
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

            }elseif ($request->has('scopes')) {
                return Response()->json($this->getModelScopes('Role'));
            } else {

                $roles = $this->roleService->getAllRoles($guardName);

            }

            return $this->success($roles);

        } catch (\Exception $e) {

            return $this->error($e);

        }
    }

    /**
     * Store a newly created role
     */
    public function store(StoreRoleRequest $request): JsonResponse
    {
        try {
            $dto = CreateRoleDTO::fromArray($request->validated());

            $role = $this->roleService->createRole($dto);

            return $this->success($role);

        } catch (\Exception $e) {
            return $this->error($e);
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

        } catch (\Exception $e) {

            return $this->error($e);

        }
    }

    /**
     * Update the specified role
     */
    public function update(UpdateRoleRequest $request, int $id): JsonResponse
    {
        try {
            $dto = UpdateRoleDTO::fromArray($request->validated());
            $role = $this->roleService->updateRole($id, $dto, $request->input('guard_name'));

            return $this->success($role);

        } catch (\Exception $e) {

            return $this->error($e);

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

        } catch (\Exception $e) {

            return $this->error($e);

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

        } catch (\Exception $e) {

            return $this->error($e);

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

        } catch (\Exception $e) {

            return $this->error($e);

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

        } catch (\Exception $e) {

            return $this->error($e);

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

        } catch (\Exception $e) {

            return $this->error($e);

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

        } catch (\Exception $e) {

            return $this->error($e);

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

        } catch (\Exception $e) {

            return $this->error($e);

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

        } catch (\Exception $e) {

            return $this->error($e);

        }
    }
}
