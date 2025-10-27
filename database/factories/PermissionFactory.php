<?php

namespace Database\Factories;

// database/factories/PermissionFactory.php
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

class PermissionFactory extends Factory
{
    protected $model = Permission::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'guard_name' => 'web',
        ];
    }
}

