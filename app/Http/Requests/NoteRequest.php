<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => stringRules(),
            'price' => priceRules(),
            'description' => stringRules(),
            'notes' => stringRules(false),
            'photos' => 'nullable|array|min:0'
        ];
    }
}
