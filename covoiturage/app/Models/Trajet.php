<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trajet extends Model
{
    use HasFactory;

    protected $fillable = [
        'ville_depart',
        'ville_arrivee',
        'date',
        'heure',
        'prix',
        'places_disponibles',
        'conducteur_id',
        'vehicule_id',
    ];

    protected $casts = [
        'date' => 'date',
        'heure' => 'string',
        'prix' => 'integer',
        'places_disponibles' => 'integer',
    ];

    public function conducteur()
    {
        return $this->belongsTo(User::class, 'conducteur_id');
    }

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function villeDepart()
    {
        return $this->belongsTo(Ville::class, 'ville_depart');
    }

    public function villeArrivee()
    {
        return $this->belongsTo(Ville::class, 'ville_arrivee');
    }
}
