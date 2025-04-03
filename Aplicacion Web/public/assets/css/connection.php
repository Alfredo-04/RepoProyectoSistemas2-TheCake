<?php
$servername = "localhost";  // O tu servidor de base de datos
$username = "root";         // Tu usuario de base de datos
$password = "";             // Tu contraseña de base de datos
$dbname = "theCakeBD";      // El nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>