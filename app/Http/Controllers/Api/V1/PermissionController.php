<?php

namespace App\Http\Controllers\Api\V1;

use App\DTOs\Permissions\CreatePermissionDTO;
use App\DTOs\Permissions\UpdatePermissionDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Permissions\StorePermissionRequest;
use App\Http\Requests\Permissions\UpdatePermissionRequest;
use App\Services\PermissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PermissionController extends Controller
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
            }elseif ($request->has('scopes')) {
                return Response()->json($this->getModelScopes('Permission'));
            } else {
                $permissions = $this->permissionService->getAllPermissions($guardName);
            }

            return response()->json([
                'success' => true,
                'data' => $permissions,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created permission
     */
    public function store(StorePermissionRequest $request): JsonResponse
    {
        try {
            $dto = CreatePermissionDTO::fromArray($request->validated());
            $permission = $this->permissionService->createPermission($dto);

            return response()->json([
                'success' => true,
                'data' => $permission,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified permission
     */
    public function show(int $id, Request $request): JsonResponse
    {
        try {
            $permission = $this->permissionService->findPermissionById($id, $request->input('guard_name'));

            return response()->json([
                'success' => true,
                'data' => $permission,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified permission
     */
    public function update(UpdatePermissionRequest $request, int $id): JsonResponse
    {
        try {
            $dto = UpdatePermissionDTO::fromArray($request->validated());
            $permission = $this->permissionService->updatePermission($id, $dto, $request->input('guard_name'));

            return response()->json([
                'success' => true,
                'data' => $permission,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified permission
     */
    public function destroy(int $id, Request $request): JsonResponse
    {
        try {
            $this->permissionService->deletePermission($id, $request->input('guard_name'));

            return response()->json([
                'success' => true,
                'message' => 'Permission deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Get permissions by role
     */
    public function getByRole(string $roleName, Request $request): JsonResponse
    {
        try {
            $permissions = $this->permissionService->getPermissionsByRole($roleName, $request->input('guard_name'));

            return response()->json([
                'success' => true,
                'data' => $permissions,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Get permissions by guard
     */
    public function getByGuard(string $guardName): JsonResponse
    {
        try {
            $permissions = $this->permissionService->getPermissionsByGuard($guardName);

            return response()->json([
                'success' => true,
                'data' => $permissions,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all guard names
     */
    public function getGuards(): JsonResponse
    {
        try {
            $guards = $this->permissionService->getAllGuards();

            return response()->json([
                'success' => true,
                'data' => $guards,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
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
                'guard_name' => 'nullable|string'
            ]);

            $exists = $this->permissionService->permissionExists(
                $request->input('name'),
                $request->input('guard_name')
            );

            return response()->json([
                'success' => true,
                'data' => ['exists' => $exists],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
