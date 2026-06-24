<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpResendAttempt extends Model
{
    protected $fillable = [
        'email',
        'device_key',
        'attempts',
        'window_started_at',
        'locked_until',
    ];

    protected $casts = [
        'window_started_at' => 'datetime',
        'locked_until' => 'datetime',
    ];
}
