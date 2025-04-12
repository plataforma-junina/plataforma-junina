<?php

declare(strict_types=1);

use App\DTOs\TenantDTO;

it('returns an instance from an array', function () {
    $data = [
        'name' => 'Test Tenant',
        'email' => 'owner@tenant.com',
        'foundation_date' => '2022-01-01',
        'state' => 'CE',
        'city' => 'Fortaleza',
    ];

    $tenantDTO = TenantDTO::from($data);

    expect($tenantDTO->name)->toBe('Test Tenant')
        ->and($tenantDTO->email)->toBe('owner@tenant.com')
        ->and($tenantDTO->foundationDate->toDateString())->toBe('2022-01-01')
        ->and($tenantDTO->state)->toBe('CE')
        ->and($tenantDTO->city)->toBe('Fortaleza');
});
