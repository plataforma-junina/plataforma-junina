<?php

declare(strict_types=1);

use App\Enums\UserType;
use App\Models\Team;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

test('belongs to owner', function () {
    $tenant = Tenant::factory()
        ->for(User::factory(['type' => UserType::Tenant]), 'owner')
        ->create();

    expect($tenant->owner())->toBeInstanceOf(BelongsTo::class)
        ->and($tenant->owner)->toBeInstanceOf(User::class);
});

test('has many teams', function () {
    $tenant = Tenant::factory()
        ->has(Team::factory()->count(2))
        ->create();

    expect($tenant->teams())->toBeInstanceOf(HasMany::class)
        ->and($tenant->teams)->toHaveCount(2)
        ->each->toBeInstanceOf(Team::class);
});

test('has many users', function () {
    $tenant = Tenant::factory()
        ->has(User::factory()->count(2))
        ->create();

    expect($tenant->users())->toBeInstanceOf(HasMany::class)
        ->and($tenant->users)->toHaveCount(2)
        ->each->toBeInstanceOf(User::class);
});
