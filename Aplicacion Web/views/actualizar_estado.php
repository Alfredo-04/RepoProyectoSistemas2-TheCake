<?php
require_once '../connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idPedido = $_POST['id_pedido'] ?? null;
    $estadoPedido = $_POST['estado_pedido'] ?? null;
    
    // Validación básica
    if ($idPedido && $estadoPedido) {
        $sql = "UPDATE pedidos SET estado_pedido = ? WHERE id_pedido = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("si", $estadoPedido, $idPedido);
            
            if ($stmt->execute()) {
                $_SESSION['mensaje'] = "Estado actualizado correctamente";
            } else {
                $_SESSION['error'] = "Error al actualizar: " . $stmt->error;
            }
            
            $stmt->close();
        } else {
            $_SESSION['error'] = "Error en la consulta SQL";
        }
    } else {
        $_SESSION['error'] = "Datos incompletos";
    }
    
    $conn->close();
}

// Redireccionar de vuelta
header("Location: historial.php");
exit;
?>