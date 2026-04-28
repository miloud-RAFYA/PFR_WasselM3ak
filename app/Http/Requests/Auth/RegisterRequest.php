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

            // Chauffeur - Véhicule
            'type_vehicule' => 'required_if:user_type,chauffeur|string|in:moto,camionnette,camion',
            'immatriculation' => 'required_if:user_type,chauffeur|string|max:20',
            'capacite_charge_kg' => 'required_if:user_type,chauffeur|numeric|min:0',
            'capacite_volume_m3' => 'nullable|numeric|min:0',

            // Chauffeur - Documents
            'doc_permis' => 'required_if:user_type,chauffeur|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'doc_carte_grise' => 'required_if:user_type,chauffeur|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'doc_assurance' => 'required_if:user_type,chauffeur|file|mimes:jpg,jpeg,png,pdf|max:5120',
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

            // Chauffeur - Véhicule
            'type_vehicule.required_if' => 'Le type de véhicule est obligatoire pour les chauffeurs.',
            'type_vehicule.in' => 'Le type de véhicule sélectionné est invalide.',
            'immatriculation.required_if' => 'L\'immatriculation est obligatoire.',
            'capacite_charge_kg.required_if' => 'La capacité de charge est obligatoire.',
            'capacite_charge_kg.numeric' => 'La charge doit être un nombre.',
            'capacite_volume_m3.numeric' => 'Le volume doit être un nombre.',

            // Chauffeur - Documents
            'doc_permis.required_if' => 'Le permis de conduire est obligatoire.',
            'doc_permis.file' => 'Le permis doit être un fichier.',
            'doc_permis.mimes' => 'Le permis doit être au format JPG, PNG ou PDF.',
            'doc_permis.max' => 'Le permis ne doit pas dépasser 5 Mo.',
            'doc_carte_grise.required_if' => 'La carte grise est obligatoire.',
            'doc_carte_grise.file' => 'La carte grise doit être un fichier.',
            'doc_carte_grise.mimes' => 'La carte grise doit être au format JPG, PNG ou PDF.',
            'doc_carte_grise.max' => 'La carte grise ne doit pas dépasser 5 Mo.',
            'doc_assurance.required_if' => 'L\'assurance est obligatoire.',
            'doc_assurance.file' => 'L\'assurance doit être un fichier.',
            'doc_assurance.mimes' => 'L\'assurance doit être au format JPG, PNG ou PDF.',
            'doc_assurance.max' => 'L\'assurance ne doit pas dépasser 5 Mo.',

            'terms.required' => 'Vous devez accepter les conditions générales.',
        ];
    }
}
