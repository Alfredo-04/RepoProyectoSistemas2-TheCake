<?php
session_start();
include '../connection.php'; // Incluir la conexión a la base de datos

// Verificar si se ha enviado el formulario de login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $email = $_POST['loginEmail'];
    $password = $_POST['loginPassword'];

    // Preparar la consulta para verificar el email y la contraseña
    $sql = "SELECT * FROM Usuarios WHERE correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Verificar si el usuario existe
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verificar la contraseña
        if (password_verify($password, $user['contraseña'])) {
            // Guardar la información del usuario en la sesión
            $_SESSION['id_usuario'] = $user['id_usuario'];
            $_SESSION['nombre'] = $user['nombre'] . ' ' . $user['apePat'] . ' ' . $user['apeMat'];
            $_SESSION['rol_id'] = $user['rol_id'];  // Cambiado a 'rol_id' para coincidir con pruebaLogin.php
            
            // Devolver éxito en formato JSON
            echo json_encode(["success" => true]);
            exit();
        } else {
            // Contraseña incorrecta
            echo json_encode(["error" => "Contraseña incorrecta."]);
            exit();
        }
    } else {
        // Usuario no encontrado
        echo json_encode(["error" => "El email no está registrado."]);
        exit();
    }

    $conn->close();
}
?>