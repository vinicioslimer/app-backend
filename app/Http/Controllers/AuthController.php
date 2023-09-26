<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            // Verifica se o email existe na tabela de usuários
            $user = User::where('email', $credentials['email'])->first();
            if (!$user) {
                return response()->json(['error' => 'Email não encontrado'], 401);
            }

            return response()->json(['error' => 'Senha incorreta'], 401);
        }

        $token = JWTAuth::attempt($credentials);

        if (!$token) {
            return response()->json(['error' => 'Falha ao gerar o token'], 401);
        }

        return response()->json(['token' => $token]);
    }
}


