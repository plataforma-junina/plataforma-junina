<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\Enums\SubscriptionPlan;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

final class SubscriptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'plan' => ['required', 'string', Rule::enum(SubscriptionPlan::class)],
            'tenant' => ['required', 'array:name,email,foundation_date,state,city'],
            'tenant.name' => ['required', 'string', 'max:255'],
            'tenant.email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('tenants', 'email')],
            'tenant.foundation_date' => ['required', 'date', 'before_or_equal:today'],
            'tenant.state' => ['required', 'string', 'size:2', 'in:AC,AL,AP,AM,BA,BH,CE,DF,ES,GO,MA,MT,MS,MG,PA,PB,PR,PE,PI,RJ,RN,RS,RO,RR,SC,SE,SP,TO'],
            'tenant.city' => ['required', 'string', 'max:255'],
            'owner' => ['required', 'array:name,email,password,password_confirmation'],
            'owner.name' => ['required', 'string', 'max:255'],
            'owner.email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')],
            'owner.password' => ['required', 'string', 'confirmed', Password::defaults()],
        ];
    }
}
