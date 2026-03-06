<?php

namespace App\Http\Controllers;

use App\Models\Property;

class PropertyController extends Controller
{
    public function show(Property $property)
    {
        $property->load(['photos', 'facilities']);

        // Order photos: primary first, then rest
        $photos = $property->photos->sortByDesc('is_primary')->values();

        // Get booked ranges
        $bookedRanges = $property->bookings()
            ->whereIn('status', ['pending', 'paid'])
            ->get()
            ->map(function ($booking) {
                return [
                    'start' => $booking->start_date->format('Y-m-d'),
                    'end' => $booking->start_date->copy()->addMonths($booking->duration_months)->format('Y-m-d'),
                ];
            });

        return view('property.show', compact('property', 'photos', 'bookedRanges'));
    }
}
