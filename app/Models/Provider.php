<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    
    protected $table = 'tbl_providers';
    protected $fillable = [
        'user_id', 
        'phone_num', 
        'home_address', 
        'province', 
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
}
