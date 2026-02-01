<?php

namespace Database\Seeders;

use App\Models\Provider;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $servicesData = [
            [
                'id' => 1,
                'title' => 'Residential Pipe Repair Services',
                'category' => 'Plumber',
                'provider' => 'Daniella Barcelon',
                'description' => 'Professional residential pipe repair services focused on fixing leaks, improving water flow, and ensuring long lasting plumbing safety.',
                'created_at' => '2024-12-12',
                'jobs' => 13,
                'rating' => 4.9,
                'reviews' => 128,
                'specialization' => 'Pipe Repair'
            ],
            [
                'id' => 2,
                'title' => 'Emergency Leak and Drain Repair',
                'category' => 'Plumber',
                'provider' => 'Mark Villanueva',
                'description' => 'Fast response emergency plumbing services for leaks and clogged drains, providing immediate solutions to prevent further damage.',
                'created_at' => '2024-11-25',
                'jobs' => 21,
                'rating' => 4.8,
                'reviews' => 96,
                'specialization' => 'Emergency Plumbing'
            ],
            [
                'id' => 3,
                'title' => 'Home Wiring and Panel Upgrade',
                'category' => 'Electrician',
                'provider' => 'Alex Cruz',
                'description' => 'Safe and reliable home wiring and electrical panel upgrades designed to improve system performance and meet modern safety standards.',
                'created_at' => '2025-01-02',
                'jobs' => 18,
                'rating' => 4.7,
                'reviews' => 82,
                'specialization' => 'Electrical Wiring'
            ],
            [
                'id' => 4,
                'title' => 'Interior and Exterior Wall Finishing',
                'category' => 'Painter',
                'provider' => 'Liam Santos',
                'description' => 'Professional interior and exterior wall finishing services delivering clean paint application, smooth surfaces, and lasting results.',
                'created_at' => '2024-10-18',
                'jobs' => 9,
                'rating' => 4.6,
                'reviews' => 54,
                'specialization' => 'Wall Finishing'
            ],
            [
                'id' => 5,
                'title' => 'Lawn Care and Landscape Maintenance',
                'category' => 'Gardener',
                'provider' => 'Rose Mendoza',
                'description' => 'Comprehensive lawn care and landscape maintenance services to keep outdoor spaces healthy, organized, and visually appealing.',
                'created_at' => '2024-12-28',
                'jobs' => 14,
                'rating' => 4.8,
                'reviews' => 73,
                'specialization' => 'Landscape Maintenance'
            ],
            [
                'id' => 6,
                'title' => 'Home Appliance Diagnostics and Repair',
                'category' => 'Technician',
                'provider' => 'John Reyes',
                'description' => 'Expert home appliance diagnostics and repair services covering common household devices to restore performance efficiently.',
                'created_at' => '2024-11-05',
                'jobs' => 25,
                'rating' => 4.9,
                'reviews' => 141,
                'specialization' => 'Appliance Repair'
            ],
            [
                'id' => 7,
                'title' => 'Bathroom Fixture Installation and Repair',
                'category' => 'Plumber',
                'provider' => 'Carlos Mendoza',
                'description' => 'Professional installation and repair of bathroom fixtures including sinks, toilets, and faucets to ensure proper function.',
                'created_at' => '2024-09-22',
                'jobs' => 17,
                'rating' => 4.7,
                'reviews' => 88,
                'specialization' => 'Bathroom Fixtures'
            ],
            [
                'id' => 8,
                'title' => 'Ceiling Fan and Lighting Installation',
                'category' => 'Electrician',
                'provider' => 'Ryan Bautista',
                'description' => 'Reliable ceiling fan and lighting installation services focused on safety, correct wiring, and optimal home illumination.',
                'created_at' => '2024-12-05',
                'jobs' => 20,
                'rating' => 4.8,
                'reviews' => 101,
                'specialization' => 'Lighting Installation'
            ],
            [
                'id' => 9,
                'title' => 'Residential House Repainting Services',
                'category' => 'Painter',
                'provider' => 'Angela Flores',
                'description' => 'Complete residential house repainting services offering professional color application for both interior and exterior spaces.',
                'created_at' => '2024-11-14',
                'jobs' => 11,
                'rating' => 4.6,
                'reviews' => 67,
                'specialization' => 'House Repainting'
            ],
            [
                'id' => 10,
                'title' => 'Garden Design and Plant Arrangement',
                'category' => 'Gardener',
                'provider' => 'Miguel Navarro',
                'description' => 'Creative garden design and plant arrangement services that enhance outdoor aesthetics and promote healthy plant growth.',
                'created_at' => '2024-10-30',
                'jobs' => 8,
                'rating' => 4.5,
                'reviews' => 39,
                'specialization' => 'Garden Design'
            ],
            [
                'id' => 11,
                'title' => 'Washing Machine and Dryer Repair',
                'category' => 'Technician',
                'provider' => 'Patrick Lim',
                'description' => 'Professional washing machine and dryer repair services ensuring appliances are restored to proper working condition.',
                'created_at' => '2024-12-18',
                'jobs' => 22,
                'rating' => 4.9,
                'reviews' => 119,
                'specialization' => 'Laundry Appliance Repair'
            ],
            [
                'id' => 12,
                'title' => 'Circuit Breaker Troubleshooting Services',
                'category' => 'Electrician',
                'provider' => 'Noel Ramos',
                'description' => 'Accurate circuit breaker troubleshooting services to diagnose electrical issues and restore safe power distribution.',
                'created_at' => '2025-01-08',
                'jobs' => 16,
                'rating' => 4.8,
                'reviews' => 74,
                'specialization' => 'Circuit Troubleshooting'
            ],
            [
                'id' => 13,
                'title' => 'Pipe Leak Detection and Assessment',
                'category' => 'Plumber',
                'provider' => 'Jerome Castillo',
                'description' => 'Advanced pipe leak detection and assessment services designed to identify hidden leaks and prevent costly water damage.',
                'created_at' => '2024-12-02',
                'jobs' => 19,
                'rating' => 4.7,
                'reviews' => 91,
                'specialization' => 'Leak Detection'
            ],
            [
                'id' => 14,
                'title' => 'Wall Texture and Decorative Painting',
                'category' => 'Painter',
                'provider' => 'Sophia Reyes',
                'description' => 'Decorative wall texture and custom painting services that add style, depth, and character to interior spaces.',
                'created_at' => '2024-11-09',
                'jobs' => 10,
                'rating' => 4.6,
                'reviews' => 58,
                'specialization' => 'Decorative Painting'
            ],
            [
                'id' => 15,
                'title' => 'Outdoor Lawn Cleanup and Maintenance',
                'category' => 'Gardener',
                'provider' => 'Benito Cruz',
                'description' => 'Seasonal outdoor lawn cleanup and maintenance services to keep yards clean, organized, and well maintained year round.',
                'created_at' => '2024-12-20',
                'jobs' => 12,
                'rating' => 4.8,
                'reviews' => 69,
                'specialization' => 'Lawn Maintenance'
            ],
            [
                'id' => 16,
                'title' => 'Outdoor Lawn Cleanup and Maintenance',
                'category' => 'Vendor',
                'provider' => 'Benito Cruz',
                'description' => 'Seasonal outdoor lawn cleanup and maintenance services to keep yards clean, organized, and well maintained year round.',
                'created_at' => '2024-12-20',
                'jobs' => 12,
                'rating' => 4.8,
                'reviews' => 69,
                'specialization' => 'Lawn Maintenance'
            ],
        ];

        
        foreach ($servicesData as $data) {
            // Create or find the user/provider first
            $user = User::firstOrCreate(
                ['email' => strtolower(str_replace(' ', '.', $data['provider'])) . '@example.com'],
                ['name' => $data['provider'], 'password' => Hash::make('password'), 'role' => 'provider']
            );

            // Split full name
            $nameParts = explode(' ', trim($data['provider']), 2);

            $provider = Provider::where('user_id', $user->id)->first();
    
            if (!$provider) {
                $provider = Provider::factory()->create([
                    'user_id'    => $user->id,
                    'first_name' => $nameParts[0],
                    'last_name'  => $nameParts[1] ?? '',
                    'profession' => $data['category'],
                    'verified_at' => now(),
                ]);
            }

            // Create the service
            Service::factory()->create([
                'provider_id'    => $provider->id,
                'title'          => $data['title'],
                'category'       => $data['category'],
                'description'    => $data['description'],
                'jobs'           => $data['jobs'],
                'rating'         => $data['rating'],
                'reviews'        => $data['reviews'],
                'specialization' => $data['specialization'],
                'created_at'     => $data['created_at'] ?? now(),
            ]);
        }
    }
}
