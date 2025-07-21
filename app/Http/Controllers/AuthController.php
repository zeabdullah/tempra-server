<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Http\Requests\Auth\StoreUserRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        try {
            [$token, $user] = AuthService::login($credentials);

            $payload = [];
            $payload['user'] = $user;
            $payload['auth'] = [
                'token' => $token,
                'type' => 'bearer'
            ];
            return $this->responseJson($payload, 'Logged in successfully');
        } catch (AuthorizationException $e) {
            return $this->responseJson(message: $e->getMessage(), status: $e->getCode());
        }
    }

    public function register(StoreUserRequest $request)
    {
        $validated = $request->validated();

        [$token, $user] = AuthService::register($validated);

        $payload = [];
        $payload['user'] = $user;
        $payload['auth'] = [
            'token' => $token,
            'type' => 'bearer'
        ];
        return $this->responseJson($payload, 'User created successfully', 201);
    }

    public function logout(Request $request)
    {
        if (AuthService::logout()) {
            return $this->responseJson(message: 'Successfully logged out');
        }
        return $this->responseJson(message: 'Failed to log out', status: 500);
    }

    public function refresh(Request $request)
    {
        [$refreshedToken, $user] = AuthService::refresh();

        $payload = [];
        $payload['user'] = $user;
        $payload['auth'] = [
            'token' => $refreshedToken,
            'type' => 'bearer'
        ];
        return $this->responseJson($payload);
    }
}
