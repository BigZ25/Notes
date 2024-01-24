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

    public function messages()
    {
        return [
            'name.required' => 'To pole jest wymagane',
            'surname.required' => 'To pole jest wymagane',
            'email.required' => 'To pole jest wymagane',
            'email.email' => 'Podana wartość nie jest adresem e-mail',
            'email.unique' => 'Ten adres e-mail jest już zajęty',
            'password.required' => 'To pole jest wymagane',
            'password.regex' => 'Hasło musi mieć co najmniej 8 znaków i zawierać co najmniej jedną wielką literę, jedną małą literę, jedną cyfrę, jeden znak specjalny.'
        ];
    }
}
