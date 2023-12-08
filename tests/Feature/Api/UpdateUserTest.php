<?php

use function Pest\Laravel\{putJson, actingAs};
use App\Models\User;

it('admin can update any user', function () {
    $admin = User::factory()->withAdminRole()->create();
    actingAs($admin);
    $user = User::factory()->create();

    $response = putJson(route('api.users.update', $user), [
        'name' => 'John',
        'last_name' => 'Doe',
        'telephone' => $user->telephone,
        'email' => $user->email,
        'role' => \App\Enums\Roles::Admin->value,
    ]);

    expect($response->status())->toBe(200);
});


it('can user update self account', function () {
    $simpleUser = User::factory()->withUserRole()->create();
    actingAs($simpleUser);

    $response = putJson(route('api.users.update', $simpleUser), [
        'name' => 'John',
        'last_name' => 'Doe',
        'telephone' => $simpleUser->telephone,
        'email' => $simpleUser->email,
        'role' => \App\Enums\Roles::Admin->value,
    ]);

    expect($response->status())->toBe(200);
});

it('can not user update any account', function () {
    $simpleUser = User::factory()->withUserRole()->create();
    actingAs($simpleUser);

    $user = User::factory()->withUserRole()->create();

    $response = putJson(route('api.users.update', $user), [
        'name' => 'John',
        'last_name' => 'Doe',
        'telephone' => $user->telephone,
        'email' => $user->email,
        'role' => \App\Enums\Roles::Admin->value,
    ]);

    expect($response->status())->toBe(403);
});
