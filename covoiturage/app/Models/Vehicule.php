<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'marque',
        'modele',
        'immatriculation',
        'nombre_places',
    ];

    protected $casts = [
        'nombre_places' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trajets()
    {
        return $this->hasMany(Trajet::class);
    }
}
