<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: LoginSignUp.php");
    exit();
}

// Obtener el nombre y rol del usuario desde la sesión
$nombreUsuario = $_SESSION['nombre'];
$rolUsuario = $_SESSION['rol_id'];

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
<?php
if (isset($_GET['error']) && $_GET['error'] == 'acceso_denegado') {
    echo '<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            icon: "error",
            title: "Acceso denegado",
            text: "No tienes permiso para acceder a esa página.",
            confirmButtonColor: "#ff6f61",
            confirmButtonText: "Entendido"
        });
    });
    </script>';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Cake - Paneles</title>

        <link rel="icon" href="../../public/assets/images/favicon.ico" type="image/x-icon">
    <!-- Stylesheets-->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:100,300,300i,400,500,600,700,900%7CRaleway:500">
    <link rel="stylesheet" href="../../public/assets/css/bootstrap.css">
    <link rel="stylesheet" href="../../public/assets/css/fonts.css">
    <link rel="stylesheet" href="../../public/assets/css/style.css">
    <link rel="stylesheet" href="../../public/assets/css/styleFooter.css">

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
    
</head>

<body>
    <div class="preloader">
      <div class="wrapper-triangle">
        <div class="pen">
          <div class="line-triangle">
            <div class="triangle"></div>
            <div class="triangle"></div>
            <div class="triangle"></div>
            <div class="triangle"></div>
            <div class="triangle"></div>
            <div class="triangle"></div>
            <div class="triangle"></div>
          </div>
          <div class="line-triangle">
            <div class="triangle"></div>
            <div class="triangle"></div>
            <div class="triangle"></div>
            <div class="triangle"></div>
            <div class="triangle"></div>
            <div class="triangle"></div>
            <div class="triangle"></div>
          </div>
          <div class="line-triangle">
            <div class="triangle"></div>
            <div class="triangle"></div>
            <div class="triangle"></div>
            <div class="triangle"></div>
            <div class="triangle"></div>
            <div class="triangle"></div>
            <div class="triangle"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="page">
      <!-- Page Header-->
      <header class="section page-header">
        <!-- RD Navbar-->
        <div class="rd-navbar-wrap">
          <nav class="rd-navbar rd-navbar-modern" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static" data-lg-device-layout="rd-navbar-fixed" data-xl-layout="rd-navbar-static" data-xl-device-layout="rd-navbar-static" data-xxl-layout="rd-navbar-static" data-xxl-device-layout="rd-navbar-static" data-lg-stick-up-offset="56px" data-xl-stick-up-offset="56px" data-xxl-stick-up-offset="56px" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">
            <div class="rd-navbar-inner-outer">
              <div class="rd-navbar-inner">
                <!-- RD Navbar Panel-->
                <div class="rd-navbar-panel">
                  <!-- RD Navbar Toggle-->
                  <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                  <!-- RD Navbar Brand-->
                  <div class="rd-navbar-brand"><a class="brand" href="#"><img class="brand-logo-dark" src="../../public/assets/images/logoTheCake.png" alt="" width="198" height="66"/></a></div>
                </div>
                <div class="rd-navbar-right rd-navbar-nav-wrap">
                  <div class="rd-navbar-aside">
                    <ul class="rd-navbar-contacts-2">
                      <li>
                        <div class="unit unit-spacing-xs">
                          <div class="unit-left"><span class="icon mdi mdi-phone"></span></div>
                          <div class="unit-body"><a class="phone" href="tel:#">+591 75424853</a></div>
                        </div>
                      </li>
                      <li>
                        <div class="unit unit-spacing-xs">
                          <div class="unit-left"><span class="icon mdi mdi-map-marker"></span></div>
                          <div class="unit-body"><a class="address" href="#">Gabriel Rene Moreno, La Paz, Bolivia</a></div>
                        </div>
                      </li>
                    </ul>
                    <ul class="list-share-2">
                      <li><a class="icon mdi mdi-facebook" href="https://www.facebook.com/TheCake.bo/?locale=es_LA" target="_blank"></a></li>
                      
                      <li><a class="icon mdi mdi-instagram" href="https://www.instagram.com/thecake.bolivia/?hl=es" target="_blank"></a></li>
                     
                    </ul>
                  </div>
                  <div class="rd-navbar-main">
                    <!-- RD Navbar Nav-->
                    <ul class="rd-navbar-nav">
                      <li class="rd-nav-item"><a class="rd-nav-link" href="InterfazPaneles.php">PANELES</a>
                      </li>
                    </ul>
                  </div>
                </div>
               
              </div>
            </div>
          </nav>
        </div>
      </header>
     
    <div class="container mt-5">
        <div class="text-center mb-5">
            <h2>¡Bienvenido, <?php echo $nombreUsuario; ?>!</h2>
            <h2>Tu rol es: <?php echo $rol; ?></h2>
            <form action="logout.php" method="POST">
                <button type="submit" class="btnCerrarSesion" style="background: #ff6f61; color: white">Cerrar sesión</button>
            </form>
        </div>
        <div class="row">
            <!-- Panel Hacer Pedido (Visible para Administrador y Mesero) -->
            <div class="col-md-4 <?php echo ($rolUsuario != 1 && $rolUsuario != 3 && $rolUsuario != 5) ? 'panel-disabled' : ''; ?>">
                <div class="panel">
                    <h2>Hacer Pedido</h2>
                    <?php if($rolUsuario == 1 || $rolUsuario == 3 || $rolUsuario == 5): ?>
                        <button onclick="window.location.href='../pedido.php'">
                            <i class="fas fa-shopping-cart"></i> Ir a Pedido
                        </button>
                    <?php else: ?>
                        <button disabled>
                            <i class="fas fa-shopping-cart"></i> No disponible
                        </button>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Panel Ver Menú (Visible para Administrador y Mesero) -->
            <div class="col-md-4 <?php echo ($rolUsuario != 1 && $rolUsuario != 3) ? 'panel-disabled' : ''; ?>">
                <div class="panel">
                    <h2>Ver Menú</h2>
                    <?php if($rolUsuario == 1 || $rolUsuario == 3): ?>
                        <button onclick="window.location.href='../menu.php'">
                            <i class="fas fa-utensils"></i> Ir al Menú
                        </button>
                    <?php else: ?>
                        <button disabled>
                            <i class="fas fa-utensils"></i> No disponible
                        </button>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Panel Gestión de Usuarios (Solo Administrador) -->
            <div class="col-md-4 <?php echo ($rolUsuario != 1) ? 'panel-disabled' : ''; ?>">
                <div class="panel">
                    <h2>Gestión de Usuarios</h2>
                    <?php if($rolUsuario == 1): ?>
                        <button onclick="window.location.href='../usuarios.php'">
                            <i class="fas fa-users-cog"></i> Administrar Usuarios
                        </button>
                    <?php else: ?>
                        <button disabled>
                            <i class="fas fa-users-cog"></i> No disponible
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Panel Historial de Pedidos (Visible para todos excepto Mesero) -->
            <div class="col-md-4 <?php echo ($rolUsuario == 3 || $rolUsuario == 5) ? 'panel-disabled' : ''; ?>">
                <div class="panel">
                    <h2>Historial de Pedidos</h2>
                    <?php if($rolUsuario != 3 || $rolUsuario == 5): ?>
                        <button onclick="window.location.href='../historial.php'">
                            <i class="fas fa-history"></i> Ver Historial
                        </button>
                    <?php else: ?>
                        <button disabled>
                            <i class="fas fa-history"></i> No disponible
                        </button>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Panel Registro Productos (Administrador y Cocinero) -->
            <div class="col-md-4 <?php echo ($rolUsuario != 1 && $rolUsuario != 4) ? 'panel-disabled' : ''; ?>">
                <div class="panel">
                    <h2>Registro</h2>
                    <?php if($rolUsuario == 1 || $rolUsuario == 4): ?>
                        <button onclick="window.location.href='../registroProductos.php'">
                            <i class="fas fa-clipboard-list"></i> Registro Productos
                        </button>
                    <?php else: ?>
                        <button disabled>
                            <i class="fas fa-clipboard-list"></i> No disponible
                        </button>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Panel Stock (Visible para Administrador y Cocinero) -->
            <div class="col-md-4 <?php echo ($rolUsuario != 1 && $rolUsuario != 4) ? 'panel-disabled' : ''; ?>">
                <div class="panel">
                    <h2>Stock</h2>
                    <?php if($rolUsuario == 1 || $rolUsuario == 4): ?>
                        <button onclick="window.location.href='../stock.php'">
                            <i class="fas fa-boxes"></i> Ver el Stock
                        </button>
                    <?php else: ?>
                        <button disabled>
                            <i class="fas fa-boxes"></i> No disponible
                        </button>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Panel Gestion Mesas (Visible para Administrador y Mesero) -->
            <div class="col-md-4 <?php echo ($rolUsuario != 1 && $rolUsuario != 3) ? 'panel-disabled' : ''; ?>">
                <div class="panel">
                    <h2>Gestion de mesas</h2>
                    <?php if($rolUsuario == 1 || $rolUsuario == 3): ?>
                        <button onclick="window.location.href='../gestion_mesas.php'">
                            <i class="fas fa-shopping-cart"></i> Mesas
                        </button>
                    <?php else: ?>
                        <button disabled>
                            <i class="fas fa-shopping-cart"></i> No disponible
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Footer-->
       <!-- Footer mejorado -->
       <footer>
        <div class="footer-container">
            <!-- Sección de Contacto -->
            <div class="footer-section">
                <h3>CONTACTO</h3>
                <ul>
                    <li><i class="fas fa-map-marker-alt"></i> Gabriel Rene Moreno, La Paz, Bolivia</li>
                    <li><i class="fas fa-phone"></i> +591 75424853</li>
                    <li><i class="fas fa-envelope"></i> marce_laime@hotmail.com</li>
                    <li><i class="fas fa-globe"></i> <a href="http://www.thecake.com" target="_blank">www.thecake.com</a></li>
                </ul>
            </div>
    
            <!-- Sección de Horario --> 
            <div class="footer-section">
                <h3>THE CAKE</h3>
                <p><strong>Horario de atención:</strong></p>
                <p>Lunes a domingo: 8:00 a.m. - 9:00 p.m.</p>
            </div>
    
            <!-- Sección de Redes Sociales -->
            <div class="footer-section">
                <h3>SÍGUENOS</h3>
                <ul class="social-links">
                    <li><a href="https://www.instagram.com/thecake.bolivia" target="_blank"><i class="fab fa-instagram"></i> Instagram</a></li>
                    <li><a href="https://www.facebook.com/share/12G4iwabKJT/" target="_blank"><i class="fab fa-facebook"></i> Facebook</a></li>
                    <li><a href="https://api.whatsapp.com/send/?phone=%2B59175427853&text&type=phone_number&app_absent=0" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp</a></li>
                </ul>
            </div>
        </div>
    </footer>
      
    </div>
    <!-- Global Mailform Output-->
    <div class="snackbars" id="form-output-global"></div>
    <!-- Javascript-->
    <script src="../../public/assets/js/core.min.js"></script>
    <script src="../../public/assets/js/scriptIndex.js"></script>
    <!-- coded by Himic-->


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    

</body>
</html>
