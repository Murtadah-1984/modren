<?php

declare(strict_types=1);

namespace Modules\RBAC\Interface\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Core\Interface\Http\Controllers\CoreApiController;
use Modules\RBAC\Application\Services\PermissionService;
use Modules\RBAC\Interface\Http\Requests\Permissions\StorePermissionRequest;
use Modules\RBAC\Interface\Http\Requests\Permissions\UpdatePermissionRequest;

final class PermissionApiController extends CoreApiController
{
    public function __construct(
        protected PermissionService $permissionService
    ) {
        $this->middleware('permission:view permissions')->only(['index', 'show', 'getByRole', 'getByGuard', 'getGuards', 'exists']);
        $this->middleware('permission:create permissions')->only(['store']);
        $this->middleware('permission:edit permissions')->only(['update']);
        $this->middleware('permission:delete permissions')->only(['destroy']);
    }

    /**
     * Display a listing of permissions
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $guardName = $request->input('guard_name');

            if ($request->has('search')) {
                $permissions = $this->permissionService->searchPermissions($request->input('search'), $guardName);
            } elseif ($request->has('scopes')) {
                return Response()->json($this->getModelScopes('Permission'));
            } else {
                $permissions = $this->permissionService->getAllPermissions($guardName);
            }

            return $this->success($permissions);

        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Store a newly created permission
     */
    public function store(StorePermissionRequest $request): JsonResponse
    {
        try {
            $permission = $this->permissionService->createPermission($request->validated());

            return $this->success($permission);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Display the specified permission
     */
    public function show(int $id, Request $request): JsonResponse
    {
        try {
            $permission = $this->permissionService->findPermissionById($id, $request->input('guard_name'));

            return $this->success($permission);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Update the specified permission
     */
    public function update(UpdatePermissionRequest $request, int $id): JsonResponse
    {
        try {

            $permission = $this->permissionService->updatePermission($id, $request->validated(), $request->input('guard_name'));

            return $this->success($permission);

        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Remove the specified permission
     */
    public function destroy(int $id, Request $request): JsonResponse
    {
        try {
            $this->permissionService->deletePermission($id, $request->input('guard_name'));

            return $this->success('Permission deleted successfully');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Get permissions by role
     */
    public function getByRole(string $roleName, Request $request): JsonResponse
    {
        try {
            $permissions = $this->permissionService->getPermissionsByRole($roleName, $request->input('guard_name'));

            return $this->success($permissions);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Get permissions by guard
     */
    public function getByGuard(string $guardName): JsonResponse
    {
        try {
            $permissions = $this->permissionService->getPermissionsByGuard($guardName);

            return $this->success($permissions);
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
            $guards = $this->permissionService->getAllGuards();

            return $this->success($guards);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Check if permission exists
     */
    public function exists(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'guard_name' => 'nullable|string',
            ]);

            $exists = $this->permissionService->permissionExists(
                $request->input('name'),
                $request->input('guard_name')
            );

            return $this->success(['exists' => $exists]);

        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
