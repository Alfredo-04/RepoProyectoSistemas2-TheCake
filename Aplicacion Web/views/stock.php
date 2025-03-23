<?php
include '../connection.php';

// Obtener productos y su stock
$query = "SELECT p.id_producto, p.nombre_producto, p.precio, p.stock_minimo, p.imagen,
            COALESCE(i.cantidad_disponible, 0) AS stock_actual
            FROM productos p
            LEFT JOIN inventario_productos i ON p.id_producto = i.id_producto";

$result = mysqli_query($conn, $query);

// Agregar stock a un producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_stock'])) {
    $id_producto = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];

    // Verificar si ya existe en el inventario
    $checkQuery = "SELECT cantidad_disponible FROM inventario_productos WHERE id_producto = '$id_producto'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Actualizar stock existente
        $updateQuery = "UPDATE inventario_productos SET cantidad_disponible = cantidad_disponible + '$cantidad' WHERE id_producto = '$id_producto'";
        mysqli_query($conn, $updateQuery);
    } else {
        // Insertar nuevo stock
        $insertQuery = "INSERT INTO inventario_productos (id_producto, cantidad_disponible) VALUES ('$id_producto', '$cantidad')";
        mysqli_query($conn, $insertQuery);
    }
    header("Location: stock.php");
    exit;
}

// Agregar un nuevo producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_producto'])) {
    $nombre_producto = $_POST['nombre_producto'];
    $precio = $_POST['precio'];
    $stock_minimo = $_POST['stock_minimo'];
    
    // Manejar la imagen
    $imagen = null;
    if (isset($_FILES['imagen']) && $_FILES['imagen']['size'] > 0) {
        $imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
    }

    $insertProductoQuery = "INSERT INTO productos (nombre_producto, precio, stock_minimo, imagen) 
                            VALUES ('$nombre_producto', '$precio', '$stock_minimo', '$imagen')";
    mysqli_query($conn, $insertProductoQuery);
    
    header("Location: stock.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Stock</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="./../public/assets/css/styleStock.css">
    <link rel="stylesheet" href="./../public/assets/css/styleFooter.css">
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
                    <li class="nav-item"><a class="nav-link" href="auth/interfazpaneles.php">PANELES</a></li>
                </ul>
            </div>
        </div>
    </nav>

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
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td>
                            <?php if ($row['imagen']) { ?>
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($row['imagen']); ?>" 
                                    alt="Imagen del producto" class="product-image">
                            <?php } else { ?>
                                <img src="../public/assets/img/no-image.png" class="product-image" alt="Sin imagen">
                            <?php } ?>
                            </td>
                            <td><?php echo $row['nombre_producto']; ?></td>
                            <td><?php echo $row['precio']; ?></td>
                            <td><?php echo $row['stock_actual']; ?></td>
                            <td><?php echo $row['stock_minimo']; ?></td>
                            <td>
                                <form method="POST" action="" class="d-flex">
                                    <input type="hidden" name="id_producto" value="<?php echo $row['id_producto']; ?>">
                                    <input type="number" class="form-control me-2" name="cantidad" min="1" required>
                                    <button type="submit" class="btn btn-primary" name="agregar_stock">+</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

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
