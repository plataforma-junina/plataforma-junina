<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tenant>
 */
final class TenantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ufs = [
            'AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF',
            'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA',
            'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS',
            'RO', 'RR', 'SC', 'SP', 'SE', 'TO',
        ];

        return [
            'owner_id' => User::factory(),
            'name' => fake()->company(),
            'acronym' => fake()->slug(),
            'email' => fake()->unique()->safeEmail(),
            'foundation_date' => fake()->date(),
            'state' => fake()->randomElement($ufs),
            'city' => fake()->city(),
        ];
    }
}
