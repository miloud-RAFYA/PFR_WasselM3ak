<?php

namespace App\Http\Requests\Vehicule;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->role->type='chauffeur';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type_vehicule'      => 'required_if:user_type,chauffeur|nullable|string',
            'immatriculation'    => 'required_if:user_type,chauffeur|nullable|string|unique:vehicules,immatriculation',
            'capacite_charge_kg' => 'required_if:user_type,chauffeur|nullable|numeric|min:0',
            'capacite_volume_m3' => 'nullable|numeric|min:0',
        ];
    }
}
