<?php

declare(strict_types=1);

use App\Enums\TeamPermissionGroup;

test('team permission group label', function () {
    foreach (TeamPermissionGroup::cases() as $teamPermissionGroup) {
        expect($teamPermissionGroup->label())->toBe(trans("enums.team_permission_group.{$teamPermissionGroup->value}"));
    }
});
