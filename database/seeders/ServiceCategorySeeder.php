<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

class ServiceCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Plumber',
            'Electrician',
            'Vendor',
            'Carpenter',
            'Painter',
            'Aircon Technician',
            'Appliance Repair',
            'House Cleaner',
            'Gardener',
            'Laundry Service',
            'Mason',
            'Welder',
            'Roofer',
            'Pest Control',
            'Computer Technician',
        ];

        foreach ($categories as $categoryName) {
            $category = ServiceCategory::withTrashed()
                ->where('name', $categoryName)
                ->first();

            if ($category) {
                $category->restore();

                $category->update([
                    'is_active' => true,
                ]);
            } else {
                ServiceCategory::create([
                    'name' => $categoryName,
                    'is_active' => true,
                ]);
            }
        }
    }
}