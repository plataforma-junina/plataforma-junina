<?php

declare(strict_types=1);

use App\Enums\TeamPermission;
use App\Enums\TeamPermissionGroup;

test('team permission label', function () {
    foreach (TeamPermission::cases() as $teamPermission) {
        expect($teamPermission->label())->toBe(trans("enums.team_permission.{$teamPermission->value}.label"));
    }
});

test('team permission description', function () {
    foreach (TeamPermission::cases() as $teamPermission) {
        expect($teamPermission->description())->toBe(trans("enums.team_permission.{$teamPermission->value}.description"));
    }
});

test('all team permissions have a group', function () {
    foreach (TeamPermission::cases() as $permission) {
        expect($permission->group())->not->toBeNull()
            ->and($permission->group())->toBeInstanceOf(TeamPermissionGroup::class);
    }
});

test('team permission group', function () {
    $teamPermissions = [
        TeamPermission::ViewAnyTeam,
        TeamPermission::CreateTeam,
        TeamPermission::ViewTeam,
        TeamPermission::UpdateTeam,
        TeamPermission::DeleteTeam,
    ];

    foreach ($teamPermissions as $permission) {
        expect($permission->group())->toBe(TeamPermissionGroup::TeamPermissions);
    }

    $memberPermissions = [
        TeamPermission::ViewAnyMember,
        TeamPermission::CreateMember,
        TeamPermission::ViewMember,
        TeamPermission::UpdateMember,
        TeamPermission::DeleteMember,
    ];

    foreach ($memberPermissions as $permission) {
        expect($permission->group())->toBe(TeamPermissionGroup::MemberPermissions);
    }
});
