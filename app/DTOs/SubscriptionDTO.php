<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enums\SubscriptionPlan;

/**
 * @phpstan-import-type TenantData from TenantDTO
 * @phpstan-import-type UserData from UserDTO
 *
 * @phpstan-type SubscriptionData array{
 *     plan: string,
 *     tenant: TenantData,
 *     owner: UserData
 * }
 */
final readonly class SubscriptionDTO
{
    public function __construct(
        public SubscriptionPlan $plan,
        public TenantDTO $tenant,
        public UserDTO $owner
    ) {
        //
    }

    /**
     * @param  SubscriptionData  $data
     */
    public static function from(array $data): self
    {
        return new self(
            SubscriptionPlan::from($data['plan']),
            TenantDTO::from($data['tenant']),
            UserDTO::from($data['owner'])
        );
    }
}
