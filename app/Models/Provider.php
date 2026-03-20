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
        'profession',
        'year_exp',
        'zip', 
        'profession', 
        'year_exp'
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
}
