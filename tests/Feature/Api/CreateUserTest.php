<?php


use App\Enums\Roles;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use function Pest\Laravel\{postJson, actingAs};
beforeEach(function () {
    User::unsetEventDispatcher();
});
it('can create user with admin role', function () {

    Storage::fake('public');
    $file = UploadedFile::fake()->image('avatar.jpg');

    $admin = User::factory()->withAdminRole()->create();
    actingAs($admin);

    $response = postJson(route('api.users.store'), [
        'name' => fake()->name(),
        'last_name' => fake()->lastName(),
        'email' => fake()->unique()->safeEmail(),
        'telephone' => fake()->unique()->numerify('##########'),
        'password' => fake()->password(8),
        'role' => \App\Enums\Roles::Admin,
        'avatar' => $file
    ]);

    expect($response->status())
        ->toBe(201)
        ->and($response->json())
        ->toBeArray()
        ->and($response->json('data'))
        ->toBeArray()
        ->and($response->json('data.type'))
        ->toBeString(User::class)
        ->and($response->json('data.attributes'))
        ->toBeArray()
        ->and($response->json('data.attributes.role'))
        ->toBe(Roles::Admin->value);
});


it('can not create user with email already registered', function () {
    Storage::fake('public');
    $admin = User::factory()->withAdminRole()->create();
    actingAs($admin);

    $user = User::factory()->withUserRole()->create();

    $response = postJson(route('api.users.store'), [
        'name' => fake()->name(),
        'last_name' => fake()->lastName(),
        'email' => $user->email,
        'telephone' => fake()->unique()->numerify('##########'),
        'password' => fake()->password(8),
        'role' => \App\Enums\Roles::Admin,
        'avatar' => UploadedFile::fake()->image('avatar.jpg')->size(1024)
    ]);

    expect($response->status())
        ->toBe(422)
        ->and($response->json())
        ->toBeArray()
        ->and($response->json('errors'))
        ->toHaveKey('email')
        ->and($response->json('errors.email'))
        ->toBe(['The email has already been taken.']);
});

it('can not create user with telephone already registered', function () {
    Storage::fake('public');
    $admin = User::factory()->withAdminRole()->create();
    actingAs($admin);

    $user = User::factory()->withAdminRole()->create();

    $response = postJson(route('api.users.store'), [
        'name' => fake()->name(),
        'last_name' => fake()->lastName(),
        'email' => fake()->unique()->safeEmail(),
        'telephone' => $user->telephone,
        'password' => fake()->password(8),
        'role' => \App\Enums\Roles::Admin,
        'avatar' => UploadedFile::fake()->image('avatar.jpg')->size(1024)
    ]);

    expect($response->status())
        ->toBe(422)
        ->and($response->json())
        ->toBeArray()
        ->and($response->json('errors'))
        ->toHaveKey('telephone')
        ->and($response->json('errors.telephone'))
        ->toBe(['The telephone has already been taken.']);
});

it('simple user can not create another user', function () {
    $simpleUser = User::factory()->withUserRole()->create();
    actingAs($simpleUser);

    $response = postJson(route('api.users.store'), [
        'name' => fake()->name(),
        'last_name' => fake()->lastName(),
        'email' => fake()->unique()->safeEmail(),
        'telephone' => fake()->unique()->numerify('##########'),
        'password' => fake()->password(8),
        'role' => \App\Enums\Roles::Admin
    ]);

    expect($response->status())->toBe(403);
});