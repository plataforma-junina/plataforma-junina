<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\UserType;
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
        $user = User::query()->where('type', UserType::Tenant)->first();
        $tenant = Tenant::factory()->create([
            'owner_id' => $user->id,
            'name' => 'Test Tenant',
        ]);

        $user->update(['current_tenant_id' => $tenant->id]);
    }
}
