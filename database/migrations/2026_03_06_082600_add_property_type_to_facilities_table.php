<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $existingFacilities = DB::table('facilities')->get();
        $existingPropertyFacilities = DB::table('property_facility')->get();
        $properties = DB::table('properties')->select('id', 'property_type')->get()->keyBy('id');

        Schema::table('facilities', function (Blueprint $table) {
            $table->string('property_type')->nullable()->after('name');
        });

        DB::table('property_facility')->delete();
        DB::table('facilities')->delete();

        $facilityMap = [];

        foreach ($existingPropertyFacilities as $propertyFacility) {
            $property = $properties->get($propertyFacility->property_id);
            $facility = $existingFacilities->firstWhere('id', $propertyFacility->facility_id);

            if (!$property || !$facility) {
                continue;
            }

            $key = $property->property_type . '::' . $facility->name;

            if (!isset($facilityMap[$key])) {
                $facilityMap[$key] = DB::table('facilities')->insertGetId([
                    'name' => $facility->name,
                    'property_type' => $property->property_type,
                ]);
            }

            DB::table('property_facility')->insert([
                'property_id' => $propertyFacility->property_id,
                'facility_id' => $facilityMap[$key],
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('facilities', function (Blueprint $table) {
            $table->dropColumn('property_type');
        });
    }
};
