<?php

declare(strict_types=1);

use App\Enums\TeamPermission;
use App\Models\Team;
use Database\Seeders\PermissionSeeder;
use Inertia\Testing\AssertableInertia as Assert;

test('index screen can be rendered', function () {
    $this->seed(PermissionSeeder::class);

    asTenantUser();

    $team = Team::factory()->create(['tenant_id' => currentTenant()->id]);
    $team->givePermissionTo(TeamPermission::ViewAnyTeam);

    $response = $this->get('/teams');

    $response->assertStatus(200)
        ->assertInertia(fn (Assert $page) => $page
            ->component('teams/index')
            ->has('teams', 1, fn (Assert $page) => $page
                ->where('id', $team->id)
                ->where('name', $team->name)
                ->where('description', $team->description)
                ->has('permissions', 1, fn (Assert $page) => $page
                    ->where('value', TeamPermission::ViewAnyTeam->value)
                    ->where('label', TeamPermission::ViewAnyTeam->label())
                    ->where('description', TeamPermission::ViewAnyTeam->description())
                )
            )
        );
});
