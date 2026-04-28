<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'demande_id',
        'expediteur_id',
        'chauffeur_id',
        'last_message',
    ];

    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }

    public function expediteur()
    {
        return $this->belongsTo(Expediteur::class);
    }

    public function chauffeur()
    {
        return $this->belongsTo(Chauffeur::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
