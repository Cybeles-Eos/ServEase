<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    
    protected $table = 'tbl_services';

    protected $fillable = [
        'user_id', 
        'first_name', 
        'last_name', 
        'phone_num', 
        'home_address', 
        'province', 
        'zip', 
        'profession', 
        'year_exp', 
        'verified_at'
    ];
    
    // ---------------------
    // Relationship
    // ---------------------
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
}
