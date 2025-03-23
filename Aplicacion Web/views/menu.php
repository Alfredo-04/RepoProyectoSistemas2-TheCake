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
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú - The Cake</title>
    <link rel="stylesheet" href="../public/assets/css/styles.css">
    <link rel="stylesheet" href="../public/assets/css/stylesIndex.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="./../public/assets/css/styleFooter.css">
    <link rel="stylesheet" href="./../public/assets/css/styleCarrito.css">

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

            /* Menú de navegación */
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

    <!-- Menú de navegación -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="../public/assets/img/logo.png" alt="Logo" class="logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">THE CAKE</a></li>
                    <li class="nav-item"><a class="nav-link" href="menu.php">MENU</a></li>
                    <li class="nav-item"><a class="nav-link" href="Sucursal.html">SUCURSALES</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">CONTACTANOS</a></li>
                    <li class="nav-item"><a class="nav-link" href="auth/interfazpaneles.php">PANELES</a></li>
                </ul>
            </div>
            <!-- Ícono del carrito -->
            <a href="pedido.php" class="cart-icon">
                <i class="fas fa-shopping-cart"></i>
            </a>
        </div>
    </nav>

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
                                <p>Precio: $<?php echo number_format($producto['precio'], 2); ?></p>
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
</body>
</html>