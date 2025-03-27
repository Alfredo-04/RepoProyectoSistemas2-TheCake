

<?php
require_once '../connection.php';

// Consulta SQL para obtener los productos y sus categorías
$sql = "SELECT p.id_producto, p.nombre_producto, p.precio, p.descripcion, p.imagen, c.nombre_categoria 
        FROM productos p
        JOIN categorias_productos c ON p.categoria_producto_id = c.id_categoria
        ORDER BY c.nombre_categoria, p.nombre_producto";

$result = $conn->query($sql);

if ($result === false) {
    die("Error en la consulta: " . $conn->error);
}

// Organizar los productos por categoría
$productosPorCategoria = [];
while ($producto = $result->fetch_assoc()) {
    $categoria = $producto['nombre_categoria'];
    if (!isset($productosPorCategoria[$categoria])) {
        $productosPorCategoria[$categoria] = [];
    }
    $productosPorCategoria[$categoria][] = $producto;
}

// Cerrar la conexión
$conn->close();
?>

<?php 
require_once 'check_role.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú - The Cake</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../public/assets/css/styleCarrito.css">

    <link rel="icon" href="../public/assets/images/favicon.ico" type="image/x-icon">
    <!-- Stylesheets-->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:100,300,300i,400,500,600,700,900%7CRaleway:500">
    <link rel="stylesheet" href="../public/assets/css/bootstrap.css">
    <link rel="stylesheet" href="../public/assets/css/fonts.css">
    <link rel="stylesheet" href="../public/assets/css/style.css">
    <link rel="stylesheet" href="../public/assets/css/styleFooter.css">

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

            /* Panel principal */
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

            /* Tarjetas de productos */
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

            .menu-item img {
                width: 100%;
                height: 200px;
                object-fit: cover;
                border-radius: 15px;
                transition: transform 0.3s ease-in-out;
            }

            .menu-item:hover img {
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

            .rd-navbar-nav {
    display: flex;
    align-items: center; /* Asegura que estén alineados verticalmente */
    justify-content: space-around; /* O "space-between" según necesites */
    list-style: none;
    padding: 0;
    margin: 0;
}
.rd-nav-item {
    padding: 10px 15px; /* Asegura que todos los elementos tengan el mismo espacio */
}
.rd-nav-item a {
    text-decoration: none;
    color: black; /* Ajusta según tu diseño */
}


            

            .nav-link {
                font-size: 1.1rem;
                color: #333 !important;
                transition: color 0.3s ease-in-out;
            }

            .nav-link:hover {
                color: #ff6f61 !important;
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

        

        .
        /* Estilos para el ícono del carrito */
    .cart-icon {
        position: fixed; /* Fija el ícono en la pantalla */
        top: 20px; /* Distancia desde la parte superior */
        right: 20px; /* Distancia desde la derecha */
        font-size: 24px; /* Tamaño del ícono */
        color: #ff6f61; /* Color del ícono */
        background-color: #fff; /* Fondo del ícono */
        padding: 10px; /* Espaciado interno */
        border-radius: 50%; /* Hace que el fondo sea circular */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Sombra para resaltar */
        transition: transform 0.3s ease, background-color 0.3s ease; /* Animación al pasar el mouse */
        z-index: 1000; /* Asegura que esté por encima de otros elementos */
    }

    .cart-icon:hover {
        transform: scale(1.1); /* Efecto de escala al pasar el mouse */
        background-color: #ffcc00; /* Cambia el color de fondo al pasar el mouse */
        color: #fff; /* Cambia el color del ícono al pasar el mouse */
    }

        @media (max-width: 768px) {
            
        }
            /* Efectos de hover para los íconos */
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
                        <div class="rd-navbar-brand"><a class="brand" href="index.php"><img class="brand-logo-dark" src="../public/assets/images/logoTheCake.png" alt="" width="198" height="66"/></a></div>
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
                                <li class="rd-nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : ''; ?>">
                                    <a class="rd-nav-link" href="index.php">THE CAKE</a>
                                </li>
                                <li class="rd-nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'menu.php' ? 'active' : ''; ?>">
                                    <a class="rd-nav-link" href="menu.php">MENU</a>
                                </li>
                                <li class="rd-nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'sucursales.php' ? 'active' : ''; ?>">
                                    <a class="rd-nav-link" href="sucursales.php">SUCURSALES</a>
                                </li>
                                <li class="rd-nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'contacts.php' ? 'active' : ''; ?>">
                                    <a class="rd-nav-link" href="contacts.php">CONTACTANOS</a>
                                </li>
                                <?php if(isset($_SESSION['id_usuario'])): ?>
                                    <li class="rd-nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'InterfazPaneles.php' ? 'active' : ''; ?>">
                                        <a class="rd-nav-link" href="auth/InterfazPaneles.php">PANELES</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <!-- Ícono del carrito -->
                        <a href="pedido.php" class="cart-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>

    <main>
    <h2>MENÚ</h2>

    <div class="productos-container">
        <?php if (!empty($productosPorCategoria)): ?>
            <?php foreach ($productosPorCategoria as $categoria => $productos): ?>
                <div class="menu-category">
                    <h3><?php echo htmlspecialchars($categoria); ?></h3>
                    <div class="menu-grid">
                        <?php foreach ($productos as $producto): ?>
                            <div class="menu-item">
                                <?php if (!empty($producto['imagen'])) { ?>
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($producto['imagen']); ?>" 
                                        alt="Imagen del producto">
                                <?php } else { ?>
                                    <img src="../public/assets/img/no-image.png" alt="Sin imagen">
                                <?php } ?>
                                <h4><?php echo htmlspecialchars($producto['nombre_producto']); ?></h4>
                                <p>Precio: Bs.<?php echo number_format($producto['precio'], 2); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay productos disponibles.</p>
        <?php endif; ?>
    </div>
</main>


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
    <script src="../public/assets/js/core.min.js"></script>
    <script src="../public/assets/js/scriptIndex.js"></script>
    <!-- coded by Himic-->
  </body>
</html>