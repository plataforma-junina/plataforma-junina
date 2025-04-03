<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Inertia\Testing\AssertableInertia;

test('reset password screen can be rendered with token and email', function (): void {
    $user = User::factory()->create();

    $token = Password::createToken($user);

    $response = $this->get(route('password.reset', ['token' => $token]));

    $response->assertInertia(
        fn (AssertableInertia $page) => $page
            ->component('auth/reset-password')
            ->has('token')
    );
});

test('password can be reset with valid token', function (): void {
    Event::fake();

    $user = User::factory()->create();

    $token = Password::createToken($user);

    $response = $this->post(route('password.store'), [
        'token' => $token,
        'email' => $user->email,
        'password' => 'NewP@ssw0rd!X9$',
        'password_confirmation' => 'NewP@ssw0rd!X9$',
    ]);

    Event::assertDispatched(PasswordReset::class);

    $response->assertRedirect(route('login'));
    $response->assertSessionHas('status');

    expect(Hash::check('NewP@ssw0rd!X9$', $user->fresh()->password))->toBeTrue();
});

test('password reset fails with invalid token', function (): void {
    Event::fake();

    $user = User::factory()->create();

    $response = $this->post(route('password.store'), [
        'token' => 'invalid-token',
        'email' => $user->email,
        'password' => 'NewP@ssw0rd!X9$',
        'password_confirmation' => 'NewP@ssw0rd!X9$',
    ]);

    Event::assertNotDispatched(PasswordReset::class);

    $response->assertSessionHasErrors('email');
});
