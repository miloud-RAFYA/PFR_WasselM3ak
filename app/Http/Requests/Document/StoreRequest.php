<?php

namespace App\Http\Requests\Document;

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
            'permis_conduire' => 'required_if:user_type,chauffeur|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'carte_grise' => 'required_if:user_type,chauffeur|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'assurance' => 'required_if:user_type,chauffeur|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'terms' => 'required|accepted',
        ];
    }
}
