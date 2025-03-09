<?php

declare(strict_types=1);

namespace App\Enums;

enum TeamPermissionGroup: string
{
    case TeamPermissions = 'team_permissions';
    case MemberPermissions = 'member_permissions';

    public function label(): string
    {
        return trans("enums.team_permission_group.{$this->value}");
    }
}
