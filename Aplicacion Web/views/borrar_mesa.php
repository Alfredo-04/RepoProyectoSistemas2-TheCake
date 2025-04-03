<?php
include '../connection.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Verificar si la mesa existe
    $check_sql = "SELECT * FROM mesas1 WHERE id = $id";
    $check_result = $conn->query($check_sql);
    
    if ($check_result->num_rows == 0) {
        header("Location: gestion_mesas.php?error=notfound");
        exit();
    }
    
    $sql = "DELETE FROM mesas1 WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: gestion_mesas.php?success=delete");
    } else {
        echo "Error al borrar la mesa: " . $conn->error;
    }
}

$conn->close();
?>