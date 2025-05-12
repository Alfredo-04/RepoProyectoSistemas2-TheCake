<?php
include '../connection.php';
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $numeroDeMesa = $_POST['numeroDeMesa'];
    $capacidad = $_POST['capacidad'];
    $estado = $_POST['estado'];
    
    // Verificar si la mesa ya existe
    $check_sql = "SELECT * FROM mesas1 WHERE numeroDeMesa = '$numeroDeMesa'";
    $check_result = $conn->query($check_sql);
    
    if ($check_result->num_rows > 0) {
        header("Location: agregar_mesa.php?error=exists");
        exit();
    }
    
    $sql = "INSERT INTO mesas1 (numeroDeMesa, capacidad, estado) 
            VALUES ('$numeroDeMesa', $capacidad, '$estado')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: gestion_mesas.php?success=add");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>