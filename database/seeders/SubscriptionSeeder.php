<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\SubscriptionPlan;
use App\Enums\SubscriptionStatus;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

final class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenant = Tenant::query()->first();

        $tenant->subscriptions()->create([
            'plan' => SubscriptionPlan::Free,
            'status' => SubscriptionStatus::Active,
            'starts_at' => now(),
            'ends_at' => now()->addYear(),
        ]);
    }
}
