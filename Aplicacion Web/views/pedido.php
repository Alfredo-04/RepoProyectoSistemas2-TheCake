<?php
require_once '../connection.php';

// Consulta SQL para obtener los productos, sus categorías y el stock disponible
$sql = "SELECT p.id_producto, p.nombre_producto, p.precio, p.descripcion, p.imagen, c.nombre_categoria, 
        COALESCE(ip.cantidad_disponible, 0) AS cantidad_disponible
        FROM productos p
        JOIN categorias_productos c ON p.categoria_producto_id = c.id_categoria
        LEFT JOIN inventario_productos ip ON p.id_producto = ip.id_producto
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

// Obtener métodos de pago
$sqlMetodosPago = "SELECT id_metodo_pago, nombre_metodo_pago FROM metodos_pago";
$resultMetodosPago = $conn->query($sqlMetodosPago);
$metodosPago = [];
while ($metodo = $resultMetodosPago->fetch_assoc()) {
    $metodosPago[] = $metodo;
}

// Cerrar la conexión
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
<?php 
require_once 'check_role.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido - The Cake</title>
    <link rel="stylesheet" href="../public/assets/css/styles.css">
    <link rel="stylesheet" href="../public/assets/css/stylesIndex.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="./../public/assets/css/styleFooter.css">
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
    display: flex;
    flex-direction: column; /* Alinea los elementos verticalmente */
    align-items: center; /* Centra los elementos horizontalmente */
    justify-content: space-between; /* Distribuye el espacio entre los elementos */
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
        /* Estilos para el ícono del carrito */
        .cart-icon {
            position: fixed;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.9);
            padding: 10px;
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            z-index: 1000;
        }

        .cart-icon i {
            font-size: 1.5rem;
            color: #ff6f61;
        }

        .cart-count {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #ff6f61;
            color: #fff;
            font-size: 0.8rem;
            padding: 2px 6px;
            border-radius: 50%;
        }

        /* Estilos para el carrito */
        .cart-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1001;
        }

        .cart-container {
            background: #fff;
            padding: 20px;
            border-radius: 20px;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            animation: slideIn 0.5s ease-in-out;
        }

        .cart-container h3 {
            font-size: 2rem;
            color: #ff6f61;
            margin-bottom: 20px;
            text-align: center;
        }

        .cart-items {
            max-height: 300px;
            overflow-y: auto;
            margin-bottom: 20px;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 10px;
        }

        .cart-item-info {
            flex: 1;
            margin-left: 10px;
        }

        .cart-item-info h4 {
            font-size: 1.2rem;
            color: #333;
        }

        .cart-item-info p {
            font-size: 1rem;
            color: #ff6f61;
        }

        .cart-item-actions {
            display: flex;
            align-items: center;
        }

        .cart-item-actions button {
            background: #ff6f61;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
        }

        .cart-item-actions button:hover {
            background: #ff4a3d;
        }

        .cart-total {
            font-size: 1.5rem;
            color: #333;
            text-align: right;
            margin-top: 20px;
        }

        .cart-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .cart-actions button {
            background: #ff6f61;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
        }

        .cart-actions button:hover {
            background: #ff4a3d;
        }

        /* Estilos para los controles de cantidad */
        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 10px 0;
        }

        .quantity-controls button {
            background: #ff6f61;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }

        .quantity-controls button:hover {
            background: #ff4a3d;
        }

        .quantity-controls span {
            font-size: 1.2rem;
            font-weight: bold;
        }
        /* Estilos para el botón "Añadir al carrito" */
        .add-to-cart-btn {
    background: #ff6f61; /* Color de fondo */
    color: #fff; /* Color del texto */
    border: none;
    padding: 10px 20px;
    border-radius: 25px; /* Bordes redondeados */
    font-size: 1rem;
    font-family: 'Poppins', sans-serif;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra suave */
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px; /* Espacio entre el ícono y el texto */
    width: 100%; /* Ocupa todo el ancho disponible */
    max-width: 200px; /* Limita el ancho máximo para que no sea demasiado grande */
    margin-top: 10px; /* Espacio superior para separarlo del precio */
}

.add-to-cart-btn:hover {
    background: #ff4a3d; /* Color de fondo al pasar el mouse */
    transform: translateY(-2px); /* Efecto de levitación */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15); /* Sombra más pronunciada */
}

