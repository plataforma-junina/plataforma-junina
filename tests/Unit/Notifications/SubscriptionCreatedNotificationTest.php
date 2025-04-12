<?php

declare(strict_types=1);

use App\Models\Subscription;
use App\Models\Tenant;
use App\Models\User;
use App\Notifications\SubscriptionCreatedNotification;

test('via', function () {
    $user = User::factory()->create();

    $tenant = Tenant::factory()->create(['owner_id' => $user->id]);
    $subscription = Subscription::factory()->create(['tenant_id' => $tenant->id]);

    $notification = new SubscriptionCreatedNotification($subscription);

    $channels = $notification->via($user);

    expect($channels)->toBeArray()
        ->and($channels)->toHaveCount(1)
        ->and($channels[0])->toBe('mail');
});

test('to mail', function () {
    $user = User::factory()->create();

    $tenant = Tenant::factory()->create(['owner_id' => $user->id]);
    $subscription = Subscription::factory()->create(['tenant_id' => $tenant->id]);

    $notification = new SubscriptionCreatedNotification($subscription);
    $mailMessage = $notification->toMail($user);

    $mailData = $mailMessage->toArray();

    expect($mailData['subject'])->toBe('Welcome to Our Service!')
        ->and($mailData['greeting'])->toBe("Hello {$user->name},")
        ->and($mailData['introLines'][0])->toBe('We are excited to welcome you to our service. Your account has been successfully created.')
        ->and($mailData['introLines'][1])->toBe('Your subscription has been created and is currently pending approval.')
        ->and($mailData['actionText'])->toBe('Login')
        ->and($mailData['actionUrl'])->toBe(url('/login'))
        ->and($mailData['outroLines'][0])->toBe('Thank you for choosing our service!');
});

test('to array', function () {
    $user = User::factory()->create();

    $tenant = Tenant::factory()->create(['owner_id' => $user->id]);
    $subscription = Subscription::factory()->create(['tenant_id' => $tenant->id]);

    $notification = new SubscriptionCreatedNotification($subscription);

    $arrayData = $notification->toArray($user);

    expect($arrayData)->toBeArray()
        ->and($arrayData)->toHaveCount(0);
});
