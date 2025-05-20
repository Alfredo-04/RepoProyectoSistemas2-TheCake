<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Categoria;

class ProductoController extends Controller
{
    
    public function index()
    {
        $productos = DB::table('productos as p')
            ->join('categorias_productos as c', 'p.categoria_producto_id', '=', 'c.id_categoria')
            ->select('p.*', 'c.nombre_categoria')
            ->get();

        $categorias = Categoria::all();

        return view('productos.index', compact('productos', 'categorias'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nombre_producto' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'categoria_producto_id' => 'required|exists:categorias_productos,id_categoria',
        ]);

        $producto = new Producto();
        $producto->nombre_producto = $request->nombre_producto;
        $producto->precio = $request->precio;
        $producto->descripcion = $request->descripcion;
        $producto->categoria_producto_id = $request->categoria_producto_id;

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('imagenes', 'public');
            $producto->imagen = $path;
        }

        $producto->save();

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }
    public function update(Request $request)
{
    $request->validate([
        'id_producto' => 'required|integer',
        'nombre_producto' => 'required|string|max:255',
        'precio' => 'required|numeric',
        'stock_minimo' => 'required|integer',
        'categoria_producto_id' => 'required|integer',
        'descripcion' => 'nullable|string',
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $producto = Producto::findOrFail($request->id_producto);
    $producto->nombre_producto = $request->nombre_producto;
    $producto->precio = $request->precio;
    $producto->stock_minimo = $request->stock_minimo;
    $producto->categoria_producto_id = $request->categoria_producto_id;
    $producto->descripcion = $request->descripcion;

    if ($request->hasFile('imagen')) {
        // Borra la imagen anterior si existe
        if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
            Storage::disk('public')->delete($producto->imagen);
        }
        $path = $request->file('imagen')->store('imagenes', 'public');
        $producto->imagen = $path;
    }

    $producto->save();

    return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
}

public function destroy($id)
{
    $producto = Producto::findOrFail($id);

    // Borra la imagen si está almacenada
    if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
        Storage::disk('public')->delete($producto->imagen);
    }

    $producto->delete();

    return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
}
}
