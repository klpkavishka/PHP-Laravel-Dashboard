<?php

namespace App\Models;

use App\Events\NewAirQualityReading;
use Illuminate\Database\Eloquent\Model;

class Reading extends Model
{
    protected $fillable = [
        'sensor_id',
        'aqi',
        'pm25',
        'pm10',
        'status',
        'reading_time',
    ];

    protected $casts = [
        'reading_time' => 'datetime',
        'aqi' => 'float',
        'pm25' => 'float',
        'pm10' => 'float',
    ];

    protected $dispatchesEvents = [
        'created' => NewAirQualityReading::class,
    ];

    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }
}
