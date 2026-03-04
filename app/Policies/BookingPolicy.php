<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    /**
     * Determine whether the user can view the booking.
     */
    public function view(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id;
    }

    /**
     * Determine whether the user can pay for the booking.
     */
    public function pay(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id && $booking->isPending();
    }
}
