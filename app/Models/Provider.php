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
        'personal_email',
        'home_address',
        'province',
        'barangay',
        'zipcode',
        'profession',
        'year_exp',

        'resume_path',
        'barangay_clearance_path',

        'application_status',
        'application_reviewed_at',
        'application_reviewed_by',
        'application_remarks',
    ];

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
