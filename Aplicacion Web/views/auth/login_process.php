<?php
session_start();
include '../../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['loginEmail'];
    $password = $_POST['loginPassword'];

    $sql = "SELECT * FROM Usuarios WHERE correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['contraseña'])) {
            $_SESSION['id_usuario'] = $user['id_usuario'];
            $_SESSION['nombre'] = $user['nombre'] . ' ' . $user['apePat'] . ' ' . $user['apeMat'];
            $_SESSION['rol_id'] = $user['rol_id'];
            
            // Redirección diferente para clientes
            if ($user['rol_id'] == 5) { // Si es cliente
                echo json_encode(["success" => true, "redirect" => "../pedido.php"]); // Cambia a index.php si prefieres
            } else {
                echo json_encode(["success" => true, "redirect" => "interfazpaneles.php"]);
            }
            exit();
        } else {
            echo json_encode(["error" => "Contraseña incorrecta."]);
            exit();
        }
    } else {
        echo json_encode(["error" => "El email no está registrado."]);
        exit();
    }

    $conn->close();
}
?>