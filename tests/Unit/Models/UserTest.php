<?php

declare(strict_types=1);

use App\Enums\UserType;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
            'current_tenant_id',
            'created_at',
            'updated_at',
        ]);
});

test('has one ownedTenant', function () {
    $user = User::factory()
        ->has(Tenant::factory(), 'ownedTenant')
        ->create(['type' => UserType::Tenant]);

    expect($user->ownedTenant())->toBeInstanceOf(HasOne::class)
        ->and($user->ownedTenant)->toBeInstanceOf(Tenant::class);
});

test('user cannot have multiple tenants', function () {
    User::factory()
        ->has(Tenant::factory()->count(2), 'ownedTenant')
        ->create(['type' => UserType::Tenant]);
})->throws(QueryException::class);

test('belongs to currentTenant', function () {
    $user = User::factory()->create(['type' => UserType::Tenant]);

    $tenant = Tenant::factory()->create(['owner_id' => $user->id]);

    $user->update(['current_tenant_id' => $tenant->id]);

    expect($user->currentTenant())->toBeInstanceOf(BelongsTo::class)
        ->and($user->currentTenant)->toBeInstanceOf(Tenant::class);
});

test('is tenant', function () {
    $user = User::factory()->create(['type' => UserType::Tenant]);

    expect($user->isTenant())->toBeTrue();
});

test('is not tenant', function () {
    $userGroup = User::factory()->create(['type' => UserType::Group]);
    $userGuest = User::factory()->create(['type' => UserType::Guest]);

    expect($userGroup->isTenant())->toBeFalse()
        ->and($userGuest->isTenant())->toBeFalse();
});

test('is group', function () {
    $user = User::factory()->create(['type' => UserType::Group]);

    expect($user->isGroup())->toBeTrue();
});

test('is not group', function () {
    $userTenant = User::factory()->create(['type' => UserType::Tenant]);
    $userGuest = User::factory()->create(['type' => UserType::Guest]);

    expect($userTenant->isGroup())->toBeFalse()
        ->and($userGuest->isGroup())->toBeFalse();
});

test('is guest', function () {
    $user = User::factory()->create(['type' => UserType::Guest]);

    expect($user->isGuest())->toBeTrue();
});

test('is not guest', function () {
    $userTenant = User::factory()->create(['type' => UserType::Tenant]);
    $userGroup = User::factory()->create(['type' => UserType::Group]);

    expect($userTenant->isGuest())->toBeFalse()
        ->and($userGroup->isGuest())->toBeFalse();
});

test('is type', function () {
    $userTenant = User::factory()->create(['type' => UserType::Tenant]);
    $userGroup = User::factory()->create(['type' => UserType::Group]);
    $userGuest = User::factory()->create(['type' => UserType::Guest]);

    expect($userTenant->isType(UserType::Tenant))->toBeTrue()
        ->and($userGroup->isType(UserType::Group))->toBeTrue()
        ->and($userGuest->isType(UserType::Guest))->toBeTrue();
});
