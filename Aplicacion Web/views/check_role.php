<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: auth/LoginSignUp.php");
    exit();
}

// Definir los permisos para cada rol (id_rol => [páginas permitidas])
$permisos = [
    1 => ['*'], // Administrador tiene acceso a todo
    2 => ['historial.php', 'index.php'], // Cajero
    3 => ['pedido.php', 'menu.php', 'index.php'], // Mesero
    4 => ['historial.php', 'stock.php', 'index.php', 'registroProductos.php'] // Cocinero
];

// Obtener la página actual
$pagina_actual = basename($_SERVER['PHP_SELF']);

// Verificar si el usuario tiene permiso
$rol_usuario = $_SESSION['rol_id'];
$tiene_acceso = false;

if (in_array('*', $permisos[$rol_usuario])) {
    $tiene_acceso = true; // Administrador tiene acceso a todo
} else {
    $tiene_acceso = in_array($pagina_actual, $permisos[$rol_usuario]);
}

if (!$tiene_acceso) {
    header("Location: auth/interfazpaneles.php?error=acceso_denegado");
    exit();
}
?>