<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlertThreshold extends Model
{
    protected $fillable = [
        'category',
        'min_value',
        'max_value',
        'color_code',
        'display_alert',
    ];

    protected $casts = [
        'min_value' => 'integer',
        'max_value' => 'integer',
        'display_alert' => 'boolean',
    ];
}
