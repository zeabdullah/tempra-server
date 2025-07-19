<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        return $this->responseJson(
            message: 'not implemented',
            status: 501
        );

    }

    public function register(Request $request)
    {
        return $this->responseJson(
            message: 'not implemented',
            status: 501
        );
    }
}
