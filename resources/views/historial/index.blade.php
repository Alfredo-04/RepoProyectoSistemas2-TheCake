@extends('layouts.app')

@section('content')
@php
use Carbon\Carbon;

function formatoFechaHumana($fecha) {
    $fecha = Carbon::parse($fecha)->startOfDay(); // normaliza la hora
    $hoy = Carbon::now()->startOfDay(); // asegura que se compare correctamente

    $dias = $fecha->diffInDays($hoy);
    $semanas = $fecha->diffInWeeks($hoy);
    $meses = $fecha->diffInMonths($hoy);

    if ($fecha->equalTo($hoy)) return 'Hoy';
    if ($dias === 1) return 'Ayer';
    if ($dias === 2) return 'Antes de ayer';
    if ($dias < 7) return 'Hace ' . $dias . ' días';
    if ($semanas === 1) return 'Hace 1 semana';
    if ($semanas < 5) return 'Hace ' . $semanas . ' semanas';
    if ($meses === 1) return 'Hace 1 mes';
    return 'Hace ' . $meses . ' meses';
}
@endphp


<style>
  /* Fuente especial para todo el body */
  @import url('https://fonts.googleapis.com/css2?family=Special+Elite&display=swap');
  body {
    font-family: 'Special Elite', monospace;
  }

  /* Contenedor principal con overflow horizontal */
  .max-w-full {
    max-width: 100%;
    overflow-x: auto;
  }

  /* Título centrado */
  h2 {
    text-align: center;
    color: black;
    font-size: 1.125rem; /* text-lg */
    font-weight: 400;
    margin-bottom: 1rem;
    letter-spacing: 0.1em;
  }

  /* Formulario flex con espacios */
  form.flex {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    justify-content: center;
    margin-bottom: 1rem;
  }

  /* Select y inputs */
  select.form-select,
  input.form-control {
    border: 1px solid #d1d5db; /* gray-300 */
    border-radius: 0.375rem; /* rounded-md */
    font-size: 0.75rem; /* text-xs */
    padding: 0.5rem 0.75rem;
    width: auto;
    min-width: 8rem; /* ~w-40 */
    box-sizing: border-box;
  }
  /* Cambia tamaño en md (media query) */
  @media(min-width: 768px) {
    select.form-select,
    input.form-control {
      font-size: 0.875rem; /* text-sm */
      min-width: 12rem; /* ~w-48 */
    }
  }

  /* Focus outline azul */
  select.form-select:focus,
  input.form-control:focus {
    outline: none;
    box-shadow: 0 0 0 2px #2563eb; /* ring-blue-600 */
    border-color: #2563eb;
  }

  /* Botones */
  button.btn {
    font-weight: 600;
    border-radius: 0.375rem;
    padding: 0.5rem 1rem;
    font-size: 0.75rem;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
  }
  button.btn-primary {
    background-color: #2563eb;
    color: white;
  }
  button.btn-primary:hover {
    background-color: #1d4ed8;
  }
  .btn-secondary {
  background-color: #6c757d; /* gris */
  color: white;
  border-radius: 0.375rem;
  padding: 0.5rem 1rem;
  font-weight: 600;
  font-size: 0.75rem;
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;
  text-decoration: none; /* para enlaces */
  border: none;
  cursor: pointer;
}

.btn-secondary:hover {
  background-color: #5a6268;
  color: white;
  text-decoration: none;
}

  button.btn-danger {
    background-color: #dc2626;
    color: white;
  }
  button.btn-danger:hover {
    background-color: #b91c1c;
  }

  /* Botón PDF rosa */
  a.btn-pink {
    background-color: #e91e63;
    border-color: #e91e63;
    color: white;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    font-weight: 600;
    border-radius: 0.375rem;
    padding: 0.5rem 1rem;
    font-size: 0.75rem;
    text-decoration: none;
  }
  a.btn-pink:hover {
    background-color: #c2185b;
    border-color: #ad1457;
    color: white;
    text-decoration: none;
  }

  /* Tabla */
  table.table-bordered {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid #e5e7eb; /* gray-200 */
    text-align: center;
    font-size: 0.875rem; /* text-sm */
  }
  table.table-bordered th,
  table.table-bordered td {
    border: 1px solid #e5e7eb;
    padding: 0.25rem 0.5rem;
  }
  table.table-bordered thead tr {
    background-color: white;
  }

  /* Para textos con saltos y espacios */
  td ul {
    padding-left: 1rem;
    margin: 0;
  }
  td ul li {
    margin-bottom: 8px; /* Más espacio entre productos */
  }
</style>

<h2>Historial de Pedidos</h2>

<form method="GET" class="flex">
    <select name="estado" class="form-select">
        <option value="">Todos</option>
        <option value="Pendiente" {{ request('estado') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
        <option value="En preparación" {{ request('estado') == 'En preparación' ? 'selected' : '' }}>En preparación</option>
        <option value="Listo" {{ request('estado') == 'Listo' ? 'selected' : '' }}>Listo</option>
        <option value="Entregado" {{ request('estado') == 'Entregado' ? 'selected' : '' }}>Entregado</option>
        <option value="Cancelado" {{ request('estado') == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
    </select>
    <input type="date" name="fecha_inicio" class="form-control" value="{{ request('fecha_inicio') }}">
    <input type="date" name="fecha_fin" class="form-control" value="{{ request('fecha_fin') }}">
    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
    
    <a href="{{ route('historial') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Limpiar</a>

    <a href="{{ route('historial.pdf', request()->all()) }}" class="btn-pink"><i class="fas fa-file-pdf"></i> Descargar PDF</a>
</form>

<table class="table table-bordered max-w-full">
    <thead>
    <tr>
        <th>Cliente</th>
        <th>Correo</th> 
        <th>Productos</th>
        <th>Fecha</th>
        <th>Hora</th>
        <th>Total</th>
        <th>Estado</th>
        <th>Método de Pago</th>
    </tr>
</thead>

    <tbody>
        @foreach ($pedidos as $pedido)
            <tr>
              <td>{{ $pedido->cliente }}</td> <!-- NUEVO -->
              <td>{{ $pedido->correo }}</td>  <!-- NUEVO -->
              <td>
                  <ul>
                      @foreach (explode(', ', $pedido->productos) as $producto)
                          <li>{{ $producto }}</li>
                      @endforeach
                  </ul>
              </td>
              <td>{{ formatoFechaHumana($pedido->fecha_pedido) }}</td>
              <td>{{ \Carbon\Carbon::parse($pedido->fecha_pedido)->format('H:i') }}</td>
              <td>Bs. {{ number_format($pedido->total, 2) }}</td>
              <td>
                  <form method="POST" action="{{ route('historial.update') }}">
                      @csrf
                      <input type="hidden" name="id_pedido" value="{{ $pedido->id_pedido }}">
                      <select name="estado_pedido" class="form-select" onchange="this.form.submit()">
                          @foreach(['Pendiente','En preparación','Listo','Entregado','Cancelado'] as $estado)
                              <option value="{{ $estado }}" {{ $pedido->estado_pedido == $estado ? 'selected' : '' }}>
                                  {{ $estado }}
                              </option>
                          @endforeach
                      </select>
                  </form>
              </td>
              <td>{{ $pedido->nombre_metodo_pago }}</td>
          </tr>

        @endforeach
    </tbody>
</table>
@endsection
