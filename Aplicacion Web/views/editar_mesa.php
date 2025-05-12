<?php 
include '../connection.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM mesas1 WHERE id = $id";
    $result = $conn->query($sql);
    $mesa = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Mesa - Cafetería</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-coffee"></i> Editar Mesa <?php echo $mesa['numeroDeMesa']; ?></h1>
        </header>

        <div class="form-container">
            <form action="actualizar_mesa.php" method="post">
                <input type="hidden" name="id" value="<?php echo $mesa['id']; ?>">
                
                <div class="form-group">
                    <label for="numeroDeMesa">Número de Mesa</label>
                    <input type="text" id="numeroDeMesa" name="numeroDeMesa" class="form-control" value="<?php echo $mesa['numeroDeMesa']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="capacidad">Capacidad</label>
                    <input type="number" id="capacidad" name="capacidad" class="form-control" value="<?php echo $mesa['capacidad']; ?>" min="1" required>
                </div>

                <div class="form-group">
                    <label for="estado">Estado</label>
                    <select id="estado" name="estado" class="form-control" required>
                        <option value="ocupada" <?php echo ($mesa['estado'] == 'ocupada') ? 'selected' : ''; ?>>Ocupada</option>
                        <option value="desocupada" <?php echo ($mesa['estado'] == 'desocupada') ? 'selected' : ''; ?>>Desocupada</option>
                    </select>
                </div>

                <div class="form-actions">
                    <a href="gestion_mesas.php" class="btn btn-cancelar">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    <button type="submit" class="btn" style="background-color: var(--color-highlight);">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<?php $conn->close(); ?>