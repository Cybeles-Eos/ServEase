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
        'customer_seen_at',
        'provider_seen_at',
        'cancelled_by',
        'completed_hours',
        'completed_minutes',
        'completed_total',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
        'completed_hours' => 'integer',
        'completed_minutes' => 'integer',
        'completed_total' => 'decimal:2',
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

    public function report()
    {
        return $this->hasOne(\App\Models\ServiceReport::class, 'booking_request_id');
    }

    public function getBillingTotalAttribute(): float
    {
        $service = $this->bookingInfo?->service;
        $price = (float) ($service?->price ?? 0);

        if (($service?->pricing_type ?? 'fixed') !== 'per_hour') {
            return $price;
        }

        if ($this->completed_total !== null) {
            return (float) $this->completed_total;
        }

        if ($this->completed_hours !== null || $this->completed_minutes !== null) {
            $totalMinutes = ((int) ($this->completed_hours ?? 0) * 60)
                + (int) ($this->completed_minutes ?? 0);

            return round(($totalMinutes / 60) * $price, 2);
        }

        return $price;
    }

    public function getBillingTotalLabelAttribute(): string
    {
        return '₱' . number_format($this->billing_total, 2);
    }

    public function getCompletedDurationLabelAttribute(): ?string
    {
        if ($this->completed_hours === null && $this->completed_minutes === null) {
            return null;
        }

        $hours = (int) ($this->completed_hours ?? 0);
        $minutes = (int) ($this->completed_minutes ?? 0);

        if ($hours === 0) {
            return $minutes . ' min';
        }

        if ($minutes === 0) {
            return $hours . ' hr' . ($hours === 1 ? '' : 's');
        }

        return $hours . ' hr' . ($hours === 1 ? '' : 's') . ' ' . $minutes . ' min';
    }
}
