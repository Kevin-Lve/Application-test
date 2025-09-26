<?php

namespace App\Http\Requests\Consommable;

use Illuminate\Foundation\Http\FormRequest;

class AdjustConsommableQuantityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'mode' => ['required', 'in:increase,decrease'],
            'amount' => ['required', 'integer', 'min:1'],
        ];
    }

    public function delta(): int
    {
        $amount = (int) $this->validated('amount');

        return $this->validated('mode') === 'decrease'
            ? -$amount
            : $amount;
    }
}
