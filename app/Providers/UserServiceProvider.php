<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\RBAC\Application\Services\PermissionService;
use Modules\RBAC\Application\Services\RoleService;
use Modules\RBAC\Domain\Interfaces\PermissionRepositoryInterface;
use Modules\RBAC\Domain\Interfaces\RoleRepositoryInterface;
use Modules\RBAC\Infrastructure\Repositories\EloquentPermissionRepository;
use Modules\RBAC\Infrastructure\Repositories\EloquentRoleRepository;
use Modules\User\Application\Services\UserService;
use Modules\User\Domain\Interfaces\UserRepositoryInterface;
use Modules\User\Infrastructure\Repositories\EloquentUserRepository;

final class UserServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind repositories
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, EloquentRoleRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, EloquentPermissionRepository::class);

        // Register services as singletons
        $this->app->singleton(UserService::class);
        $this->app->singleton(RoleService::class);
        $this->app->singleton(PermissionService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // You can add any event listeners, observers, etc. here later
    }
}
