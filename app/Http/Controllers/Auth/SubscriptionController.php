<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\DTOs\SubscriptionDTO;
use App\Enums\SubscriptionStatus;
use App\Events\SubscriptionCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SubscriptionRequest;
use App\Models\Subscription;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

/**
 * @phpstan-import-type SubscriptionData from SubscriptionDTO
 */
final class SubscriptionController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('auth/subscription');
    }

    public function store(SubscriptionRequest $request): RedirectResponse
    {
        return DB::transaction(function () use ($request) {
            /** @var SubscriptionData $data */
            $data = $request->validated();

            $subscriptionData = SubscriptionDTO::from($data);

            $user = User::create([
                'name' => $subscriptionData->owner->name,
                'email' => $subscriptionData->owner->email,
                'password' => Hash::make($subscriptionData->owner->password),
            ]);

            $tenant = Tenant::create([
                'owner_id' => $user->id,
                'name' => $subscriptionData->tenant->name,
                'email' => $subscriptionData->tenant->email,
                'foundation_date' => $subscriptionData->tenant->foundationDate,
                'state' => $subscriptionData->tenant->state,
                'city' => $subscriptionData->tenant->city,
            ]);

            $subscription = Subscription::create([
                'tenant_id' => $tenant->id,
                'plan' => $subscriptionData->plan,
                'status' => SubscriptionStatus::Active,
            ]);

            event(new Registered($user));
            event(new SubscriptionCreated($subscription));

            return redirect()->intended(route('login', absolute: false));
        });
    }
}
