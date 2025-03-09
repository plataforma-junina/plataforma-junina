<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\TeamPermission;
use App\Enums\TeamPermissionGroup;
use App\Models\Permission;
use App\Models\PermissionGroup;
use Illuminate\Database\Seeder;

final class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (TeamPermissionGroup::cases() as $group) {
            $permissionGroup = PermissionGroup::query()->firstOrCreate([
                'name' => $group,
            ]);

            foreach (TeamPermission::cases() as $permission) {
                if ($permission->group() === $group) {
                    Permission::query()->firstOrCreate([
                        'permission_group_id' => $permissionGroup->id,
                        'name' => $permission,
                    ]);
                }
            }
        }
    }
}
