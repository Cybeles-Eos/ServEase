<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    
    protected $table = 'tbl_services';

    // protected $fillable = [
    //     'provider_id',
    //     'title',
    //     'slug',
    //     'description',
    //     'content',
    //     'category',
    //     'price',
    //     'image',
    //     'jobs',---
    //     'rating',---
    //     'reviews',---
    //     'specialization',
    // ];
    protected $fillable = [
        'provider_id',
        'title',
        'slug',
        'description',
        'content',
        'category',
        'price',
        'image',
        'specialization',
    ];

    // ---------------------
    // Relationship
    // ---------------------
    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }
}
