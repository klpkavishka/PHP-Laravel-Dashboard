<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alert extends Model
{
    protected $fillable = [
        'sensor_id',
        'type',
        'message',
        'active',
        'threshold_value',
        'triggered_value',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Get the sensor that owns this alert
     */
    public function sensor(): BelongsTo
    {
        return $this->belongsTo(Sensor::class);
    }
}
