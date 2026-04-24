<?php

namespace App\Http\Requests\Driver;

use Illuminate\Foundation\Http\FormRequest;

class OnboardingStep2Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type_vehicule' => 'required|string|in:camion,fourgonnette,voiture',
            'capacite_charge_kg' => 'required|numeric|min:0',
            'capacite_volume_m3' => 'nullable|numeric|min:0',
            'immatriculation' => 'required|string|unique:vehicules,immatriculation',
            'permis_conduire' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'carte_grise' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'assurance' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'type_vehicule.required' => 'Le type de véhicule est obligatoire.',
            'capacite_charge_kg.required' => 'La capacité de charge est obligatoire.',
            'immatriculation.required' => 'L\'immatriculation est obligatoire.',
            'immatriculation.unique' => 'Cette immatriculation est déjà enregistrée.',
            'permis_conduire.required' => 'Le permis de conduire est obligatoire.',
            'carte_grise.required' => 'La carte grise est obligatoire.',
            'assurance.required' => 'L\'assurance est obligatoire.',
            'permis_conduire.mimes' => 'Le permis doit être un fichier JPG, PNG ou PDF.',
            'carte_grise.mimes' => 'La carte grise doit être un fichier JPG, PNG ou PDF.',
            'assurance.mimes' => 'L\'assurance doit être un fichier JPG, PNG ou PDF.',
            'permis_conduire.max' => 'Le fichier ne doit pas dépasser 2MB.',
            'carte_grise.max' => 'Le fichier ne doit pas dépasser 2MB.',
            'assurance.max' => 'Le fichier ne doit pas dépasser 2MB.',
        ];
    }
}
