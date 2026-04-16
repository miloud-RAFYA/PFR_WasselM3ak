<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offre extends Model
{
    /** @use HasFactory<\Database\Factories\OffreFactory> */
    use HasFactory;

    protected $fillable = [
        'chauffeur_id',
        'demande_id',
        'status',
        'montant_propose',
    ];

    public function chauffeur(){
        return $this->belongsTo(Chauffeur::class);
    }
    public function demande(){
        return $this->belongsTo(Demande::class);
    }
}