.add-to-cart-btn:active {
    transform: translateY(0); /* Efecto de clic */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra normal */
}
.remove-btn {
    background-color: #ff4a3d; /* Rosa */
    color: white;
    border: none;
    padding: 8px 12px;
    cursor: pointer;
    border-radius: 5px;
    font-weight: bold;
    transition: background 0.3s;
}

.remove-btn:hover {
    background-color: #ff1493; /* Rosa más oscuro al pasar el cursor */
}

/* Estilos para el ícono del carrito dentro del botón */
.add-to-cart-btn i {
    font-size: 1.2rem;
}

        @media (max-width: 768px) {
            .cart-container {
                width: 90%;
            }
        }
        /* Estilos para el overlay de métodos de pago */
.payment-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5); /* Fondo semitransparente */
    display: none; /* Oculto por defecto */
    justify-content: center;
    align-items: center;
    z-index: 1002; /* Asegura que esté por encima del carrito */
}

.payment-container {
    background: #fff; /* Fondo blanco */
    padding: 20px;
    border-radius: 20px; /* Bordes redondeados */
    max-width: 400px; /* Ancho máximo */
    width: 100%;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3); /* Sombra suave */
    animation: slideIn 0.5s ease-in-out; /* Animación de entrada */
}

.payment-container h3 {
    font-size: 2rem;
    color: #ff6f61; /* Color rosado */
    margin-bottom: 20px;
    text-align: center;
}

.payment-container form {
    display: flex;
    flex-direction: column;
    gap: 15px; /* Espacio entre elementos */
}

.payment-container label {
    font-size: 1.1rem;
    color: #333; /* Color de texto oscuro */
    display: flex;
    align-items: center;
    gap: 10px; /* Espacio entre el radio y el texto */
}

.payment-container input[type="radio"] {
    accent-color: #ff6f61; /* Color del radio seleccionado */
}

.payment-container button {
    background: #ff6f61; /* Color de fondo */
    color: #fff; /* Color del texto */
    border: none;
    padding: 10px 20px;
    border-radius: 10px; /* Bordes redondeados */
    font-size: 1rem;
    cursor: pointer;
    transition: background 0.3s ease, transform 0.2s ease;
}

.payment-container button:hover {
    background: #ff4a3d; /* Color de fondo al pasar el mouse */
    transform: translateY(-2px); /* Efecto de levitación */
}

.payment-container button:active {
    transform: translateY(0); /* Efecto de clic */
}

/* Animación de entrada para el overlay */
@keyframes slideIn {
    from { transform: translateY(-20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}







/* Estilos para el overlay de selección de consumo */
.consumption-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 1002;
}

.consumption-container {
    background: #fff;
    padding: 20px;
    border-radius: 20px;
    max-width: 400px;
    width: 100%;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    animation: slideIn 0.5s ease-in-out;
}

.consumption-container h3 {
    font-size: 2rem;
    color: #ff6f61;
    margin-bottom: 20px;
    text-align: center;
}

.consumption-options {
    display: flex;
    flex-direction: column;
    gap: 15px;
    margin: 20px 0;
}

.consumption-options button {
    background: #ff6f61;
    color: #fff;
    border: none;
    padding: 15px;
    border-radius: 10px;
    font-size: 1.2rem;
    cursor: pointer;
    transition: all 0.3s;
}

.consumption-options button:hover {
    background: #ff4a3d;
    transform: translateY(-2px);
}

/* Estilos para el overlay de selección de mesas */
.tables-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 1003;
}

.tables-container {
    background: #fff;
    padding: 20px;
    border-radius: 20px;
    max-width: 500px;
    width: 100%;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    animation: slideIn 0.5s ease-in-out;
}

.tables-container h3 {
    font-size: 2rem;
    color: #ff6f61;
    margin-bottom: 20px;
    text-align: center;
}

.tables-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    gap: 15px;
    margin: 20px 0;
}

.table-item {
    padding: 20px;
    text-align: center;
    background-color: #4CAF50;
    color: white;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s;
}

