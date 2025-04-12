<?php

declare(strict_types=1);

use App\Events\SubscriptionCreated;
use App\Listeners\SendSubscriptionCreatedNotification;
use App\Models\Subscription;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Support\Facades\Event;

test('creates event with correct subscription', function () {
    $subscription = Subscription::factory()->create();

    $event = new SubscriptionCreated($subscription);

    expect($event->subscription)
        ->toBeInstanceOf(Subscription::class)
        ->toBe($subscription);
});

test('broadcasts on expected private channel', function () {
    $subscription = Subscription::factory()->create();

    $event = new SubscriptionCreated($subscription);

    $channels = $event->broadcastOn();

    expect($channels)->toBeArray()
        ->and($channels)->toHaveCount(1)
        ->and($channels[0])->toBeInstanceOf(PrivateChannel::class)
        ->and($channels[0]->name)->toBe('private-channel-name');
});

test('event has expected listeners', function () {
    Event::fake();

    Event::assertListening(
        SubscriptionCreated::class,
        SendSubscriptionCreatedNotification::class
    );
});
