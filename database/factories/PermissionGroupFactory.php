<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\TeamPermissionGroup;
use App\Models\PermissionGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PermissionGroup>
 */
final class PermissionGroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement(TeamPermissionGroup::class),
        ];
    }
}
