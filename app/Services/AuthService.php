<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public static function login(array $credentials)
    {
        if (!$token = Auth::attempt($credentials)) {
            throw new AuthorizationException('Unauthorized', 401);
        }
        return [$token, Auth::user()];
    }

    public static function register(array $validated_data)
    {
        $user = User::create([
            'first_name' => $validated_data['first_name'],
            'last_name' => $validated_data['last_name'],
            'email' => $validated_data['email'],
            'password' => Hash::make($validated_data['password']),
            'avatar_url' => $validated_data['avatar_url'],
        ]);

        $token = Auth::login($user);
        return [$token, $user];
    }

    public static function logout()
    {
        Auth::logout();
        return true;
    }

    public static function refresh()
    {
        return [Auth::refresh(), Auth::user()];
    }
}
