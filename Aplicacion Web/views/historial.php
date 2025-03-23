<?php
require_once '../connection.php';

$idCliente = 1; // Aquí deberías obtener el ID del cliente desde la sesión

// Filtrar por estado si se envía el formulario
$estadoFiltro = isset($_GET['estado']) ? $_GET['estado'] : '';

// Consulta SQL con filtro dinámico
$sql = "SELECT p.id_pedido, p.fecha_pedido, p.total, p.estado_pedido, m.nombre_metodo_pago 
        FROM pedidos p
        JOIN metodos_pago m ON p.metodo_pago_id = m.id_metodo_pago
        WHERE p.id_cliente = ?";

if (!empty($estadoFiltro)) {
    $sql .= " AND p.estado_pedido = ?";
}

$sql .= " ORDER BY p.fecha_pedido DESC";

$stmt = $conn->prepare($sql);
if (!empty($estadoFiltro)) {
    $stmt->bind_param("is", $idCliente, $estadoFiltro);
} else {
    $stmt->bind_param("i", $idCliente);
}

$stmt->execute();
$result = $stmt->get_result();
$pedidos = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Pedidos</title>
    <link rel="stylesheet" href="../public/assets/css/styles.css">
    <link rel="stylesheet" href="../public/assets/css/stylesIndex.css">
    <link rel="stylesheet" href="../public/assets/css/styleFooter.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">
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

    <div class="container mt-4">
        <h2>Historial de Pedidos</h2>

        <!-- Formulario de Búsqueda -->
        <form method="GET" class="mb-3 d-flex">
            <select name="estado" class="form-select me-2">
                <option value="">Todos</option>
                <option value="Pendiente" <?= ($estadoFiltro == 'Pendiente') ? 'selected' : '' ?>>Pendiente</option>
                <option value="Completado" <?= ($estadoFiltro == 'Completado') ? 'selected' : '' ?>>Completado</option>
                <option value="Cancelado" <?= ($estadoFiltro == 'Cancelado') ? 'selected' : '' ?>>Cancelado</option>
            </select>
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
            <a href="historial_pedidos.php" class="btn btn-secondary ms-2"><i class="fas fa-times"></i> Limpiar</a>
        </form>

        <!-- Tabla de Pedidos -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Pedido</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Método de Pago</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                        <td><?= $pedido['id_pedido']; ?></td>
                        <td><?= $pedido['fecha_pedido']; ?></td>
                        <td>Bs. <?= number_format($pedido['total'], 2); ?></td>
                        <td><?= $pedido['estado_pedido']; ?></td>
                        <td><?= $pedido['nombre_metodo_pago']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Botón de PDF -->
        <a href="generar_pdf.php" class="btn btn-danger"><i class="fas fa-file-pdf"></i> Descargar PDF</a>
    </div>

    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h3>CONTACTO</h3>
                <ul>
                    <li><i class="fas fa-map-marker-alt"></i> Gabriel Rene Moreno, La Paz, Bolivia</li>
                    <li><i class="fas fa-phone"></i> +591 75424853</li>
                    <li><i class="fas fa-envelope"></i> marce_laime@hotmail.com</li>
                    <li><i class="fas fa-globe"></i> <a href="http://www.thecake.com" target="_blank">www.thecake.com</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>THE CAKE</h3>
                <p><strong>Horario de atención:</strong></p>
                <p>Lunes a domingo: 8:00 a.m. - 9:00 p.m.</p>
            </div>

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
