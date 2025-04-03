<?php 
require_once 'check_role.php';
?>
<!DOCTYPE html>
<html class="wide wow-animation" lang="en">
  <head>
    <title>Home</title>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <link rel="icon" href="../public/assets/images/favicon.ico" type="image/x-icon">
    <!-- Stylesheets-->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:100,300,300i,400,500,600,700,900%7CRaleway:500">
    <link rel="stylesheet" href="../public/assets/css/bootstrap.css">
    <link rel="stylesheet" href="../public/assets/css/fonts.css">
    <link rel="stylesheet" href="../public/assets/css/style.css">
    <link rel="stylesheet" href="../public/assets/css/styleFooter.css">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!--[if lt IE 10]>
    <div style="background: #212121; padding: 10px 0; box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3); clear: both; text-align:center; position: relative; z-index:1;"><a href="http://windows.microsoft.com/en-US/internet-explorer/"><img src="images/ie8-panel/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a></div>
    <script src="../public/assets/js/html5shiv.min.js"></script>
    <![endif]-->
    
    <style>

<?php if (basename($_SERVER['PHP_SELF']) == 'menu.php') : ?>           
/* Estilos generales */
body {
    background: linear-gradient(135deg, #f8a29b, #ff6f61);
    color: #333;
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    text-align: center;
    overflow-x: hidden;
}

h2 {
    font-size: 3rem;
    color: #fff;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    margin: 40px 0;
    animation: fadeIn 2s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* Panel principal */
.menu-category {
    background: rgba(255, 255, 255, 0.9);
    border-radius: 20px;
    padding: 30px;
    margin: 40px auto;
    max-width: 1200px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    animation: slideIn 1s ease-in-out;
}

@keyframes slideIn {
    from { transform: translateY(50px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.menu-category h3 {
    font-size: 2rem;
    color: #ff6f61;
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.menu-grid {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 30px;
}

/* Tarjetas de productos */
.menu-item {
    background: #fff;
    padding: 20px;
    border-radius: 20px;
    text-align: center;
    width: 280px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    position: relative;
    overflow: hidden;
}

.menu-item:hover {
    transform: scale(1.1);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
}

.menu-item img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 15px;
    transition: transform 0.3s ease-in-out;
}

.menu-item:hover img {
    transform: scale(1.1);
}

.menu-item h4 {
    margin: 15px 0;
    font-size: 1.5rem;
    color: #333;
}

.menu-item p {
    font-size: 1.2rem;
    color: #ff6f61;
    font-weight: bold;
}

/* Efecto de brillo al pasar el mouse */
.menu-item::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 300%;
    height: 300%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.4), rgba(255, 255, 255, 0) 70%);
    transform: translate(-50%, -50%) scale(0);
    transition: transform 0.5s ease-in-out;
    pointer-events: none;
}

.menu-item:hover::before {
    transform: translate(-50%, -50%) scale(1);
}

.rd-navbar-nav {
display: flex;
align-items: center; /* Asegura que estén alineados verticalmente */
justify-content: space-around; /* O "space-between" según necesites */
list-style: none;
padding: 0;
margin: 0;
}
.rd-nav-item {
padding: 10px 15px; /* Asegura que todos los elementos tengan el mismo espacio */
}
.rd-nav-item a {
text-decoration: none;
color: black; /* Ajusta según tu diseño */
}


.nav-link {
    font-size: 1.1rem;
    color: #333 !important;
    transition: color 0.3s ease-in-out;
}

.nav-link:hover {
    color: #ff6f61 !important;
}

/* Animación de fondo */
body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0) 70%);
    pointer-events: none;
    animation: float 6s infinite ease-in-out;
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
}



.
/* Estilos para el ícono del carrito */
.cart-icon {
position: fixed; /* Fija el ícono en la pantalla */
top: 20px; /* Distancia desde la parte superior */
right: 20px; /* Distancia desde la derecha */
font-size: 24px; /* Tamaño del ícono */
color: #ff6f61; /* Color del ícono */
background-color: #fff; /* Fondo del ícono */
padding: 10px; /* Espaciado interno */
border-radius: 50%; /* Hace que el fondo sea circular */
box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Sombra para resaltar */
transition: transform 0.3s ease, background-color 0.3s ease; /* Animación al pasar el mouse */
z-index: 1000; /* Asegura que esté por encima de otros elementos */
}

.cart-icon:hover {
transform: scale(1.1); /* Efecto de escala al pasar el mouse */
background-color: #ffcc00; /* Cambia el color de fondo al pasar el mouse */
color: #fff; /* Cambia el color del ícono al pasar el mouse */
}

@media (max-width: 768px) {

}
/* Efectos de hover para los íconos */
.social-links a {
    display: inline-block;
    padding: 8px 12px;
    border-radius: 5px;
    background: rgba(255, 255, 255, 0.1);
    transition: background 0.3s ease, transform 0.3s ease;
}

.social-links a:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-3px);
}

