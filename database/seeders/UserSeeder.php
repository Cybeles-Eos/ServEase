<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['customer', 'provider', 'admin'];

        foreach ($roles as $role) {
            User::create([
                'name'              => "Test " . ucfirst($role),
                'email'             => "{$role}@example.com",
                'role'              => $role,
                'email_verified_at' => now(),
                'password'          => Hash::make('test123'),
                'remember_token'    => \Illuminate\Support\Str::random(10),
            ]);
        }
    }
}
