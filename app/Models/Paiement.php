<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'demande_id',
        'montant_total',
        'commission',
        'mode_paiement',
        'status',
    ];

    protected $casts = [
        'montant_total' => 'float',
        'commission' => 'float',
    ];

    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }
}