<?php

declare(strict_types=1);

namespace App\Enums;

enum UserType: string
{
    case Tenant = 'tenant';
    case Group = 'group';
    case Guest = 'guest';
}
