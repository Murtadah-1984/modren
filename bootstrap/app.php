<?php

declare(strict_types=1);

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Modules\RBAC\Interface\Http\Middleware\CheckPermission;
use Modules\RBAC\Interface\Http\Middleware\CheckRole;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api(prepend: [
            Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            Illuminate\Routing\Middleware\SubstituteBindings::class,
            Illuminate\Http\Middleware\HandleCors::class,
        ]);

        $middleware->alias([
            'verified' => \Modules\Auth\Interface\Http\Middleware\EnsureEmailIsVerified::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'api/*',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Global Middleware
        |--------------------------------------------------------------------------
        | Only keep essential global middleware (e.g., CORS, maintenance mode, etc.)
        | Custom access-control middleware should NOT be global.
        */
        // Example: $middleware->append(HandleCors::class);

        /*
        |--------------------------------------------------------------------------
        | Route Middleware Aliases
        |--------------------------------------------------------------------------
        | Register your custom and Spatie permission/role middleware here.
        | Use them by name in routes, e.g. ->middleware('role:admin')
        |--------------------------------------------------------------------------
        */
        $middleware->alias([
            // Custom middleware
            'checkRole' => CheckRole::class,
            'checkPermission' => CheckPermission::class,

            // Spatie permission middlewares
            'permission' => PermissionMiddleware::class,
            'role' => RoleMiddleware::class,
            'roleOrPermission' => RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Custom exception handling if needed
    })
    ->create();
