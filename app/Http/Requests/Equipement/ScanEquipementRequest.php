<?php

namespace App\Http\Requests\Equipement;

use Illuminate\Foundation\Http\FormRequest;

class ScanEquipementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:255'],
        ];
    }

    public function code(): string
    {
        return trim($this->validated('code'));
    }

    public function normalizedCode(): string
    {
        return preg_replace('/[^A-Z0-9]/', '', strtoupper($this->code()));
    }
}
