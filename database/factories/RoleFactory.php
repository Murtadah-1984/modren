<?php

namespace Database\Factories;

// database/factories/PermissionFactory.php
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
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
