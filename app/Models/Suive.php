<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suive extends Model
{
    /** @use HasFactory<\Database\Factories\SuiveFactory> */
    use HasFactory;

     protected $fillable = [
        'latitude',
        'longitude',
        'horodatage',
    ];
    
    public function demande(){
        return $this->belongsTo(Demande::class);
    }
}
