<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require '../conexion.php';
/** @var mysqli $conexion */
mysqli_report(MYSQLI_REPORT_OFF);

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit();
}

$error = '';

if (isset($_POST['guardar'])) {
    $nombre      = trim($_POST['nombre'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $precio      = (float) ($_POST['precio'] ?? 0);
    $stock       = (int) ($_POST['stock'] ?? 0);

    $stmt = mysqli_prepare($conexion, "INSERT INTO productos (nombre, descripcion, precio, stock) VALUES (?, ?, ?, ?)");

    if (!$stmt) {
        $error = "Error al preparar la consulta: " . mysqli_error($conexion);
    } else {
        mysqli_stmt_bind_param($stmt, "ssdi", $nombre, $descripcion, $precio, $stock);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: productos.php");
            exit();
        } else {
            $error = "Error al guardar: " . mysqli_stmt_error($stmt);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulo CRUD - Productos</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; margin: 0; padding: 0; color: #333; }
        header { background-color: #212529; color: white; padding: 15px 0; text-align: center; font-size: 20px; font-weight: bold; }
        .container { max-width: 800px; margin: 30px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .foto-perfil { width: 150px !important; height: 150px !important; border-radius: 50% !important; object-fit: cover !important; display: block !important; margin: 0 auto 25px auto !important; box-shadow: 0 4px 8px rgba(0,0,0,0.15); }
        h2 { color: #333; margin-top: 0; border-bottom: 2px solid #dee2e6; padding-bottom: 10px; text-align: left; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #495057; text-align: left; }
        input[type="text"], input[type="number"], textarea { width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px; box-sizing: border-box; }
        textarea { resize: vertical; height: 80px; }
        .btn { border: none; padding: 12px 20px; font-size: 16px; border-radius: 4px; cursor: pointer; width: 100%; font-weight: bold; text-decoration: none; display: block; text-align: center; box-sizing: border-box; margin-top: 15px; }
        .btn-primary { background-color: #343a40; color: white; }
        .btn-primary:hover { background-color: #23272b; }
        .btn-secondary { background-color: #495057; color: white; }
        .btn-secondary:hover { background-color: #343a40; }
        .error { background: #fee2e2; color: #991b1b; padding: 10px; border-radius: 6px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <header>Módulo CRUD - Productos</header>
    <div class="container">
        <img src="/yoo.png" alt="Foto de perfil" class="foto-perfil">

        <h2>Añadir Nuevo Producto (Create)</h2>

        <?php if ($error): ?>
            <p class="error"><?= e($error) ?></p>
        <?php endif; ?>

        <form action="index.php" method="POST">
            <div class="form-group">
                <label>Nombre del Producto:</label>
                <input type="text" name="nombre" required>
            </div>
            <div class="form-group">
                <label>Descripción:</label>
                <textarea name="descripcion" required></textarea>
            </div>
            <div class="form-group">
                <label>Precio ($):</label>
                <input type="number" step="0.01" name="precio" required>
            </div>
            <div class="form-group">
                <label>Stock / Cantidad:</label>
                <input type="number" name="stock" required>
            </div>
            <button type="submit" name="guardar" class="btn btn-primary">Guardar Producto</button>
        </form>

        <a href="productos.php" class="btn btn-secondary">Ver Lista de Productos</a>
        <a href="../menu.php" class="btn btn-secondary">Volver al Menú</a>
    </div>
</body>
</html>