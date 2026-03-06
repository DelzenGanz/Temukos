<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facility;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        $facilitiesByType = [
            'kos' => [
                'AC',
                'WiFi',
                'Kamar mandi dalam',
                'Dapur bersama',
                'Laundry',
                'Security 24 jam',
            ],
            'kontrakan' => [
                'Garasi',
                'Ruang tamu',
                'Dapur pribadi',
                'Kamar mandi',
                'Halaman',
                'Parkir mobil',
            ],
            'apartemen' => [
                'AC',
                'WiFi',
                'Kitchen set',
                'Lift',
                'Kolam renang',
                'Gym',
                'Security 24 jam',
            ],
        ];

        foreach ($facilitiesByType as $propertyType => $facilities) {
            foreach ($facilities as $name) {
                Facility::firstOrCreate([
                    'name' => $name,
                    'property_type' => $propertyType,
                ]);
            }
        }
    }
}
