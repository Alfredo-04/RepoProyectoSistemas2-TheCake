<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login-signup');
    }
    
    

    /* public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'contraseña' => 'required'
        ]);

        $credentials = $request->only('correo', 'contraseña');
        
        // Autenticación manual más segura
        $user = \App\Models\Usuario::where('correo', $credentials['correo'])->first();
        
        if (!$user || !Hash::check($credentials['contraseña'], $user->contraseña)) {
            return back()->withErrors([
                'correo' => 'Las credenciales proporcionadas son incorrectas.',
            ]);
        }

        Auth::login($user); // Usa el guard por defecto
        
        return redirect()->intended('/dashboard'); // Cambia a tu ruta deseada
    } */

    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'contraseña' => 'required'
        ]);

        $credentials = $request->only('correo', 'contraseña');

        $user = \App\Models\Usuario::where('correo', $credentials['correo'])->first();

        if (!$user || !Hash::check($credentials['contraseña'], $user->contraseña)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'errors' => ['correo' => 'Credenciales incorrectas']
                ], 422);
            }

            return back()->withErrors([
                'correo' => 'Las credenciales proporcionadas son incorrectas.',
            ]);
        }

        Auth::login($user);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => '¡Bienvenido!',
                'redirect' => route('dashboard')
            ]);
        }

        return redirect()->intended('/dashboard');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login-signup');
    }
}