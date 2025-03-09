<?php

declare(strict_types=1);

namespace App\Http\Controllers\Teams;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teams\StoreTeamRequest;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

final class TeamController extends Controller
{
    public function index(): Response
    {
        $tenant = currentTenant();

        $teams = $tenant->teams()->with('permissions')->get()->map(fn (Team $team): array => [
            'id' => $team->id,
            'name' => $team->name,
            'description' => $team->description,
            'permissions' => $team->permissions->map(fn (Permission $permission): array => [
                'value' => $permission->name->value,
                'label' => $permission->name->label(),
                'description' => $permission->name->description(),
            ]),
        ]);

        return Inertia::render('teams/index', [
            'teams' => $teams,
        ]);
    }

    public function create(): Response
    {
        $permissionGroups = PermissionGroup::with('permissions')->get()->map(fn (PermissionGroup $group): array => [
            'value' => $group->name->value,
            'label' => $group->name->label(),
            'permissions' => $group->permissions->map(fn (Permission $permission): array => [
                'value' => $permission->name->value,
                'label' => $permission->name->label(),
                'description' => $permission->name->description(),
            ]),
        ]);

        return Inertia::render('teams/create', [
            'permissionGroups' => $permissionGroups,
        ]);
    }

    public function store(StoreTeamRequest $request): RedirectResponse
    {
        return DB::transaction(function () use ($request) {
            $tenant = currentTenant();

            $team = $tenant->teams()->create([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            if ($request->permissions) {
                /** @var array<string> $permissions */
                $permissions = type($request->permissions)->asArray();

                foreach ($permissions as $permission) {
                    $team->givePermissionTo($permission);
                }
            }

            return to_route('teams.index');
        });
    }
}
