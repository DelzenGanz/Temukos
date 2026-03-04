<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Property;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function __construct(
        protected MidtransService $midtrans
    ) {}

    /**
     * Show the user's booking history.
     */
    public function index()
    {
        $bookings = Auth::user()
            ->bookings()
            ->with('property.primaryPhoto')
            ->latest()
            ->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Create a new booking and generate Midtrans Snap token.
     */
    public function store(Request $request, Property $property)
    {
        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'duration_months' => 'required|integer|min:1|max:12',
        ]);

        $totalPrice = $property->price_month * $validated['duration_months'];

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'property_id' => $property->id,
            'start_date' => $validated['start_date'],
            'duration_months' => $validated['duration_months'],
            'total_price' => $totalPrice,
            'status' => 'pending',
            'midtrans_order_id' => 'TMKS-' . strtoupper(Str::random(8)) . '-' . time(),
        ]);

        try {
            $snapToken = $this->midtrans->createSnapToken($booking, Auth::user());
            $booking->update(['snap_token' => $snapToken]);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'booking_id' => $booking->id,
            ]);
        } catch (\Exception $e) {
            $booking->update(['status' => 'cancelled']);

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat pembayaran. Silakan coba lagi.',
            ], 500);
        }
    }

    /**
     * Get the snap token for an existing pending booking (pay now).
     */
    public function pay(Booking $booking)
    {
        $this->authorize('pay', $booking);

        if (!$booking->isPending()) {
            return response()->json([
                'success' => false,
                'message' => 'Booking ini tidak dalam status pending.',
            ], 400);
        }

        if ($booking->snap_token) {
            return response()->json([
                'success' => true,
                'snap_token' => $booking->snap_token,
            ]);
        }

        // Generate a new snap token if the old one expired
        try {
            $snapToken = $this->midtrans->createSnapToken($booking, Auth::user());
            $booking->update(['snap_token' => $snapToken]);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat pembayaran.',
            ], 500);
        }
    }
}
