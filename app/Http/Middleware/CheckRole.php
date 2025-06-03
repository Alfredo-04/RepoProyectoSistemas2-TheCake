<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
   public function handle(Request $request, Closure $next, ...$roles)
    {
        // Combina todos los parámetros en una cadena y luego explota
        $rolesString = implode(',', $roles);
        $allowedRoles = explode(',', $rolesString);
        
        if (!Auth::check()) {
            return redirect()->route('login.show');
        }

        $userRoleId = Auth::user()->rol_id ?? null;

        if (!in_array($userRoleId, $allowedRoles)) {
            if ($userRoleId == 5) {
                // Cliente fuera de su ruta, redirige al home
                return redirect()->route('home');
            }
            abort(403, 'Acceso no autorizado. Rol actual: '.$userRoleId.', Roles permitidos: '.$rolesString);
        }

        return $next($request);
    }
}
