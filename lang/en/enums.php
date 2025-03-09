<?php

declare(strict_types=1);

return [
    'team_permission' => [
        'view_any_team' => [
            'label' => 'View Any Team',
            'description' => 'Allows viewing any team.',
        ],
        'create_team' => [
            'label' => 'Create Team',
            'description' => 'Allows creating a new team.',
        ],
        'view_team' => [
            'label' => 'View Team',
            'description' => 'Allows viewing a specific team.',
        ],
        'update_team' => [
            'label' => 'Update Team',
            'description' => 'Allows updating team information.',
        ],
        'delete_team' => [
            'label' => 'Delete Team',
            'description' => 'Allows deleting a team.',
        ],
        'view_any_member' => [
            'label' => 'View Any Member',
            'description' => 'Allows viewing any member.',
        ],
        'create_member' => [
            'label' => 'Create Member',
            'description' => 'Allows creating a new member.',
        ],
        'view_member' => [
            'label' => 'View Member',
        ],
        'update_member' => [
            'label' => 'Update Member',
            'description' => 'Allows updating member information.',
        ],
        'delete_member' => [
            'label' => 'Delete Member',
            'description' => 'Allows deleting a member.',
        ],
    ],
    'team_permission_group' => [
        'team_permissions' => 'Team Permissions',
        'member_permissions' => 'Member Permissions',
    ],
];
