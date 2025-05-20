@extends('layouts.app')

@section('title', 'Menú')

@section('content')
<style>

    body {
        background: linear-gradient(135deg, #f8a29b, #ff6f61); /* Degradado rosado */
        color: #333; /* Color de texto principal */
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        text-align: center;
        overflow-x: hidden;
    }

    h2 {
        font-size: 3rem;
        color: #fff; /* Texto blanco para contraste */
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); /* Sombra suave */
        margin: 40px 0;
        animation: fadeIn 2s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* Panel principal */
    .menu-category {
        background: rgba(255, 255, 255, 0.9); /* Fondo blanco semitransparente */
        border-radius: 20px;
        padding: 30px;
        margin: 40px auto;
        max-width: 1200px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3); /* Sombra suave */
        animation: slideIn 1s ease-in-out;
    }

    @keyframes slideIn {
        from { transform: translateY(50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .menu-category h3 {
        font-size: 2rem;
        color: #ff6f61; /* Color rosado */
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

    /* Tarjetas de productos */
    .menu-item {
        background: #fff; /* Fondo blanco */
        padding: 20px;
        border-radius: 20px;
        text-align: center;
        width: 280px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Sombra suave */
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        position: relative;
        overflow: hidden;
    }

    .menu-item:hover {
        transform: scale(1.1);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3); /* Sombra más pronunciada al hover */
    }


    .menu-item h4 {
        margin: 15px 0;
        font-size: 1.5rem;
        color: #333; /* Color de texto oscuro */
    }

    .menu-item p {
        font-size: 1.2rem;
        color: #ff6f61; /* Color rosado */
        font-weight: bold;
    }

    /* Efecto de brillo al pasar el mouse */
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
    /* Estilos para las imágenes en las tarjetas de productos */
.menu-item img {
    width: 100%; /* Ocupa el 100% del ancho del contenedor */
    height: 200px; /* Altura fija */
    object-fit: cover; /* Ajusta la imagen para cubrir el espacio sin distorsionarla */
    border-radius: 15px; /* Bordes redondeados */
    transition: transform 0.3s ease-in-out; /* Animación al hacer hover */
}

.menu-item:hover img {
    transform: scale(1.1); /* Efecto de zoom al hacer hover */
}

    /* Menú de navegación */
    .navbar {
        background: rgba(255, 255, 255, 0.9); /* Fondo blanco semitransparente */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Sombra suave */
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
        color: #333 !important; /* Color de texto oscuro */
        transition: color 0.3s ease-in-out;
    }

    .nav-link:hover {
        color: #ff6f61 !important; /* Color rosado al hover */
    }

    /* Animación de fondo */
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

    /* Tabla de productos */
    table {
        width: 100%;
        border-collapse: collapse;
        background: #fff; /* Fondo blanco */
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Sombra suave */
        margin-bottom: 30px;
    }

    thead {
        background: #ff6f61; /* Color rosado */
        color: white; /* Texto blanco */
        font-size: 1.2rem;
    }

    th, td {
        padding: 15px;
        border-bottom: 1px solid #f0f0f0; /* Borde suave */
        text-align: center;
    }

    tbody tr:hover {
        background: rgba(255, 111, 97, 0.1); /* Fondo rosado muy suave al hover */
        transition: background 0.3s;
    }

    /* Formulario para añadir stock */
    form {
        background: rgba(255, 255, 255, 0.9); /* Fondo blanco semitransparente */
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Sombra suave */
        margin-top: 20px;
    }

    .form-label {
        font-weight: bold;
        color: #ff6f61; /* Color rosado */
    }

    .form-control {
        border: 1px solid #ff6f61; /* Borde rosado */
        border-radius: 10px;
        padding: 10px;
        font-size: 1rem;
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    .form-control:focus {
        border-color: #ff3b30; /* Color rosado más intenso */
        outline: none;
        box-shadow: 0 0 5px rgba(255, 111, 97, 0.5); /* Sombra rosada */
    }

    /* Botones */
    .btn-primary {
        background: #ff6f61; /* Color rosado */
        border: none;
        padding: 12px 24px;
        border-radius: 10px;
        color: #fff; /* Texto blanco */
        font-weight: bold;
        cursor: pointer;
        transition: background 0.3s, transform 0.2s;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2); /* Sombra suave */
    }

    .btn-primary:hover {
        background: #ff3b30; /* Color rosado más intenso al hover */
        transform: scale(1.05);
    }

    /* Responsividad */
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
<h2 class="titulo-menu">MENÚ</h2>

<div class="productos-container">
    @forelse($productos->groupBy('nombre_categoria') as $categoria => $items)
        <div class="menu-category">
            <h3 class="titulo-categoria">{{ strtoupper($categoria) }}</h3>
            <div class="menu-grid">
                @foreach ($items as $producto)
                    <div class="menu-item">
                        @if ($producto->imagen)
                            <img src="data:image/jpeg;base64,{{ base64_encode($producto->imagen) }}" alt="Imagen del producto">
                        @else
                            <img src="{{ asset('assets/img/no-image.png') }}" alt="Imagen del producto">
                        @endif
                        <h4 class="nombre">{{ $producto->nombre_producto }}</h4>
                        <p class="precio">Precio: Bs.{{ number_format($producto->precio, 2) }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <p>No hay productos disponibles.</p>
    @endforelse
</div>


@endsection
