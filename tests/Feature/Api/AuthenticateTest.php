<?php

use App\Models\User;

use function Pest\Laravel\postJson;

it('user can authenticate with telephone', function () {

    $password = fake()->words(asText: true);
    $user = User::factory()->create([
        'password' => bcrypt($password),
    ]);

    $response = postJson(route('api.auth.users'), [
        'telephone' => $user->telephone,
        'password' => $password,
    ]);

    expect($response->status())
        ->toBe(200)
        ->and($response->json())
        ->toBeArray()
        ->and($response->json('data'))
        ->toBeArray()
        ->and($response->json('data.id'))
        ->toBeString($user->id)
        ->and($response->json('data.type'))
        ->toBeString(User::class)
        ->and($response->json('data.attributes'))
        ->toBeArray()
        ->and($response->json('data.attributes.last_login'))
        ->toBeString();
});


it('receive error if password is wrong', function () {

    $password = fake()->words(asText: true);
    $user = User::factory()->create();

    $response = postJson(route('api.auth.users'), [
        'telephone' => $user->telephone,
        'password' => $password,
    ]);

    expect($response->status())
        ->toBe(422)
        ->and($response->json())
        ->toBeArray()
        ->and($response->json('errors'))
        ->toHaveKey('password')
        ->and($response->json('errors.password'))
        ->toBe(['The provided credentials are incorrect.']);
});

it('receive error if telephone does not exists', function () {

    $password = fake()->words(asText: true);
    User::factory()->create([
        'password' => bcrypt($password)
    ]);

    $response = postJson(route('api.auth.users'), [
        'telephone' => 9281232142,
        'password' => $password,
    ]);

    expect($response->status())
        ->toBe(422)
        ->and($response->json())
        ->toBeArray()
        ->and($response->json('errors'))
        ->toHaveKey('telephone')
        ->and($response->json('errors.telephone'))
        ->toBe(['The selected telephone is invalid.']);
});

it('receive error if telephone is not numeric', function () {

    $password = fake()->words(asText: true);
    User::factory()->create([
        'password' => bcrypt($password)
    ]);

    $response = postJson(route('api.auth.users'), [
        'telephone' => "helloworld",
        'password' => $password,
    ]);

    expect($response->status())
        ->toBe(422)
        ->and($response->json())
        ->toBeArray()
        ->and($response->json('errors'))
        ->toHaveKey('telephone')
        ->and($response->json('errors.telephone'))
        ->toBe(['The telephone field must be a number.']);
});
