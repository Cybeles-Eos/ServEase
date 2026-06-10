<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;
    protected $table = 'tbl_providers';
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'profile_image',
        'phone_number',
        'home_address',
        'province',
        'barangay',
        'zipcode',
        'profession',
        'year_exp',
        'availability_days',
        'availability_start_time',
        'availability_end_time',

        'resume_path',
        'barangay_clearance_path',

        'application_status',
        'application_reviewed_at',
        'application_reviewed_by',
        'application_remarks',
    ];

    protected $casts = [
        'availability_days' => 'array',
    ];

    public const AVAILABILITY_DAYS = [
        'mon' => 'Monday',
        'tue' => 'Tuesday',
        'wed' => 'Wednesday',
        'thu' => 'Thursday',
        'fri' => 'Friday',
        'sat' => 'Saturday',
        'sun' => 'Sunday',
    ];

    public const AVAILABILITY_DAY_SHORT_LABELS = [
        'mon' => 'Mon',
        'tue' => 'Tue',
        'wed' => 'Wed',
        'thu' => 'Thu',
        'fri' => 'Fri',
        'sat' => 'Sat',
        'sun' => 'Sun',
    ];

    public const DEFAULT_AVAILABILITY_DAYS = ['mon', 'tue', 'wed', 'thu', 'fri'];
    public const DEFAULT_AVAILABILITY_START_TIME = '08:00';
    public const DEFAULT_AVAILABILITY_END_TIME = '22:00';
    public const ACCOUNT_HEALTH_LIMIT = 20;

    public function availabilityDays(): array
    {
        $days = is_array($this->availability_days) ? $this->availability_days : [];
        $days = array_values(array_intersect(array_keys(self::AVAILABILITY_DAYS), $days));

        return !empty($days) ? $days : self::DEFAULT_AVAILABILITY_DAYS;
    }

    public function availabilityStartTime(): string
    {
        return $this->availability_start_time
            ? \Carbon\Carbon::parse($this->availability_start_time)->format('H:i')
            : self::DEFAULT_AVAILABILITY_START_TIME;
    }

    public function availabilityEndTime(): string
    {
        return $this->availability_end_time
            ? \Carbon\Carbon::parse($this->availability_end_time)->format('H:i')
            : self::DEFAULT_AVAILABILITY_END_TIME;
    }

    public function availabilityLabel(): string
    {
        $days = $this->availabilityDays();

        $dayLabel = $days === self::DEFAULT_AVAILABILITY_DAYS
            ? 'Mon-Fri'
            : (count($days) === count(self::AVAILABILITY_DAYS)
            ? 'Mon-Sun'
            : collect($days)
                ->map(fn ($day) => self::AVAILABILITY_DAY_SHORT_LABELS[$day] ?? null)
                ->filter()
                ->implode(', '));

        $startTime = \Carbon\Carbon::parse($this->availabilityStartTime())->format('g:i A');
        $endTime = \Carbon\Carbon::parse($this->availabilityEndTime())->format('g:i A');

        return $dayLabel . ', ' . $startTime . ' - ' . $endTime;
    }

    public function isAvailableAt($date, $time): bool
    {
        if (!$date || !$time) {
            return true;
        }

        $dayKey = strtolower(\Carbon\Carbon::parse($date)->format('D'));
        $dayKey = ['mon' => 'mon', 'tue' => 'tue', 'wed' => 'wed', 'thu' => 'thu', 'fri' => 'fri', 'sat' => 'sat', 'sun' => 'sun'][$dayKey] ?? null;

        if (!$dayKey || !in_array($dayKey, $this->availabilityDays(), true)) {
            return false;
        }

        $requestedTime = \Carbon\Carbon::parse($time)->format('H:i');
        $startTime = $this->availabilityStartTime();
        $endTime = $this->availabilityEndTime();

        return $requestedTime >= $startTime && $requestedTime <= $endTime;
    }

    public function accountHealth(): array
    {
        $limit = self::ACCOUNT_HEALTH_LIMIT;

        $metrics = collect([
            [
                'key' => 'declines',
                'title' => 'Declined Requests',
                'description' => 'Booking requests declined by the provider.',
                'count' => \App\Models\BookingRequest::where('provider_id', $this->id)
                    ->where('status', 'DECLINED')
                    ->count(),
            ],
            [
                'key' => 'cancellations',
                'title' => 'Provider Cancellations',
                'description' => 'Accepted or pending bookings cancelled by the provider.',
                'count' => \App\Models\BookingRequest::where('provider_id', $this->id)
                    ->where('status', 'CANCELLED')
                    ->where('cancelled_by', 'provider')
                    ->count(),
            ],
            [
                'key' => 'reports',
                'title' => 'Customer Reports',
                'description' => 'Completed bookings reported by customers.',
                'count' => \App\Models\ServiceReport::where('provider_id', $this->id)->count(),
            ],
        ])->map(function ($metric) use ($limit) {
            $metric['limit'] = $limit;
            $metric['percentage'] = min(100, (int) round(($metric['count'] / $limit) * 100));
            $metric['is_subject'] = $metric['count'] >= $limit;

            return $metric;
        })->values()->all();

        $maxPercentage = collect($metrics)->max('percentage') ?? 0;

        return [
            'limit' => $limit,
            'overall_percentage' => $maxPercentage,
            'is_subject' => collect($metrics)->contains(fn ($metric) => $metric['is_subject']),
            'metrics' => $metrics,
        ];
    }

    // ---------------------
    // Relationship
    // ---------------------
    public function user() 
    { 
        return $this->belongsTo(User::class); 
    }
    public function service()
    {
        return $this->hasMany(Service::class);
    }
    public function ratings()
    {
        return $this->hasMany(\App\Models\ServiceRating::class, 'provider_id');
    }
    public function reports()
    {
        return $this->hasMany(\App\Models\ServiceReport::class, 'provider_id');
    }

    public function averageRating()
    {
        return round($this->ratings()->avg('rating') ?? 0, 1);
    }

    public function ratingsCount()
    {
        return $this->ratings()->count();
    }
}