.table-item:hover {
    background-color: #45a049;
    transform: translateY(-3px);
}

.table-item.selected {
    background-color: #2E7D32;
    border: 2px solid #000;
    transform: scale(1.05);
}

.table-info {
    font-size: 0.9em;
    margin-top: 5px;
}

/* Animación de entrada para los overlays */
@keyframes slideIn {
    from { transform: translateY(-20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

/* Estilos para el navbar y dropdown */
.navbar-brand img:hover {
        transform: rotate(10deg);
    }
    
    .nav-link:hover {
        color: #ff6f61 !important;
        transform: translateY(-2px);
    }
    
    .dropdown-item:hover {
        background-color: #f8a29b !important;
        color: white !important;
        transform: translateX(5px);
    }
    
    .dropdown-item:hover i {
        color: white !important;
    }
    
    .dropdown-menu {
        min-width: 220px;
    }
    

    


    /* Estilos responsivos */
    @media (max-width: 992px) {
        .navbar-nav {
            padding-top: 15px;
        }
        
        .nav-item {
            margin-bottom: 8px;
        }
        
        .d-flex {
            margin: 15px 0;
            justify-content: flex-end;
        }
        
        .dropdown-menu {
            position: static !important;
            transform: none !important;
        }
    }
    </style>
</head>
<body>

<!-- Menú de navegación -->
<nav class="navbar navbar-expand-lg navbar-light" style="background: rgba(255, 255, 255, 0.9); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="../public/assets/img/logo.png" alt="Logo" class="logo" style="height: 60px; transition: transform 0.3s ease-in-out;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="index.php" style="font-size: 1.1rem; color: #333 !important; transition: color 0.3s ease-in-out;">THE CAKE</a></li>
                <li class="nav-item"><a class="nav-link" href="menu.php" style="font-size: 1.1rem; color: #333 !important; transition: color 0.3s ease-in-out;">MENU</a></li>
                <li class="nav-item"><a class="nav-link" href="Sucursales.php" style="font-size: 1.1rem; color: #333 !important; transition: color 0.3s ease-in-out;">SUCURSALES</a></li>
                <li class="nav-item"><a class="nav-link" href="Contacts.php" style="font-size: 1.1rem; color: #333 !important; transition: color 0.3s ease-in-out;">CONTACTANOS</a></li>
                <?php if(isset($_SESSION['rol_id']) && $_SESSION['rol_id'] != 5): ?>
                    <li class="nav-item"><a class="nav-link" href="auth/interfazpaneles.php" style="font-size: 1.1rem; color: #333 !important; transition: color 0.3s ease-in-out;">PANELES</a></li>
                <?php endif; ?>
            </ul>
            
            <div class="d-flex align-items-center">
                <?php if(isset($_SESSION['id_usuario'])): ?>
                    <!-- Menú desplegable del usuario -->
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false" style="color: #ff6f61;">
                            <i class="fas fa-user-circle fs-3 me-1" style="color: #ff6f61;"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser" style="background: rgba(255, 255, 255, 0.98); border-radius: 15px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15); border: none; padding: 10px 0;">
                            <li>
                                <div class="dropdown-item" style="font-family: 'Poppins', sans-serif; color: #ff6f61; font-weight: 600; padding: 8px 20px;">
                                    <strong><?php echo explode(' ', $_SESSION['nombre'])[0] . ' ' . explode(' ', $_SESSION['nombre'])[1]; ?></strong>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-item" style="font-family: 'Poppins', sans-serif; color: #333; padding: 8px 20px;">
                                    <?php 
                                        $rol = "";
                                        switch($_SESSION['rol_id']) {
                                            case 1: $rol = "Administrador"; break;
                                            case 2: $rol = "Cajero"; break;
                                            case 3: $rol = "Mesero"; break;
                                            case 4: $rol = "Cocinero"; break;
                                            case 5: $rol = "Cliente"; break;
                                        }
                                        echo "ROL: $rol";
                                    ?>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider" style="margin: 0.5rem 20px;"></li>
                            <li>
                                <a class="dropdown-item" href="#" style="font-family: 'Poppins', sans-serif; color: #333; transition: all 0.3s; padding: 8px 20px;">
                                    <i class="fas fa-user-circle me-2" style="color: #ff6f61;"></i>Ver cuenta
                                </a>
                            </li>
                            <li>
                                <form action="auth/logout.php" method="POST">
                                    <button type="submit" class="dropdown-item" style="font-family: 'Poppins', sans-serif; color: #333; transition: all 0.3s; background: none; border: none; width: 100%; text-align: left; padding: 8px 20px;">
                                        <i class="fas fa-sign-out-alt me-2" style="color: #ff6f61;"></i>Cerrar sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                <?php else: ?>
                    <!-- Botón de iniciar sesión si no hay sesión activa -->
                    <a href="auth/LoginSignUp.php" class="btn ms-2" style="background: #ff6f61; color: white; border-radius: 25px; padding: 8px 20px; font-family: 'Poppins', sans-serif; transition: all 0.3s;">
                        Iniciar sesión
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

     <!-- Ícono del carrito -->
     <div class="cart-icon" onclick="toggleCart()">
                <i class="fas fa-shopping-cart"></i>
                <span class="cart-count">0</span>
            </div>
        </div>
    </nav>

    <!-- Overlay del carrito -->
    <div class="cart-overlay" id="cartOverlay">
        <div class="cart-container">
            <h3>Carrito de Compras</h3>
            <div class="cart-items" id="cartItems">
                <!-- Aquí se mostrarán los items del carrito -->
            </div>
            <div class="cart-total">
                Total: <span id="cartTotal">Bs. 0</span>
            </div>
            <div class="cart-actions">
                <button onclick="closeCart()">Cerrar</button>
                <button onclick="showConsumptionType()">Siguiente</button>
            </div>
        </div>
    </div>


    <!-- Overlay para seleccionar tipo de consumo -->
    <div class="consumption-overlay" id="consumptionOverlay">
        <div class="consumption-container">
            <h3>¿Dónde va a consumir?</h3>
            <div class="consumption-options">
                <button onclick="selectConsumptionType('local')">En el local</button>
                <button onclick="selectConsumptionType('takeaway')">Para llevar</button>
            </div>
            <div class="cart-actions">
                <button onclick="closeConsumptionType()">Volver</button>
            </div>
        </div>
    </div>

    <!-- Overlay para seleccionar mesa (solo para consumo en local) -->
    <div class="tables-overlay" id="tablesOverlay">
        <div class="tables-container">
            <h3>Seleccione una mesa disponible</h3>
            <div class="tables-grid" id="tablesGrid">
                <!-- Aquí se mostrarán las mesas disponibles -->
            </div>
            <div class="cart-actions">
                <button onclick="closeTablesSelection()">Volver</button>
                <button onclick="confirmTableSelection()">Confirmar Mesa</button>
            </div>
        </div>
    </div>


    <!-- Overlay de métodos de pago -->
    <div class="payment-overlay" id="paymentOverlay">
        <div class="payment-container">
            <h3>Seleccione un método de pago</h3>
            <form id="paymentForm">
                <?php foreach ($metodosPago as $metodo): ?>
                    <label>
                        <input type="radio" name="metodo_pago" value="<?php echo $metodo['id_metodo_pago']; ?>">
                        <?php echo htmlspecialchars($metodo['nombre_metodo_pago']); ?>
                    </label><br>
                <?php endforeach; ?>
                <button type="button" onclick="processPayment()">Confirmar Pago</button>
                <button type="button" onclick="closePaymentMethods()">Cancelar</button>
            </form>
        </div>
    </div>



<main>
        <h2>PEDIDO</h2>

        <!-- Mostrar productos por categoría -->
        <div class="productos-container">
            <?php if (!empty($productosPorCategoria)): ?>
                <?php foreach ($productosPorCategoria as $categoria => $productos): ?>
                    <div class="menu-category">
                        <h3><?php echo htmlspecialchars($categoria); ?></h3>
                        <div class="menu-grid">
                            <?php foreach ($productos as $producto): ?>
                                <div class="menu-item" data-id="<?php echo $producto['id_producto']; ?>" 
                                     data-name="<?php echo htmlspecialchars($producto['nombre_producto']); ?>" 
                                     data-price="<?php echo $producto['precio']; ?>" 
                                     data-image="data:image/jpeg;base64,<?php echo base64_encode($producto['imagen']); ?>"
                                     data-stock="<?php echo $producto['cantidad_disponible']; ?>"> <!-- Nuevo campo: stock -->
                                    <?php if (!empty($producto['imagen'])) { ?>
                                        <img src="data:image/jpeg;base64,<?php echo base64_encode($producto['imagen']); ?>" 
                                             alt="Imagen del producto"> 
                                    <?php } else { ?>
                                        <img src="../public/assets/img/no-image.png" alt="Sin imagen">
                                    <?php } ?>
                                    <h4><?php echo htmlspecialchars($producto['nombre_producto']); ?></h4>
                                    <p>Bs. <?php echo number_format($producto['precio'], 2); ?></p>
                                    <?php if ($producto['cantidad_disponible'] > 0): ?>
                                        <button class="add-to-cart-btn" onclick="addToCart(this)">
                                            <i class="fas fa-cart-plus"></i> Añadir al carrito
                                        </button>
                                    <?php else: ?>
                                        <button class="add-to-cart-btn" disabled>
                                            <i class="fas fa-times"></i> Agotado
                                        </button>
                                    <?php endif; ?>
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

    <script>
        let cart = []; // Array para almacenar los productos del carrito
        let cartTotal = 0; // Variable para almacenar el total del carrito
        let consumptionType = null; // Variable para almacenar el tipo de consumo
        let selectedTableId = null; // Variable para almacenar la mesa seleccionada

        // Función para añadir un producto al carrito
        function addToCart(button) {
            const item = button.parentElement; // Obtener el contenedor del producto
            const itemId = item.getAttribute('data-id'); // Obtener el ID del producto
            const itemName = item.getAttribute('data-name'); // Obtener el nombre del producto
            const itemPrice = parseFloat(item.getAttribute('data-price')); // Obtener el precio del producto
            const itemImage = item.getAttribute('data-image'); // Obtener la imagen del producto
            const itemStock = parseInt(item.getAttribute('data-stock')); // Obtener el stock del producto

            // Verificar si hay stock disponible
            if (itemStock <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Producto agotado',
                    text: 'Este producto no está disponible actualmente.',
                    confirmButtonColor: '#ff6f61'
                });
                return;
            }

            // Verificar si el producto ya está en el carrito
            const existingItem = cart.find((product) => product.id === itemId);

            if (existingItem) {
                // Si ya está, incrementar la cantidad (si hay stock suficiente)
                if (existingItem.quantity < itemStock) {
                    existingItem.quantity++;
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Stock insuficiente',
                        text: 'No hay suficiente stock para este producto.',
                        confirmButtonColor: '#ff6f61'
                    });
                    return;
                }
            } else {
                // Si no está, añadirlo al carrito
                cart.push({
                    id: itemId,
                    name: itemName,
                    price: itemPrice,
                    image: itemImage,
                    quantity: 1, // Cantidad inicial
                    stock: itemStock, // Stock disponible
                });
            }

            // Actualizar la interfaz del carrito
            updateCartUI();
        }

        // Función para actualizar la interfaz del carrito
        function updateCartUI() {
            const cartItemsContainer = document.getElementById('cartItems'); // Contenedor de los items del carrito
            const cartCount = document.querySelector('.cart-count'); // Contedor de productos en el carrito
            const cartTotalElement = document.getElementById('cartTotal'); // Elemento que muestra el total

            // Limpiar el contenedor de items del carrito
            cartItemsContainer.innerHTML = '';

            // Reiniciar el total del carrito
            cartTotal = 0;
            let totalItems = 0;

            // Recorrer los productos del carrito y mostrarlos
            cart.forEach((item, index) => {
                const subtotal = item.quantity * item.price; // Calcular el subtotal del producto
                cartTotal += subtotal; // Sumar al total del carrito
                totalItems += item.quantity; // Sumar al contador de productos

                // Crear el elemento del producto en el carrito
                const cartItem = document.createElement('div');
                cartItem.className = 'cart-item';
                cartItem.innerHTML = `
                    <img src="${item.image}" alt="${item.name}">
                    <div class="cart-item-info">
                        <h4>${item.name}</h4>
                        <p>Bs. ${item.price.toFixed(2)} c/u</p>
                        <div class="quantity-controls">
                            <button onclick="decreaseQuantity(${index})">-</button>
                            <span>${item.quantity}</span>
                            <button onclick="increaseQuantity(${index})" ${item.quantity >= item.stock ? 'disabled' : ''}>+</button>
                        </div>
                        <p>Subtotal: Bs. ${subtotal.toFixed(2)}</p>
                    </div>
                    <button class="remove-btn" onclick="removeFromCart(${index})">Eliminar</button>
                `;
                cartItemsContainer.appendChild(cartItem); // Añadir el producto al carrito
            });

            // Actualizar el total del carrito y el contador de productos
            cartTotalElement.textContent = `Bs. ${cartTotal.toFixed(2)}`;
            cartCount.textContent = totalItems;
        }

        // Función para aumentar la cantidad de un producto en el carrito
        function increaseQuantity(index) {
            if (cart[index].quantity < cart[index].stock) {
                cart[index].quantity++; // Incrementar la cantidad
                updateCartUI(); // Actualizar la interfaz
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Stock máximo',
                    text: 'No puedes añadir más unidades de este producto.',
                    confirmButtonColor: '#ff6f61'
                });
            }
        }

        // Función para disminuir la cantidad de un producto en el carrito
        function decreaseQuantity(index) {
            if (cart[index].quantity > 1) {
                cart[index].quantity--; // Disminuir la cantidad
            } else {
                cart.splice(index, 1); // Eliminar el producto si la cantidad es 1
            }
            updateCartUI(); // Actualizar la interfaz
        }

        // Función para eliminar un producto del carrito
        function removeFromCart(index) {
            cart.splice(index, 1); // Eliminar el producto
            updateCartUI(); // Actualizar la interfaz
        }

        // Función para mostrar/ocultar el carrito
        function toggleCart() {
            const cartOverlay = document.getElementById('cartOverlay');
            if (cartOverlay.style.display === 'flex') {
                cartOverlay.style.display = 'none'; // Ocultar el carrito
            } else {
                cartOverlay.style.display = 'flex'; // Mostrar el carrito
            }
        }

        // Función para cerrar el carrito
        function closeCart() {
            document.getElementById('cartOverlay').style.display = 'none'; // Ocultar el carrito
        }

        // Función para mostrar el overlay de tipo de consumo
        function showConsumptionType() {
            if (cart.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Carrito vacío',
                    text: 'Agrega productos al carrito antes de continuar.',
                    confirmButtonColor: '#ff6f61'
                });
                return;
            }
            document.getElementById('cartOverlay').style.display = 'none';
            document.getElementById('consumptionOverlay').style.display = 'flex';
        }

        // Función para cerrar el overlay de tipo de consumo
        function closeConsumptionType() {
            document.getElementById('consumptionOverlay').style.display = 'none';
            document.getElementById('cartOverlay').style.display = 'flex';
        }

        // Función para seleccionar el tipo de consumo
        function selectConsumptionType(type) {
            consumptionType = type;
            
            if (type === 'takeaway') {
                // Si es para llevar, ir directamente a pagos
                closeConsumptionType();
                showPaymentMethods();
            } else {
                // Si es para local, mostrar mesas disponibles
                document.getElementById('consumptionOverlay').style.display = 'none';
                showAvailableTables();
            }
        }

        // Función para mostrar mesas disponibles
        function showAvailableTables() {
            // Limpiar el grid de mesas
            const tablesGrid = document.getElementById('tablesGrid');
            tablesGrid.innerHTML = '';
            
            // Hacer una petición para obtener las mesas disponibles
            fetch('get_available_tables.php')
                .then(response => response.json())
                .then(tables => {
                    if (tables.length === 0) {
                        tablesGrid.innerHTML = '<p>No hay mesas disponibles en este momento</p>';
                        return;
                    }

                    tables.forEach(table => {
                        const tableElement = document.createElement('div');
                        tableElement.className = 'table-item';
                        tableElement.innerHTML = `
                            <div>${table.numeroDeMesa}</div>
                            <div class="table-info">Capacidad: ${table.capacidad}</div>
                        `;
                        tableElement.dataset.tableId = table.id;
                        tableElement.onclick = function() {
                            // Deseleccionar cualquier mesa previamente seleccionada
                            document.querySelectorAll('.table-item.selected').forEach(item => {
                                item.classList.remove('selected');
                            });
                            // Seleccionar esta mesa
                            this.classList.add('selected');
                            selectedTableId = table.id;
                        };
                        tablesGrid.appendChild(tableElement);
                    });
                    
                    // Mostrar el overlay de mesas
                    document.getElementById('tablesOverlay').style.display = 'flex';
                })
                .catch(error => {
                    console.error('Error al obtener mesas:', error);
                    tablesGrid.innerHTML = '<p>Error al cargar mesas disponibles</p>';
                    document.getElementById('tablesOverlay').style.display = 'flex';
                });
        }

        // Función para cerrar la selección de mesas
        function closeTablesSelection() {
            document.getElementById('tablesOverlay').style.display = 'none';
            document.getElementById('consumptionOverlay').style.display = 'flex';
            selectedTableId = null; // Resetear la mesa seleccionada
        }

        // Función para confirmar la selección de mesa
        function confirmTableSelection() {
            if (!selectedTableId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Selecciona una mesa',
                    text: 'Por favor elige una mesa para continuar.',
                    confirmButtonColor: '#ff6f61'
                });
                return;
            }
            
            // Marcar la mesa como ocupada en la base de datos
            fetch('update_table_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    tableId: selectedTableId,
                    status: 'ocupada'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Ir a métodos de pago
                    document.getElementById('tablesOverlay').style.display = 'none';
                    showPaymentMethods();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al reservar',
                        text: data.error || 'No se pudo reservar la mesa',
                        confirmButtonColor: '#ff6f61'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error al reservar la mesa',
                    confirmButtonColor: '#ff6f61'
                });
            });
        }

        // Función para mostrar el overlay de métodos de pago
        function showPaymentMethods() {
            document.getElementById('paymentOverlay').style.display = 'flex';
        }

        // Función para cerrar el overlay de métodos de pago
        function closePaymentMethods() {
            document.getElementById('paymentOverlay').style.display = 'none';
            
            // Volver al carrito si no se ha seleccionado mesa
            if (!selectedTableId) {
                document.getElementById('cartOverlay').style.display = 'flex';
            }
        }

        // Función para procesar el pago
        function processPayment() {
            const metodoPago = document.querySelector('input[name="metodo_pago"]:checked'); // Obtener el método de pago seleccionado
            if (!metodoPago) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Método de pago',
                    text: 'Por favor selecciona un método de pago',
                    confirmButtonColor: '#ff6f61'
                }); // Mostrar alerta si no se selecciona un método de pago
                return;
            }

            // Crear el objeto con los datos del pedido
            const pedido = {
                cart: cart,
                metodoPagoId: metodoPago.value,
                total: cartTotal,
                consumptionType: consumptionType,
                tableId: selectedTableId
            };


            // Mostrar loader mientras se procesa
            Swal.fire({
                title: 'Procesando pedido',
                html: 'Por favor espera mientras confirmamos tu pago...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });


            // Enviar los datos del carrito y el método de pago al servidor
            fetch('procesar_pedido.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(pedido),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la solicitud');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Pedido completado!',
                        text: 'Tu pago se ha procesado correctamente',
                        confirmButtonColor: '#ff6f61',
                        willClose: () => {
                            cart = [];
                            updateCartUI();
                            closePaymentMethods();
                            resetOrderData();
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al procesar',
                        text: data.message || 'Hubo un problema con tu pedido',
                        confirmButtonColor: '#ff6f61'
                    });
                }
            })
            .catch(error => {

                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo completar el pedido',
                    confirmButtonColor: '#ff6f61'
                });
            });
        }

        // Función para resetear los datos de la orden
        function resetOrderData() {
            consumptionType = null;
            selectedTableId = null;
            cart = [];
            updateCartUI();
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>