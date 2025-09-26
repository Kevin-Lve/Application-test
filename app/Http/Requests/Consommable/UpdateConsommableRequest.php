<?php

namespace App\Http\Requests\Consommable;

use Illuminate\Foundation\Http\FormRequest;

class UpdateConsommableRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'nom' => ['required', 'string', 'max:255'],
            'reference' => ['nullable', 'string', 'max:255'],
            'code_barre' => ['nullable', 'string', 'max:255'],
            'numero_serie' => ['nullable', 'string', 'max:255'],
            'immo' => ['nullable', 'string', 'max:50'],
            'adresse_mac' => ['nullable', 'string', 'max:32'],
            'quantite_stock' => ['required', 'integer', 'min:0'],
            'quantite_minimale' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
