<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expediteur extends Model
{
    /** @use HasFactory<\Database\Factories\ExpediteurFactory> */
    use HasFactory;
    protected $fillable = [
        'adresse_principale',
        'total_envois',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }
}
