<?php

declare(strict_types=1);

use App\Events\SubscriptionCreated;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;

test('subscription screen can be rendered', function () {
    $response = $this->get('/subscription');

    $response->assertStatus(200);
});

test('subscription route is correct', function () {
    $route = route('subscription.create', absolute: false);

    expect($route)->toBe('/subscription');
});

test('subscription can be created', function () {
    Event::fake();

    $response = $this->post(route('subscription.store'), [
        'plan' => 'free',
        'tenant' => [
            'name' => 'Tenant Name',
            'email' => 'tenant.name@example.com',
            'foundation_date' => '2022-01-01',
            'state' => 'CE',
            'city' => 'Fortaleza',
        ],
        'owner' => [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'P@ssw0rd!X9$',
            'password_confirmation' => 'P@ssw0rd!X9$',
        ],
    ]);

    $response->assertRedirect(route('login', absolute: false));

    Event::assertDispatched(Registered::class);
    Event::assertDispatched(SubscriptionCreated::class);

    $this->assertDatabaseCount('users', 1);
    $this->assertDatabaseCount('tenants', 1);
    $this->assertDatabaseCount('subscriptions', 1);

    $this->assertDatabaseHas('users', [
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
    ]);

    $this->assertDatabaseHas('tenants', [
        'owner_id' => User::query()->first()->id,
        'name' => 'Tenant Name',
        'email' => 'tenant.name@example.com',
        'foundation_date' => '2022-01-01 00:00:00',
        'state' => 'CE',
        'city' => 'Fortaleza',
    ]);

    $this->assertDatabaseHas('subscriptions', [
        'tenant_id' => Tenant::query()->first()->id,
        'plan' => 'free',
        'status' => 'active',
    ]);
});
