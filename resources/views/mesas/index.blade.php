@extends('layouts.app')

@section('content')
<style>
    /* Reset general */
    body {
        background-color: #f8a29b;
        color: #5a2e2e;
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
    }

    h1 {
        font-weight: bold;
        font-size: 28px;
        text-align: center;
        margin-top: 20px;
        color: #6b3e3e;
    }

    /* Alertas */
    .alert {
        max-width: 800px;
        margin: 10px auto;
        border-radius: 10px;
        padding: 15px;
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
    }

    .alert-info {
        background-color: #fff3cd;
        color: #856404;
    }

    /* Botón agregar mesa */
    .btn-success {
        display: block;
        width: fit-content;
        margin: 20px auto;
        background-color: #ffbc0a;
        border: none;
        padding: 12px 20px;
        border-radius: 10px;
        color: #fff;
        font-weight: bold;
        transition: all 0.3s ease;
        text-decoration: none;
        text-align: center;
    }

    .btn-success:hover {
        background-color: #f497b7;
        color: white;
    }

    /* Grid de mesas */
    .row {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        padding: 0 20px;
    }

    .col-md-4 {
        flex: 0 0 300px;
        margin: 15px;
    }

    .card {
        background-color: #f4cac7;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        transition: transform 0.3s;
    }

    .card:hover {
        transform: scale(1.03);
    }

    .card-header {
        background-color: #fff;
        padding: 15px;
        font-weight: bold;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 18px;
        border-bottom: 2px solid #ddd;
    }

    .badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 14px;
        color: white;
    }

    .bg-danger {
        background-color: #dc3545 !important;
    }

    .bg-success {
        background-color: #28a745 !important;
    }

    .card-body {
        padding: 20px;
        font-size: 16px;
        color: #5a2e2e;
    }

    /* Botones editar y borrar */
    .btn-sm {
        font-size: 14px;
        padding: 8px 12px;
        border-radius: 8px;
        font-weight: bold;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-right: 5px;
    }

    .btn-warning {
        background-color: #ffc107;
        color: #212529;
        border: none;
    }

    .btn-warning:hover {
        background-color: #e0a800;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
        border: none;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    /* Responsivo */
    @media (max-width: 768px) {
        .col-md-4 {
            flex: 0 0 100%;
        }

        .btn-success {
            width: 90%;
        }

        .alert {
            width: 90%;
        }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <h1><i class="fas fa-coffee"></i> Gestión de Mesas</h1>

    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> {{ $desocupadas }} Desocupadas
    </div>
    <div class="alert alert-danger">
        <i class="fas fa-times-circle"></i> {{ $ocupadas }} Ocupadas
    </div>

    @if(session('success'))
        <div class="alert alert-info">{{ session('success') }}</div>
    @endif

    <a href="{{ route('mesas.create') }}" class="btn btn-success mb-3">
        <i class="fas fa-plus"></i> Agregar Nueva Mesa
    </a>

    <div class="row">
        @forelse ($mesas as $mesa)
            <div class="col-md-4 mb-4">
                <div class="card border-{{ $mesa->estado === 'ocupada' ? 'danger' : 'success' }}">
                    <div class="card-header">
                        Mesa {{ $mesa->numeroDeMesa }}
                        <span class="badge bg-{{ $mesa->estado === 'ocupada' ? 'danger' : 'success' }}">
                            {{ ucfirst($mesa->estado) }}
                        </span>
                    </div>
                    <div class="card-body">
                        <p><i class="fas fa-users"></i> Capacidad: {{ $mesa->capacidad }} personas</p>
                        <a href="{{ route('mesas.edit', $mesa) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <form action="{{ route('mesas.destroy', $mesa) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('¿Estás seguro de eliminar esta mesa?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                <i class="fas fa-trash-alt"></i> Borrar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p>No hay mesas registradas.</p>
        @endforelse
    </div>
@endsection
