<?php


use App\Models\User;
use function Pest\Laravel\{deleteJson, actingAs};

it('admin can delete user', function () {
    $admin = User::factory()->withAdminRole()->create();
    actingAs($admin);

    $user = User::factory()->create();

    $response = deleteJson(route('api.users.destroy', $user));
    expect($response->status())->toBe(204);
});

it('simple user can not delete user', function () {
    $admin = User::factory()->withUserRole()->create();
    actingAs($admin);

    $user = User::factory()->create();

    $response = deleteJson(route('api.users.destroy', $user));
    expect($response->status())->toBe(403);
});
