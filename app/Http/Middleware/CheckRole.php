<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     * @param  string|null  $guard
     */
    public function handle(Request $request, Closure $next, string $role, ?string $guard = null): Response
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

        // Parse multiple roles (separated by |)
        $roles = explode('|', $role);

        // Check if user has any of the required roles
        if (!$user->hasAnyRole($roles)) {
            // Log unauthorized access attempt
            Log::warning('Unauthorized role access attempt', [
                'user_id' => $user->id,
                'email' => $user->email,
                'required_roles' => $roles,
                'user_roles' => $user->roles->pluck('name')->toArray(),
                'route' => $request->path(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return $this->handleUnauthorized($request, 'Insufficient role privileges');
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
}
