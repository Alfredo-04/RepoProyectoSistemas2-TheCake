<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function index()
    {
        // Obtener productos con stock y su categoría
        $productos = DB::table('productos as p')
            ->join('categorias_productos as c', 'p.categoria_producto_id', '=', 'c.id_categoria')
            ->leftJoin('inventario_productos as ip', 'p.id_producto', '=', 'ip.id_producto')
            ->select(
                'p.id_producto',
                'p.nombre_producto',
                'p.precio',
                'p.descripcion',
                'p.imagen',
                'c.nombre_categoria',
                DB::raw('COALESCE(ip.cantidad_disponible, 0) as cantidad_disponible')
            )
            ->orderBy('c.nombre_categoria')
            ->orderBy('p.nombre_producto')
            ->get();

        // Agrupar productos por categoría
        $productosPorCategoria = $productos->groupBy('nombre_categoria');

        // Obtener métodos de pago
        $metodosPago = DB::table('metodos_pago')
            ->select('id_metodo_pago', 'nombre_metodo_pago')
            ->get();

        return view('pedido', compact('productosPorCategoria', 'metodosPago'));
    }
}
