<?php 
include '../connection.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Mesa - Cafetería</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-coffee"></i> Agregar Nueva Mesa</h1>
        </header>

        <?php if(isset($_GET['error']) && $_GET['error'] == 'exists'): ?>
            <div class="alert error">
                <i class="fas fa-exclamation-circle"></i>
                ¡El número de mesa ya existe!
            </div>
        <?php endif; ?>

        <div class="form-container">
            <form action="procesar_agregar.php" method="post">
                <div class="form-group">
                    <label for="numeroDeMesa">Número de Mesa</label>
                    <input type="text" id="numeroDeMesa" name="numeroDeMesa" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="capacidad">Capacidad</label>
                    <input type="number" id="capacidad" name="capacidad" class="form-control" min="1" required>
                </div>

                <div class="form-group">
                    <label for="estado">Estado</label>
                    <select id="estado" name="estado" class="form-control" required>
                        <option value="ocupada">Ocupada</option>
                        <option value="desocupada" selected>Desocupada</option>
                    </select>
                </div>

                <div class="form-actions">
                    <a href="gestion_mesas.php" class="btn btn-cancelar">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-agregar">
                        <i class="fas fa-save"></i> Guardar Mesa
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<?php $conn->close(); ?>