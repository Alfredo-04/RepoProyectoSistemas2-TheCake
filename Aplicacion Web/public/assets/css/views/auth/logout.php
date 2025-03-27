<?php
session_start();
session_destroy(); // Destruir toda la sesión
header("Location: LoginSignUp.php"); // Redirigir al formulario de login
exit();
?>
