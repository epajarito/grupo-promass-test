<?php

namespace Database\Factories;

use App\Enums\Roles;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'last_name' => fake()->lastName,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'telephone' => fake()->unique()->numerify('##########'),
            'avatar' => 'storage/users/avatars/' . fake()->image('public/storage/users/avatars', 640, 480, null, false),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function withAdminRole(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => Roles::Admin->value,
        ]);
    }

    public function withUserRole(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => Roles::User->value,
        ]);
    }
}
