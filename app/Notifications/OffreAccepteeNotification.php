<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class OffreAccepteeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $offre;

    public function __construct($offre)
    {
        $this->offre = $offre;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            // 🧠 TYPE (important pour UI)
            'type' => 'offre_acceptee',

            // 🏷️ TITRE
            'title' => 'Offre acceptée 🎉',

            // 💬 MESSAGE PRO
            'message' => "Votre offre de {$this->offre->montant_propose} DH a été acceptée",

            // 📦 DATA UTILE
            'demande_id' => $this->offre->demande_id,
            'offre_id' => $this->offre->id,
            'montant' => $this->offre->montant_propose,

            // 🔗 LIEN DIRECT (UX 🔥)
            'url' => route('driver.demandes.show', $this->offre->demande_id),

            // 🎨 ICÔNE (frontend)
            'icon' => 'check-circle',
            'color' => 'green',
        ];
    }
}