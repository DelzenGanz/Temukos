<?php

namespace App\Http\Controllers;

use App\Models\Property;

class PropertyController extends Controller
{
    public function show(Property $property)
    {
        $property->load(['photos', 'facilities', 'bookings']);

        // Order photos: primary first, then rest
        $photos = $property->photos->sortByDesc('is_primary')->values();

        return view('property.show', compact('property', 'photos'));
    }
}
