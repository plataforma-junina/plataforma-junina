<?php

declare(strict_types=1);

use App\Enums\UserType;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\QueryException;

test('to array', function () {
    $user = User::factory()->create()->refresh();

    expect(array_keys($user->toArray()))
        ->toBe([
            'id',
            'name',
            'type',
            'email',
            'email_verified_at',
            'avatar',
            'created_at',
            'updated_at',
        ]);
});

test('user has ownedTenant', function () {
    $user = User::factory()
        ->has(Tenant::factory(), 'ownedTenant')
        ->create(['type' => UserType::Tenant]);

    expect($user->ownedTenant)->toBeInstanceOf(Tenant::class);
});

test('user cannot have multiple tenants', function () {
    User::factory()
        ->has(Tenant::factory()->count(2), 'ownedTenant')
        ->create(['type' => UserType::Tenant]);
})->throws(QueryException::class);
