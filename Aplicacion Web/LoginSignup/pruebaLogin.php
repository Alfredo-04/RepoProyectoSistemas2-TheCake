<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario'])) {
    // Si no está autenticado, redirigir al formulario de login
    header("Location: LoginSignUp.php");
    exit();
}

// Obtener el nombre y rol del usuario desde la sesión
$nombreUsuario = $_SESSION['nombre'];
$rolUsuario = $_SESSION['rol_id'];  // Cambiado a 'rol_id'

// Obtener el nombre del rol desde la base de datos
include '../connection.php';
$sql = "SELECT nombre_rol FROM Roles WHERE id_rol = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $rolUsuario);
$stmt->execute();
$result = $stmt->get_result();
$rol = $result->fetch_assoc()['nombre_rol'];
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de prueba - The Cake</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container text-center mt-5">
        <h1>¡Bienvenido, <?php echo $nombreUsuario; ?>!</h1>
        <h2 style="font-size: 2rem;">Tu rol es: <?php echo $rol; ?></h2>
        <form action="logout.php" method="POST">
            <button type="submit" class="btn btn-danger mt-3">Cerrar sesión</button>
        </form>
    </div>

    <!-- Bootstrap JS y dependencias -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>