<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Provider>
 */
class ProviderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ph_sample_province = [ 'Metro Manila', 'Cavite', 'Laguna', 'Batangas', 'Rizal', 'Bulacan', 'Pampanga', 'Nueva Ecija', 'Tarlac', 'Pangasinan', 'Cebu', 'Iloilo', 'Negros Occidental', 'Davao del Sur', 'Bukidnon', 'Misamis Oriental', 'Zamboanga del Sur', 'South Cotabato', 'Leyte', 'Samar'];

        return [
            'user_id'      => User::factory(), // Creates a user if one isn't passed
            'first_name'   => $this->faker->firstName(),
            'last_name'    => $this->faker->lastName(),
            'phone_num'    => $this->faker->phoneNumber(),

            'home_address' => $this->faker->streetAddress(),
            'province'     => $this->faker->randomElement($ph_sample_province),
            'zip'          => $this->faker->postcode(),

            'profession'   => $this->faker->jobTitle(),
            'year_exp'     => $this->faker->numberBetween(1, 20),
            'verified_at'  => now(),
        ];
    }
}
