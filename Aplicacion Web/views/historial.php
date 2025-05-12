<?php
require_once '../connection.php';

// ID del cliente (debería obtenerse de la sesión)
$idCliente = 1; 

// Filtrar por estado y fecha si se envía el formulario
$estadoFiltro = isset($_GET['estado']) ? $_GET['estado'] : '';
$fechaInicioFiltro = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : '';
$fechaFinFiltro = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : '';

// Consulta SQL con JOIN para obtener productos
$sql = "SELECT p.id_pedido, p.fecha_pedido, p.total, p.estado_pedido, 
               m.nombre_metodo_pago, 
               GROUP_CONCAT(CONCAT(pr.nombre_producto, ' - Cantidad: ', dp.cantidad) SEPARATOR ', ') AS productos
        FROM pedidos p
        JOIN metodos_pago m ON p.metodo_pago_id = m.id_metodo_pago
        JOIN detalle_pedido dp ON p.id_pedido = dp.id_pedido
        JOIN productos pr ON dp.id_producto = pr.id_producto
        WHERE p.id_cliente = ?";

// Agregar filtros de estado
if (!empty($estadoFiltro)) {
    $sql .= " AND p.estado_pedido = ?";
}

// Agregar filtros de fecha si están definidos
if (!empty($fechaInicioFiltro)) {
    $sql .= " AND p.fecha_pedido >= ?";
}
if (!empty($fechaFinFiltro)) {
    $sql .= " AND p.fecha_pedido <= ?";
}

$sql .= " GROUP BY p.id_pedido ORDER BY p.fecha_pedido DESC";

$stmt = $conn->prepare($sql);

// Vincular los parámetros según los filtros
if (!empty($estadoFiltro) && !empty($fechaInicioFiltro) && !empty($fechaFinFiltro)) {
    $stmt->bind_param("ssss", $idCliente, $estadoFiltro, $fechaInicioFiltro, $fechaFinFiltro);
} elseif (!empty($estadoFiltro) && !empty($fechaInicioFiltro)) {
    $stmt->bind_param("sss", $idCliente, $estadoFiltro, $fechaInicioFiltro);
} elseif (!empty($estadoFiltro) && !empty($fechaFinFiltro)) {
    $stmt->bind_param("sss", $idCliente, $estadoFiltro, $fechaFinFiltro);
} elseif (!empty($fechaInicioFiltro) && !empty($fechaFinFiltro)) {
    $stmt->bind_param("sss", $idCliente, $fechaInicioFiltro, $fechaFinFiltro);
} elseif (!empty($estadoFiltro)) {
    $stmt->bind_param("ss", $idCliente, $estadoFiltro);
} elseif (!empty($fechaInicioFiltro)) {
    $stmt->bind_param("ss", $idCliente, $fechaInicioFiltro);
} elseif (!empty($fechaFinFiltro)) {
    $stmt->bind_param("ss", $idCliente, $fechaFinFiltro);
} else {
    $stmt->bind_param("i", $idCliente);
}

$stmt->execute();
$result = $stmt->get_result();
$pedidos = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();



/**
 * Función para formatear la fecha en "Hoy", "Ayer", etc.
 */
function formatearFecha($fechaCompleta) {
    $fecha = new DateTime($fechaCompleta);
    $hoy = new DateTime();
    $diferencia = $hoy->diff($fecha)->days;

    if ($diferencia == 0) {
        return "Hoy";
    } elseif ($diferencia == 1) {
        return "Ayer";
    } elseif ($diferencia == 2) {
        return "Antes de ayer";
    } elseif ($diferencia <= 6) {
        return "Hace $diferencia días";
    } elseif ($diferencia <= 13) {
        return "Hace 1 semana";
    } else {
        return $fecha->format('d-m-Y');
    }
}
?>
<?php
include 'templates/header.php';
?>  

<head>

    <title>Historial de Pedidos</title>






    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>

</head>
     

      <h2>Historial de Pedidos</h2>

