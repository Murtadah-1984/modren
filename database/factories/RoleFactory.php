<?php

declare(strict_types=1);

namespace Database\Factories;

// database/factories/PermissionFactory.php
use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Permission\Models\Role;

final class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'guard_name' => 'web',
        ];
    }
}
