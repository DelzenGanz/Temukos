<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Property extends Model
{
    protected $fillable = [
        'name',
        'city',
        'address',
        'price_month',
        'description',
        'property_type',
    ];

    protected function casts(): array
    {
        return [
            'price_month' => 'integer',
        ];
    }

    // ── Relationships ──

    public function photos(): HasMany
    {
        return $this->hasMany(PropertyPhoto::class);
    }

    public function primaryPhoto()
    {
        return $this->hasOne(PropertyPhoto::class)->where('is_primary', true);
    }

    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(Facility::class, 'property_facility');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    // extensible: add owner() belongsTo relationship when multi-landlord is implemented

    // ── Scopes ──

    public function scopeFilterByType($query, string|array|null $types)
    {
        $types = array_values(array_filter((array) $types));

        if (!empty($types)) {
            $query->whereIn('property_type', $types);
        }
        return $query;
    }

    public function scopeFilterByPrice($query, $min = null, $max = null)
    {
        if ($min) {
            $query->where('price_month', '>=', $min);
        }
        if ($max) {
            $query->where('price_month', '<=', $max);
        }
        return $query;
    }

    public function scopeFilterByFacilities($query, array $facilityIds)
    {
        if (!empty($facilityIds)) {
            foreach ($facilityIds as $facilityId) {
                $query->whereHas('facilities', function ($q) use ($facilityId) {
                    $q->where('facilities.id', $facilityId);
                });
            }
        }
        return $query;
    }

    public function scopeFilterByLocation($query, ?string $keyword)
    {
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('city', 'like', "%{$keyword}%")
                  ->orWhere('address', 'like', "%{$keyword}%");
            });
        }
        return $query;
    }

    // ── Helpers ──

    public function formattedPrice(): string
    {
        return 'Rp ' . number_format($this->price_month, 0, ',', '.');
    }

    /**
     * Check if the property is available between the given dates.
     * Uses query builder to ensure dates don't overlap with existing pending or paid bookings.
     */
    public function isAvailableBetween(string $startDate, int $durationMonths): bool
    {
        $start = \Carbon\Carbon::parse($startDate)->startOfDay();
        $end = $start->copy()->addMonths($durationMonths)->endOfDay();

        return !$this->bookings()
            ->whereIn('status', ['pending', 'paid'])
            ->where(function ($query) use ($start, $end) {
                // Check if any existing booking overlaps with the requested range
                // A booking overlaps if its start_date is before our end
                // AND its end_date (start_date + duration) is after our start
                // Since end_date is not a column, we use raw SQL or date/month arithmetic.

                // Using raw raw DB expression since MySQL DATE_ADD is standard.
                $query->whereRaw('start_date < ?', [$end])
                      ->whereRaw('DATE_ADD(start_date, INTERVAL duration_months MONTH) > ?', [$start]);
            })
            ->exists();
    }
}
