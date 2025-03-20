<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario'])) {
    // Si no está autenticado, redirigir al formulario de login
    header("Location: LoginSignUp.php");
    exit();
}

// Obtener el nombre y rol del usuario desde la sesión
$nombreUsuario = $_SESSION['nombre'];
$rolUsuario = $_SESSION['rol_id'];  // Cambiado a 'rol_id'

// Obtener el nombre del rol desde la base de datos
include '../../connection.php';
$sql = "SELECT nombre_rol FROM Roles WHERE id_rol = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $rolUsuario);
$stmt->execute();
$result = $stmt->get_result();
$rol = $result->fetch_assoc()['nombre_rol'];
$conn->close();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Cake - Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../../public/assets/css/stylesSucursal.css">
    <link rel="stylesheet" href="../../public/assets/css/styles.css">
    <link rel="stylesheet" href="../../public/assets/css/stylesIndex.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            background-color: #f8a29b;
            color: #333;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
        }
    
        .panel {
            background-color: #f4cac7; /* Color secundario */
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
            margin-bottom: 20px;
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
        @media (max-width: 768px) {
            .panel button {
                max-width: 100%;
            }
            .logo-container img {
                max-height: 150px;
            }
        }
    </style>
    
</head>
<body>
    <!-- Menú de navegación -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="../../public/assets/img/logo.png" alt="Logo" class="logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="interfazpaneles.php">PANELES</a></li>
                </ul>
            </div>
        </div>
    </nav>
     
    <div class="container mt-5">
        <div class="text-center mb-5">
            <h1>¡Bienvenido, <?php echo $nombreUsuario; ?>!</h1>
            <h2>Tu rol es: <?php echo $rol; ?></h2>
            <form action="logout.php" method="POST">
                <button type="submit" class="btnCerrarSesion">Cerrar sesión</button>
            </form>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="panel">
                    <h3>Hacer Pedido</h3>
                    <button onclick="window.location.href='../pedido.html'">
                        <i class="fas fa-shopping-cart"></i> Ir a Pedido
                    </button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel">
                    <h3>Ver Menú</h3>
                    <button onclick="window.location.href='../menu.html'">
                        <i class="fas fa-utensils"></i> Ir al Menú
                    </button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel">
                    <h3>Gestión de Usuarios</h3>
                    <button onclick="window.location.href='../usuarios.php'">
                        <i class="fas fa-users-cog"></i> Administrar Usuarios
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="panel">
                    <h3>Historial de Pedidos</h3>
                    <button onclick="window.location.href='../historial.html'">
                        <i class="fas fa-history"></i> Ver Historial
                    </button>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel">
                    <h3>Configuración</h3>
                    <button onclick="window.location.href='../configuracion.html'">
                        <i class="fas fa-cog"></i> Configuración
                    </button>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div class="footer-container">
            <div class="footer-section left">
                <p><i class="fas fa-map-marker-alt"> </i><strong> Dirección:</strong> Gabriel Rene Moreno, La Paz, Bolivia</p>
                <p><i class="fas fa-phone"></i> <strong>Teléfono:</strong> +591 123 4567</p>
                <p><i class="fas fa-envelope"></i> <strong>Email:</strong> info@thecake.com</p>
                <p><i class="fas fa-globe"></i> <strong>Sitio web:</strong> www.thecake.com</p>
            </div>
            <div class="footer-section center">
                <h2>THE CAKE</h2>
                <p><strong>Horario de atención:</strong></p>
                <p>Lunes a domingo: 8:00 a.m. - 9:00 p.m.</p>
            </div>
            <div class="footer-section right">
                <p><strong>Síguenos en redes sociales:</strong></p>
                <p><i class="fab fa-instagram"></i> <strong>Instagram:</strong> @thecake_lapaz</p>
                <p><i class="fab fa-facebook"></i> <strong>Facebook:</strong> The Cake La Paz</p>
                <p><i class="fab fa-twitter"></i> <strong>Twitter:</strong> @thecake_lapaz</p>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
