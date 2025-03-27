<?php
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idPedido = $_POST['id_pedido'];
    $estadoPedido = $_POST['estado_pedido'];

    // Actualizar el estado del pedido
    $sql = "UPDATE pedidos SET estado_pedido = ? WHERE id_pedido = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $estadoPedido, $idPedido);

    if ($stmt->execute()) {
        header("Location: historial.php"); // Redirigir de vuelta al historial
        exit;
    } else {
        echo "Error al actualizar el estado del pedido: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>