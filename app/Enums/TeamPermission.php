<?php

declare(strict_types=1);

namespace App\Enums;

enum TeamPermission: string
{
    case ViewAnyTeam = 'view_any_team';
    case CreateTeam = 'create_team';
    case ViewTeam = 'view_team';
    case UpdateTeam = 'update_team';
    case DeleteTeam = 'delete_team';
    case ViewAnyMember = 'view_any_member';
    case CreateMember = 'create_member';
    case ViewMember = 'view_member';
    case UpdateMember = 'update_member';
    case DeleteMember = 'delete_member';

    public function label(): string
    {
        return trans("enums.team_permission.{$this->value}.label");
    }

    public function description(): string
    {
        return trans("enums.team_permission.{$this->value}.description");
    }

    public function group(): TeamPermissionGroup
    {
        return match ($this) {
            self::ViewAnyTeam,
            self::CreateTeam,
            self::ViewTeam,
            self::UpdateTeam,
            self::DeleteTeam => TeamPermissionGroup::TeamPermissions,

            self::ViewAnyMember,
            self::CreateMember,
            self::ViewMember,
            self::UpdateMember,
            self::DeleteMember => TeamPermissionGroup::MemberPermissions,
        };
    }
}
