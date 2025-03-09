<?php

declare(strict_types=1);

namespace App\Http\Requests\Teams;

use App\Enums\TeamPermission;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreTeamRequest extends FormRequest
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
        $user = type(auth()->user())->as(User::class);
        $tenant = type($user->currentTenant)->as(Tenant::class);

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('teams')
                    ->where('tenant_id', $tenant->id),
            ],
            'description' => ['nullable', 'string', 'max:255'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['
                required',
                'string',
                'distinct',
                Rule::enum(TeamPermission::class),
                'exists:permissions,name',
            ],
        ];
    }
}
