<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\UserTypeEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'email' => 'test@test.test',
        ], [
            'name' => 'Sky',
            'role' => UserTypeEnum::Admin->value,
            'email_verified_at' => now(),
            'password' => Hash::make('testpassword1'),
        ]);

        User::factory()->guest()->count(15)->create();
    }
}
