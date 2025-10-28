<?php

declare(strict_types=1);

namespace App\Exceptions\Core;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\Core\Domain\Exceptions\Access\BulkAccessOperationException;
use Modules\Core\Domain\Exceptions\Access\CacheException;
use Modules\Core\Domain\Exceptions\Access\SyncException;
use Modules\Core\Domain\Exceptions\Access\UnauthorizedAccessException;
use Modules\RBAC\Domain\Exceptions\Permissions\GuardNotFoundException;
use Modules\RBAC\Domain\Exceptions\Permissions\InvalidPermissionDataException;
use Modules\RBAC\Domain\Exceptions\Permissions\PermissionAlreadyExistsException;
use Modules\RBAC\Domain\Exceptions\Permissions\PermissionAssignmentException;
use Modules\RBAC\Domain\Exceptions\Permissions\PermissionDeletionException;
use Modules\RBAC\Domain\Exceptions\Permissions\PermissionDependencyException;
use Modules\RBAC\Domain\Exceptions\Permissions\PermissionGroupException;
use Modules\RBAC\Domain\Exceptions\Permissions\PermissionNotFoundException;
use Modules\RBAC\Domain\Exceptions\Permissions\SystemPermissionException;
use Modules\RBAC\Domain\Exceptions\Roles\InvalidRoleDataException;
use Modules\RBAC\Domain\Exceptions\Roles\RoleAlreadyExistsException;
use Modules\RBAC\Domain\Exceptions\Roles\RoleAssignmentException;
use Modules\RBAC\Domain\Exceptions\Roles\RoleDeletionException;
use Modules\RBAC\Domain\Exceptions\Roles\RoleHierarchyException;
use Modules\RBAC\Domain\Exceptions\Roles\RoleNotFoundException;
use Modules\RBAC\Domain\Exceptions\Roles\SystemRoleException;
use Modules\User\Domain\Exceptions\AvatarUploadException;
use Modules\User\Domain\Exceptions\BulkOperationException;
use Modules\User\Domain\Exceptions\InvalidEmailException;
use Modules\User\Domain\Exceptions\InvalidPasswordException;
use Modules\User\Domain\Exceptions\InvalidUserDataException;
use Modules\User\Domain\Exceptions\ProfileNotFoundException;
use Modules\User\Domain\Exceptions\ProfileUpdateException;
use Modules\User\Domain\Exceptions\UserAlreadyExistsException;
use Modules\User\Domain\Exceptions\UserDeletionException;
use Modules\User\Domain\Exceptions\UserInactiveException;
use Modules\User\Domain\Exceptions\UserNotFoundException;
use Modules\User\Domain\Exceptions\UserNotVerifiedException;
use Modules\User\Domain\Exceptions\UserPermissionException;
use Modules\User\Domain\Exceptions\UserRoleException;
use Throwable;

/**
 * Custom Exception Handler for DDD Modules
 *
 * Add this to your app/Exceptions/Handler.php or create a separate handler
 */
