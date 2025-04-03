

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
<head>
    <title>Menú - The Cake</title>
    <link rel="stylesheet" href="../public/assets/css/styleCarrito.css">

    <link rel="icon" href="../public/assets/images/favicon.ico" type="image/x-icon">

</head>

<?php
include 'templates/header.php';
?>       

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