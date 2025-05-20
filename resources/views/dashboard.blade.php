
@extends('layouts.app')
@section('title', 'Paneles')

@section('content')
    <style>
        /* Estilos generales */
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
                font-size: 40px;
                color: #fff;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
                margin: 40px 0;
                animation: fadeIn 2s ease-in-out;
            }
        .panel {
            background-color: #f4cac7; /* Color secundario */
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            margin-bottom: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
    
        .panel button {
            background-color: #ffbc0a; /* Color complementario */
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            color: #000000; /* Negro para contraste */
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s ease-in-out, transform 0.2s ease-in-out;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            max-width: 220px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
        }
    
        .panel button:hover {
            background-color: #f4a900; /* Un tono más oscuro del complementario */
            transform: scale(1.05);
        }
        
         /* Nuevo estilo para paneles deshabilitados */
        .panel-disabled {
            opacity: 0.5;
            pointer-events: none;
        }


        header img {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    
        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #ffffff; /* Fondo blanco neutro */
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
    
        .logo-container img {
            max-height: 250px;
            width: auto;
            object-fit: contain;
            border-radius: 10px;
        }

        .btnCerrarSesion{
            position: relative;
            border-radius: 10px;
            border: none;
            background-color: #ffbc0a; /* Color complementario */
            color: #000000;
            font-size: 15px;
            font-weight: 700;
            margin: 10px;
            padding: 12px 50px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s ease-in-out, transform 0.2s ease-in-out;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            max-width: 220px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
        }
        button:hover {
            background-color: #f4a900; /* Un tono más oscuro del complementario */
            transform: scale(1.05);
        }
        /* Estilos del footer */
footer {
    background: linear-gradient(135deg, #ff6f61, #f8a29b);
    color: #fff;
    padding: 40px 20px;
    font-family: 'Poppins', sans-serif;
    box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.1);
}

.footer-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    max-width: 1200px;
    margin: 0 auto;
    gap: 20px;
}

.footer-section {
    flex: 1;
    min-width: 250px;
    margin-bottom: 20px;
}

.footer-section h3 {
    font-size: 1.5rem;
    margin-bottom: 15px;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.footer-section ul {
    list-style: none;
    padding: 0;
}

.footer-section ul li {
    margin-bottom: 10px;
    font-size: 1rem;
    display: flex;
    align-items: center;
}

.footer-section ul li i {
    margin-right: 10px;
    font-size: 1.2rem;
    color: #fff;
}

.footer-section a {
    color: #fff;
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer-section a:hover {
    color: #ffcc00;
}

.footer-bottom {
    text-align: center;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
    font-size: 0.9rem;
}

.social-links a {
    display: inline-block;
    padding: 8px 12px;
    border-radius: 5px;
    background: rgba(255, 255, 255, 0.1);
    transition: background 0.3s ease, transform 0.3s ease;
}
a {
    text-decoration: none;
}

.social-links a:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-3px);
}

/* Responsive design */
@media (max-width: 768px) {
    .footer-container {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .footer-section ul li {
        justify-content: center;
    }
}

        
        @media (max-width: 768px) {
            .panel button {
                max-width: 100%;
            }
            .logo-container img {
                max-height: 150px;
            }
        }
    </style>

<div class="container">
@if(Auth::check())
    <h2>¡Bienvenido, {{ Auth::user()->nombre }} {{ Auth::user()->apePat }} {{ Auth::user()->apeMat }}!</h2>
    <h2>Tu rol es: 
        @if(Auth::user()->rol)
        {{ Auth::user()->rol->nombre_rol }}
        @else
            No asignado (ID: {{ Auth::user()->rol_id ?? 'null' }})
        @endif
    </h2>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    @php
        $rol = Auth::user()->rol ? Auth::user()->rol->nombre_rol : null;
    @endphp

    <div class="row mt-5">

        {{-- Hacer Pedido: Cliente, Mesero/a, Administrador --}}
<div class="col-md-4 {{ in_array($rol, ['Administrador', 'Mesero/a', 'Cliente', 'Cajero/a']) ? '' : 'panel-disabled' }}">
    <div class="panel">
        <h2>Hacer Pedido</h2>
        <a href="{{ in_array($rol, ['Administrador', 'Mesero/a', 'Cliente', 'Cajero/a']) ? route('pedido') : '#' }}">
            <button type="button" {{ in_array($rol, ['Administrador', 'Mesero/a', 'Cliente', 'Cajero/a']) ? '' : 'disabled' }}>
                <i class="fas fa-shopping-cart"></i> 
                {{ in_array($rol, ['Administrador', 'Mesero/a', 'Cliente', 'Cajero/a']) ? 'Ir a Pedido' : 'No disponible' }}
            </button>
        </a>
    </div>
</div>

        {{-- Ver Menú: Mesero/a, Administrador --}}
<div class="col-md-4 {{ in_array($rol, ['Administrador', 'Mesero/a']) ? '' : 'panel-disabled' }}">
    <div class="panel">
        <h2>Ver Menú</h2>
        <a href="{{ in_array($rol, ['Administrador', 'Mesero/a']) ? route('menu') : '#' }}">
            <button type="button" {{ in_array($rol, ['Administrador', 'Mesero/a']) ? '' : 'disabled' }}>
                <i class="fas fa-utensils"></i> 
                {{ in_array($rol, ['Administrador', 'Mesero/a']) ? 'Ver Menú' : 'No disponible' }}
            </button>
        </a>
    </div>
</div>




{{-- Gestión de Usuarios: solo Administrador --}}
<div class="col-md-4 {{ $rol === 'Administrador' ? '' : 'panel-disabled' }}">
    <div class="panel">
        <h2>Gestión de Usuarios</h2>
        <a href="{{ $rol === 'Administrador' ? route('gestion.usuarios') : '#' }}">
            <button type="button" {{ $rol === 'Administrador' ? '' : 'disabled' }}>
                <i class="fas fa-users-cog"></i> 
                {{ $rol === 'Administrador' ? 'Gestionar Usuarios' : 'No disponible' }}
            </button>
        </a>
    </div>
</div>

{{-- Historial de Pedidos: Cliente, Cajero/a, Administrador --}}
<div class="col-md-4 {{ in_array($rol, ['Administrador', 'Cliente', 'Cajero/a', 'Cocinero/a']) ? '' : 'panel-disabled' }}">
    <div class="panel">
        <h2>Historial de Pedidos</h2>
        <a href="{{ in_array($rol, ['Administrador', 'Cliente', 'Cajero/a', 'Cocinero/a']) ? route('historial.pedidos') : '#' }}">
            <button type="button" {{ in_array($rol, ['Administrador', 'Cliente', 'Cajero/a', 'Cocinero/a']) ? '' : 'disabled' }}>
                <i class="fas fa-history"></i> 
                {{ in_array($rol, ['Administrador', 'Cliente', 'Cajero/a']) ? 'Ver Historial' : 'No disponible' }}
            </button>
        </a>
    </div>
</div>

{{-- Gestión de Productos: Administrador, Cocinero/a --}}
<div class="col-md-4 {{ in_array($rol, ['Administrador', 'Cocinero/a']) ? '' : 'panel-disabled' }}">
    <div class="panel">
        <h2>Gestión de Productos</h2>
        <a href="{{ in_array($rol, ['Administrador', 'Cocinero/a']) ? route('productos.index') : '#' }}">
            <button type="button" {{ in_array($rol, ['Administrador', 'Cocinero/a']) ? '' : 'disabled' }}>
                <i class="fas fa-clipboard-list"></i> 
                {{ in_array($rol, ['Administrador', 'Cocinero/a']) ? 'Gestionar Productos' : 'No disponible' }}
            </button>
        </a>
    </div>
</div>

{{-- Gestión de Mesas: Mesero/a, Administrador --}}
<div class="col-md-4 {{ in_array($rol, ['Administrador', 'Mesero/a']) ? '' : 'panel-disabled' }}">
    <div class="panel">
        <h2>Gestión de Mesas</h2>
        <a href="{{ in_array($rol, ['Administrador', 'Mesero/a']) ? route('gestion.mesas') : '#' }}">
            <button type="button" {{ in_array($rol, ['Administrador', 'Mesero/a']) ? '' : 'disabled' }}>
                <i class="fas fa-table"></i> 
                {{ in_array($rol, ['Administrador', 'Mesero/a']) ? 'Gestionar Mesas' : 'No disponible' }}
            </button>
        </a>
    </div>
</div>

{{-- Gestionar Stock: Cocinero/a, Administrador --}}
<div class="col-md-4 {{ in_array($rol, ['Administrador', 'Cocinero/a']) ? '' : 'panel-disabled' }}">
    <div class="panel">
        <h2>Gestionar Stock</h2>
        <a href="{{ in_array($rol, ['Administrador', 'Cocinero/a']) ? route('stock.index') : '#' }}">
            <button type="button" {{ in_array($rol, ['Administrador', 'Cocinero/a']) ? '' : 'disabled' }}>
                <i class="fas fa-boxes"></i> 
                {{ in_array($rol, ['Administrador', 'Cocinero/a']) ? 'Ir al Stock' : 'No disponible' }}
            </button>
        </a>
    </div>
</div>

        
    </div>
    

@else
    <h2>No has iniciado sesión</h2>
    <a href="{{ route('login.show') }}" class="btnCerrarSesion">Iniciar sesión</a>
@endif
</div>
<!-- Scripts del dashboard -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
window.addEventListener('pageshow', function(event) {
    if (event.persisted) {
        window.location.reload();
    }
});
</script>

<script>{!! file_get_contents(resource_path('js/sesionExpirada.js')) !!}</script>
@endsection







