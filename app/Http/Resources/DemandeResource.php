<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DemandeResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'ville_depart' => $this->ville_depart,
            'ville_arrive' => $this->ville_arrive,
            'type_marchendise' => $this->type_marchendise,
            'poids_kg' => $this->poids_kg,
            'prix_estime' => $this->prix_estime,
            'description' => $this->description,
            'image_marchandise' => $this->image_marchandise ? asset('storage/'.$this->image_marchandise) : null,
            'prix_final' => $this->prix_final,
            'status' => $this->status,
            'offres_count' => $this->whenLoaded('offres', function () {
                return $this->offres->count();
            }),
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
            'expediteur' => $this->whenLoaded('expediteur', function () {
                return [
                    'id' => $this->expediteur->id,
                    'user_id' => $this->expediteur->user_id,
                ];
            }),
        ];
    }
}
