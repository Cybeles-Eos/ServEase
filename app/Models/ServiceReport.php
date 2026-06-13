<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceReport extends Model
{
    protected $fillable = [
        'booking_request_id',
        'booking_info_id',
        'customer_id',
        'provider_id',
        'service_id',
        'reason',
        'details',
        'status',
    ];

    public function bookingRequest()
    {
        return $this->belongsTo(BookingRequest::class, 'booking_request_id');
    }

    public function bookingInfo()
    {
        return $this->belongsTo(BookingInfo::class, 'booking_info_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
