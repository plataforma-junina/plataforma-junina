<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Inertia\Testing\AssertableInertia;

test('password settings page can be rendered', function (): void {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get(route('password.edit'));

    $response->assertInertia(
        fn (AssertableInertia $page) => $page
            ->component('settings/password')
            ->has('mustVerifyEmail')
            ->has('status')
    );
});

test('password can be updated with correct current password', function (): void {
    $user = User::factory()->create([
        'password' => Hash::make('current-password'),
    ]);

    $response = $this
        ->actingAs($user)
        ->put(route('password.update'), [
            'current_password' => 'current-password',
            'password' => 'NewP@ssw0rd!X9$',
            'password_confirmation' => 'NewP@ssw0rd!X9$',
        ]);

    $response->assertRedirect();
    expect(Hash::check('NewP@ssw0rd!X9$', $user->fresh()->password))->toBeTrue();
});

test('password cannot be updated with incorrect current password', function (): void {
    $user = User::factory()->create([
        'password' => Hash::make('current-password'),
    ]);

    $response = $this
        ->actingAs($user)
        ->put(route('password.update'), [
            'current_password' => 'wrong-password',
            'password' => 'NewP@ssw0rd!X9$',
            'password_confirmation' => 'NewP@ssw0rd!X9$',
        ]);

    $response->assertSessionHasErrors('current_password');
    expect(Hash::check('current-password', $user->fresh()->password))->toBeTrue();
});
