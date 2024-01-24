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

    public function messages()
    {
        return [
            'name.required' => 'To pole jest wymagane',
            'surname.required' => 'To pole jest wymagane',
            'email.required' => 'To pole jest wymagane',
            'email.email' => 'Podana wartość nie jest adresem e-mail',
            'email.unique' => 'Ten adres e-mail jest już zajęty',
            'new_password.regex' => 'Hasło musi mieć co najmniej 8 znaków i zawierać co najmniej jedną wielką literę, jedną małą literę, jedną cyfrę, jeden znak specjalny.',
            'new_password.confirmed' => 'Hasła się różnią'
        ];
    }
}
