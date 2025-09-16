<?php
// Incluir la conexión a la base de datos
include '../connection.php';

header('Content-Type: application/json'); // Asegura que la respuesta sea JSON

// Si se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $nombre = mysqli_real_escape_string($conn, $_POST['signupName']);
    $apellidoPaterno = mysqli_real_escape_string($conn, $_POST['signupLastName1']);
    $apellidoMaterno = mysqli_real_escape_string($conn, $_POST['signupLastName2']);
    $email = mysqli_real_escape_string($conn, $_POST['signupEmail']);
    $password = mysqli_real_escape_string($conn, $_POST['signupPassword']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['signupConfirmPassword']);
    $rolId = mysqli_real_escape_string($conn, $_POST['signupRole']);

    // Verificar si la contraseña y confirmación coinciden
    if ($password !== $confirmPassword) {
        echo json_encode(["error" => "Las contraseñas no coinciden."]);
        exit;
    }

    // Encriptar la contraseña
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Verificar si el email ya está registrado
    $emailCheckQuery = "SELECT * FROM Usuarios WHERE correo = '$email'";
    $result = $conn->query($emailCheckQuery);

    if ($result->num_rows > 0) {
        echo json_encode(["error" => "Este email ya está registrado."]);
        exit;
    }

    // Insertar el nuevo usuario en la base de datos
    $sql = "INSERT INTO Usuarios (nombre, apePat, apeMat, correo, contraseña, rol_id) 
            VALUES ('$nombre', '$apellidoPaterno', '$apellidoMaterno', '$email', '$passwordHash', '$rolId')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => "¡Registro exitoso! Serás redirigido al login."]);
    } else {
        echo json_encode(["error" => "Error al registrar el usuario: " . $conn->error]);
    }

    $conn->close();
} else {
    echo json_encode(["error" => "Método de solicitud no válido"]);
}
?>
