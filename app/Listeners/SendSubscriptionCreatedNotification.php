<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\SubscriptionCreated;
use App\Notifications\SubscriptionCreatedNotification;

final class SendSubscriptionCreatedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SubscriptionCreated $event): void
    {
        $event->subscription->tenant->owner->notify(new SubscriptionCreatedNotification($event->subscription));
    }
}
