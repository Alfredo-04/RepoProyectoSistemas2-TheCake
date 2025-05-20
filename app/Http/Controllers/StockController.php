<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Producto;
use App\Models\InventarioProducto;

class StockController extends Controller
{
    public function index()
    {
        $productos = DB::table('productos as p')
            ->leftJoin('inventario_productos as i', 'p.id_producto', '=', 'i.id_producto')
            ->select('p.id_producto', 'p.nombre_producto', 'p.precio', 'p.stock_minimo', 'p.imagen',
                     DB::raw('COALESCE(i.cantidad_disponible, 0) as stock_actual'))
            ->get();

        return view('stock.index', compact('productos'));
    }

    public function agregarStock(Request $request)
    {
        $request->validate([
            'id_producto' => 'required|exists:productos,id_producto',
            'cantidad' => 'required|integer|min:1',
        ]);

        $inventario = InventarioProducto::where('id_producto', $request->id_producto)->first();

        if ($inventario) {
            $inventario->cantidad_disponible += $request->cantidad;
            $inventario->save();
        } else {
            InventarioProducto::create([
                'id_producto' => $request->id_producto,
                'cantidad_disponible' => $request->cantidad
            ]);
        }

        return redirect()->route('stock.index')->with('success', 'Stock actualizado');
    }
}
