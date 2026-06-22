<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyOtpUsage extends Model
{
    protected $fillable = [
        'date',
        'used',
    ];

    protected $casts = [
        'date' => 'date',
        'used' => 'integer',
    ];
}
