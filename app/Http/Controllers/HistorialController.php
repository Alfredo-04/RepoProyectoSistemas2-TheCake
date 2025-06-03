<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF; // barryvdh/laravel-dompdf
use Carbon\Carbon;

class HistorialController extends Controller
{
    public function index(Request $request)
    {
        $estado = $request->estado;
        $fechaInicio = $request->fecha_inicio;
        $fechaFin = $request->fecha_fin;

        $query = DB::table('pedidos as p')
            ->join('metodos_pago as m', 'p.metodo_pago_id', '=', 'm.id_metodo_pago')
            ->join('detalle_pedido as dp', 'p.id_pedido', '=', 'dp.id_pedido')
            ->join('productos as pr', 'dp.id_producto', '=', 'pr.id_producto')
            ->join('clientes as c', 'p.id_cliente', '=', 'c.id_cliente')  // join cliente
            ->select(
                'p.id_pedido',
                'p.fecha_pedido',
                'p.total',
                'p.estado_pedido',
                'm.nombre_metodo_pago',
                DB::raw("CONCAT(c.nombre, ' ', c.apePat, ' ', c.apeMat) as cliente"),
                'c.correo',
                DB::raw("GROUP_CONCAT(CONCAT(pr.nombre_producto, ' - Cantidad: ', dp.cantidad) SEPARATOR ', ') AS productos")
            );

        if ($estado) {
            $query->where('p.estado_pedido', $estado);
        }
        if ($fechaInicio) {
            $query->whereDate('p.fecha_pedido', '>=', $fechaInicio);
        }
        if ($fechaFin) {
            $query->whereDate('p.fecha_pedido', '<=', $fechaFin);
        }

        $pedidos = $query
            ->groupBy(
                'p.id_pedido',
                'p.fecha_pedido',
                'p.total',
                'p.estado_pedido',
                'm.nombre_metodo_pago',
                'c.nombre', 'c.apePat', 'c.apeMat', 'c.correo'
            )
            ->orderByDesc('p.fecha_pedido')
            ->get();

        // Cambiamos la fecha para que sea humana con Carbon (ejemplo: "hace 2 días")
        foreach ($pedidos as $pedido) {
            $pedido->fecha_humana = Carbon::parse($pedido->fecha_pedido)->diffForHumans();
            $pedido->hora = Carbon::parse($pedido->fecha_pedido)->format('H:i');
        }

        return view('historial.index', compact('pedidos', 'estado', 'fechaInicio', 'fechaFin'));
    }

    public function actualizarEstado(Request $request)
    {
        DB::table('pedidos')
            ->where('id_pedido', $request->id_pedido)
            ->update(['estado_pedido' => $request->estado_pedido]);

        return redirect()->route('historial')->with('success', 'Estado actualizado correctamente');
    }

    public function generarPDF(Request $request)
    {
        $estado = $request->estado;
        $fechaInicio = $request->fecha_inicio;
        $fechaFin = $request->fecha_fin;

        $query = DB::table('pedidos as p')
            ->join('metodos_pago as m', 'p.metodo_pago_id', '=', 'm.id_metodo_pago')
            ->join('detalle_pedido as dp', 'p.id_pedido', '=', 'dp.id_pedido')
            ->join('productos as pr', 'dp.id_producto', '=', 'pr.id_producto')
            ->join('clientes as c', 'p.id_cliente', '=', 'c.id_cliente')
            ->select(
                'p.id_pedido',
                'p.fecha_pedido',
                'p.total',
                'p.estado_pedido',
                'm.nombre_metodo_pago',
                DB::raw("CONCAT(c.nombre, ' ', c.apePat, ' ', c.apeMat) as cliente"),
                'c.correo',
                DB::raw("GROUP_CONCAT(CONCAT(pr.nombre_producto, ' - Cantidad: ', dp.cantidad) SEPARATOR ', ') AS productos")
            );

        if ($estado) {
            $query->where('p.estado_pedido', $estado);
        }
        if ($fechaInicio) {
            $query->whereDate('p.fecha_pedido', '>=', $fechaInicio);
        }
        if ($fechaFin) {
            $query->whereDate('p.fecha_pedido', '<=', $fechaFin);
        }

        $pedidos = $query
            ->groupBy(
                'p.id_pedido',
                'p.fecha_pedido',
                'p.total',
                'p.estado_pedido',
                'm.nombre_metodo_pago',
                'c.nombre', 'c.apePat', 'c.apeMat', 'c.correo'
            )
            ->orderByDesc('p.fecha_pedido')
            ->get();

        $pdf = PDF::loadView('historial.pdf', compact('pedidos', 'estado', 'fechaInicio', 'fechaFin'));
        return $pdf->download('Historial_de_Pedidos.pdf');
    }
}
