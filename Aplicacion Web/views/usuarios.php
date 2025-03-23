<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sucursales - The Cake</title>
    <link rel="stylesheet" href="../public/assets/css/stylesSucursal.css">
    <link rel="stylesheet" href="../public/assets/css/styles.css">
    <link rel="stylesheet" href="../public/assets/css/stylesIndex.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="./../public/assets/css/styleFooter.css">
    <style>
        /* Estilos personalizados para la tabla */
        .user-table {
            margin: 40px auto;
            width: 90%;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .user-table th, .user-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .user-table th {
            background-color: #f4cac7; /* Color secundario */
            color: #000000; /* Texto negro */
            font-weight: bold;
        }

        .user-table tr:hover {
            background-color: #f9b1a6; /* Color primario */
        }

        .user-table tr:nth-child(even) {
            background-color: #f8f9fa; /* Fondo gris claro */
        }

        .user-table tr:nth-child(odd) {
            background-color: #ffffff; /* Fondo blanco */
        }

        .user-table img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body>

    <!-- Menú de navegación -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="../public/assets/img/logo.png" alt="Logo" class="logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="auth/interfazpaneles.php">PANELES</a></li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- Tabla de Usuarios Registrados -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Usuarios Registrados</h2>
        <table class="user-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Descripción Rol</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Incluir la conexión a la base de datos
                include '../connection.php';

                // Consulta para obtener los usuarios
                $sql = "SELECT u.nombre, u.apePat, u.apeMat, u.correo, r.nombre_rol, r.descripcion
                        FROM Usuarios u 
                        INNER JOIN Roles r ON u.rol_id = r.id_rol";
                $result = $conn->query($sql);

                // Mostrar los datos en la tabla
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['nombre']}</td>
                                <td>{$row['apePat']} {$row['apeMat']}</td>
                                <td>{$row['correo']}</td>
                                <td>{$row['nombre_rol']}</td>
                                <td>{$row['descripcion']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>No hay usuarios registrados.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <footer>
        <div class="footer-container">
            <!-- Sección de Contacto -->
            <div class="footer-section">
                <h3>CONTACTO</h3>
                <ul>
                    <li><i class="fas fa-map-marker-alt"></i> Gabriel Rene Moreno, La Paz, Bolivia</li>
                    <li><i class="fas fa-phone"></i> +591 75424853</li>
                    <li><i class="fas fa-envelope"></i> marce_laime@hotmail.com</li>
                    <li><i class="fas fa-globe"></i> <a href="http://www.thecake.com" target="_blank">www.thecake.com</a></li>
                </ul>
            </div>
    
            <!-- Sección de Horario -->
            <div class="footer-section">
                <h3>THE CAKE</h3>
                <p><strong>Horario de atención:</strong></p>
                <p>Lunes a domingo: 8:00 a.m. - 9:00 p.m.</p>
            </div>
    
            <!-- Sección de Redes Sociales -->
            <div class="footer-section">
                <h3>SÍGUENOS</h3>
                <ul class="social-links">
                    <li><a href="https://www.instagram.com/thecake.bolivia" target="_blank"><i class="fab fa-instagram"></i> Instagram</a></li>
                    <li><a href="https://www.facebook.com/share/12G4iwabKJT/" target="_blank"><i class="fab fa-facebook"></i> Facebook</a></li>
                    <li><a href="https://api.whatsapp.com/send/?phone=%2B59175427853&text&type=phone_number&app_absent=0" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>