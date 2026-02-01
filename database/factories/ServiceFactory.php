<?php

namespace Database\Factories;

use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['Plumber', 'Electrician', 'Painter', 'Gardener', 'Technician'];
    
        return [
            'provider_id'    => Provider::factory(), // Automatically creates a provider if needed
            'title'          => $this->faker->sentence(4),
            'category'       => $this->faker->randomElement($categories),
            'description'    => $this->faker->paragraph(),
            'jobs'           => $this->faker->numberBetween(1, 50),
            'rating'         => $this->faker->randomFloat(1, 3, 5), // Random rating between 3.0 and 5.0
            'reviews'        => $this->faker->numberBetween(0, 200),
            'specialization' => $this->faker->words(2, true),
            'created_at'     => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
