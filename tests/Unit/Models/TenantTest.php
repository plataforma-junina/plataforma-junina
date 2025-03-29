<?php

declare(strict_types=1);

use App\Enums\SubscriptionStatus;
use App\Models\Subscription;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\QueryException;

describe('Model Structure', function () {
    test('to array', function () {
        $tenant = Tenant::factory()->create()->refresh();

        expect(array_keys($tenant->toArray()))
            ->toBe([
                'id',
                'owner_id',
                'name',
                'email',
                'avatar',
                'foundation_date',
                'state',
                'city',
                'created_at',
                'updated_at',
            ]);
    });

    test('casts', function () {
        $tenant = new Tenant();

        expect($tenant->getCasts())
            ->toBe([
                'id' => 'int',
                'owner_id' => 'int',
                'foundation_date' => 'date',
            ]);
    });
});

describe('Database Constraints', function () {
    test('owner_id has unique', function () {
        $user = User::factory()->create();

        Tenant::factory()->count(2)->create(['owner_id' => $user->id]);
    })->throws(QueryException::class);

    test('email has unique', function () {
        Tenant::factory()->count(2)->create(['email' => 'email@example.com']);
    })->throws(QueryException::class);
});

describe('Relationships', function () {
    test('belongsTo User as owner', function () {
        $user = User::factory()->create();
        $tenant = Tenant::factory()->create([
            'owner_id' => $user->id,
        ]);

        expect($tenant->owner)
            ->not()->toBeNull()
            ->toBeInstanceOf(User::class)
            ->and($tenant->owner->id)->toBe($user->id);
    });

    test('hasMany Subscription', function () {
        $tenant = Tenant::factory()->create();

        $expiredSubscription = Subscription::factory()->create([
            'tenant_id' => $tenant->id,
            'status' => SubscriptionStatus::Expired,
            'starts_at' => now()->subYear(),
            'ends_at' => now()->subDay(),
        ]);

        $activeSubscription = Subscription::factory()->create([
            'tenant_id' => $tenant->id,
            'status' => SubscriptionStatus::Active,
            'starts_at' => now(),
            'ends_at' => now()->addYear(),
        ]);

        expect($tenant->subscriptions)
            ->not()->toBeEmpty()
            ->toHaveCount(2);

        expect($tenant->subscriptions)
            ->each->toBeInstanceOf(Subscription::class);

        expect($tenant->subscriptions->pluck('id'))
            ->toContain($expiredSubscription->id, $activeSubscription->id);
    });
});
