<?php

declare(strict_types=1);

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\QueryException;

describe('Model Structure', function () {
    test('to array', function () {
        $user = User::factory()->create()->refresh();

        expect(array_keys($user->toArray()))
            ->toBe([
                'id',
                'name',
                'email',
                'email_verified_at',
                'created_at',
                'updated_at',
            ]);
    });

    test('hidden', function () {
        $user = new User();

        expect($user->getHidden())
            ->toBe([
                'password',
                'remember_token',
            ]);
    });

    test('casts', function () {
        $user = new User();

        expect($user->getCasts())
            ->toBe([
                'id' => 'int',
                'email_verified_at' => 'datetime',
                'password' => 'hashed',
            ]);
    });
});

describe('Database Constraints', function () {
    test('email has unique', function () {
        User::factory()->count(2)->create(['email' => 'email@example.com']);
    })->throws(QueryException::class);
});

describe('Relationships', function () {
    test('hasOne Tenant as ownedTenant', function () {
        $user = User::factory()->create();
        $tenant = Tenant::factory()->create(['owner_id' => $user->id]);

        expect($user->ownedTenant)->toBeInstanceOf(Tenant::class)
            ->and($user->ownedTenant->id)->toBe($tenant->id);
    });
});
