<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        User::create([
            'name' => 'Seller',
            'email' => 'seller@example.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
        ]);
        User::create([
            'name' => 'Viewer',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'viewer',
        ]);
    }
}
