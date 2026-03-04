<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'property_id',
        'start_date',
        'duration_months',
        'total_price',
        'status',
        'midtrans_order_id',
        'snap_token',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'duration_months' => 'integer',
            'total_price' => 'integer',
        ];
    }

    // ── Relationships ──

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    // ── Helpers ──

    public function formattedTotalPrice(): string
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    // extensible: add notification relationship or scope when notification system is implemented
}
