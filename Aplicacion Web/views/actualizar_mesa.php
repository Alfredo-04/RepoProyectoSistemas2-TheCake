<?php
include '../connection.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $numeroDeMesa = $_POST['numeroDeMesa'];
    $capacidad = $_POST['capacidad'];
    $estado = $_POST['estado'];
    
    $sql = "UPDATE mesas1 SET 
            numeroDeMesa = '$numeroDeMesa', 
            capacidad = $capacidad, 
            estado = '$estado' 
            WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: gestion_mesas.php?success=1");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>