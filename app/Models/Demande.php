<?php

namespace App\Models;

use App\Models\Chauffeur;
use App\Models\Offre;
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
        'type_marchendise',
        'poids_kg',
        'prix_estime',
        'description',
        'image_marchandise',
        'prix_final',
        'status',
        'expediteur_id'
    ];
    public function offres(){
        return $this->hasMany(Offre::class);
    }

    public function acceptedOffre()
    {
        return $this->hasOne(Offre::class)->where('status', 'acceptee');
    }

    public function isAssignedToDriver(Chauffeur $chauffeur): bool
    {
        return $this->offres()
            ->where('status', 'acceptee')
            ->where('chauffeur_id', $chauffeur->id)
            ->exists();
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
