<?php
require_once '../connection.php';
require_once __DIR__ . '/../../vendor/autoload.php';

// Obtener parámetros de la URL
$estadoFiltro = isset($_GET['estado']) ? $_GET['estado'] : '';
$fechaInicioFiltro = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : '';
$fechaFinFiltro = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : '';

// ID del cliente (debería obtenerse de la sesión)
$idCliente = 1;

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

// Crear el PDF
$pdf = new FPDF();
$pdf->AddPage();

// ** Logo y Título **

$pdf->Image('../public/assets/images/logoTheCake.png', 10, 10, 30); // Ajusta la posición y el tamaño del logo
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 10, 'Historial de Pedidos', 0, 1, 'C');

// Título dinámico
$title = 'Reporte de Pedidos';

if (!empty($estadoFiltro) && !empty($fechaInicioFiltro) && !empty($fechaFinFiltro)) {
    $title = 'Reporte por Estado y Fechas';
} elseif (!empty($estadoFiltro)) {
    $title = 'Reporte por Estado';
} elseif (!empty($fechaInicioFiltro) && !empty($fechaFinFiltro)) {
    $title = 'Reporte por Fechas';
}

$pdf->SetFont('Arial', 'B', 18);
$pdf->SetFillColor(249, 177, 166); // f9b1a6
$pdf->Cell(190, 10, $title, 0, 1, 'C', true);

// Espacio entre el título y la tabla
$pdf->Ln(10);

// ** Estilo de Tabla **

$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(244, 202, 199); // f4cac7
$pdf->Cell(30, 10, 'ID Pedido', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Fecha', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Total (Bs.)', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Estado', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Método de Pago', 1, 1, 'C', true);

// ** Datos de la Tabla **
$pdf->SetFont('Arial', '', 12);
foreach ($pedidos as $row) {
    $fechaPedido = date("d-m-Y", strtotime($row['fecha_pedido'])); // Formato de fecha
    $horaPedido = date("H:i", strtotime($row['fecha_pedido'])); // Formato de hora

    $pdf->Cell(30, 10, $row['id_pedido'], 1, 0, 'C');
    $pdf->Cell(40, 10, $fechaPedido, 1, 0, 'C');
    $pdf->Cell(30, 10, number_format($row['total'], 2), 1, 0, 'C');
    $pdf->Cell(40, 10, $row['estado_pedido'], 1, 0, 'C');
    $pdf->Cell(50, 10, $row['nombre_metodo_pago'], 1, 1, 'C');
}

// ** Pie de página con datos de contacto **
$pdf->Ln(10);
$pdf->SetFont('Arial', 'I', 10);
$pdf->SetTextColor(0, 0, 0); // Color negro
$pdf->Cell(0, 10, 'Cafeteria "The Cake" | Contacto: 123-456-789 | Email: info@cafecito.com', 0, 1, 'C');

// ** Forzar la descarga del PDF **
$pdf->Output('D', 'Historial_de_Pedidos.pdf');

// ** Script de recarga de la página **
echo '<script type="text/javascript">
    setTimeout(function() {
        window.location.href = "historial.php";
    }, 1000); // Redirecciona después de 1 segundo
</script>';
?>
