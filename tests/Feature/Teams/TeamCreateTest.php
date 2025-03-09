<?php

declare(strict_types=1);

use App\Enums\TeamPermission;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Team;
use Database\Seeders\PermissionSeeder;
use Inertia\Testing\AssertableInertia as Assert;

test('create team screen can be rendered', function () {
    $this->seed(PermissionSeeder::class);

    $permissions = PermissionGroup::with('permissions')->get();

    $response = asTenantUser()
        ->get('/teams/create');

    $response->assertStatus(200)
        ->assertInertia(fn (Assert $page) => $page
            ->component('teams/create')
            ->has('permissionGroups', $permissions->count(), fn (Assert $page) => $page
                ->where('value', $permissions->first()->name->value)
                ->where('label', $permissions->first()->name->label())
                ->has('permissions', $permissions->first()->permissions->count(), fn (Assert $page) => $page
                    ->where('value', $permissions->first()->permissions->first()->name->value)
                    ->where('label', $permissions->first()->permissions->first()->name->label())
                    ->where('description', $permissions->first()->permissions->first()->name->description())
                )
            )
        );
});

test('new teams can be created', function () {
    $this->seed(PermissionSeeder::class);

    $permissions = [
        TeamPermission::ViewAnyTeam->value,
        TeamPermission::CreateTeam->value,
        TeamPermission::ViewTeam->value,
        TeamPermission::UpdateTeam->value,
        TeamPermission::DeleteTeam->value,
    ];

    $response = asTenantUser()
        ->post('/teams/create', [
            'name' => 'Test Team',
            'description' => 'Test Team Description',
            'permissions' => $permissions,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/teams');

    $this->assertDatabaseHas('teams', [
        'tenant_id' => currentTenant()->id,
        'name' => 'Test Team',
    ]);

    foreach ($permissions as $permission) {
        $this->assertDatabaseHas('permission_team', [
            'permission_id' => Permission::query()->where('name', $permission)->first()->id,
            'team_id' => Team::query()->first()->id,
        ]);
    }
});
