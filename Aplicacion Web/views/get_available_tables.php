<?php
require_once '../connection.php';

header('Content-Type: application/json');

// Consultar mesas disponibles
$sql = "SELECT id, numeroDeMesa, capacidad FROM mesas1 WHERE estado = 'desocupada'";
$result = $conn->query($sql);

$mesas = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $mesas[] = $row;
    }
}

$conn->close();
echo json_encode($mesas);
?>