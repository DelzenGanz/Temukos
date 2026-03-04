<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facility;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        $facilities = [
            'AC',
            'WiFi',
            'Kamar mandi dalam',
            'Dapur bersama',
            'Parkir motor',
            'Parkir mobil',
            'Laundry',
            'Security 24 jam',
        ];

        foreach ($facilities as $name) {
            Facility::create(['name' => $name]);
        }
    }
}
