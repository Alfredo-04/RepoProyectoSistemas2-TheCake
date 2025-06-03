<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Pedidos</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }
        .title {
            text-align: center;
            font-size: 18px;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .subtitle {
            text-align: center;
            font-size: 14px;
            margin-bottom: 15px;
            background-color: #f9b1a6;
            padding: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            border: 1px solid #666;
            padding: 6px;
            text-align: center;
        }
        th {
            background-color: #f4cac7;
        }
        footer {
            position: fixed;
            bottom: -20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            font-style: italic;
        }
    </style>
</head>
<body>

    <img src="{{ public_path('assets/images/logoTheCake.png') }}" width="80" style="float: left;">

    <div class="title">Historial de Pedidos</div>

    <div class="subtitle">
        @if($estado && $fechaInicio && $fechaFin)
            Reporte por Estado y Fechas
        @elseif($estado)
            Reporte por Estado
        @elseif($fechaInicio && $fechaFin)
            Reporte por Fechas
        @else
            Reporte de Pedidos
        @endif
    </div>

    <table>
       <thead>
            <tr>
                <th>ID Pedido</th>
                <th>Cliente</th>  <!-- NUEVO -->
                <th>Correo</th>   <!-- NUEVO -->
                <th>Fecha</th>
                <th>Total (Bs.)</th>
                <th>Estado</th>
                <th>Método de Pago</th>
            </tr>
        </thead>

        <tbody>
            @foreach($pedidos as $pedido)
                <tr>
                    <td>{{ $pedido->id_pedido }}</td>
                    <td>{{ $pedido->cliente }}</td> <!-- NUEVO -->
                    <td>{{ $pedido->correo }}</td>  <!-- NUEVO -->
                    <td>{{ \Carbon\Carbon::parse($pedido->fecha_pedido)->format('d-m-Y') }}</td>
                    <td>{{ number_format($pedido->total, 2) }}</td>
                    <td>{{ $pedido->estado_pedido }}</td>
                    <td>{{ $pedido->nombre_metodo_pago }}</td>
                </tr>

            @endforeach
        </tbody>
    </table>

    <footer>
        Cafetería "The Cake" | Contacto: +591 75424853 | Email: marce_laime@hotmail.com
    </footer>

</body>
</html>
