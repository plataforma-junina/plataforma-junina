<?php

declare(strict_types=1);

use App\Enums\UserType;
use App\Models\Tenant;
use App\Models\User;

test('to array', function () {
    $tenant = Tenant::factory()->create()->refresh();

    expect(array_keys($tenant->toArray()))
        ->toBe([
            'id',
            'owner_id',
            'name',
            'acronym',
            'email',
            'foundation_date',
            'state',
            'city',
            'created_at',
            'updated_at',
        ]);
});

test('tenant has owner', function () {
    $tenant = Tenant::factory()
        ->for(User::factory(['type' => UserType::Tenant]), 'owner')
        ->create();

    expect($tenant->owner)->toBeInstanceOf(User::class);
});
