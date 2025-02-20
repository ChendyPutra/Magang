<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::create(
            [
                'name' => 'Admin',
                'email' => 'adminSum007@admin.com',
                'email_verified_at' => now(),
                'password' => bcrypt('SumberarumGood1224'),
                'remember_token' => str::random(10),
                'is_admin' => true
            ]
        );
        // User::factory(10)->create();

        //User::factory()->create([
        //    'name' => 'Test User',
        //    'email' => 'test@example.com',
        //]);
    }
}
