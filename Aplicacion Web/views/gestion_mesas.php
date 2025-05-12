
<?php include '../connection.php';

// Contar mesas por estado
$sql_ocupadas = "SELECT COUNT(*) as total FROM mesas1 WHERE estado = 'ocupada'";
$result_ocupadas = $conn->query($sql_ocupadas);
$ocupadas = $result_ocupadas->fetch_assoc();

$sql_desocupadas = "SELECT COUNT(*) as total FROM mesas1 WHERE estado = 'desocupada'";
$result_desocupadas = $conn->query($sql_desocupadas);
$desocupadas = $result_desocupadas->fetch_assoc();
?>

<?php 
require_once 'check_role.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Mesas - Cafetería</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
   
</head>
<body>
<div class="container">
        <header>
            <h1><i class="fas fa-coffee"></i> Gestión de Mesas</h1>
            <div class="contadores">
                <div class="contador desocupadas">
                    <i class="fas fa-check-circle"></i>
                    <span><?php echo $desocupadas['total']; ?> Desocupadas</span>
                </div>
                <div class="contador ocupadas">
                    <i class="fas fa-times-circle"></i>
                    <span><?php echo $ocupadas['total']; ?> Ocupadas</span>
                </div>
            </div>
            <li class="rd-nav-item"><a class="rd-nav-link" href="auth/InterfazPaneles.php">PANELES</a>

        </header>

        <a href="agregar_mesa.php" class="btn btn-agregar">
            <i class="fas fa-plus"></i> Agregar Nueva Mesa
        </a>

        <?php if(isset($_GET['success'])): ?>
            <div class="alert success">
                <i class="fas fa-check-circle"></i>
                <?php 
                    if($_GET['success'] == 'add') echo "Mesa agregada correctamente";
                    if($_GET['success'] == 'update') echo "Mesa actualizada correctamente";
                    if($_GET['success'] == 'delete') echo "Mesa eliminada correctamente";
                ?>
            </div>
        <?php endif; ?>

        <div class="mesas-grid">
            <?php
            $sql = "SELECT * FROM mesas1 ORDER BY id";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='mesa-card mesa-{$row['estado']}'>
                            <div class='mesa-header'>
                                <h3>{$row['numeroDeMesa']}</h3>
                                <span class='estado-badge estado-{$row['estado']}'>
                                    ".ucfirst($row['estado'])."
                                </span>
                            </div>
                            <div class='mesa-body'>
                                <p><i class='fas fa-users'></i> Capacidad: {$row['capacidad']} personas</p>
                                <div class='mesa-actions'>
                                    <a href='editar_mesa.php?id={$row['id']}' class='btn btn-editar'>
                                        <i class='fas fa-edit'></i> Editar
                                    </a>
                                    <a href='#' class='btn btn-borrar' onclick='confirmarEliminacionMesa({$row['id']}, \"{$row['numeroDeMesa']}\")'>
                                        <i class='fas fa-trash-alt'></i> Borrar
                                    </a>

                                </div>
                            </div>
                          </div>";
                }
            } else {
                echo "<div class='no-mesas'>No hay mesas registradas</div>";
            }
            ?>
        </div>
    </div>
    <script src="script.js"></script>
    </div>

</body>


<script>
function confirmarEliminacionMesa(idMesa, numeroMesa) {
    Swal.fire({
        title: '¿Eliminar mesa?',
        html: `Estás a punto de eliminar la mesa <b>${numeroMesa}</b>. ¿Deseas continuar?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        allowOutsideClick: false
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirigir a la página de eliminación con el ID de la mesa
            window.location.href = `borrar_mesa.php?id=${idMesa}`;
        }
    });
}
</script>
         <!-- SweetAlert2 JS -->
         <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>


<?php $conn->close(); ?>