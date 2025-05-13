<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Cliente;
use Illuminate\Support\Facades\Validator;





class UsuarioController extends Controller
{

    // Constructor
    /* public function __construct()
    {
        $this->middleware('auth:usuario');
    } */

    // Mostrar formulario de creación
    public function create()
    {
        return view('usuarios.create');
    }

    // Guardar el nuevo usuario (como cliente)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apePat' => 'required|string|max:255',
            'apeMat' => 'nullable|string|max:255',
            'correo' => 'required|email|unique:usuarios,correo',
            'contraseña' => 'required|string|min:8|confirmed'
        ],[
            'correo.unique' => 'El correo electrónico ya está registrado',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        try {
            // Crear usuario
            $usuario = Usuario::create([
                'nombre' => $request['nombre'],
                'apePat' => $request['apePat'],
                'apeMat' => $request['apeMat'],
                'correo' => $request['correo'],
                'contraseña' => bcrypt($request['contraseña']),
                'rol_id' => 5
            ]);

            return response()->json(['success' => '¡Registro exitoso!']);
    
        } catch (\Exception $e) {
            return response()->json(['errors' => ['server' => 'Error: ' . $e->getMessage()]], 500);
        }
    }   
}