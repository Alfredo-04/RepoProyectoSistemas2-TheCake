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

    <h1>Agregar Nueva Mesa</h1>

    <form action="{{ route('mesas.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="numeroDeMesa">Número de Mesa</label>
        <input type="number" name="numeroDeMesa" class="form-control" min="1" max="50" required>
        @error('numeroDeMesa')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="capacidad">Capacidad</label>
        <input type="number" name="capacidad" class="form-control" min="2" max="8" required>
        @error('capacidad')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="estado">Estado</label>
        <select name="estado" class="form-select" required>
            <option value="ocupada">Ocupada</option>
            <option value="desocupada" selected>Desocupada</option>
        </select>
        @error('estado')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <a href="{{ route('mesas.index') }}" class="btn btn-secondary">Cancelar</a>
    <button type="submit" class="btn btn-primary">Guardar Mesa</button>
</form>

@endsection
