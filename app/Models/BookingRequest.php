<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingRequest extends Model
{
    use HasFactory;

    protected $table = 'booking_requests';

    protected $fillable = [
        'booking_info_id',
        'provider_id',
        'status',
        'responded_at',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
    ];

    public function bookingInfo()
    {
        return $this->belongsTo(BookingInfo::class, 'booking_info_id');
    }
    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }
    public function rating()
    {
        return $this->hasOne(\App\Models\ServiceRating::class, 'booking_request_id');
    }
}