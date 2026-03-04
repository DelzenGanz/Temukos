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

    public function scopeFilterByType($query, array $types)
    {
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
}
