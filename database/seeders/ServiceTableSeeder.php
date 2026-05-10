<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Support\Str;

class ServiceTableSeeder extends Seeder
{
    public function run(): void
    {
        $plumberCategory = ServiceCategory::where('name', 'Plumber')->first();
        $electricianCategory = ServiceCategory::where('name', 'Electrician')->first();
        $painterCategory = ServiceCategory::where('name', 'Painter')->first();

        Service::create([
            'provider_id' => 2,
            'service_id' => 'SE-2026-PCOIL',
            'service_category_id' => $plumberCategory?->id,
            'title' => 'Residential Pipe Repair Services',
            'slug' => Str::slug('Residential Pipe Repair Services') . '-1',
            'description' => 'We provide high-quality plumbing services for residential and commercial properties.',
            'content' => '
                <p>
                    Our residential pipe repair service ensures your home’s plumbing system runs efficiently and safely. 
                    From minor leaks to major pipe replacements, we handle every issue with precision and care.
                </p>
                <br>
                <h5>What We Offer:</h5>
                <ul>
                    <li>Leak detection and repair</li>
                    <li>Pipe replacement and installation</li>
                    <li>Drain unclogging</li>
                    <li>Water pressure troubleshooting</li>
                </ul>

                <p>
                    We use modern tools and high-quality materials to ensure long-lasting results. 
                    Available for emergency repairs and scheduled maintenance.
                </p>
            ',
            'specialization' => 'Pipe Installation',
            'price' => 1500.00,
            'image' => 'images/service-detail-img.png',
            'rating' => 4.80,
        ]);

        Service::create([
            'provider_id' => 2,
            'service_id' => 'SE-2026-PCOZK',
            'service_category_id' => $electricianCategory?->id,
            'title' => 'Home Wiring and Panel Upgrade',
            'slug' => Str::slug('Home Wiring and Panel Upgrade') . '-2',
            'description' => 'Certified electrician for wiring, panel upgrades, and troubleshooting.',
            'content' => '
                <p>
                    Ensure your home’s electrical system is up to standard with our certified wiring and panel upgrade services.
                    We specialize in safe installations that comply with electrical safety codes.
                </p>
                <br>
                <h5>Our Services Include:</h5>
                <ul>
                    <li>Full house rewiring</li>
                    <li>Circuit breaker upgrades</li>
                    <li>Electrical panel replacements</li>
                    <li>Lighting installation</li>
                </ul>

                <p>
                    We prioritize safety, efficiency, and durability in every project.
                    Whether you’r upgrading or renovating, we guarantee dependable service.
                </p>
            ',
            'specialization' => 'Wiring & Installation',
            'price' => 2000.00,
            'image' => 'images/service-detail-img.png',
            'rating' => 4.95,
        ]);

        Service::create([
            'provider_id' => 2,
            'service_id' => 'SE-2026-PTHZK',
            'service_category_id' => $painterCategory?->id,
            'title' => 'Interior and Exterior Wall Finishings',
            'slug' => Str::slug('Interior and Exterior Wall Finishing') . '-3',
            'description' => 'Professional interior and exterior wall finishing services delivering clean paint application, smooth surfaces, and lasting results.',
            'content' => '
                <p>
                    Transform your space with expert interior and exterior wall finishing services.
                    We deliver smooth, high-quality finishes that enhance both aesthetics and durability.
                </p>
                <br>
                <h5>Our Expertise Covers:</h5>
                <ul>
                    <li>Interior and exterior painting</li>
                    <li>Surface preparation and smoothing</li>
                    <li>Decorative wall finishes</li>
                    <li>Color consultation and design</li>
                </ul>

                <p>
                    Using premium paints and modern techniques, we ensure a flawless finish 
                    that lasts for years. Perfect for residential and commercial properties.
                </p>
            ',
            'specialization' => 'paint, graphic design',
            'price' => 5000.00,
            'image' => 'images/service-detail-img.png',
            'rating' => 4.60,
        ]);
    }
}