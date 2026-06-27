<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerRequestApplication extends Model
{
    protected $fillable = [
        'customer_request_id',
        'provider_id',
        'notes',
        'status',
        'applied_at',
        'accepted_at',
        'customer_seen_at',
        'provider_seen_at',
    ];

    protected $casts = [
        'applied_at' => 'datetime',
        'accepted_at' => 'datetime',
        'customer_seen_at' => 'datetime',
        'provider_seen_at' => 'datetime',
    ];

    public function customerRequest()
    {
        return $this->belongsTo(CustomerRequest::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }
}
