<?php

declare(strict_types=1);

use App\DTOs\UserDTO;

it('returns an instance from an array', function () {
    $data = [
        'name' => 'Test User',
        'email' => 'user@tenant.com',
        'password' => 'P@ssw0rd!X9$',
    ];

    $userDTO = UserDTO::from($data);

    expect($userDTO->name)->toBe('Test User')
        ->and($userDTO->email)->toBe('user@tenant.com')
        ->and($userDTO->password)->toBe('P@ssw0rd!X9$');
});
