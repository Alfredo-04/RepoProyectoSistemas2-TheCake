<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Mesa;

class MesaController extends Controller
{
    public function index()
    {
        $ocupadas = Mesa::where('estado', 'ocupada')->count();
        $desocupadas = Mesa::where('estado', 'desocupada')->count();
        $mesas = Mesa::orderBy('id')->get();

        return view('mesas.index', compact('mesas', 'ocupadas', 'desocupadas'));
    }

    public function create()
    {
        return view('mesas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'numeroDeMesa' => 'required|integer|between:1,50|unique:mesas,numeroDeMesa',
            'capacidad' => 'required|integer|between:2,8',
            'estado' => 'required|in:ocupada,desocupada',
        ], [
            'numeroDeMesa.unique' => 'Ya existe el número de mesa.',
            'numeroDeMesa.integer' => 'El número de mesa debe ser un número entero.',
            'numeroDeMesa.between' => 'El número de mesa debe estar entre 1 y 50.',
        ]);

        Mesa::create($request->only(['numeroDeMesa', 'capacidad', 'estado']));

        return redirect()->route('mesas.index')->with('success', 'Mesa agregada correctamente');
    }


    public function edit(Mesa $mesa)
    {
        return view('mesas.edit', compact('mesa'));
    }

    public function update(Request $request, Mesa $mesa)
    {
        $request->validate([
            'numeroDeMesa' => 'required',
            'capacidad' => 'required|integer|min:1',
            'estado' => 'required|in:ocupada,desocupada',
        ]);

        $mesa->update($request->all());
        return redirect()->route('mesas.index')->with('success', 'Mesa actualizada correctamente');
    }

    public function destroy(Mesa $mesa)
    {
        $mesa->delete();
        return redirect()->route('mesas.index')->with('success', 'Mesa eliminada correctamente');
    }
    public function mesasDisponibles()
    {
        $mesas = \App\Models\Mesa::select('id', 'numeroDeMesa', 'capacidad')
                    ->where('estado', 'desocupada')
                    ->get();

        return response()->json($mesas);
    }
    public function actualizarEstadoMesa(Request $request)
    {
        $request->validate([
            'tableId' => 'required|integer|exists:mesas,id',
            'status' => 'required|string|in:ocupada,desocupada',
        ]);

        $mesa = \App\Models\Mesa::find($request->tableId);
        $mesa->estado = $request->status;

        if ($mesa->save()) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'error' => 'No se pudo actualizar el estado']);
        }
    }
}
