@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f8a29b;
        color: #5a2e2e;
        font-family: 'Arial', sans-serif;
    }

    h1 {
        text-align: center;
        margin-top: 20px;
        color: #6b3e3e;
        font-weight: bold;
    }

    form {
        max-width: 600px;
        margin: 30px auto;
        background-color: #f4cac7;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    label {
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
        color: #5a2e2e;
    }

    .form-control, .form-select {
        width: 100%;
        padding: 10px 15px;
        border-radius: 10px;
        border: 1px solid #ccc;
        margin-bottom: 20px;
        background-color: #fff7f7;
    }

    .form-control:focus, .form-select:focus {
        border-color: #ffbc0a;
        box-shadow: 0 0 5px #ffbc0a;
        outline: none;
    }

    .btn {
        padding: 10px 20px;
        font-weight: bold;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-secondary {
        background-color: #bbb;
        color: #fff;
        margin-right: 10px;
    }

    .btn-secondary:hover {
        background-color: #999;
    }

    .btn-primary {
        background-color: #ffbc0a;
        color: #fff;
    }

    .btn-primary:hover {
        background-color: #f497b7;
    }

    @media (max-width: 768px) {
        form {
            padding: 20px;
            margin: 20px;
        }
    }
</style>

    <h1>Editar Mesa {{ $mesa->numeroDeMesa }}</h1>

    <form action="{{ route('mesas.update', $mesa) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="numeroDeMesa">Número de Mesa</label>
            <input type="text" name="numeroDeMesa" class="form-control" value="{{ $mesa->numeroDeMesa }}" required>
        </div>

        <div class="mb-3">
            <label for="capacidad">Capacidad</label>
            <input type="number" name="capacidad" class="form-control" value="{{ $mesa->capacidad }}" min="1" required>
        </div>

        <div class="mb-3">
            <label for="estado">Estado</label>
            <select name="estado" class="form-select">
                <option value="ocupada" {{ $mesa->estado == 'ocupada' ? 'selected' : '' }}>Ocupada</option>
                <option value="desocupada" {{ $mesa->estado == 'desocupada' ? 'selected' : '' }}>Desocupada</option>
            </select>
        </div>

        <a href="{{ route('mesas.index') }}" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
@endsection
