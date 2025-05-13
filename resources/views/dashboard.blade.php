
<!DOCTYPE html>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
            No asignado
        @endif
    </h2>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btnCerrarSesion">Cerrar sesión</button>
    </form>
    <br>
    <a href="{{ route('home') }}" class="btnCerrarSesion">Ir al Inicio</a>
@else
    <h2>No has iniciado sesión</h2>
    <a href="{{ route('login.show') }}" class="btnCerrarSesion">Iniciar sesión</a>
@endif
    <div class="row mt-5">
        <div class="col-md-4 panel-disabled">
            <div class="panel">
                <h2>Hacer Pedido</h2>
                <button disabled><i class="fas fa-shopping-cart"></i> No disponible</button>
            </div>
        </div>
        <div class="col-md-4 panel-disabled">
            <div class="panel">
                <h2>Ver Menú</h2>
                <button disabled><i class="fas fa-utensils"></i> No disponible</button>
            </div>
        </div>
        <div class="col-md-4 panel-disabled">
            <div class="panel">
                <h2>Gestión de Usuarios</h2>
                <button disabled><i class="fas fa-users-cog"></i> No disponible</button>
            </div>
        </div>
         <div class="col-md-4 panel-disabled">
            <div class="panel">
                <h2>Gestión de Productos</h2>
                <button disabled><i class="fas fa-clipboard-list"></i> No disponible</button>
            </div>
        </div>
         <div class="col-md-4 panel-disabled">
            <div class="panel">
                <h2>Gestión de Mesas</h2>
                <button disabled><i class="fas fa-shopping-cart"></i> No disponible</button>
            </div>
        </div>
         <div class="col-md-4 panel-disabled">
            <div class="panel">
                <h2>Gestionar Stock</h2>
                <button disabled><i class="fas fa-boxes"></i> No disponible</button>
            </div>
        </div>
    </div>
</div>