<!-- Formulario de Búsqueda -->
<form method="GET" class="mb-3 d-flex">
    <select name="estado" class="form-select me-2">
        <option value="">Todos</option>
        <option value="Pendiente" <?= ($estadoFiltro == 'Pendiente') ? 'selected' : '' ?>>Pendiente</option>
        <option value="En preparación" <?= ($estadoFiltro == 'En preparación') ? 'selected' : '' ?>>En preparación</option>
        <option value="Listo" <?= ($estadoFiltro == 'Listo') ? 'selected' : '' ?>>Listo</option>
        <option value="Entregado" <?= ($estadoFiltro == 'Entregado') ? 'selected' : '' ?>>Entregado</option>
        <option value="Cancelado" <?= ($estadoFiltro == 'Cancelado') ? 'selected' : '' ?>>Cancelado</option>
    </select>
    
    <!-- Filtro de fecha de inicio -->
    <input type="date" name="fecha_inicio" class="form-control me-2" value="<?= $fechaInicioFiltro ?>">

    <!-- Filtro de fecha de fin -->
    <input type="date" name="fecha_fin" class="form-control me-2" value="<?= $fechaFinFiltro ?>">

    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
    <a href="historial.php" class="btn btn-secondary ms-2"><i class="fas fa-times"></i> Limpiar</a>
    <a href="generar_pdf.php?estado=<?= urlencode($estadoFiltro) ?>&fecha_inicio=<?= urlencode($fechaInicioFiltro) ?>&fecha_fin=<?= urlencode($fechaFinFiltro) ?>" class="btn btn-danger ms-2"><i class="fas fa-file-pdf"></i> Descargar PDF</a>
</form>




    <!-- Tabla de Pedidos -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Productos</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Método de Pago</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $pedido): ?>
                <tr>
                      <td>
                        <?php 
                        // Obtener los productos concatenados con comas
                        $productos = $pedido['productos'];

                        // Convertir la cadena de productos en un array
                        $productosArray = explode(', ', $productos);

                        // Mostrar los productos en formato de lista
                        echo '<ul>';
                        foreach ($productosArray as $producto) {
                            echo '<li>' . htmlspecialchars($producto) . '</li>';
                        }
                        echo '</ul>';
                        ?>
                    </td>
                    <td><?= formatearFecha($pedido['fecha_pedido']); ?></td>
                    <td><?= date('H:i', strtotime($pedido['fecha_pedido'])); ?></td>
                    <td>Bs. <?= number_format($pedido['total'], 2); ?></td>
                    <td>
                        <form method="POST" action="actualizar_estado.php" class="form-estado">
                            <input type="hidden" name="id_pedido" value="<?= $pedido['id_pedido']; ?>">
                            <select name="estado_pedido" class="form-select" onchange="this.form.submit()">
                                <option value="Pendiente" <?= ($pedido['estado_pedido'] == 'Pendiente') ? 'selected' : '' ?>>Pendiente</option>
                                <option value="En preparación" <?= ($pedido['estado_pedido'] == 'En preparación') ? 'selected' : '' ?>>En preparación</option>
                                <option value="Listo" <?= ($pedido['estado_pedido'] == 'Listo') ? 'selected' : '' ?>>Listo</option>
                                <option value="Entregado" <?= ($pedido['estado_pedido'] == 'Entregado') ? 'selected' : '' ?>>Entregado</option>
                                <option value="Cancelado" <?= ($pedido['estado_pedido'] == 'Cancelado') ? 'selected' : '' ?>>Cancelado</option>
                            </select>
                        </form>
                    </td>
                    <td><?= htmlspecialchars($pedido['nombre_metodo_pago']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

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
    <script src="../public/assets/js/core.min.js"></script>
    <script src="../public/assets/js/scriptIndex.js"></script>
    <!-- coded by Himic-->


    <script>
// Manejo del cambio de estado con confirmación
document.querySelectorAll('.cambiarEstado').forEach(select => {
    select.addEventListener('change', function() {
        if (this.value === 'Cancelado') {
            if (!confirm('¿Estás seguro de cancelar este pedido?')) {
                this.value = this.dataset.prevValue;
                return;
            }
        }
        this.closest('form').submit();
    });
    
    // Guardar valor inicial para posible restauración
    select.dataset.prevValue = select.value;
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
