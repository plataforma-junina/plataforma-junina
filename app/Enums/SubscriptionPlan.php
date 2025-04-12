<?php

declare(strict_types=1);

namespace App\Enums;

enum SubscriptionPlan: string
{
    case Free = 'free';
    case Pro = 'pro';
}
