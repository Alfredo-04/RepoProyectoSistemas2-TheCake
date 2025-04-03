<?php
include '../connection.php';

// Obtener categorías para el formulario
$queryCategorias = "SELECT id_categoria, nombre_categoria FROM categorias_productos";
$resultCategorias = mysqli_query($conn, $queryCategorias);

// Crear (Agregar un producto)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear'])) {
    $nombre = $_POST['nombre_producto'];
    $precio = $_POST['precio'];
    $stock_minimo = $_POST['stock_minimo'];
    $categoria_id = $_POST['categoria_producto_id']; // Aquí se envía el ID
    $descripcion = $_POST['descripcion'];

    // Manejo de la imagen
    if ($_FILES['imagen']['size'] > 0) {
        $imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
    } else {
        $imagen = null;
    }

    $query = "INSERT INTO productos (nombre_producto, precio, stock_minimo, categoria_producto_id, descripcion, imagen) 
              VALUES ('$nombre', '$precio', '$stock_minimo', '$categoria_id', '$descripcion', '$imagen')";
    mysqli_query($conn, $query);
    header("Location: registroProductos.php");
    exit;
}

// Leer (Mostrar productos)
$query = "SELECT p.*, c.nombre_categoria 
          FROM productos p 
          INNER JOIN categorias_productos c ON p.categoria_producto_id = c.id_categoria";
$result = mysqli_query($conn, $query);

// Actualizar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])) {
    $id = $_POST['id_producto'];
    $nombre = $_POST['nombre_producto'];    
    $precio = $_POST['precio'];
    $stock_minimo = $_POST['stock_minimo'];
    $categoria_id = $_POST['categoria_producto_id']; // Aquí se envía el ID
    $descripcion = $_POST['descripcion'];

    $updateQuery = "UPDATE productos SET nombre_producto='$nombre', precio='$precio', stock_minimo='$stock_minimo',
                    categoria_producto_id='$categoria_id', descripcion='$descripcion'";

    if ($_FILES['imagen']['size'] > 0) {
        $imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
        $updateQuery .= ", imagen='$imagen'";
    }

    $updateQuery .= " WHERE id_producto='$id'";
    mysqli_query($conn, $updateQuery);
    header("Location: registroProductos.php");
    exit;
}

// Eliminar
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    mysqli_query($conn, "DELETE FROM productos WHERE id_producto='$id'");
    header("Location: registroProductos.php");
    exit;
}
?>
<?php 
require_once 'check_role.php';
?>
<?php
include 'templates/header.php';
?>     
<head>
    <title>Gestión de Productos</title>


    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="./../public/assets/css/styleRegistro.css">
