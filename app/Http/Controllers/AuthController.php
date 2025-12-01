<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // FUNCIÓN DE LOGIN
    public function login(Request $request)
    {
        // 1. Validar que envíen email y contraseña
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // 2. Intentar autenticar con esas credenciales
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Credenciales incorrectas'
            ], 401);
        }

        // 3. Buscar al usuario para verificar si es Admin
        $user = User::where('email', $request->email)->firstOrFail();

        if ($user->is_admin == false) {
            return response()->json([
                'message' => 'No tienes permisos de administrador para entrar aquí.'
            ], 403);
        }

        // 4. Si pasa todo, crear el Token
        $token = $user->createToken('auth_token')->plainTextToken;

        // 5. Devolver el token y los datos del usuario a React
        return response()->json([
            'message' => 'Hola ' . $user->nombre,
            'accessToken' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    // FUNCIÓN DE LOGOUT
    public function logout()
    {
        // Borra los tokens del usuario que está haciendo la petición
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Sesión cerrada correctamente'
        ]);
    }
}