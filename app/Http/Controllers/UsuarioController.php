<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\Pedido;
use Illuminate\Support\Facades\Validator;
use App\Models\Rol;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UsuarioController extends Controller
{

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
             // Crear cliente asociado
            Cliente::create([
                'id_usuario' => $usuario->id_usuario,
                'nombre' => $usuario->nombre,
                'apePat' => $usuario->apePat,
                'apeMat' => $usuario->apeMat,
                'correo' => $usuario->correo,
                'telefono' => null,  // o asigna otro valor si tienes
            ]);

            return response()->json(['success' => '¡Registro exitoso!']);
    
        } catch (\Exception $e) {
            return response()->json(['errors' => ['server' => 'Error: ' . $e->getMessage()]], 500);
        }
    }


    public function createEmpleado()
        {
            $rolesEmpleados = Rol::whereIn('id_rol', [2, 3, 4])->get();

            // Excluir admin (suponiendo que tiene rol_id = 1)
            $usuarios = Usuario::where('rol_id', '!=', 1)->with('rol')->get();

            return view('usuarios.index', compact('rolesEmpleados', 'usuarios'));
        }
        public function storeEmpleado(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apePat' => 'required|string|max:255',
            'apeMat' => 'required|string|max:255',
            'correo' => 'required|email|unique:usuarios,correo',
            'contraseña' => 'required|string|min:8|confirmed',
            'rol_id' => 'required|in:2,3,4',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
        ], [
            'correo.unique' => 'El correo electrónico ya está registrado',
            'rol_id.in' => 'Rol no válido',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $usuario = Usuario::create([
                'nombre' => $request->nombre,
                'apePat' => $request->apePat,
                'apeMat' => $request->apeMat,
                'correo' => $request->correo,
                'contraseña' => bcrypt($request->contraseña),
                'rol_id' => $request->rol_id,
            ]);

            Empleado::create([
                'id_usuario' => $usuario->id_usuario,
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
                'fecha_contratacion' => Carbon::now()->toDateString(),
            ]);

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => '¡Empleado registrado correctamente!'
                ]);
            }

            return redirect()->back()->with('success', '¡Empleado registrado correctamente!');
            
        } catch (\Exception $e) {
            DB::rollback();

            if ($request->expectsJson()) {
                return response()->json([
                    'errors' => ['server' => 'Error del servidor: ' . $e->getMessage()]
                ], 500);
            }

            return redirect()->back()->withErrors(['server' => 'Error del servidor: ' . $e->getMessage()]);
        }
    }
public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'nombre' => 'required|string|max:255',
        'correo' => 'required|email|unique:usuarios,correo,' . $id . ',id_usuario',
        'rol' => 'required|exists:roles,id_rol',
    ]);

    if ($validator->fails()) {
        if ($request->expectsJson()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        return redirect()->back()->withErrors($validator)->withInput();
    }

    $usuario = Usuario::findOrFail($id);
    $usuario->update([
        'nombre' => $request->nombre,
        'correo' => $request->correo,
        'rol_id' => $request->rol,
    ]);

    if ($request->expectsJson()) {
        return response()->json(['success' => 'Usuario actualizado correctamente.']);
    }

    return redirect()->back()->with('success', 'Usuario actualizado correctamente.');
}



public function destroy($id)
{
    try {
        // Verificar si hay pedidos asociados al empleado
        $pedidos = Pedido::where('id_empleado', $id)->exists();

        if ($pedidos) {
            return redirect()->back()->withErrors(['error' => 'No se puede eliminar el usuario porque tiene pedidos asignados.']);
        }

        DB::beginTransaction();

        // Eliminar primero el empleado
        Empleado::where('id_usuario', $id)->delete();

        // Luego el usuario
        Usuario::where('id_usuario', $id)->delete();

        DB::commit();

        return redirect()->back()->with('success', 'Usuario eliminado correctamente.');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->withErrors(['error' => 'Error al eliminar: ' . $e->getMessage()]);
    }
}




public function updateCliente(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'nombre' => 'required|string|max:255',
        'correo' => 'required|email|unique:usuarios,correo,' . $id . ',id_usuario',
        // agregar otros campos de cliente que tengas y reglas
    ]);

    if ($validator->fails()) {
        if ($request->expectsJson()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $usuario = Usuario::findOrFail($id);
    $usuario->update([
        'nombre' => $request->nombre,
        'correo' => $request->correo,
    ]);

    $cliente = Cliente::where('id_usuario', $id)->first();
    if ($cliente) {
        $cliente->update([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            // otros campos cliente que tengas en el formulario
        ]);
    }

    if ($request->expectsJson()) {
        return response()->json(['success' => 'Cliente actualizado correctamente.']);
    }

    return redirect()->back()->with('success', 'Cliente actualizado correctamente.');
}

public function destroyCliente($id_usuario)
{
    try {
        // Buscar cliente a partir del id_usuario
        $cliente = Cliente::where('id_usuario', $id_usuario)->first();

        if (!$cliente) {
            return redirect()->back()->withErrors(['error' => 'Cliente no encontrado.']);
        }

        // Verificar si tiene pedidos asociados
        $tienePedidos = Pedido::where('id_cliente', $cliente->id_cliente)->exists();

        if ($tienePedidos) {
            return redirect()->back()->withErrors(['error' => 'No se puede eliminar el cliente porque tiene pedidos asignados.']);
        }

        DB::beginTransaction();

        // Eliminar cliente
        $cliente->delete();

        // Eliminar usuario
        Usuario::where('id_usuario', $id_usuario)->delete();

        DB::commit();

        return redirect()->back()->with('success', 'Cliente eliminado correctamente.');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->withErrors(['error' => 'Error al eliminar: ' . $e->getMessage()]);
    }
}


}