<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(LoginRequest $loginRequest)
    {
        $credentials = $loginRequest->validated();
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            //Pode deixar a função, se estiver com erro é apenas o inteliphense, porém esse método funciona no laravel 9
            $token = $user->createToken('auth-token')->plainTextToken;
            return response()->json(['token' => $token]);
        }
    
        return response()->json(['message' => 'Credenciais inválidas'], 401);
    }
}
