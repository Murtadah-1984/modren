<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

final class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User Management
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            'users.restore',
            'users.force-delete',

            // Role Management
            'roles.view',
            'roles.create',
            'roles.edit',
            'roles.delete',

            // Permission Management
            'permissions.view',
            'permissions.create',
            'permissions.edit',
            'permissions.delete',

            // Dashboard
            'dashboard.view',
            'dashboard.analytics',

            // Reports
            'reports.view',
            'reports.create',
            'reports.export',
            'reports.delete',

            // Settings
            'settings.view',
            'settings.edit',

            // Activity Logs
            'activity-logs.view',
            'activity-logs.delete',

            // Posts (example resource)
            'posts.view',
            'posts.create',
            'posts.edit',
            'posts.delete',
            'posts.publish',

            // Comments (example resource)
            'comments.view',
            'comments.create',
            'comments.edit',
            'comments.delete',
            'comments.moderate',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions

        // Super Admin - Has all permissions
        $superAdmin = Role::create(['name' => 'super-admin']);
        $superAdmin->givePermissionTo(Permission::all());

        // Admin - Has most permissions except super admin specific ones
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo([
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            'roles.view',
            'dashboard.view',
            'dashboard.analytics',
            'reports.view',
            'reports.create',
            'reports.export',
            'settings.view',
            'settings.edit',
            'activity-logs.view',
            'posts.view',
            'posts.create',
            'posts.edit',
            'posts.delete',
            'posts.publish',
            'comments.view',
            'comments.create',
            'comments.edit',
            'comments.delete',
            'comments.moderate',
        ]);

        // Manager - Has moderate permissions
        $manager = Role::create(['name' => 'manager']);
        $manager->givePermissionTo([
            'users.view',
            'dashboard.view',
            'reports.view',
            'reports.create',
            'posts.view',
            'posts.create',
            'posts.edit',
            'comments.view',
            'comments.create',
            'comments.moderate',
        ]);

        // Editor - Content management permissions
        $editor = Role::create(['name' => 'editor']);
        $editor->givePermissionTo([
            'dashboard.view',
            'posts.view',
            'posts.create',
            'posts.edit',
            'posts.publish',
            'comments.view',
            'comments.moderate',
        ]);

        // Author - Can manage own content
        $author = Role::create(['name' => 'author']);
        $author->givePermissionTo([
            'dashboard.view',
            'posts.view',
            'posts.create',
            'posts.edit',
            'comments.view',
        ]);

        // User - Basic permissions
        $user = Role::create(['name' => 'user']);
        $user->givePermissionTo([
            'dashboard.view',
            'posts.view',
            'comments.view',
            'comments.create',
        ]);

        // Guest - Very limited permissions
        $guest = Role::create(['name' => 'guest']);
        $guest->givePermissionTo([
            'posts.view',
        ]);

        $this->command->info('Roles and permissions created successfully!');
        $this->command->info('Created roles: super-admin, admin, manager, editor, author, user, guest');
        $this->command->info('Total permissions: '.count($permissions));
    }
}
