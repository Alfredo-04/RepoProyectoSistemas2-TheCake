<?php
require_once '../connection.php';

header('Content-Type: application/json');

// Obtener los datos del pedido
$data = json_decode(file_get_contents('php://input'), true);

// Validar los datos recibidos
if (!isset($data['cart']) || !is_array($data['cart']) || 
    !isset($data['metodoPagoId']) || 
    !isset($data['total']) || 
    !isset($data['consumptionType'])) {
    echo json_encode(['success' => false, 'message' => 'Datos del pedido incompletos']);
    exit;
}

// Iniciar transacción
$conn->begin_transaction();

try {
    // 1. Insertar el pedido en la tabla pedidos
    $sqlPedido = "INSERT INTO pedidos (
                    fecha_pedido, 
                    estado_pedido, 
                    total, 
                    metodo_pago_id, 
                    tipo_consumo,
                    id_mesa
                ) VALUES (NOW(), 'Pendiente', ?, ?, ?, ?)";
    
    $stmtPedido = $conn->prepare($sqlPedido);
    
    // Determinar el ID de la mesa (null si es para llevar)
    $mesaId = ($data['consumptionType'] === 'local' && isset($data['tableId'])) ? $data['tableId'] : null;
    
    $stmtPedido->bind_param(
        "ddsi",
        $data['total'],
        $data['metodoPagoId'],
        $data['consumptionType'],
        $mesaId
    );
    
    if (!$stmtPedido->execute()) {
        throw new Exception("Error al crear el pedido: " . $stmtPedido->error);
    }
    
    $pedidoId = $stmtPedido->insert_id;
    $stmtPedido->close();

    // 2. Insertar los detalles del pedido
    $sqlDetalle = "INSERT INTO detalle_pedido (
                    id_pedido, 
                    id_producto, 
                    cantidad, 
                    precio_unitario
                ) VALUES (?, ?, ?, ?)";
    
    $stmtDetalle = $conn->prepare($sqlDetalle);
    
    foreach ($data['cart'] as $item) {
        $stmtDetalle->bind_param(
            "iiid",
            $pedidoId,
            $item['id'],
            $item['quantity'],
            $item['price']
        );
        
        if (!$stmtDetalle->execute()) {
            throw new Exception("Error al agregar productos al pedido: " . $stmtDetalle->error);
        }
        
        // 3. Actualizar el inventario (reducir stock)
        $sqlUpdateStock = "UPDATE inventario_productos 
                          SET cantidad_disponible = cantidad_disponible - ? 
                          WHERE id_producto = ?";
        
        $stmtStock = $conn->prepare($sqlUpdateStock);
        $stmtStock->bind_param("ii", $item['quantity'], $item['id']);
        
        if (!$stmtStock->execute()) {
            throw new Exception("Error al actualizar el inventario: " . $stmtStock->error);
        }
        
        $stmtStock->close();
    }
    
    $stmtDetalle->close();

    // 4. Si es consumo en local, marcar la mesa como ocupada
    if ($data['consumptionType'] === 'local' && isset($data['tableId'])) {
        $sqlMesa = "UPDATE mesas1 SET estado = 'ocupada' WHERE id = ?";
        $stmtMesa = $conn->prepare($sqlMesa);
        $stmtMesa->bind_param("i", $data['tableId']);
        
        if (!$stmtMesa->execute()) {
            throw new Exception("Error al actualizar el estado de la mesa: " . $stmtMesa->error);
        }
        
        $stmtMesa->close();
    }

    // 5. Crear notificación para cocina
    $sqlNotificacion = "INSERT INTO notificaciones (
                        id_pedido, 
                        mensaje, 
                        estado
                    ) VALUES (?, ?, 'No leído')";
    
    $stmtNotificacion = $conn->prepare($sqlNotificacion);
    $mensaje = "Nuevo pedido #$pedidoId - " . ($data['consumptionType'] === 'local' ? 'Mesa ' . $data['tableId'] : 'Para llevar');
    $stmtNotificacion->bind_param("is", $pedidoId, $mensaje);
    
    if (!$stmtNotificacion->execute()) {
        throw new Exception("Error al crear notificación: " . $stmtNotificacion->error);
    }
    
    $stmtNotificacion->close();

    // 6. Registrar en auditoría (simplificado)
    $sqlAuditoria = "INSERT INTO auditoria (
                        tabla_afectada, 
                        id_registro, 
                        accion, 
                        usuario, 
                        detalle
                    ) VALUES ('pedidos', ?, 'INSERT', 1, ?)";
    
    $stmtAuditoria = $conn->prepare($sqlAuditoria);
    $detalle = "Pedido creado por sistema. Total: " . $data['total'];
    $stmtAuditoria->bind_param("is", $pedidoId, $detalle);
    
    if (!$stmtAuditoria->execute()) {
        throw new Exception("Error al registrar auditoría: " . $stmtAuditoria->error);
    }
    
    $stmtAuditoria->close();

    // Confirmar la transacción
    $conn->commit();

    // Respuesta exitosa
    echo json_encode([
        'success' => true,
        'message' => 'Pedido procesado con éxito',
        'pedidoId' => $pedidoId,
        'notificacion' => $mensaje
    ]);

} catch (Exception $e) {
    // Revertir la transacción en caso de error
    $conn->rollback();
    
    echo json_encode([
        'success' => false,
        'message' => 'Error al procesar el pedido: ' . $e->getMessage()
    ]);
}
?>