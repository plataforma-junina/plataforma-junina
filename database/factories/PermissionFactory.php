<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\TeamPermission;
use App\Models\PermissionGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TeamPermission>
 */
final class PermissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'permission_group_id' => PermissionGroup::factory(),
            'name' => fake()->unique()->randomElement(TeamPermission::class),
        ];
    }
}
