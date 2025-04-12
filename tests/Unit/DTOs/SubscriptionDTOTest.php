<?php

declare(strict_types=1);

use App\DTOs\SubscriptionDTO;

it('', function () {
    $data = [
        'plan' => 'free',
        'tenant' => [
            'name' => 'Test Tenant',
            'email' => 'owner@tenant.com',
            'foundation_date' => '2022-01-01',
            'state' => 'CE',
            'city' => 'Fortaleza',
        ],
        'owner' => [
            'name' => 'Test User',
            'email' => 'user@tenant.com',
            'password' => 'P@ssw0rd!X9$',
        ],
    ];

    $subscriptionDTO = SubscriptionDTO::from($data);

    expect($subscriptionDTO->plan->value)->toBe('free')
        ->and($subscriptionDTO->tenant->name)->toBe('Test Tenant')
        ->and($subscriptionDTO->tenant->email)->toBe('owner@tenant.com')
        ->and($subscriptionDTO->tenant->foundationDate->toDateString())->toBe('2022-01-01')
        ->and($subscriptionDTO->tenant->state)->toBe('CE')
        ->and($subscriptionDTO->tenant->city)->toBe('Fortaleza')
        ->and($subscriptionDTO->owner->name)->toBe('Test User')
        ->and($subscriptionDTO->owner->email)->toBe('user@tenant.com')
        ->and($subscriptionDTO->owner->password)->toBe('P@ssw0rd!X9$');
});
