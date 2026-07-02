<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlatformSetting extends Model
{
    protected $fillable = [
        'platform_email',
        'phone_number',
        'facebook_page',
        'office_address',
        'support_hours',
        'platform_name',
        'platform_tagline',
        'service_area',
        'privacy_policy_url',
        'terms_url',
        'front_logo_path',
        'front_footer_logo_path',
        'front_favicon_path',
        'meta_image_path',
        'otp_enabled',
    ];

    protected $casts = [
        'otp_enabled' => 'boolean',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate([], [
            'platform_name' => 'ServEase',
            'platform_tagline' => 'Service help with ease and convenience.',
            'service_area' => 'Burgos Barangay Hall Rodriguez, Rizal',
            'support_hours' => 'Mon-Sat, 8:00 AM - 5:00 PM',
            'otp_enabled' => true,
        ]);
    }
}
