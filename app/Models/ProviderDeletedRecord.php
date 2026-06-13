<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProviderDeletedRecord extends Model
{
    protected $fillable = [
        'provider_name',
        'provider_email',
        'deleted_at',
    ];

    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }
}
