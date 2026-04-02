<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // $users=User::all();
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
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'user_type' => 'required|string|in:expediteur,chauffeur',
            'adresse_principale' => 'required_if:user_type,expediteur|nullable|string|max:500',
            'type_vehicule'      => 'required_if:user_type,chauffeur|nullable|string',
            'immatriculation'    => 'required_if:user_type,chauffeur|nullable|string|unique:vehicules,immatriculation',
            'capacite_charge_kg' => 'required_if:user_type,chauffeur|nullable|numeric|min:0',
            'capacite_volume_m3' => 'nullable|numeric|min:0',

            'permis_conduire' => 'required_if:user_type,chauffeur|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'carte_grise' => 'required_if:user_type,chauffeur|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'assurance' => 'required_if:user_type,chauffeur|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'terms' => 'required|accepted',
        ];
    }
    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom est obligatoire.',
            'nom.string' => 'Le nom doit être une chaîne de caractères.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'L\'adresse email doit être valide.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'phone.required' => 'Le numéro de téléphone est obligatoire.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins :min caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'user_type.required' => 'Veuillez choisir si vous êtes un Client ou un Chauffeur.',
            'user_type.in' => 'Le type d\'utilisateur sélectionné est invalide.',

            'adresse_principale.required_if' => 'L\'adresse est obligatoire pour les clients.',

            'type_vehicule.required_if' => 'Le type de véhicule est obligatoire pour les chauffeurs.',
            'immatriculation.required_if' => 'L\'immatriculation est obligatoire.',
            'immatriculation.unique' => 'Cette immatriculation est déjà enregistrée.',
            'capacite_charge_kg.required_if' => 'La capacité de charge est obligatoire.',
            'capacite_charge_kg.numeric' => 'La charge doit être un nombre.',
            'capacite_volume_m3.numeric' => 'Le volume doit être un nombre.',
            'terms.required' => 'Vous devez accepter les conditions générales.',
        ];
    }
}
