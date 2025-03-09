<?php

declare(strict_types=1);

use App\Enums\TeamPermission;
use App\Models\Permission;
use App\Models\Team;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

test('to array', function () {
    $team = Team::factory()->create()->refresh();

    expect(array_keys($team->toArray()))
        ->toBe([
            'id',
            'tenant_id',
            'name',
            'description',
            'created_at',
            'updated_at',
        ]);
});

test('belongs to tenant', function () {
    $team = Team::factory()
        ->for(Tenant::factory())
        ->create();

    expect($team->tenant())->toBeInstanceOf(BelongsTo::class)
        ->and($team->tenant)->toBeInstanceOf(Tenant::class);
});

test('belongs to many permissions', function () {
    $team = Team::factory()
        ->has(Permission::factory()->count(2))
        ->create();

    expect($team->permissions())->toBeInstanceOf(BelongsToMany::class)
        ->and($team->permissions)->toHaveCount(2)
        ->each->toBeInstanceOf(Permission::class);
});

test('has permission', function () {
    Permission::factory()->create(['name' => TeamPermission::ViewAnyTeam]);

    $team = Team::factory()->create();

    expect($team->hasPermissionTo(TeamPermission::ViewAnyTeam))->toBeFalse();

    $team->givePermissionTo(TeamPermission::ViewAnyTeam);

    expect($team->hasPermissionTo(TeamPermission::ViewAnyTeam))->toBeTrue();

    $team->removePermissionTo(TeamPermission::ViewAnyTeam);

    expect($team->hasPermissionTo(TeamPermission::ViewAnyTeam))->toBeFalse();
});
