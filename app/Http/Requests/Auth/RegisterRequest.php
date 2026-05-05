<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Step 2 - infos personnelles
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',

            // Role (hidden input Alpine)
            'user_type' => 'required|in:expediteur,chauffeur',

            // Step 3 - expéditeur
            'adresse_principale' => 'required_if:user_type,expediteur|nullable|string|max:500',

            // Step 3 - chauffeur véhicule
            'type_vehicule' => 'required_if:user_type,chauffeur|in:moto,camionnette,camion',
            'immatriculation' => 'required_if:user_type,chauffeur|string|max:20',
            'capacite_charge_kg' => 'required_if:user_type,chauffeur|numeric|min:0',
            'capacite_volume_m3' => 'nullable|numeric|min:0',

            // Step 4 - documents chauffeur
            'doc_permis' => 'required_if:user_type,chauffeur|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'doc_carte_grise' => 'required_if:user_type,chauffeur|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'doc_assurance' => 'required_if:user_type,chauffeur|file|mimes:jpg,jpeg,png,pdf|max:5120',

            // Step 5 - conditions générales (IMPORTANT)
            'terms' => 'required|accepted',
        ];
    }

    public function messages(): array
    {
        return [
            // infos perso
            'nom.required' => 'Le nom est obligatoire.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'email.required' => 'L’email est obligatoire.',
            'email.email' => 'Email invalide.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'phone.required' => 'Le téléphone est obligatoire.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe est incorrecte.',

            // role
            'user_type.required' => 'Veuillez choisir un type de compte.',
            'user_type.in' => 'Type de compte invalide.',

            // expéditeur
            'adresse_principale.required_if' => 'L’adresse est obligatoire pour les expéditeurs.',

            // chauffeur véhicule
            'type_vehicule.required_if' => 'Le type de véhicule est obligatoire.',
            'type_vehicule.in' => 'Type de véhicule invalide.',
            'immatriculation.required_if' => 'L’immatriculation est obligatoire.',
            'capacite_charge_kg.required_if' => 'La capacité de charge est obligatoire.',
            'capacite_charge_kg.numeric' => 'La capacité doit être un nombre.',
            'capacite_volume_m3.numeric' => 'Le volume doit être un nombre.',

            // documents
            'doc_permis.required_if' => 'Le permis est obligatoire.',
            'doc_carte_grise.required_if' => 'La carte grise est obligatoire.',
            'doc_assurance.required_if' => 'L’assurance est obligatoire.',
            'doc_permis.mimes' => 'Format permis invalide.',
            'doc_carte_grise.mimes' => 'Format carte grise invalide.',
            'doc_assurance.mimes' => 'Format assurance invalide.',

            // terms (IMPORTANT pour ton bug)
            'terms.required' => 'Vous devez accepter les conditions générales.',
            'terms.accepted' => 'Vous devez accepter les conditions générales.',
        ];
    }
}