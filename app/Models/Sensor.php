<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Sensor extends Model
{
    protected $fillable = [
        'name',
        'location',
        'location_name',
        'latitude',
        'longitude',
        'active',
        'status'
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Get all readings for this sensor
     */
    public function readings(): HasMany
    {
        return $this->hasMany(Reading::class);
    }

    /**
     * Get the most recent reading for this sensor
     */
    public function latestReading(): HasOne
    {
        return $this->hasOne(Reading::class)->latest();
    }

    /**
     * Get all alerts for this sensor
     */
    public function alerts(): HasMany
    {
        return $this->hasMany(Alert::class);
    }
}
