<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_ville',
    ];

    public function trajetsDepart()
    {
        return $this->hasMany(Trajet::class, 'ville_depart');
    }

    public function trajetsArrivee()
    {
        return $this->hasMany(Trajet::class, 'ville_arrivee');
    }
}
