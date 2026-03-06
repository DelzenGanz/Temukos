<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Facility extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'property_type',
    ];

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'property_facility');
    }

    public function scopeForPropertyType($query, ?string $propertyType)
    {
        if ($propertyType) {
            $query->where('property_type', $propertyType);
        }

        return $query;
    }
}
