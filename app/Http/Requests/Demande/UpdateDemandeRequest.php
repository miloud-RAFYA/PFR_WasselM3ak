<?php

namespace App\Http\Requests\Demande;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDemandeRequest extends FormRequest
{
    public function authorize(): bool
    {
        $demande = $this->route('demande');

        if (! $demande) {
            return false;
        }

        return $this->user() && $this->user()->id === $demande->expediteur->user_id;
    }

    public function rules(): array
    {
        return [
            'ville_depart' => 'sometimes|required|string|max:255',
            'ville_arrive' => 'sometimes|required|string|max:255',
            'type_marchendise' => 'sometimes|required|string|max:255',
            'poids_kg' => 'sometimes|required|numeric|min:0.1',
            'prix_estime' => 'sometimes|required|numeric|min:0',
            'status' => 'sometimes|required|in:pending,in_progress,delivered',
            'prix_final' => 'sometimes|nullable|numeric|min:0',
        ];
    }
}
