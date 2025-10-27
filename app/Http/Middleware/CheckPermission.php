<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $permission
     * @param  string|null  $guard
     */
    public function handle(Request $request, Closure $next, string $permission, ?string $guard = null): Response
    {
        $authGuard = app('auth')->guard($guard);

        if ($authGuard->guest()) {
            return $this->handleUnauthorized($request, 'User not authenticated');
        }

        $user = $authGuard->user();

        // Check if user is active
        if (method_exists($user, 'isActive') && !$user->isActive()) {
            return $this->handleUnauthorized($request, 'User account is inactive');
        }

        // Super admin bypass
        if ($user->hasRole('super-admin')) {
            return $next($request);
        }

        // Check permission
        if (!$user->hasPermissionTo($permission)) {
            // Log unauthorized access attempt
            Log::warning('Unauthorized access attempt', [
                'user_id' => $user->id,
                'email' => $user->email,
                'permission' => $permission,
                'route' => $request->path(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return $this->handleUnauthorized($request, 'Insufficient permissions');
        }

        // Log successful permission check for sensitive operations
        if ($this->isSensitivePermission($permission)) {
            Log::info('Sensitive permission accessed', [
                'user_id' => $user->id,
                'permission' => $permission,
                'route' => $request->path(),
                'ip' => $request->ip(),
            ]);
        }

        return $next($request);
    }

    /**
     * Handle unauthorized access
     *
     * @param Request $request
     * @param string $message
     * @return Response
     */
    protected function handleUnauthorized(Request $request, string $message): Response
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
                'error' => 'Unauthorized'
            ], 403);
        }

        abort(403, $message);
    }

    /**
     * Check if permission is sensitive and requires logging
     *
     * @param string $permission
     * @return bool
     */
    protected function isSensitivePermission(string $permission): bool
    {
        $sensitivePermissions = [
            'users.delete',
            'users.force-delete',
            'roles.delete',
            'permissions.delete',
            'settings.edit',
        ];

        return in_array($permission, $sensitivePermissions);
    }
}
