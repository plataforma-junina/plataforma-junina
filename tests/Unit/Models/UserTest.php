<?php

declare(strict_types=1);

use App\Models\User;

test('to array', function () {
    $user = User::factory()->create()->refresh();

    expect(array_keys($user->toArray()))
        ->toBe([
            'id',
            'name',
            'type',
            'email',
            'email_verified_at',
            'avatar',
            'created_at',
            'updated_at',
        ]);
});
