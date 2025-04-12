<?php

declare(strict_types=1);

use App\Enums\SubscriptionPlan;
use App\Http\Requests\Auth\SubscriptionRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rules\Unique;

beforeEach(function () {
    $this->request = new SubscriptionRequest();
    $this->rules = $this->request->rules();
});

test('subscription request is authorized', function () {
    expect($this->request->authorize())->toBeTrue();
});

test('subscription request validates required fields', function () {
    expect($this->rules)->toHaveKeys([
        'plan',
        'tenant',
        'tenant.name',
        'tenant.email',
        'tenant.foundation_date',
        'tenant.state',
        'tenant.city',
        'owner',
        'owner.name',
        'owner.email',
        'owner.password',
    ]);
});

describe('subscription request validates', function () {
    test('plan', function () {
        expect($this->rules['plan'])->toContain('required', 'string');

        $enumRule = collect($this->rules['plan'])->first(
            fn ($rule) => $rule instanceof Enum
        );

        $type = (fn () => $this->type)->call($enumRule);

        expect($type)->toBe(SubscriptionPlan::class);
    });

    test('tenant', function () {
        expect($this->rules['tenant'])
            ->toContain('required', 'array:name,email,foundation_date,state,city');
    });

    test('tenant.name', function () {
        expect($this->rules['tenant.name'])
            ->toContain('required', 'string', 'max:255');
    });

    test('tenant.email', function () {
        expect($this->rules['tenant.email'])
            ->toContain('required', 'string', 'lowercase', 'email', 'max:255');

        $uniqueRule = collect($this->rules['tenant.email'])->first(
            fn ($rule) => $rule instanceof Unique
        );

        $table = (fn () => $this->table)->call($uniqueRule);
        $column = (fn () => $this->column)->call($uniqueRule);

        expect($table)->toBe('tenants')
            ->and($column)->toBe('email');
    });

    test('tenant.foundation_date', function () {
        expect($this->rules['tenant.foundation_date'])
            ->toContain('required', 'date', 'before_or_equal:today');
    });

    test('tenant.state', function () {
        expect($this->rules['tenant.state'])
            ->toContain('required', 'string', 'size:2', 'in:AC,AL,AP,AM,BA,BH,CE,DF,ES,GO,MA,MT,MS,MG,PA,PB,PR,PE,PI,RJ,RN,RS,RO,RR,SC,SE,SP,TO');
    });

    test('tenant.city', function () {
        expect($this->rules['tenant.city'])
            ->toContain('required', 'string', 'max:255');
    });

    test('owner', function () {
        expect($this->rules['owner'])
            ->toContain('required', 'array:name,email,password,password_confirmation');
    });

    test('owner.name', function () {
        expect($this->rules['owner.name'])
            ->toContain('required', 'string', 'max:255');
    });

    test('owner.email', function () {
        expect($this->rules['owner.email'])
            ->toContain('required', 'string', 'lowercase', 'email', 'max:255');

        $uniqueRule = collect($this->rules['owner.email'])->first(
            fn ($rule) => $rule instanceof Unique
        );

        $table = (fn () => $this->table)->call($uniqueRule);
        $column = (fn () => $this->column)->call($uniqueRule);

        expect($table)->toBe('users')
            ->and($column)->toBe('email');
    });

    test('owner.password', function () {
        expect($this->rules['owner.password'])
            ->toContain('required', 'string', 'confirmed');

        $passwordRule = collect($this->rules['owner.password'])->first(
            fn ($rule) => $rule instanceof Password
        );

        $min = (fn () => $this->min)->call($passwordRule);
        $letters = (fn () => $this->letters)->call($passwordRule);
        $mixedCase = (fn () => $this->mixedCase)->call($passwordRule);
        $numbers = (fn () => $this->numbers)->call($passwordRule);
        $symbols = (fn () => $this->symbols)->call($passwordRule);
        $uncompromised = (fn () => $this->uncompromised)->call($passwordRule);

        expect($min)->toBe(8)
            ->and($letters)->toBe(true)
            ->and($mixedCase)->toBe(true)
            ->and($numbers)->toBe(true)
            ->and($symbols)->toBe(true)
            ->and($uncompromised)->toBe(true);
    });
});
