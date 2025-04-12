<?php

declare(strict_types=1);

use App\Events\SubscriptionCreated;
use App\Listeners\SendSubscriptionCreatedNotification;
use App\Models\Subscription;
use App\Models\Tenant;
use App\Models\User;
use App\Notifications\SubscriptionCreatedNotification;
use Illuminate\Support\Facades\Notification;

test('subscription created notification is sent', function () {
    Notification::fake();

    $owner = User::factory()->create();
    $tenant = Tenant::factory()->create([
        'owner_id' => $owner->id,
    ]);
    $subscription = Subscription::factory()->create([
        'tenant_id' => $tenant->id,
    ]);

    $listener = new SendSubscriptionCreatedNotification();
    $listener->handle(new SubscriptionCreated($subscription));

    Notification::assertSentTo(
        $owner,
        SubscriptionCreatedNotification::class,
        function ($notification, $channels) use ($subscription) {
            return $notification->subscription->id === $subscription->id;
        }
    );
});
