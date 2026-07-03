<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'tbl_customers';

    protected $fillable = [
        'first_name', 
        'last_name', 
        'profile_image',
        'phone_number',
        'house_number',
        'gender',
        'birth_date',
        'street_address',
        'city',
        'barangay',
        'zipcode',
        'valid_id_path',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function user() 
    { 
        return $this->belongsTo(User::class); 
    }
    public function ratings()
    {
        return $this->hasMany(\App\Models\ServiceRating::class, 'customer_id');
    }
    public function reports()
    {
        return $this->hasMany(\App\Models\ServiceReport::class, 'customer_id');
    }
    public function receivedRatings()
    {
        return $this->hasMany(\App\Models\CustomerRating::class, 'customer_id');
    }
    public function receivedReports()
    {
        return $this->hasMany(\App\Models\CustomerReport::class, 'customer_id');
    }
    public function averageRating()
    {
        return round($this->receivedRatings()->avg('rating') ?? 0, 1);
    }
    public function ratingsCount()
    {
        return $this->receivedRatings()->count();
    }
}
