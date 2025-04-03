<?php
require_once '../connection.php';
require_once __DIR__ . '/../vendor/autoload.php';

//Descargar Composer, despues quitar del php.ini el ; de extension=gd y extension=zip, luego php -m en la consola, composer require setasign/fpdf

$idCliente = 1; // ID del cliente desde la sesión
$sql = "SELECT p.id_pedido, p.fecha_pedido, p.total, p.estado_pedido, m.nombre_metodo_pago 
        FROM pedidos p
        JOIN metodos_pago m ON p.metodo_pago_id = m.id_metodo_pago
        WHERE p.id_cliente = ?
        ORDER BY p.fecha_pedido DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idCliente);
$stmt->execute();
$result = $stmt->get_result();

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 10, 'Historial de Pedidos', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);

while ($row = $result->fetch_assoc()) {
    $pdf->Cell(190, 10, "Pedido #{$row['id_pedido']} - {$row['fecha_pedido']} - Bs. {$row['total']} - {$row['estado_pedido']} - {$row['nombre_metodo_pago']}", 0, 1);
}

$pdf->Output();
?>
