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
            'phone_number' => '09123456789',
            'profession' => 'Software Engineer',
            'home_address' => 'Test Antipolo City',
            'province' => 'Rizal',
            'barangay' => 'Mambugan',
            'zipcode' => '1870',
            'year_exp' => 3
        ]);

        $providerUser1 = User::create([
            'name' => 'Dawn Izach',
            'email' => 'dawnzach10@gmail.com',
            'role' => 'provider',
            'password' => Hash::make('test123'),
        ]);
        $providerUser1->provider()->create([
            'first_name' => 'Dawn',
            'last_name' => 'Izach',
            'phone_number' => '09123456781',
            'profession' => 'Software Engineer',
            'home_address' => 'Test Antipolo City',
            'province' => 'Rizal',
            'barangay' => 'Mambugan',
            'zipcode' => '1870',
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
            'last_name' => 'User',
            'phone_number' => '09123456789',
            'street_address' => '123 Main St',
            'profile_image' => '/uploads/customer_profiles/user.png',
            'city' => 'Sample City',
            'barangay' => 'Sample Barangay',
            'zipcode' => '1807'
        ]);
    }
}
