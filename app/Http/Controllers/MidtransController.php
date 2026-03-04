<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function __construct(
        protected MidtransService $midtrans
    ) {}

    /**
     * Handle Midtrans webhook callback.
     * This endpoint is excluded from CSRF protection.
     */
    public function callback(Request $request)
    {
        $orderId = $request->input('order_id');
        $statusCode = $request->input('status_code');
        $grossAmount = $request->input('gross_amount');
        $signatureKey = $request->input('signature_key');
        $transactionStatus = $request->input('transaction_status');
        $fraudStatus = $request->input('fraud_status');

        // Verify signature
        $expectedSignature = $this->midtrans->verifySignature($orderId, $statusCode, $grossAmount);

        if ($signatureKey !== $expectedSignature) {
            Log::warning('Midtrans callback: invalid signature', ['order_id' => $orderId]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $booking = Booking::where('midtrans_order_id', $orderId)->first();

        if (!$booking) {
            Log::warning('Midtrans callback: booking not found', ['order_id' => $orderId]);
            return response()->json(['message' => 'Booking not found'], 404);
        }

        // Update booking status based on transaction status
        if ($transactionStatus === 'settlement' || ($transactionStatus === 'capture' && $fraudStatus === 'accept')) {
            $booking->update(['status' => 'paid']);
            Log::info('Midtrans callback: payment settled', ['order_id' => $orderId]);
            // extensible: send payment confirmation notification here
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $booking->update(['status' => 'cancelled']);
            Log::info('Midtrans callback: payment cancelled/expired', ['order_id' => $orderId]);
        }
        // pending status — no action needed, booking is already pending

        return response()->json(['message' => 'OK']);
    }
}
