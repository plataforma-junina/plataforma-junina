<?php

declare(strict_types=1);

namespace App\DTOs;

/**
 * @phpstan-type UserData array{
 *     name: string,
 *     email: string,
 *     password: string
 * }
 */
final readonly class UserDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password
    ) {
        //
    }

    /**
     * @param  UserData  $data
     */
    public static function from(array $data): self
    {
        return new self(
            $data['name'],
            $data['email'],
            $data['password']
        );
    }
}
