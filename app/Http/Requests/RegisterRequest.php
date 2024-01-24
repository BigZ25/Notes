<?php

namespace App\Http\Requests;

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
            'name' => stringRules(),
            'surname' => stringRules(),
            'email' => array_merge(['unique:users,email'], emailRules()),
            'password' => array_merge(stringRules(), [passwordRegexRule()]),
        ];
    }
}
