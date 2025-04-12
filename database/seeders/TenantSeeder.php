<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;

final class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Test Owner Tenant',
            'email' => 'owner@tenant.com',
        ]);

        Tenant::factory()->create([
            'owner_id' => $user->id,
            'name' => 'Test Tenant',
            'email' => 'owner@tenant.com',
            'foundation_date' => now(),
            'state' => 'CE',
            'city' => 'Fortaleza',
        ]);
    }
}
