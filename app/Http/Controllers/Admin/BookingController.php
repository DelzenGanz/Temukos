<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'property']);

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('property', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $bookings = $query->latest()->paginate(15)->withQueryString();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $properties = \App\Models\Property::orderBy('name')->get();
        return view('admin.bookings.create', compact('properties'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'start_date' => 'required|date|after_or_equal:today',
            'duration_months' => 'required|integer|min:1|max:12',
            'notes' => 'nullable|string|max:500',
        ]);

        $property = \App\Models\Property::findOrFail($validated['property_id']);
        
        // Check availability
        if (!$property->isAvailableBetween($validated['start_date'], $validated['duration_months'])) {
            return back()->withInput()->with('error', 'Properti tidak tersedia pada tanggal tersebut.');
        }

        $totalPrice = $property->price_month * $validated['duration_months'];

        Booking::create([
            'property_id' => $validated['property_id'],
            'user_id' => null, // Manual booking by admin
            'start_date' => $validated['start_date'],
            'duration_months' => $validated['duration_months'],
            'total_price' => $totalPrice,
            'status' => 'paid', // Manual booking is usually considered paid/confirmed
            'notes' => $validated['notes'],
        ]);

        return redirect()->route('admin.bookings.index')->with('success', 'Pemesanan manual berhasil ditambahkan.');
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,paid,cancelled',
        ]);

        $booking->update(['status' => $validated['status']]);

        return back()->with('success', 'Status pemesanan berhasil diperbarui.');
    }
}
