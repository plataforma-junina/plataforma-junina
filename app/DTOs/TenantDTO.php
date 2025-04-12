<?php

declare(strict_types=1);

namespace App\DTOs;

use Carbon\CarbonImmutable;

/**
 * @phpstan-type TenantData array{
 *     name: string,
 *     email: string,
 *     foundation_date: string,
 *     state: string,
 *     city: string
 * }
 */
final readonly class TenantDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public CarbonImmutable $foundationDate,
        public string $state,
        public string $city
    ) {
        //
    }

    /**
     * @param  TenantData  $data
     */
    public static function from(array $data): self
    {
        return new self(
            $data['name'],
            $data['email'],
            CarbonImmutable::parse($data['foundation_date']),
            $data['state'],
            $data['city']
        );
    }
}
