<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    /** @use HasFactory<\Database\Factories\DemandeFactory> */
    use HasFactory;
    protected $fillable = [
        'reference',
        'ville_depart',
        'ville_arrive',
        'type_marchondise',
        'poids_kg',
        'prix_estime',
        'prix_final',
        'status'
    ];
    public function offres(){
        return $this->hasMany(Offre::class);
    }
    public function evaluation(){
        return $this->hasOne(Evaluation::class);
    }
    public function suivres(){
        return $this->hasMany(Suive::class);
    }
    public function Paiement(){
        return $this->hasOne(Paiement::class);
    }
    public function expediteur(){
        return $this->belongsTo(Expediteur::class);
    }
    
}
