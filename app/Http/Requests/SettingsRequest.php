<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => stringRules(),
            'surname' => stringRules(),
            'email' => array_merge(stringRules(false), ['unique:users,email,' . auth()->id()]),
            'new_password' => array_merge(stringRules(false), [passwordRegexRule(), 'confirmed']),
            'new_password_confirmation' => ['required_with:new_password']
        ];
    }
}
