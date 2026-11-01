<?php
require '../conexion.php';
/** @var mysqli $conexion */

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_POST['actualizar'])) {
    $id = intval($_POST['id_producto']);
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);
    $precio = mysqli_real_escape_string($conexion, $_POST['precio']);
    $stock = mysqli_real_escape_string($conexion, $_POST['stock']);

    $sql = "UPDATE productos SET nombre='$nombre', descripcion='$descripcion', precio='$precio', stock='$stock' WHERE id_producto=$id";
    if (mysqli_query($conexion, $sql)) {
        header("Location: productos.php");
        exit();
    } else {
        echo "Error al actualizar: " . mysqli_error($conexion);
    }
}

$row = null;
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $resultado = mysqli_query($conexion, "SELECT * FROM productos WHERE id_producto = $id");
    if ($resultado) {
        $row = mysqli_fetch_assoc($resultado);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; margin: 0; padding: 0; color: #333; }
        header { background-color: #212529; color: white; padding: 15px 0; text-align: center; font-size: 20px; font-weight: bold; }
        .container { max-width: 800px; margin: 30px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .foto-perfil { width: 150px !important; height: 150px !important; border-radius: 50% !important; object-fit: cover !important; display: block !important; margin: 0 auto 25px auto !important; box-shadow: 0 4px 8px rgba(0,0,0,0.15); }
        h2 { color: #333; margin-top: 0; border-bottom: 2px solid #dee2e6; padding-bottom: 10px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #495057; }
        input[type="text"], input[type="number"], textarea { width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px; box-sizing: border-box; }
        textarea { resize: vertical; height: 80px; }
        .btn { border: none; padding: 12px 20px; font-size: 16px; border-radius: 4px; cursor: pointer; width: 100%; font-weight: bold; text-decoration: none; display: block; text-align: center; margin-top: 15px; box-sizing: border-box; }
        .btn-primary { background-color: #343a40; color: white; }
        .btn-primary:hover { background-color: #23272b; }
        .btn-secondary { background-color: #495057; color: white; display: inline-block; width: auto; }
    </style>
</head>
<body>
    <header>Módulo CRUD - Editar Producto</header>
    <div class="container">
        <img src="/yoo.png" alt="Foto de perfil" class="foto-perfil">
        <h2>Modificar Producto</h2>
        <?php if ($row): ?>
        <form action="editar.php" method="POST">
            <input type="hidden" name="id_producto" value="<?php echo (int) $row['id_producto']; ?>">
            <div class="form-group">
                <label>Nombre del Producto:</label>
                <input type="text" name="nombre" value="<?php echo e($row['nombre']); ?>" required>
            </div>
            <div class="form-group">
                <label>Descripción:</label>
                <textarea name="descripcion" required><?php echo e($row['descripcion']); ?></textarea>
            </div>
            <div class="form-group">
                <label>Precio ($):</label>
                <input type="number" step="0.01" name="precio" value="<?php echo e($row['precio']); ?>" required>
            </div>
            <div class="form-group">
                <label>Stock / Cantidad:</label>
                <input type="number" name="stock" value="<?php echo e($row['stock']); ?>" required>
            </div>
            <button type="submit" name="actualizar" class="btn btn-primary">Actualizar Producto</button>
        </form>
        <?php else: ?>
            <p>No se encontró el producto a editar.</p>
        <?php endif; ?>
        <a href="productos.php" class="btn btn-secondary" style="margin-top: 20px;">Cancelar</a>
    </div>
</body>
</html>