final class DomainExceptionHandler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     */
    protected $levels = [
        UserNotFoundException::class => 'info',
        RoleNotFoundException::class => 'info',
        PermissionNotFoundException::class => 'info',
    ];

    /**
     * A list of the exception types that are not reported.
     */
    protected $dontReport = [
        UserNotFoundException::class,
        RoleNotFoundException::class,
        PermissionNotFoundException::class,
        InvalidUserDataException::class,
        InvalidRoleDataException::class,
        InvalidPermissionDataException::class,
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        // User Exceptions
        $this->renderable(function (UserNotFoundException $e, Request $request) {
            return $this->handleDomainException($e, $request, 'User not found');
        });

        $this->renderable(function (UserAlreadyExistsException $e, Request $request) {
            return $this->handleDomainException($e, $request, 'User already exists');
        });

        $this->renderable(function (InvalidUserDataException $e, Request $request) {
            return $this->handleDomainException($e, $request, 'Invalid user data');
        });

        $this->renderable(function (UserInactiveException $e, Request $request) {
            return $this->handleDomainException($e, $request, 'User account is inactive');
        });

        $this->renderable(function (UserNotVerifiedException $e, Request $request) {
            return $this->handleDomainException($e, $request, 'User email not verified');
        });

        $this->renderable(function (UserDeletionException $e, Request $request) {
            return $this->handleDomainException($e, $request, 'Cannot delete user');
        });

        $this->renderable(function (InvalidPasswordException $e, Request $request) {
            return $this->handleDomainException($e, $request, 'Invalid password');
        });

        $this->renderable(function (InvalidEmailException $e, Request $request) {
            return $this->handleDomainException($e, $request, 'Invalid email');
        });

        $this->renderable(function (ProfileNotFoundException $e, Request $request) {
            return $this->handleDomainException($e, $request, 'Profile not found');
        });

        $this->renderable(function (ProfileUpdateException $e, Request $request) {
            return $this->handleDomainException($e, $request, 'Profile update failed');
        });

        $this->renderable(function (AvatarUploadException $e, Request $request) {
            return $this->handleDomainException($e, $request, 'Avatar upload failed');
        });

        $this->renderable(function (UserPermissionException $e, Request $request) {
            return $this->handleDomainException($e, $request, 'Permission error');
        });

        $this->renderable(function (UserRoleException $e, Request $request) {
            return $this->handleDomainException($e, $request, 'Role error');
        });

        $this->renderable(function (BulkOperationException $e, Request $request) {
            return $this->handleBulkOperationException($e, $request);
        });

        // Role Exceptions
        $this->renderable(function (RoleNotFoundException $e, Request $request) {
            return $this->handleDomainException($e, $request, 'Role not found');
        });

        $this->renderable(function (RoleAlreadyExistsException $e, Request $request) {
            return $this->handleDomainException($e, $request, 'Role already exists');
        });

        $this->renderable(function (InvalidRoleDataException $e, Request $request) {
            return $this->handleDomainException($e, $request, 'Invalid role data');
        });

        $this->renderable(function (SystemRoleException $e, Request $request) {
            return $this->handleDomainException($e, $request, 'System role cannot be modified');
        });

        $this->renderable(function (RoleDeletionException $e, Request $request) {
            return $this->handleDomainException($e, $request, 'Cannot delete role');
        });

        $this->renderable(function (RoleAssignmentException $e, Request $request) {
            return $this->handleDomainException($e, $request, 'Cannot assign role');
        });

        $this->renderable(function (RoleHierarchyException $e, Request $request) {
            return $this->handleDomainException($e, $request, 'Role hierarchy violation');
        });

        // Permission Exceptions
        $this->renderable(function (PermissionNotFoundException $e, Request $request) {
            return $this->handleDomainException($e, $request, 'Permission not found');
        });

        $this->renderable(function (PermissionAlreadyExistsException $e, Request $request) {
            return $this->handleDomainException($e, $request, 'Permission already exists');
        });

        $this->renderable(function (InvalidPermissionDataException $e, Request $request) {
            return $this->handleDomainException($e, $request, 'Invalid permission data');
        });

        $this->renderable(function (SystemPermissionException $e, Request $request) {
            return $this->handleDomainException($e, $request, 'System permission cannot be modified');
        });

        $this->renderable(function (PermissionDeletionException $e, Request $request) {
            return $this->handleDomainException($e, $request, 'Cannot delete permission');
        });

        $this->renderable(function (PermissionAssignmentException $e, Request $request) {
            return $this->handleDomainException($e, $request, 'Cannot assign permission');
        });

        $this->renderable(function (PermissionGroupException $e, Request $request) {
            return $this->handleDomainException($e, $request, 'Permission group error');
        });

        $this->renderable(function (PermissionDependencyException $e, Request $request) {
            return $this->handleDomainException($e, $request, 'Permission dependency error');
        });

        // General Access Exceptions
        $this->renderable(function (GuardNotFoundException $e, Request $request) {
            return $this->handleDomainException($e, $request, 'Guard not found');
        });

        $this->renderable(function (UnauthorizedAccessException $e, Request $request) {
            return $this->handleDomainException($e, $request, 'Unauthorized access');
        });

        $this->renderable(function (CacheException $e, Request $request) {
            return $this->handleDomainException($e, $request, 'Cache operation failed');
        });

        $this->renderable(function (BulkAccessOperationException $e, Request $request) {
            return $this->handleBulkAccessOperationException($e, $request);
        });

        $this->renderable(function (SyncException $e, Request $request) {
            return $this->handleDomainException($e, $request, 'Sync operation failed');
        });
    }

    /**
     * Handle domain exceptions
     */
    protected function handleDomainException(
        Throwable $exception,
        Request $request,
        string $defaultMessage
    ): JsonResponse {
        $statusCode = $exception->getCode() ?: 500;

        // Ensure valid HTTP status code
        if ($statusCode < 100 || $statusCode > 599) {
            $statusCode = 500;
        }

        $response = [
            'success' => false,
            'error' => [
                'type' => class_basename($exception),
                'message' => $exception->getMessage() ?: $defaultMessage,
                'code' => $statusCode,
            ],
        ];

        // Add additional context in debug mode
        if (config('app.debug')) {
            $response['error']['file'] = $exception->getFile();
            $response['error']['line'] = $exception->getLine();
            $response['error']['trace'] = $exception->getTraceAsString();
        }

        // Log the exception
        if ($statusCode >= 500) {
            Log::error($exception->getMessage(), [
                'exception' => get_class($exception),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]);
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Handle bulk operation exceptions
     */
    protected function handleBulkOperationException(
        BulkOperationException $exception,
        Request $request
    ): JsonResponse {
        $response = [
            'success' => false,
            'error' => [
                'type' => 'BulkOperationException',
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
                'failed_ids' => $exception->getFailedIds(),
            ],
        ];

        return response()->json($response, $exception->getCode());
    }

    /**
     * Handle bulk access operation exceptions
     */
    protected function handleBulkAccessOperationException(
        BulkAccessOperationException $exception,
        Request $request
    ): JsonResponse {
        $response = [
            'success' => false,
            'error' => [
                'type' => 'BulkAccessOperationException',
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
                'failed_items' => $exception->getFailedItems(),
            ],
        ];

        return response()->json($response, $exception->getCode());
    }

    /**
     * Convert exception to array for logging
     */
    protected function convertExceptionToArray(Throwable $e): array
    {
        return config('app.debug') ? [
            'message' => $e->getMessage(),
            'exception' => get_class($e),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => collect($e->getTrace())->map(function ($trace) {
                return array_except($trace, ['args']);
            })->all(),
        ] : [
            'message' => $this->isHttpException($e) ? $e->getMessage() : 'Server Error',
        ];
    }
}

/**
 * Helper trait for controllers to handle exceptions consistently
 */
trait HandlesExceptions
{
    /**
     * Return success response
     */
    protected function successResponse(
        $data = null,
        string $message = 'Operation successful',
        int $code = 200
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * Return error response
     */
    protected function errorResponse(
        string $message = 'Operation failed',
        int $code = 400,
        $errors = null
    ): JsonResponse {
        $response = [
            'success' => false,
            'error' => [
                'message' => $message,
                'code' => $code,
            ],
        ];

        if ($errors) {
            $response['error']['details'] = $errors;
        }

        return response()->json($response, $code);
    }

    /**
     * Return validation error response
     */
    protected function validationErrorResponse(array $errors): JsonResponse
    {
        return response()->json([
            'success' => false,
            'error' => [
                'message' => 'Validation failed',
                'code' => 422,
                'details' => $errors,
            ],
        ], 422);
    }

    /**
     * Return not found response
     */
    protected function notFoundResponse(string $message = 'Resource not found'): JsonResponse
    {
        return $this->errorResponse($message, 404);
    }

    /**
     * Return unauthorized response
     */
    protected function unauthorizedResponse(string $message = 'Unauthorized'): JsonResponse
    {
        return $this->errorResponse($message, 401);
    }

    /**
     * Return forbidden response
     */
    protected function forbiddenResponse(string $message = 'Forbidden'): JsonResponse
    {
        return $this->errorResponse($message, 403);
    }
}
