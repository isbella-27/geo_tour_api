<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hebergement extends Model
{
    protected $fillable = [
        'title',
        'location',
        'rating',
        'price',
        'description',
        'features', 
        'image',
        'type',
    ];

    protected $casts = [
        'features' => 'array',
        'rating' => 'float', 
    ];
}
