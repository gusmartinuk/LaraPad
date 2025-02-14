<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create an admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@larapad.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create 10 regular users
        \App\Models\User::factory()->count(10)->create();
    }
}
