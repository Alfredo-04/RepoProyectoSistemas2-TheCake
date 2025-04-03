<?php
require_once '../connection.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['tableId']) || !isset($data['status'])) {
    die(json_encode(['success' => false, 'error' => 'Datos incompletos']));
}

$stmt = $conn->prepare("UPDATE mesas1 SET estado = ? WHERE id = ?");
$stmt->bind_param("si", $data['status'], $data['tableId']);

$response = [];
if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['success'] = false;
    $response['error'] = $conn->error;
}

$stmt->close();
$conn->close();
echo json_encode($response);
?>