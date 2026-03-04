<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\User;
use Midtrans\Config as MidtransConfig;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        MidtransConfig::$serverKey = config('midtrans.server_key');
        MidtransConfig::$isProduction = config('midtrans.is_production');
        MidtransConfig::$isSanitized = true;
        MidtransConfig::$is3ds = true;
    }

    /**
     * Generate a Snap token for the given booking.
     */
    public function createSnapToken(Booking $booking, User $user): string
    {
        $params = [
            'transaction_details' => [
                'order_id'     => $booking->midtrans_order_id,
                'gross_amount' => (int) $booking->total_price,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email'      => $user->email,
                'phone'      => $user->phone ?? '',
            ],
        ];

        return Snap::getSnapToken($params);
    }

    /**
     * Verify the Midtrans webhook signature.
     */
    public function verifySignature(string $orderId, string $statusCode, string $grossAmount): string
    {
        return hash('sha512', $orderId . $statusCode . $grossAmount . config('midtrans.server_key'));
    }

    // extensible: add refund method, recurring payment support, or alternative payment provider here
}