<style>
    body {
    background: linear-gradient(135deg, #f8a29b, #ff6f61);
    color: #333;
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    text-align: center;

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

.container {
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

/* Estilos específicos para el formulario */
form {
    position: relative;
    z-index: 10;
    background: rgba(255, 255, 255, 0.95);
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    margin-bottom: 30px;
}

.form-label {
    display: block;
    text-align: left;
    margin-bottom: 20px;
    font-weight: bold;
    color: #ff6f61;
    position: relative;
    z-index: 10;
}

.mb-3 {
    margin-bottom: 1.5rem;
    position: relative;
    z-index: 10;
}

.form-control {
    border: 1px solid #ff6f61;
    border-radius: 10px;
    padding: 5px;
    font-size: 1rem;
    margin-bottom: 10px;
    transition: border-color 0.3s, box-shadow 0.3s;
}

.form-control:focus {
    border-color: #ff3b30;
    outline: none;
    box-shadow: 0 0 5px rgba(255, 111, 97, 0.5);
}

.btn-success {
    background: #ff6f61;
    border: none;
    padding: 12px 24px;
    border-radius: 10px;
    color: #fff;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s, transform 0.2s;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
}

.btn-success:hover {
    background: #ff3b30;
    transform: scale(1.05);
}

.btn-warning {
    background: #ffbc0a;
    border: none;
    padding: 8px 16px;
    border-radius: 10px;
    color: #000;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s, transform 0.2s;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
}

.btn-warning:hover {
    background: #f4a900;
    transform: scale(1.05);
}

.btn-danger {
    background: #ff6f61;
    border: none;
    padding: 8px 16px;
    border-radius: 10px;
    color: #fff;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s, transform 0.2s;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
}

.btn-danger:hover {
    background: #ff3b30;
    transform: scale(1.05);
}

.btn-sm {
    padding: 6px 12px;
    margin: 0 4px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-sm i {
    margin-right: 5px;
}

table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    margin-bottom: 30px;
}

thead {
    background: #ff6f61;
    color: white;
    font-size: 1.2rem;
}

th, td {
    padding: 15px;
    border-bottom: 1px solid #f0f0f0;
    text-align: center;
}

tbody tr:hover {
    background: rgba(255, 111, 97, 0.1);
    transition: background 0.3s;
}

/* Estilos para las imágenes en la tabla */
table img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease-in-out;
}

table img:hover {
    transform: scale(1.1);
}

#modalEditar {
    background: rgba(255, 255, 255, 0.9);
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    margin-top: 20px;
    display: none;
}

.navbar {
    background: rgba(255, 255, 255, 0.9);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.navbar-brand img {
    height: 60px;
    transition: transform 0.3s ease-in-out;
}

.navbar-brand img:hover {
    transform: rotate(10deg);
}

.nav-link {
    font-size: 1.1rem;
    color: #333 !important;
    transition: color 0.3s ease-in-out;
}

.nav-link:hover {
    color: #ff6f61 !important;
}

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

@media (max-width: 768px) {
    .container {
        width: 90%;
        padding: 20px;
    }

    table {
        font-size: 0.9rem;
    }

    th, td {
        padding: 10px;
    }

    h2 {
        font-size: 2rem;
    }

    .btn-success, .btn-warning, .btn-danger {
        padding: 8px 16px;
        font-size: 0.9rem;
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
</head>

    <div class="container mt-5">
        <h2>Registro de Productos</h2>

        <!-- Formulario para agregar un nuevo producto -->
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre_producto" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Precio</label>
                <input type="number" class="form-control" name="precio" step="0.01" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Stock Mínimo</label>
                <input type="number" class="form-control" name="stock_minimo" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Categoría</label>
                <select class="form-control" name="categoria_producto_id" required>
                    <option value="">Seleccione una categoría</option>
                    <?php while ($categoria = mysqli_fetch_assoc($resultCategorias)) { ?>
                        <option value="<?php echo $categoria['id_categoria']; ?>">
                            <?php echo $categoria['nombre_categoria']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea class="form-control" name="descripcion"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Imagen</label>
                <input type="file" class="form-control" name="imagen">
            </div>
            
            <button type="submit" name="crear" class="btn btn-success">Agregar Producto</button>
        </form>

            
            
        <hr>

        <!-- Tabla para mostrar productos -->
        <h3>Lista de Productos</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock Mínimo</th>
                    <th>Categoría</th>
                    <th>Descripcion</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td>
                            <?php if ($row['imagen']) { ?>
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($row['imagen']); ?>" width="50">
                            <?php } else { ?>
                                <p>Sin imagen</p>
                            <?php } ?>
                        </td>
                        <td><?php echo $row['nombre_producto']; ?></td>
                        <td><?php echo $row['precio']; ?></td>
                        <td><?php echo $row['stock_minimo']; ?></td>
                        <td><?php echo $row['nombre_categoria']; ?></td> <!-- Mostrar el nombre de la categoría -->
                        <td><?php echo $row['descripcion']; ?></td>
                        <td>
                            <!-- Botón de editar -->
                            <button class="btn btn-warning btn-sm" onclick="editarProducto(<?php echo $row['id_producto']; ?>, '<?php echo $row['nombre_producto']; ?>', <?php echo $row['precio']; ?>, <?php echo $row['stock_minimo']; ?>, <?php echo $row['categoria_producto_id']; ?>, '<?php echo $row['descripcion']; ?>')">
                                <i class="fas fa-edit"></i> <!-- Ícono de editar -->
                            </button>

                            <button class="btn btn-danger btn-sm" onclick="confirmarEliminacion(<?php echo $row['id_producto']; ?>, '<?php echo addslashes($row['nombre_producto']); ?>')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Modal de Edición -->
    <div id="modalEditar" style="display:none;">
    <h3>Editar Producto</h3>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_producto" id="edit_id">
        <input type="text" name="nombre_producto" id="edit_nombre" class="form-control" required>
        <input type="number" name="precio" id="edit_precio" class="form-control" step="0.01" required>
        <input type="number" name="stock_minimo" id="edit_stock" class="form-control" required>
        <select name="categoria_producto_id" id="edit_categoria" class="form-control" required>
            <option value="">Seleccione una categoría</option>
            <?php
            mysqli_data_seek($resultCategorias, 0); // Reiniciar el puntero del resultado
            while ($categoria = mysqli_fetch_assoc($resultCategorias)) { ?>
                <option value="<?php echo $categoria['id_categoria']; ?>">
                    <?php echo $categoria['nombre_categoria']; ?>
                </option>
            <?php } ?>
        </select>
        <textarea name="descripcion" id="edit_descripcion" class="form-control"></textarea>
        <input type="file" name="imagen" class="form-control">
        <button type="submit" name="editar" class="btn btn-primary">Actualizar</button>
    </form>
</div>
   <!-- Page Footer-->
       <!-- Footer mejorado -->
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
      
    </div>
    <!-- Global Mailform Output-->
    <div class="snackbars" id="form-output-global"></div>
    <!-- Javascript-->
    <script src="../public/assets/js/core.min.js"></script>
    <script src="../public/assets/js/scriptIndex.js"></script>
    <!-- coded by Himic-->


    <script>
        function editarProducto(id, nombre, precio, stock, categoria_id, descripcion) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_nombre').value = nombre;
    document.getElementById('edit_precio').value = precio;
    document.getElementById('edit_stock').value = stock;
    document.getElementById('edit_categoria').value = categoria_id; // Establecer el ID de la categoría
    document.getElementById('edit_descripcion').value = descripcion;
    document.getElementById('modalEditar').style.display = 'block';
}
    </script>

<script>
function confirmarEliminacion(idProducto, nombreProducto) {
    Swal.fire({
        title: '¿Eliminar producto?',
        html: `Estás a punto de eliminar el producto <b>"${nombreProducto.replace(/"/g, '&quot;')}"</b>.<br>¿Deseas continuar?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        allowOutsideClick: false,
        allowEscapeKey: false
    }).then((result) => {
        if (result.isConfirmed) {
            // Crear un formulario dinámico para enviar la solicitud
            const form = document.createElement('form');
            form.method = 'GET';
            form.action = window.location.pathname;
            
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'eliminar';
            input.value = idProducto;
            
            form.appendChild(input);
            document.body.appendChild(form);
            
            // Mostrar loader mientras se procesa
            Swal.fire({
                title: 'Eliminando producto',
                html: 'Por favor espera...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                    form.submit();
                }
            });
        }
    });
}
</script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
         <!-- SweetAlert2 JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
