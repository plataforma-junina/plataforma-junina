<?php

declare(strict_types=1);

use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Team;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

test('to array', function () {
    $permission = Permission::factory()->create()->refresh();

    expect(array_keys($permission->toArray()))
        ->toBe([
            'id',
            'permission_group_id',
            'name',
            'created_at',
            'updated_at',
        ]);
});

test('belongs to permission groups', function () {
    $permission = Permission::factory()
        ->for(PermissionGroup::factory())
        ->create();

    expect($permission->permissionGroup())->toBeInstanceOf(BelongsTo::class)
        ->and($permission->permissionGroup)->toBeInstanceOf(PermissionGroup::class);
});

test('belongs to many teams', function () {
    $permission = Permission::factory()
        ->has(Team::factory()->count(2))
        ->create();

    expect($permission->teams())->toBeInstanceOf(BelongsToMany::class)
        ->and($permission->teams)->toHaveCount(2)
        ->each->toBeInstanceOf(Team::class);
});
