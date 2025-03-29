<?php

declare(strict_types=1);

use App\Enums\SubscriptionPlan;
use App\Enums\SubscriptionStatus;
use App\Models\Subscription;
use App\Models\Tenant;

describe('Model Structure', function () {
    test('to array', function () {
        $subscription = Subscription::factory()->create()->refresh();

        expect(array_keys($subscription->toArray()))
            ->toBe([
                'id',
                'tenant_id',
                'plan',
                'status',
                'starts_at',
                'ends_at',
                'canceled_at',
                'created_at',
                'updated_at',
            ]);
    });

    test('casts', function () {
        $subscription = new Subscription();

        expect($subscription->getCasts())
            ->toBe([
                'id' => 'int',
                'tenant_id' => 'int',
                'plan' => SubscriptionPlan::class,
                'status' => SubscriptionStatus::class,
                'starts_at' => 'datetime',
                'ends_at' => 'datetime',
                'canceled_at' => 'datetime',
            ]);
    });
});

describe('Relationships', function () {
    test('belongsTo Tenant', function () {
        $tenant = Tenant::factory()->create();
        $subscription = Subscription::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        expect($subscription->tenant)
            ->not()->toBeNull()
            ->toBeInstanceOf(Tenant::class)
            ->and($subscription->tenant->id)->toBe($tenant->id);
    });
});
