<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\Facility;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        // Sample Property 1 — Kos
        $property1 = Property::updateOrCreate(
            ['name' => 'Kos Harmoni Residence'],
            [
            'city' => 'Jakarta Pusat',
            'address' => 'Jl. Harmoni No. 12, Gambir',
            'price_month' => 1500000,
            'description' => 'Kos nyaman dan strategis di pusat kota Jakarta. Dekat dengan stasiun MRT dan pusat perbelanjaan. Lingkungan aman dan tenang, cocok untuk mahasiswa dan pekerja. Kamar luas dengan ventilasi yang baik dan pencahayaan alami.',
            'property_type' => 'kos',
            ]
        );

        $property1->photos()->delete();
        $property1->photos()->createMany([
            ['filename' => 'kos-harmoni-1.jpg', 'is_primary' => true],
            ['filename' => 'kos-harmoni-2.jpg', 'is_primary' => false],
            ['filename' => 'kos-harmoni-3.jpg', 'is_primary' => false],
        ]);

        // Attach facilities: AC, WiFi, Kamar mandi dalam, Security 24 jam
        $property1->facilities()->sync(
            Facility::where('property_type', 'kos')
                ->whereIn('name', ['AC', 'WiFi', 'Kamar mandi dalam', 'Security 24 jam'])
                ->pluck('id')
        );

        // Sample Property 2 — Kontrakan
        $property2 = Property::updateOrCreate(
            ['name' => 'Kontrakan Asri Cijantung'],
            [
            'city' => 'Jakarta Timur',
            'address' => 'Jl. Raya Cijantung No. 45, Pasar Rebo',
            'price_month' => 3500000,
            'description' => 'Kontrakan 2 kamar tidur dengan halaman luas di lingkungan asri Cijantung. Cocok untuk keluarga kecil. Tersedia parkir motor dan mobil. Dekat dengan pasar dan sekolah.',
            'property_type' => 'kontrakan',
            ]
        );

        $property2->photos()->delete();
        $property2->photos()->createMany([
            ['filename' => 'kontrakan-cijantung-1.jpg', 'is_primary' => true],
            ['filename' => 'kontrakan-cijantung-2.jpg', 'is_primary' => false],
        ]);

        // Attach facilities: Garasi, Ruang tamu, Dapur pribadi, Parkir mobil
        $property2->facilities()->sync(
            Facility::where('property_type', 'kontrakan')
                ->whereIn('name', ['Garasi', 'Ruang tamu', 'Dapur pribadi', 'Parkir mobil'])
                ->pluck('id')
        );
    }
}
