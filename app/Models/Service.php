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
        'service_category_id',
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
    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }
    public function ratings()
    {
        return $this->hasMany(\App\Models\ServiceRating::class, 'service_id');
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
