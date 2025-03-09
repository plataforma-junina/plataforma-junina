<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Enums\TeamPermission;
use App\Models\Permission;

trait HasPermissions
{
    public function givePermissionTo(TeamPermission|string $permission): void
    {
        $permissionValue = $this->resolvePermission($permission);

        if (! $this->hasPermissionTo($permissionValue)) {
            $permissionModel = Permission::firstOrCreate(['name' => $permissionValue]);
            $this->permissions()->attach($permissionModel);
        }
    }

    public function removePermissionTo(TeamPermission|string $permission): void
    {
        $permissionValue = $this->resolvePermission($permission);

        if ($this->hasPermissionTo($permissionValue)) {
            $permissionModel = Permission::where('name', $permissionValue)->first();
            $this->permissions()->detach($permissionModel);
        }
    }

    public function hasPermissionTo(TeamPermission|string $permission): bool
    {
        return $this->permissions()->where('name', $this->resolvePermission($permission))->exists();
    }

    protected function resolvePermission(TeamPermission|string $permission): string
    {
        return $permission instanceof TeamPermission ? $permission->value : $permission;
    }
}
