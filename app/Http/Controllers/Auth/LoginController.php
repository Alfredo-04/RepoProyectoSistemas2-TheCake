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
        return view('auth.login-signup', ['rol' => Auth::check() ? Auth::user()->rol_id : null]);
    }

    
    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'contraseña' => 'required'
        ]);

        $credentials = $request->only('correo', 'contraseña');

        $user = \App\Models\Usuario::where('correo', $credentials['correo'])->first();

        if (!$user || !Hash::check($credentials['contraseña'], $user->contraseña)) {
            return back()->withErrors(['correo' => 'Credenciales incorrectas'])->withInput();
        }

        Auth::login($user);

        return $this->redirectByRole($user->rol_id);
    }

    protected function redirectByRole($rol_id)
    {
        switch ($rol_id) {
            case 5: // Cliente
                return redirect()->route('home')->with('success', 'Inicio de sesión exitoso');  // Ruta pública o de cliente
            case 1: // Admin
            case 2: // Cajero
            case 3: // Mesero
            case 4: // Cocinero
                return redirect()->route('dashboard')->with('success', 'Inicio de sesión exitoso'); // Ruta para roles internos
            default:
                Auth::logout();
                return redirect()->route('login.show')->withErrors(['correo' => 'Rol no permitido.']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login-signup');
    }
}
