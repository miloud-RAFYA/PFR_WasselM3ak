<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    /** @use HasFactory<\Database\Factories\PaiementFactory> */
    use HasFactory;
    protected $fillable = [
        'mantant_toal',
        'commission',
        'mode_paiement',
        'status',
    ];
    public function demande(){
        return $this->belongsTo(Demande::class);
    }
}
