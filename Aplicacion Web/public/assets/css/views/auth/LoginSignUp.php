<?php
session_start(); // Iniciar la sesión

// Verificar si el usuario ya está autenticado
if (isset($_SESSION['id_usuario'])) {
    header("Location: interfazpaneles.php"); // Redirigir a interfazpaneles.php
    exit;
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Registro - The Cake</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="../../public/assets/css/stylesLS.css">
    <!-- En el head de tu HTML -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

</head>
<body>


<!-- Aquí iría el código HTML del formulario de login y registro -->

    <div class="container" id="container">
        <!-- Formulario de Registro -->
        <div class="form-container register-container">
            <form id="signupForm" action="signup_process.php" method="POST" novalidate>
                <h1>Regístrate</h1>
                <input type="text" id="signupName" name="signupName" placeholder="Nombre" required>
                <span class="error-message" id="signupNameError"></span>
                <input type="text" id="signupLastName1" name="signupLastName1" placeholder="Apellido Paterno" required>
                <span class="error-message" id="signupLastName1Error"></span>
                <input type="text" id="signupLastName2" name="signupLastName2" placeholder="Apellido Materno" required>
                <span class="error-message" id="signupLastName2Error"></span>
                <select id="signupRole" name="signupRole" required>
                    <option value="" disabled selected>Selecciona tu rol</option>
                    <?php
                        include '../../connection.php'; // Incluir la conexión a la base de datos

                        // Obtener roles desde la base de datos
                        $sql = "SELECT * FROM Roles";
                        $result = $conn->query($sql);

                        // Verificar si hay roles
                        if ($result->num_rows > 0) {
                            // Mostrar los roles en el select
                            while($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['id_rol'] . "'>" . $row['nombre_rol'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No hay roles disponibles</option>";
                        }

                        $conn->close(); // Cerrar la conexión
                    ?>
                </select>
                <span class="error-message" id="signupRoleError"></span>
                <input type="email" id="signupEmail" name="signupEmail" placeholder="Email" required>
                <span class="error-message" id="signupEmailError"></span>
                <input type="password" id="signupPassword" name="signupPassword" placeholder="Contraseña" required>
                <span class="error-message" id="signupPasswordError"></span>
                <input type="password" id="signupConfirmPassword" name="signupConfirmPassword" placeholder="Confirmar Contraseña" required>
                <span class="error-message" id="signupConfirmPasswordError"></span>
                <button type="submit">Registrarse</button>
            </form>
        </div>

        <!-- Formulario de Login -->
        <div class="form-container login-container">
            <form id="loginForm" action="login_process.php" method="POST" novalidate>
                <h1>Inicia Sesión</h1>
                <input type="email" id="loginEmail" name="loginEmail" placeholder="Email" required>
                <span class="error-message" id="loginEmailError"></span>
                <input type="password" id="loginPassword" name="loginPassword" placeholder="Contraseña" required>
                <span class="error-message" id="loginPasswordError"></span>
                <button type="submit">Iniciar Sesión</button>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <img src="../../public/assets/img/Logo%20the%20cake.jpg" alt="Logo The Cake" class="logo">
                    <h1 class="title">¿Ya tienes una cuenta?</h1>
                    <p>Inicia sesión aquí.</p>
                    <button class="ghost" id="loginButton">Iniciar Sesión</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <img src="../../public/assets/img/Logo%20the%20cake.jpg" alt="Logo The Cake" class="logo">
                    <h1 class="title">¡Únete a nosotros!</h1>
                    <p>Regístrate para comenzar tu viaje con The Cake.</p>
                    <button class="ghost" id="registerButton">Registrarse</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS y dependencias -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <!-- Script personalizado -->
    <script src="../../public/assets/js/scriptLS.js"></script>
    <!-- Antes de cerrar el body -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>