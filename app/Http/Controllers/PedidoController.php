<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\InventarioProducto;
use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Cliente;
use App\Models\Usuario; 
use Illuminate\Support\Facades\Auth; // Solo si lo usás en auth()

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
    /* public function procesarPedido(Request $request)
    {
        if (!class_exists('App\Models\Pedido')) {
            return response()->json([
                'success' => false,
                'message' => 'Clase Pedido no encontrada.'
            ], 500);
        }
        // Validar la información recibida
        $data = $request->validate([
            'cart' => 'required|array',
            'cart.*.id' => 'required|integer|exists:inventario_productos,id_producto',
            'cart.*.quantity' => 'required|integer|min:1',
            'cart.*.price' => 'required|numeric|min:0',
            'metodoPagoId' => 'required|integer|exists:metodos_pago,id_metodo_pago',
            'total' => 'required|numeric|min:0',
        ]);

        // Validar stock
        foreach ($data['cart'] as $item) {
            $producto = InventarioProducto::where('id_producto', $item['id'])->first();
            if (!$producto || $producto->cantidad_disponible < $item['quantity']) {
                return response()->json([
                    'success' => false,
                    'message' => "No hay suficiente stock para el producto ID: {$item['id']}"
                ], 400);
            }
        }

        DB::beginTransaction();

        try {
            $pedido = Pedido::create([
                'id_cliente' => 1, // Cambiar según contexto
                'id_empleado' => 1, // Cambiar según contexto
                'metodo_pago_id' => $data['metodoPagoId'],
                'estado_pedido' => 'Pendiente',
                'total' => $data['total'],
            ]);

            foreach ($data['cart'] as $item) {
                DetallePedido::create([
                    'id_pedido' => $pedido->id_pedido,
                    'id_producto' => $item['id'],
                    'cantidad' => $item['quantity'],
                    'precio_unitario' => $item['price'],
                ]);

                InventarioProducto::where('id_producto', $item['id'])->decrement('cantidad_disponible', $item['quantity']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pedido procesado correctamente.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el pedido: ' . $e->getMessage()
            ], 500);
        }
    } */
   public function procesarPedido(Request $request)
    {
        if (!class_exists('App\Models\Pedido')) {
            return response()->json([
                'success' => false,
                'message' => 'Clase Pedido no encontrada.'
            ], 500);
        }

        // Validar la información recibida
        $data = $request->validate([
            'cart' => 'required|array',
            'cart.*.id' => 'required|integer|exists:inventario_productos,id_producto',
            'cart.*.quantity' => 'required|integer|min:1',
            'cart.*.price' => 'required|numeric|min:0',
            'metodoPagoId' => 'required|integer|exists:metodos_pago,id_metodo_pago',
            'total' => 'required|numeric|min:0',
        ]);

        // Validar stock
        foreach ($data['cart'] as $item) {
            $producto = InventarioProducto::where('id_producto', $item['id'])->first();
            if (!$producto || $producto->cantidad_disponible < $item['quantity']) {
                return response()->json([
                    'success' => false,
                    'message' => "No hay suficiente stock para el producto ID: {$item['id']}"
                ], 400);
            }
        }

        // Obtener usuario autenticado
        $usuario = Auth::user();

        if (!$usuario || !$usuario->cliente) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no autenticado o sin cliente asociado.'
            ], 403);
        }

        DB::beginTransaction();

        try {
            $pedido = Pedido::create([
                'id_cliente' => $usuario->cliente->id_cliente, // cliente vinculado
                'id_empleado' => 1, // fijo por ahora
                'metodo_pago_id' => $data['metodoPagoId'],
                'estado_pedido' => 'Pendiente',
                'total' => $data['total'],
            ]);

            foreach ($data['cart'] as $item) {
                DetallePedido::create([
                    'id_pedido' => $pedido->id_pedido,
                    'id_producto' => $item['id'],
                    'cantidad' => $item['quantity'],
                    'precio_unitario' => $item['price'],
                ]);

                InventarioProducto::where('id_producto', $item['id'])->decrement('cantidad_disponible', $item['quantity']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pedido procesado correctamente.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el pedido: ' . $e->getMessage()
            ], 500);
        }
    }
}
