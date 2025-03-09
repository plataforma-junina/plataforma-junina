<?php

declare(strict_types=1);

use App\Models\Permission;
use App\Models\PermissionGroup;
use Illuminate\Database\Eloquent\Relations\HasMany;

test('to array', function () {
    $permissionGroup = PermissionGroup::factory()->create()->refresh();

    expect(array_keys($permissionGroup->toArray()))
        ->toBe([
            'id',
            'name',
            'created_at',
            'updated_at',
        ]);
});

test('has many permissions', function () {
    $permissionGroup = PermissionGroup::factory()
        ->has(Permission::factory()->count(2))
        ->create();

    expect($permissionGroup->permissions())->toBeInstanceOf(HasMany::class)
        ->and($permissionGroup->permissions)->toHaveCount(2)
        ->each->toBeInstanceOf(Permission::class);
});
