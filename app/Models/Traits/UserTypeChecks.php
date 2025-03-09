<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Enums\UserType;

trait UserTypeChecks
{
    public function isTenant(): bool
    {
        return $this->type === UserType::Tenant;
    }

    public function isGroup(): bool
    {
        return $this->type === UserType::Group;
    }

    public function isGuest(): bool
    {
        return $this->type === UserType::Guest;
    }

    public function isType(UserType $type): bool
    {
        return $this->type === $type;
    }
}
