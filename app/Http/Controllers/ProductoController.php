<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
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
}
