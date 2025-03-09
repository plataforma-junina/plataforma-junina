<?php

declare(strict_types=1);

use App\Enums\UserType;
use App\Models\Tenant;
use App\Models\User;

test('current tenant can be retrieved', function () {
    $user = User::factory()->create(['type' => UserType::Tenant]);

    $tenant = Tenant::factory()->create(['owner_id' => $user->id]);

    $user->update(['current_tenant_id' => $tenant->id]);

    auth()->login($user);

    expect($tenant->id)->toBe(currentTenant()->id);
});
