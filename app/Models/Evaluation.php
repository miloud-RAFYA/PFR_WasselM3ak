<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    /** @use HasFactory<\Database\Factories\EvaluationFactory> */
    use HasFactory;
    protected $fillable = [
        'adresse_principale',
        'tota_envois',
    ];
    public function demande(){
        return $this->belongsTo(Demande::class);
    }
}
