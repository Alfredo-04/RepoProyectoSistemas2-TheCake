<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrusel Bootstrap</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/assets/css/styles.css">
    <link rel="stylesheet" href="../public/assets/css/stylesIndex.css">
    <link rel="stylesheet" href="./../public/assets/css/styleFooter.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
</head>
<body>
    <!-- Menú de navegación -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="../public/assets/img/logo.png" alt="Logo" class="logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">THE CAKE</a></li>
                    <li class="nav-item"><a class="nav-link" href="menu.php">MENU</a></li>
                    <li class="nav-item"><a class="nav-link" href="Sucursal.html">SUCURSALES</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">CONTACTANOS</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Carrusel -->
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="../public/assets/img/1.png" class="d-block w-100" alt="Imagen 1">
            </div>
            <div class="carousel-item">
                <img src="../public/assets/img/2.png" class="d-block w-100" alt="Imagen 2">
            </div>
            <div class="carousel-item">
                <img src="../public/assets/img/3.png" class="d-block w-100" alt="Imagen 3">
            </div>
            <div class="carousel-item">
                <img src="../public/assets/img/4.png" class="d-block w-100" alt="Imagen 4">
            </div>
            <div class="carousel-item">
                <img src="../public/assets/img/5.png" class="d-block w-100" alt="Imagen 5">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>

    <!-- Sección de Ubicación -->
 <!-- Sección de Ubicación -->
 <section id="ubicacion" class="container my-5">

  <!-- Objetivo -->
  <div class="objectives-container text-center my-5">
        <h3>THE CAKE</h3>
        <ul class="list-unstyled">
        <p class="text-justify">The Cake es un rincón dulce y acogedor ubicado en el corazón de La Paz, Bolivia, donde los amantes del café y los postres pueden disfrutar de momentos inolvidables. Con una combinación perfecta de elegancia y calidez, esta cafetería se ha convertido en un destino favorito para locales y turistas que buscan deleitarse con sabores únicos y una experiencia gastronómica excepcional.</p>
        </ul>
    </div>

    <div class="info-container d-flex justify-content-between my-5">
        <div class="info-box">
            <h3 class="text-center">Objetivo</h3>
            <li><i class="bi bi-check-circle"></i> Mantener la más alta calidad en productos y servicio.</li>
            <li><i class="bi bi-check-circle"></i> Innovar en sabores y presentaciones.</li>
            <li><i class="bi bi-check-circle"></i> Expandir nuestra presencia en Bolivia.</li>
        </div>

        <div class="info-box">
            <h3 class="text-center">Misión</h3>
            <p class="text-justify">Ofrecer experiencias gastronómicas únicas a través de pasteles, postres y café de alta calidad, en un ambiente acogedor que celebra los momentos especiales.</p>
        </div>

        <div class="info-box">
            <h3 class="text-center">Visión</h3>
            <p class="text-justify">Ser la cafetería líder en La Paz, reconocida por nuestra creatividad, excelencia y compromiso con la satisfacción del cliente.</p>
        </div>
    </div>


    <h2 class="text-center mb-4 text-light">Ubicación</h2>
    <div class="map-container d-flex justify-content-center mb-4">
        <div class="map-frame-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3824.681816561739!2d-68.08126762485396!3d-16.54215348420799!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x915f21044fa3d5ef%3A0x397f76d4267ff4c2!2sThe%20Cake!5e0!3m2!1ses!2sbo!4v1742440799728!5m2!1ses!2sbo" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>

    <!-- Descripción, Misión, Visión y Objetivos -->

</section>

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