/* Responsive design */
@media (max-width: 768px) {
    .footer-container {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    .footer-container {
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.footer-section ul li {
    justify-content: center;
}
}


</style>
<?php endif; ?>


    <style>
/* Estilos para el navbar y dropdown */
.navbar-brand img:hover {
        transform: rotate(10deg);
    }
    
    .nav-link:hover {
        color: #ff6f61 !important;
        transform: translateY(-2px);
    }
    
    .dropdown-item:hover {
        background-color: #f8a29b !important;
        color: white !important;
        transform: translateX(5px);
    }
    
    .dropdown-item:hover i {
        color: white !important;
    }
    


/* Estilo para el contenedor del ícono de usuario */
.dropdown-toggle {
    display: flex;
    align-items: center;
    padding: 0.5rem 1rem;
}

/* Aumentar tamaño del ícono de usuario */
.fa-user-circle.fs-3 {
    font-size: 1.75rem !important; /* Tamaño más grande */
    margin-right: 0.5rem;
    transition: all 0.3s ease;
}

/* Alinear verticalmente los elementos del navbar */
.navbar-nav {
    align-items: center;
}

/* Asegurar que el dropdown esté alineado correctamente */
.dropdown {
    display: flex;
    align-items: center;
}

/* Estilo para el menú desplegable */
.dropdown-menu {
    margin-top: 0.5rem;
}

/* Ajustar el padding del navbar para mejor alineación */
.navbar {
    padding: 0.5rem 1rem;
}

/* Estilos específicos para el header */
.rd-navbar-nav {
  display: flex;
  align-items: center;
  width: 100%;
}

.rd-nav-item.dropdown,
.rd-nav-item.ml-auto {
  margin-left: auto !important;
}

.dropdown-toggle {
  display: flex;
  align-items: center;
  padding: 0.5rem 1rem;
}

.dropdown-menu {
  position: absolute;
  right: 0;
  left: auto;
  z-index: 1000;
  margin-top: 0.5rem;
}

/* Estilos responsivos */
@media (max-width: 992px) {
  .rd-nav-item.dropdown,
  .rd-nav-item.ml-auto {
    margin-left: 0 !important;
  }
  
  .dropdown-menu {
    position: static !important;
  }
}
    </style>
  </head>
  <body>
    <div class="preloader">
      <div class="wrapper-triangle">
        <div class="pen">
          <div class="line-triangle">
            <div class="triangle"></div>
            <div class="triangle"></div>
            <div class="triangle"></div>
            <div class="triangle"></div>
            <div class="triangle"></div>
            <div class="triangle"></div>
            <div class="triangle"></div>
          </div>
          <div class="line-triangle">
            <div class="triangle"></div>
            <div class="triangle"></div>
            <div class="triangle"></div>
            <div class="triangle"></div>
            <div class="triangle"></div>
            <div class="triangle"></div>
            <div class="triangle"></div>
          </div>
          <div class="line-triangle">
            <div class="triangle"></div>
            <div class="triangle"></div>
            <div class="triangle"></div>
            <div class="triangle"></div>
            <div class="triangle"></div>
            <div class="triangle"></div>
            <div class="triangle"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="page">
<!-- Page Header-->
<header class="section page-header">
  <!-- RD Navbar-->
  <div class="rd-navbar-wrap">
    <nav class="rd-navbar rd-navbar-modern" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static" data-lg-device-layout="rd-navbar-fixed" data-xl-layout="rd-navbar-static" data-xl-device-layout="rd-navbar-static" data-xxl-layout="rd-navbar-static" data-xxl-device-layout="rd-navbar-static" data-lg-stick-up-offset="56px" data-xl-stick-up-offset="56px" data-xxl-stick-up-offset="56px" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">
      <div class="rd-navbar-inner-outer">
        <div class="rd-navbar-inner">
          <!-- RD Navbar Panel-->
          <div class="rd-navbar-panel">
            <!-- RD Navbar Toggle-->
            <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
            <!-- RD Navbar Brand-->
            <div class="rd-navbar-brand"><a class="brand" href="index.php"><img class="brand-logo-dark" src="../public/assets/images/logoTheCake.png" alt="" width="198" height="66"/></a></div>
          </div>
          <div class="rd-navbar-right rd-navbar-nav-wrap">
            <div class="rd-navbar-aside">
              <ul class="rd-navbar-contacts-2">
                <li>
                  <div class="unit unit-spacing-xs">
                    <div class="unit-left"><span class="icon mdi mdi-phone"></span></div>
                    <div class="unit-body"><a class="phone" href="tel:#">+591 75424853</a></div>
                  </div>
                </li>
                <li>
                  <div class="unit unit-spacing-xs">
                    <div class="unit-left"><span class="icon mdi mdi-map-marker"></span></div>
                    <div class="unit-body"><a class="address" href="#">Gabriel Rene Moreno, La Paz, Bolivia</a></div>
                  </div>
                </li>
              </ul>
              <ul class="list-share-2">
                <li><a class="icon mdi mdi-facebook" href="https://www.facebook.com/TheCake.bo/?locale=es_LA" target="_blank"></a></li>
                <li><a class="icon mdi mdi-instagram" href="https://www.instagram.com/thecake.bolivia/?hl=es" target="_blank"></a></li>
              </ul>
            </div>
            <div class="rd-navbar-main">
              <ul class="rd-navbar-nav">
                <li class="rd-nav-item active"><a class="rd-nav-link" href="index.php">THE CAKE</a></li>
                <li class="rd-nav-item"><a class="rd-nav-link" href="menu.php">MENU</a></li>
                <li class="rd-nav-item"><a class="rd-nav-link" href="sucursales.php">SUCURSALES</a></li>
                <li class="rd-nav-item"><a class="rd-nav-link" href="contacts.php">CONTACTANOS</a></li>
                
                
                <?php if(isset($_SESSION['id_usuario'])): 
                  // Determinar el rol del usuario
                  $rol = "";
                  $rol_id = $_SESSION['rol_id'];
                  switch($rol_id) {
                    case 1: $rol = "Administrador"; break;
                    case 2: $rol = "Cajero"; break;
                    case 3: $rol = "Mesero"; break;
                    case 4: $rol = "Cocinero"; break;
                    case 5: $rol = "Cliente"; break;
                  }
                ?>
                  <!-- Menú desplegable del usuario -->
                  <li class="rd-nav-item dropdown ml-auto">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle rd-nav-link" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false" style="color: #ff6f61;">
                      <i class="fas fa-user-circle fs-3 me-1" style="color: #ff6f61;"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser" style="background: rgba(255, 255, 255, 0.98); border-radius: 15px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15); border: none; padding: 10px 0;">
                      <li>
                        <div class="dropdown-item" style="font-family: 'Poppins', sans-serif; color: #ff6f61; font-weight: 600; padding: 8px 20px;">
                          <strong><?php echo explode(' ', $_SESSION['nombre'])[0] . ' ' . explode(' ', $_SESSION['nombre'])[1]; ?></strong>
                        </div>
                      </li>
                      <li>
                        <div class="dropdown-item" style="font-family: 'Poppins', sans-serif; color: #333; padding: 8px 20px;">
                          ROL: <?php echo $rol; ?>
                        </div>
                      </li>
                      <li><hr class="dropdown-divider" style="margin: 0.5rem 20px;"></li>
                      
                      <?php if($rol_id != 5): // Mostrar Paneles solo si no es cliente ?>
                      <li>
                        <a class="dropdown-item" href="auth/interfazpaneles.php" style="font-family: 'Poppins', sans-serif; color: #333; transition: all 0.3s; padding: 8px 20px;">
                          <i class="fas fa-tachometer-alt me-2" style="color: #ff6f61;"></i>Paneles
                        </a>
                      </li>
                      <?php endif; ?>
                      
                      <li>
                        <a class="dropdown-item" href="#" style="font-family: 'Poppins', sans-serif; color: #333; transition: all 0.3s; padding: 8px 20px;">
                          <i class="fas fa-user-circle me-2" style="color: #ff6f61;"></i>Ver cuenta
                        </a>
                      </li>
                      <li>
                        <form action="auth/logout.php" method="POST">
                          <button type="submit" class="dropdown-item" style="font-family: 'Poppins', sans-serif; color: #333; transition: all 0.3s; background: none; border: none; width: 100%; text-align: left; padding: 8px 20px;">
                            <i class="fas fa-sign-out-alt me-2" style="color: #ff6f61;"></i>Cerrar sesión
                          </button>
                        </form>
                      </li>
                    </ul>
                  </li>
                <?php else: ?>
                  <!-- Botón de iniciar sesión si no hay sesión activa -->
                  <li class="rd-nav-item ml-auto" style="margin-left: 20px !important;">
                    <a href="auth/LoginSignUp.php" class="btn" style="background: #ff6f61; color: white; border-radius: 25px; padding: 6px 16px; font-family: 'Poppins', sans-serif; transition: all 0.3s; font-size: 0.9rem;">
                      Iniciar sesión
                    </a>
                  </li>
                <?php endif; ?>
              </ul>
            </div>
            <?php if (basename($_SERVER['PHP_SELF']) == 'menu.php'): ?>
                <!-- Ícono del carrito -->
                <a href="pedido.php" class="cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </nav>
  </div>
</header>
<script>
        // Función para mostrar/ocultar el menú de usuario
        function toggleUserMenu() {
          document.getElementById('userDropdown').classList.toggle('show');
        }
        
        // Cerrar el menú al hacer clic fuera de él
        window.onclick = function(event) {
          if (!event.target.matches('.user-toggle') && !event.target.closest('.user-toggle')) {
            var dropdowns = document.getElementsByClassName("user-dropdown");
            for (var i = 0; i < dropdowns.length; i++) {
              var openDropdown = dropdowns[i];
              if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
              }
            }
          }
        }
      </script>
      <?php if (basename($_SERVER['PHP_SELF']) == 'menu.php') : ?>    
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
      <?php endif; ?>
      <script>
    window.addEventListener('pageshow', function(event) {
        if (event.persisted || performance.navigation.type === 2) {
            window.location.reload();
        }
    });
</script>

      