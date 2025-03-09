<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SubscribeRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

final class SubscribeController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('auth/subscribe');
    }

    public function store(SubscribeRequest $request): RedirectResponse
    {
        return DB::transaction(function () use ($request) {
            $user = User::create([
                'type' => UserType::Tenant,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->string('password')->value()),
            ]);

            $tenant = $user->ownedTenant()->create([
                'name' => $request->name,
                'acronym' => $request->acronym,
                'email' => $request->email,
                'foundation_date' => $request->foundation_date,
                'state' => $request->state,
                'city' => $request->city,
            ]);

            $user->update([
                'current_tenant_id' => $tenant->id,
            ]);

            event(new Registered($user));

            Auth::login($user);

            return to_route('dashboard');
        });
    }
}
