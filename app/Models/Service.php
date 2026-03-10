<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tbl_services';
    protected $dates = ['deleted_at'];
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
        'service_id',
        'provider_id',
        'title',
        'slug',
        'description',
        'content',
        'category',
        'price',
        'image',
        'specialization',
        'is_active',
    ];

    // ---------------------
    // Relationship
    // ---------------------
    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }
}
