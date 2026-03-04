<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Property;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProperties = Property::count();
        $totalBookings = Booking::count();
        $totalPaidBookings = Booking::where('status', 'paid')->count();
        $totalRevenue = Booking::where('status', 'paid')->sum('total_price');

        $recentBookings = Booking::with(['user', 'property'])
            ->latest()
            ->take(10)
            ->get();

        // extensible: add revenue reports, charts, and analytics here

        return view('admin.dashboard', compact(
            'totalProperties',
            'totalBookings',
            'totalPaidBookings',
            'totalRevenue',
            'recentBookings'
        ));
    }
}
