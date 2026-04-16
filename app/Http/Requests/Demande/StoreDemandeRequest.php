<?php

namespace App\Http\Requests\Demande;

use Illuminate\Foundation\Http\FormRequest;

class StoreDemandeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isClient();
    }

    public function rules(): array
    {
        return [
            'ville_depart' => 'required|string|max:255',
            'ville_arrive' => 'required|string|max:255',
            'type_marchendise' => 'required|string|max:255',
            'poids_kg' => 'required|numeric|min:0.1',
            'prix_estime' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'image_marchandise' => 'nullable|image|max:5120',
            'reference' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'ville_depart.required' => 'La ville de départ est requise.',
            'ville_arrive.required' => 'La ville d arrivée est requise.',
            'type_marchendise.required' => 'Le type de marchandise est requis.',
            'poids_kg.required' => 'Le poids estimé est requis.',
            'prix_estime.required' => 'Le prix estimé est requis.',
            'image_marchandise.image' => 'Le fichier doit être une image valide.',
            'image_marchandise.max' => 'L image ne doit pas dépasser 5 Mo.',
        ];
    }
}
