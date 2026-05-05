<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chauffeur extends Model
{
    /** @use HasFactory<\Database\Factories\ChauffeurFactory> */
    use HasFactory;
    protected $fillable = [
        'status',
        'note_moyenne',
        'total_livraisons',
        'commentaire_admin'
    ];
    
     public function user(){
        return $this->belongsTo(User::class);
    }
    public function documents(){
        return $this->hasMany(Document::class);
    }
    public function vehicule(){
        return $this->hasOne(Vehicule::class);
    }
    public function offres(){
        return $this->hasMany(Offre::class);
    }
    public function is_available(){
        
    }
}
