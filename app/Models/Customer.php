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
        'gender',
        'street_address',
        'city',
        'barangay',
        'zipcode',
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
}
