<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingInfo extends Model
{
    use HasFactory;

    protected $table = 'booking_infos';

    protected $fillable = [
        'service_id',
        'customer_id',
        'fname',
        'lname',
        'address',
        'email',
        'number',
        'date',
        'time',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function bookingRequest()
    {
        return $this->hasOne(BookingRequest::class, 'booking_info_id');
    }
}