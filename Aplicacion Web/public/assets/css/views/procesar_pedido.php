<?php
// Habilitar reporte de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Establecer el tipo de contenido como JSON
header('Content-Type: application/json');

require_once '../connection.php';

// Verificar la conexión a la base de datos
if (!$conn) {
    echo json_encode(["success" => false, "message" => "Error de conexión a la base de datos: " . mysqli_connect_error()]);
    exit;
}

// Obtener los datos del carrito y el método de pago
$data = json_decode(file_get_contents('php://input'), true);

// Verificar si los datos llegan correctamente
if (empty($data)) {
    echo json_encode(["success" => false, "message" => "No se recibieron datos del carrito."]);
    exit;
}

// Validar los datos recibidos
if (!isset($data['cart']) || !isset($data['metodoPagoId']) || !isset($data['total'])) {
    echo json_encode(["success" => false, "message" => "Datos incompletos."]);
    exit;
}

// Verificar el stock de cada producto
foreach ($data['cart'] as $item) {
    $idProducto = $item['id'];
    $cantidad = $item['quantity'];

    // Consultar el stock disponible en la tabla `inventario_productos`
    $sqlStock = "SELECT cantidad_disponible FROM inventario_productos WHERE id_producto = ?";
    $stmtStock = $conn->prepare($sqlStock);
    $stmtStock->bind_param("i", $idProducto);
    $stmtStock->execute();
    $resultStock = $stmtStock->get_result();
    $rowStock = $resultStock->fetch_assoc();

    if (!$rowStock || $rowStock['cantidad_disponible'] < $cantidad) {
        echo json_encode(["success" => false, "message" => "No hay suficiente stock para el producto: " . $item['name']]);
        exit;
    }
}

// Insertar el pedido en la tabla `pedidos`
$idCliente = 1; // ID del cliente por defecto
$idEmpleado = 2; // ID del empleado por defecto
$metodoPagoId = $data['metodoPagoId'];
$total = $data['total'];

$sqlPedido = "INSERT INTO pedidos (id_cliente, id_empleado, metodo_pago_id, estado_pedido, total) 
              VALUES (?, ?, ?, 'Pendiente', ?)";
$stmtPedido = $conn->prepare($sqlPedido);

if (!$stmtPedido) {
    echo json_encode(["success" => false, "message" => "Error al preparar la consulta del pedido: " . $conn->error]);
    exit;
}

$stmtPedido->bind_param("iiid", $idCliente, $idEmpleado, $metodoPagoId, $total);

if (!$stmtPedido->execute()) {
    echo json_encode(["success" => false, "message" => "Error al insertar el pedido: " . $stmtPedido->error]);
    exit;
}

$idPedido = $stmtPedido->insert_id;

// Insertar los detalles del pedido en la tabla `detalle_pedido`
foreach ($data['cart'] as $item) {
    $idProducto = $item['id'];
    $cantidad = $item['quantity'];
    $precioUnitario = $item['price'];

    $sqlDetalle = "INSERT INTO detalle_pedido (id_pedido, id_producto, cantidad, precio_unitario) 
                   VALUES (?, ?, ?, ?)";
    $stmtDetalle = $conn->prepare($sqlDetalle);
    $stmtDetalle->bind_param("iiid", $idPedido, $idProducto, $cantidad, $precioUnitario);
    $stmtDetalle->execute();

    // Reducir el stock del producto en la tabla `inventario_productos`
    $sqlUpdateStock = "UPDATE inventario_productos SET cantidad_disponible = cantidad_disponible - ? WHERE id_producto = ?";
    $stmtUpdateStock = $conn->prepare($sqlUpdateStock);
    $stmtUpdateStock->bind_param("ii", $cantidad, $idProducto);
    $stmtUpdateStock->execute();
}

// Cerrar la conexión
$stmtPedido->close();
$conn->close();

// Respuesta al frontend
echo json_encode(["success" => true, "message" => "Pedido procesado correctamente."]);
?>