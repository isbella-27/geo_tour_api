<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Destination extends Model
{
    protected $fillable = [
        'title',
        'region',
        'description',
        'image',
        'pointsOfInterest',
        'bestPeriod',
    ];

    protected $casts = [
        'pointsOfInterest' => 'array',
    ];

    public function getImageAttribute($value)
    {
        if ($value && Storage::disk('public')->exists($value)) {
            // Utilise l'aide `asset()` pour générer l'URL complète vers le lien symbolique 'storage'
            return asset('storage/' . $value);
        }
        // Retourne un placeholder ou null si l'image n'est pas définie ou n'existe pas
        return null; 
    }
}
