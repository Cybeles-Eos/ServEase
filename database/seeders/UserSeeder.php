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
        // Dummy Admin 
        User::create([
            'name' => 'System Admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => Hash::make('test123'),
        ]);


        // Dummy Provider
        $providerUser = User::create([
            'name' => 'Provider User',
            'email' => 'provider@example.com',
            'role' => 'provider',
            'password' => Hash::make('test123'),
        ]);
        $providerUser->provider()->create([
            'first_name' => 'Provider',
            'last_name' => 'User',
            'phone_num' => '09123456789',
            'profession' => 'Software Engineer',
            'year_exp' => 3
        ]);


        // Dummy Customer
        $customerUser = User::create([
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'role' => 'customer',
            'password' => Hash::make('test123'),
        ]);
        $customerUser->customer()->create([
            'first_name' => 'Customer',
            'last_name' => 'User'
        ]);
    }
}
