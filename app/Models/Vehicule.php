<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    /** @use HasFactory<\Database\Factories\VehiculeFactory> */
    use HasFactory;

    protected $fillable = [
        'chauffeur_id',
        'type',
        'immatriculation',
        'capacite_charge_kg',
        'capacite_volume_m3',
    ];

    public function chauffeur(){
        return $this->belongsTo(Chauffeur::class);
    }
   
}
