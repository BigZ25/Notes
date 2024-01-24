<?php

namespace App\Http\Controllers;

use App\DB\Models\User;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\SettingsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (!Auth::attempt($credentials)) {
            return errorResponse("Błędne dane logowania", 422);
        }

        $token = auth()->user()->createToken('authToken');

        return vueResponse('Zalogowano', 'success',
            [
                'session' => [
                    'access_token' => $token->accessToken,
                    'auth_token' => $token->token->id,
                    'user' => auth()->user()
                ]
            ]
        );
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        $credentials = [
            'email' => $user->email,
            'password' => $request->password
        ];

        Auth::attempt($credentials);

        $token = auth()->user()->createToken('authToken');

        return vueResponse('Konto zostało utworzone', 'success',
            [
                'session' => [
                    'access_token' => $token->accessToken,
                    'auth_token' => $token->token->id,
                    'user' => auth()->user()
                ]
            ]
        );
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();

        return vueResponse('Wylogowano', 'success');
    }

    public function settings(SettingsRequest $request)
    {
        $data = $request->validated();

        if ($data['new_password'] !== null && $data['new_password'] === $data['new_password_confirmation']) {
            $data['password'] = bcrypt($data['new_password']);
        }

        unset($data['new_password']);
        unset($data['new_password_confirmation']);

        auth()->user()->update($data);

        return vueResponse('Ustawienia zostały zapisane', 'success');
    }
}
