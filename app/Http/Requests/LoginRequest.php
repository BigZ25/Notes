<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => emailRules(),
            'password' => stringRules(),
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'To pole jest wymagane',
            'email.email' => 'Podana wartość nie jest adresem e-mail',
            'password.required' => 'To pole jest wymagane',
        ];
    }
}
