<?php

declare(strict_types=1);

use App\Models\User;

test('subscribe screen can be rendered', function () {
    $response = $this->get('/subscribe');

    $response->assertOk();
});

test('new users can subscribe', function () {
    $response = $this->post('/subscribe', [
        'name' => 'Test User',
        'acronym' => 'TU',
        'email' => 'test@example.com',
        'foundation_date' => '2022-01-01',
        'password' => 'P@ssw0rd!2025',
        'password_confirmation' => 'P@ssw0rd!2025',
        'state' => 'CE',
        'city' => 'Fortaleza',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));

    $this->assertDatabaseHas('users', [
        'type' => 'tenant',
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);

    $this->assertDatabaseHas('tenants', [
        'owner_id' => User::first()->id,
        'name' => 'Test User',
        'acronym' => 'TU',
        'foundation_date' => '2022-01-01',
        'state' => 'CE',
        'city' => 'Fortaleza',
    ]);
});
