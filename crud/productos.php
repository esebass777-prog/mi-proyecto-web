<?php
require '../conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $sql_delete = "DELETE FROM productos WHERE id_producto = $id";
    if (mysqli_query($conexion, $sql_delete)) {
        header("Location: productos.php");
        exit();
    } else {
        echo "Error al eliminar: " . mysqli_error($conexion);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulo CRUD - Lista de Productos</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; margin: 0; padding: 0; color: #333; }
        header { background-color: #212529; color: white; padding: 15px 0; text-align: center; font-size: 20px; font-weight: bold; }
        .container { max-width: 900px; margin: 30px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .foto-perfil { width: 150px !important; height: 150px !important; border-radius: 50% !important; object-fit: cover !important; display: block !important; margin: 0 auto 25px auto !important; box-shadow: 0 4px 8px rgba(0,0,0,0.15); }
        h2 { color: #333; margin-top: 0; border-bottom: 2px solid #dee2e6; padding-bottom: 10px; text-align: left; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px 15px; border: 1px solid #dee2e6; text-align: left; }
        th { background-color: #e9ecef; color: #495057; }
        tr:nth-child(even) { background-color: #f8f9fa; }
        .btn { border: none; padding: 10px 20px; font-size: 14px; border-radius: 4px; cursor: pointer; font-weight: bold; text-decoration: none; display: inline-block; text-align: center; margin-top: 20px; margin-right: 8px; }
        .btn-secondary { background-color: #495057; color: white; }
        .btn-secondary:hover { background-color: #343a40; }
        .btn-edit { background-color: #f8f9fa; color: #212529; border: 1px solid #ced4da; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 14px; }
        .btn-edit:hover { background-color: #e2e6ea; }
        .btn-delete { background-color: #fff; color: #dc3545; border: 1px solid #dc3545; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 14px; }
        .btn-delete:hover { background-color: #dc3545; color: white; }
    </style>
</head>
<body>
    <header>Módulo CRUD - Lista de Productos</header>
    <div class="container">
        <img src="/yoo.png" alt="Foto de perfil" class="foto-perfil">
        <h2>Lista de Productos (Read)</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $resultado = mysqli_query($conexion, "SELECT * FROM productos");
                if ($resultado) {
                    while ($row = mysqli_fetch_assoc($resultado)) {
                ?>
                <tr>
                    <td><?php echo e($row['id_producto']); ?></td>
                    <td><?php echo e($row['nombre']); ?></td>
                    <td><?php echo e($row['descripcion']); ?></td>
                    <td>$<?php echo number_format($row['precio'], 2); ?></td>
                    <td><?php echo e($row['stock']); ?></td>
                    <td>
                        <a href="editar.php?id=<?php echo (int) $row['id_producto']; ?>" class="btn-edit">Editar</a>
                        <a href="productos.php?eliminar=<?php echo (int) $row['id_producto']; ?>" class="btn-delete" onclick="return confirm('¿Estás seguro de eliminar este producto?');">Eliminar</a>
                    </td>
                </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
        <a href="index.php" class="btn btn-secondary">Agregar otro producto</a>
        <a href="../menu.php" class="btn btn-secondary">Volver al Menú</a>
    </div>
</body>
</html>