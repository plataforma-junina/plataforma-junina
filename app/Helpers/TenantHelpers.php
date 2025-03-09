<?php

declare(strict_types=1);

use App\Models\Tenant;
use App\Models\User;

if (! function_exists('currentTenant')) {
    function currentTenant(): Tenant
    {
        $user = type(auth()->user())->as(User::class);

        return type($user->currentTenant)->as(Tenant::class);
    }
}
