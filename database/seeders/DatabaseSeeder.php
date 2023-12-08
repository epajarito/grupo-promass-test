<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         \App\Models\User::factory(10)->withUserRole()->create();
         \App\Models\User::factory(10)->withAdminRole()->create();

        \App\Models\User::factory(10)->withUserRole()->create([
            'deleted_at' => now(),
        ]);

        User::factory()->withAdminRole()->create([
            'telephone' => '1234567892',
            'password' => 'password',
        ]);

        User::factory()->withUserRole()->create([
            'telephone' => '1234567891',
            'password' => 'password',
        ]);
    }
}
