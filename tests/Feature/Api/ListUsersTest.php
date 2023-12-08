<?php

use App\Models\User;
use function Pest\Laravel\getJson;
use Illuminate\Database\Eloquent\Factories\Sequence;

it('list only active users', function () {
    $admin = User::factory()->withAdminRole()->create();
    \Pest\Laravel\actingAs($admin);

    User::factory()
        ->count(5)
        ->create(
            new Sequence(
                ['deleted_at' => now()],
                ['deleted_at' => null],
                ['deleted_at' => now()],
                ['deleted_at' => null],
                ['deleted_at' => now()],
            )
        );
    $response = getJson(route('api.users.index'));

    expect($response->status())
        ->toBe(200)
        ->and($response->json())
        ->toHaveKey('data')
        ->and($response->json('data'))
        ->toHaveCount(3)
        ->and($response->json('data'))
        ->toBeArray()
        ->each
        ->toHaveKey('attributes')
        ->and($response->json('data.*.attributes'))
        ->each
        ->toHaveKeys([
            'name',
            'last_name',
            'telephone',
            'email',
            'role',
            'created_at',
            'updated_at',
            'last_login',
            'avatar'
        ]);
});
