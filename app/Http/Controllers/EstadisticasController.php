<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstadisticasController extends Controller
{
    public function index()
    {
        // Total de clientes
        $totalClientes = DB::table('clientes')->count();

        // Total de empleados
        $totalEmpleados = DB::table('empleados')->count();

        // Total de productos
        $totalProductos = DB::table('productos')->count();

        // Total de pedidos
        $totalPedidos = DB::table('pedidos')->count();

        // Total de ventas (suma del campo total en pedidos)
        $totalVentas = DB::table('pedidos')->sum('total');

        // Ventas por mes (usando la fecha_pedido de la tabla pedidos)
        $ventasPorMes = DB::table('pedidos')
            ->selectRaw("DATE_FORMAT(fecha_pedido, '%M %Y') as mes, SUM(total) as total")
            ->groupByRaw("DATE_FORMAT(fecha_pedido, '%M %Y')")
            ->orderByRaw("MIN(fecha_pedido)")
            ->get();

        // Productos por categoría
        $productosPorCategoria = DB::table('productos')
            ->join('categorias_productos', 'productos.categoria_producto_id', '=', 'categorias_productos.id_categoria')
            ->select('categorias_productos.nombre_categoria', DB::raw('COUNT(*) as total'))
            ->groupBy('categorias_productos.nombre_categoria')
            ->pluck('total', 'nombre_categoria');

        // Métodos de pago más usados
        $metodosPago = DB::table('pedidos')
            ->join('metodos_pago', 'pedidos.metodo_pago_id', '=', 'metodos_pago.id_metodo_pago')
            ->select('metodos_pago.nombre_metodo_pago', DB::raw('COUNT(*) as total'))
            ->groupBy('metodos_pago.nombre_metodo_pago')
            ->pluck('total', 'nombre_metodo_pago');

        // Pedidos por estado
        $pedidosPorEstado = DB::table('pedidos')
            ->select('estado_pedido', DB::raw('COUNT(*) as total'))
            ->groupBy('estado_pedido')
            ->pluck('total', 'estado_pedido');

        // Productos con bajo stock (menos o igual a stock_minimo)
        $productosBajoStock = DB::table('productos')
            ->join('inventario_productos', 'productos.id_producto', '=', 'inventario_productos.id_producto')
            ->whereRaw('inventario_productos.cantidad_disponible <= productos.stock_minimo')
            ->select('productos.nombre_producto', 'inventario_productos.cantidad_disponible')
            ->get();

        // Productos más vendidos (corregido)
        $productosMasVendidos = DB::table('detalle_pedido')
            ->join('productos', 'detalle_pedido.id_producto', '=', 'productos.id_producto')
            ->select(
                'productos.id_producto',
                'productos.nombre_producto', 
                DB::raw('SUM(detalle_pedido.cantidad) as total_vendidos')
            )
            ->groupBy('productos.id_producto', 'productos.nombre_producto')
            ->orderByDesc('total_vendidos')
            ->limit(5)
            ->get();

        // Tasa de crecimiento mensual de ventas
        $ventasCrecimiento = DB::table('pedidos')
            ->selectRaw("DATE_FORMAT(fecha_pedido, '%Y-%m') as mes, SUM(total) as total")
            ->groupByRaw("DATE_FORMAT(fecha_pedido, '%Y-%m')")
            ->orderByRaw("MIN(fecha_pedido)")
            ->get();

        // Top clientes frecuentes (corregido)
        $clientesFrecuentes = DB::table('pedidos')
            ->join('clientes', 'pedidos.id_cliente', '=', 'clientes.id_cliente')
            ->select(
                'clientes.id_cliente',
                DB::raw("CONCAT(clientes.nombre, ' ', clientes.apePat) as cliente"),
                DB::raw('COUNT(*) as pedidos')
            )
            ->groupBy('clientes.id_cliente', 'clientes.nombre', 'clientes.apePat')
            ->orderByDesc('pedidos')
            ->limit(5)
            ->get();

        // Actividad reciente del sistema
        $actividadReciente = DB::table('auditoria')
            ->join('usuarios', 'auditoria.usuario', '=', 'usuarios.id_usuario')
            ->select('auditoria.*', 'usuarios.nombre as usuario_nombre')
            ->orderBy('fecha', 'desc')
            ->limit(10)
            ->get();

        return view('estadisticas.index', compact(
            'totalClientes',
            'totalEmpleados',
            'totalProductos',
            'totalPedidos',
            'totalVentas',
            'ventasPorMes',
            'productosPorCategoria',
            'metodosPago',
            'pedidosPorEstado',
            'productosBajoStock',
            'productosMasVendidos',
            'ventasCrecimiento',
            'clientesFrecuentes',
            'actividadReciente'
        ));
    }
}