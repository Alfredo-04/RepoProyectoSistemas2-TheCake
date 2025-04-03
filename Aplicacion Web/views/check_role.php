<?php
session_start();

// Páginas públicas que no requieren autenticación
$paginas_publicas = [
    'index.php', 
    'menu.php', 
    'sucursales.php', 
    'contacts.php',
    'loginsignup.php',
    'login_process.php',
    'signup_process.php'
];

// Obtener la página actual
$pagina_actual = basename($_SERVER['PHP_SELF']);

// Permitir acceso a páginas públicas sin verificar sesión
if (in_array(strtolower($pagina_actual), array_map('strtolower', $paginas_publicas))) {
    return;
}

// Verificar si el usuario está logueado (para páginas privadas)
if (!isset($_SESSION['id_usuario'])) {
    header("Location: auth/LoginSignUp.php");
    exit();
}

// Definir permisos por rol
$permisos = [
    1 => ['*'], // Administrador
    2 => ['historial.php', 'index.php'], // Cajero
    3 => ['pedido.php', 'menu.php', 'index.php', 'gestion_mesas.php'], // Mesero
    4 => ['historial.php', 'stock.php', 'index.php', 'registroProductos.php'], // Cocinero
    5 => ['pedido.php', 'index.php'] // Cliente
];

// Verificar permisos
$rol_usuario = $_SESSION['rol_id'];
$tiene_acceso = false;

// Bloquear interfazpaneles.php para clientes
if (strtolower($pagina_actual) == 'interfazpaneles.php' && $rol_usuario == 5) {
    header("Location: pedido.php?error=acceso_restringido");
    exit();
}

if (in_array('*', $permisos[$rol_usuario])) {
    $tiene_acceso = true;
} else {
    $tiene_acceso = in_array(strtolower($pagina_actual), array_map('strtolower', $permisos[$rol_usuario]));
}

if (!$tiene_acceso) {
    if ($rol_usuario == 5) {
        header("Location: pedido.php?error=acceso_restringido");
    } else {
        header("Location: auth/interfazpaneles.php?error=acceso_denegado");
    }
    exit();
}
?>