@extends('layouts.app')

@section('title', 'Inventario de Productos')

@section('content')
<style>
        body {
    background: linear-gradient(135deg, #f8a29b, #ff6f61);
    color: #333;
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    text-align: center;
    overflow-x: hidden;
}

h2 {
    font-size: 3rem;
    color: #fff;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    margin: 40px 0;
    animation: fadeIn 2s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.menu-category {
    background: rgba(255, 255, 255, 0.9);
    border-radius: 20px;
    padding: 30px;
    margin: 40px auto;
    max-width: 1200px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    animation: slideIn 1s ease-in-out;
}

@keyframes slideIn {
    from { transform: translateY(50px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.menu-category h3 {
    font-size: 2rem;
    color: #ff6f61;
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.menu-grid {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 30px;
}

.menu-item {
    background: #fff;
    padding: 20px;
    border-radius: 20px;
    text-align: center;
    width: 280px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    position: relative;
    overflow: hidden;
}

.menu-item:hover {
    transform: scale(1.1);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
}

/* Estilos para las imágenes de productos */
.product-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease-in-out;
}

.product-image:hover {
    transform: scale(1.1);
}

.menu-item h4 {
    margin: 15px 0;
    font-size: 1.5rem;
    color: #333;
}

.menu-item p {
    font-size: 1.2rem;
    color: #ff6f61;
    font-weight: bold;
}

.menu-item::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 300%;
    height: 300%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.4), rgba(255, 255, 255, 0) 70%);
    transform: translate(-50%, -50%) scale(0);
    transition: transform 0.5s ease-in-out;
    pointer-events: none;
}

.menu-item:hover::before {
    transform: translate(-50%, -50%) scale(1);
}

.navbar {
    background: rgba(255, 255, 255, 0.9);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.navbar-brand img {
    height: 60px;
    transition: transform 0.3s ease-in-out;
}

.navbar-brand img:hover {
    transform: rotate(10deg);
}

.nav-link {
    font-size: 1.1rem;
    color: #333 !important;
    transition: color 0.3s ease-in-out;
}

.nav-link:hover {
    color: #ff6f61 !important;
}

body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0) 70%);
    pointer-events: none;
    animation: float 6s infinite ease-in-out;
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
}

table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    margin-bottom: 30px;
}

thead {
    background: #ff6f61;
    color: white;
    font-size: 1.2rem;
}

th, td {
    padding: 15px;
    border-bottom: 1px solid #f0f0f0;
    text-align: center;
}

tbody tr:hover {
    background: rgba(255, 111, 97, 0.1);
    transition: background 0.3s;
}

form {
    background: rgba(255, 255, 255, 0.9);
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    margin-top: 20px;
}

.form-label {
    font-weight: bold;
    color: #ff6f61;
}

.form-control {
    border: 1px solid #ff6f61;
    border-radius: 10px;
    padding: 10px;
    font-size: 1rem;
    transition: border-color 0.3s, box-shadow 0.3s;
}

.form-control:focus {
    border-color: #ff3b30;
    outline: none;
    box-shadow: 0 0 5px rgba(255, 111, 97, 0.5);
}

.btn-primary {
    background: #ff6f61;
    border: none;
    padding: 12px 24px;
    border-radius: 10px;
    color: #fff;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s, transform 0.2s;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
}

.btn-primary:hover {
    background: #ff3b30;
    transform: scale(1.05);
}

@media (max-width: 768px) {
    .container {
        width: 90%;
        padding: 20px;
    }

    table {
        font-size: 0.9rem;
    }

    th, td {
        padding: 10px;
    }

    h2 {
        font-size: 2rem;
    }

    .btn-primary {
        padding: 8px 16px;
        font-size: 0.9rem;
    }

    .footer-container {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .footer-section ul li {
        justify-content: center;
    }
}
    </style>
<div class="container mt-5">
    <h2>Inventario de Productos</h2>
    <div class="menu-category">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Stock Actual</th>
                    <th>Stock Mínimo</th>
                    <th>Añadir Stock</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $row)
                    <tr>
                        <td>
                            @if ($row->imagen)
                                <img src="data:image/jpeg;base64,{{ base64_encode($row->imagen) }}" class="product-image" width="100" alt="Imagen del producto">
                            @else
                                <img src="{{ asset('assets/img/no-image.png') }}" width="100" class="product-image" alt="Sin imagen">
                            @endif
                        </td>
                        <td>{{ $row->nombre_producto }}</td>
                        <td>Bs {{ number_format($row->precio, 2) }}</td>
                        <td>{{ $row->stock_actual }}</td>
                        <td>{{ $row->stock_minimo }}</td>
                        <td>
                            <form method="POST" action="{{ route('stock.agregar') }}" class="d-flex">
                                @csrf
                                <input type="hidden" name="id_producto" value="{{ $row->id_producto }}">
                                <input type="number" name="cantidad" class="form-control me-2" min="1" required>
                                <button type="submit" class="btn btn-primary">+</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
