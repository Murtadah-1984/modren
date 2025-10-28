<?php

declare(strict_types=1);

namespace Database\Factories;

// database/factories/PermissionFactory.php
use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Permission\Models\Permission;

final class PermissionFactory extends Factory
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
