<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Facility;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::with(['primaryPhoto', 'facilities']);

        // Search by location keyword
        $query->filterByLocation($request->input('search'));

        // Filter by property type (array of checkboxes)
        $query->filterByType($request->input('type', []));

        // Filter by price range
        $query->filterByPrice($request->input('price_min'), $request->input('price_max'));

        // Filter by facilities
        $query->filterByFacilities($request->input('facilities', []));

        // Sort
        $sort = $request->input('sort', 'terbaru');
        $query = match ($sort) {
            'harga_terendah' => $query->orderBy('price_month', 'asc'),
            'harga_tertinggi' => $query->orderBy('price_month', 'desc'),
            'paling_populer' => $query->withCount('bookings')->orderBy('bookings_count', 'desc'),
            default => $query->orderBy('created_at', 'desc'), // terbaru
        };

        $properties = $query->paginate(12)->withQueryString();
        $facilities = Facility::orderBy('name')->get();
        $totalResults = $properties->total();

        return view('home', compact('properties', 'facilities', 'totalResults'));
    }
}
