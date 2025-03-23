<?php
require_once '../connection.php';

// Consulta SQL para obtener los productos, sus categorías y el stock disponible
$sql = "SELECT p.id_producto, p.nombre_producto, p.precio, p.descripcion, p.imagen, c.nombre_categoria, ip.cantidad_disponible 
        FROM productos p
        JOIN categorias_productos c ON p.categoria_producto_id = c.id_categoria
        JOIN inventario_productos ip ON p.id_producto = ip.id_producto
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
                <button onclick="showPaymentMethods()">Pagar</button>
            </div>
        </div>
    </div>

    <!-- Overlay de métodos de pago (oculto por defecto) -->
    <!-- Overlay de métodos de pago (oculto por defecto) -->
<div class="payment-overlay" id="paymentOverlay" style="display: none;">
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
                alert('Este producto está agotado.');
                return;
            }

            // Verificar si el producto ya está en el carrito
            const existingItem = cart.find((product) => product.id === itemId);

            if (existingItem) {
                // Si ya está, incrementar la cantidad (si hay stock suficiente)
                if (existingItem.quantity < itemStock) {
                    existingItem.quantity++;
                } else {
                    alert('No hay suficiente stock para este producto.');
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
            const cartCount = document.querySelector('.cart-count'); // Contador de productos en el carrito
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
                alert('No hay suficiente stock para este producto.');
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

        // Función para mostrar el overlay de métodos de pago
        function showPaymentMethods() {
            if (cart.length === 0) {
                alert("El carrito está vacío."); // Mostrar alerta si el carrito está vacío
                return;
            }
            document.getElementById('paymentOverlay').style.display = 'flex'; // Mostrar el overlay de métodos de pago
        }

        // Función para cerrar el overlay de métodos de pago
        function closePaymentMethods() {
            document.getElementById('paymentOverlay').style.display = 'none'; // Ocultar el overlay de métodos de pago
        }

        // Función para procesar el pago
        function processPayment() {
            const metodoPago = document.querySelector('input[name="metodo_pago"]:checked'); // Obtener el método de pago seleccionado
            if (!metodoPago) {
                alert('Seleccione un método de pago.'); // Mostrar alerta si no se selecciona un método de pago
                return;
            }

            // Crear el objeto con los datos del pedido
            const pedido = {
                cart: cart,
                metodoPagoId: metodoPago.value,
                total: cartTotal,
            };

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
                    alert('Pago realizado con éxito');
                    cart = []; // Vaciar el carrito
                    updateCartUI(); // Actualizar la interfaz
                    closePaymentMethods(); // Cerrar el overlay de métodos de pago
                } else {
                    alert('Hubo un error al procesar el pedido: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Hubo un error al procesar el pedido.');
            });
        }
    </script>
</body>
</html>