<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerRequest extends Model
{
    protected $fillable = [
        'customer_id',
        'title',
        'description',
        'service_type',
        'fixed_price',
        'image_path',
        'contact_name',
        'contact_email',
        'contact_phone',
        'contact_address',
        'status',
        'accepted_provider_id',
        'accepted_application_id',
        'accepted_at',
        'completed_at',
        'completion_source',
    ];

    protected $casts = [
        'fixed_price' => 'decimal:2',
        'accepted_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function applications()
    {
        return $this->hasMany(CustomerRequestApplication::class);
    }

    public function acceptedApplication()
    {
        return $this->belongsTo(CustomerRequestApplication::class, 'accepted_application_id');
    }

    public function acceptedProvider()
    {
        return $this->belongsTo(Provider::class, 'accepted_provider_id');
    }

    public function getFixedPriceLabelAttribute(): string
    {
        return '₱ ' . number_format((float) ($this->fixed_price ?? 0), 2);
    }
}
