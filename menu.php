<?php
require 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}
$nombre = $_SESSION['nombre'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #fafafa; color: #333; }
        header { background: #1a1a1a; color: #fff; padding: 18px 0; text-align: center; font-size: 20px; font-weight: bold; position: relative; }
        .salir { position: absolute; right: 12px; top: 10px; background: #2b2b2b; color: #fff; padding: 9px 14px; border-radius: 6px; text-decoration: none; font-size: 14px; }
        .salir:hover { background: #3a3a3a; }
        main { max-width: 640px; margin: 0 auto; padding: 20px; text-align: center; }
        .foto { width: 325px; max-width: 80%; border-radius: 14px; box-shadow: 0 4px 12px rgba(0,0,0,.2); }
        h1 { margin: 30px 0 10px; }
        p { color: #555; margin-bottom: 35px; }
        .opcion { position: relative; display: block; padding: 18px; margin-bottom: 15px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 18px; box-shadow: 0 2px 6px rgba(0,0,0,.15); }
        .opcion i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 30px; height: 30px; line-height: 30px; border-radius: 50%; font-size: 14px; }
        .oscuro { background: #2b2b2b; color: #fff; }
        .oscuro i { background: #fff; color: #2b2b2b; }
        .claro { background: #fff; color: #222; border: 1px solid #ddd; }
        .claro i { background: #888; color: #fff; }
        .opcion:hover { opacity: .9; }
    </style>
</head>
<body>
    <header>
        Menú Principal
        <a class="salir" href="logout.php"><i class="fa-solid fa-power-off"></i> Cerrar Sesión</a>
    </header>

    <main>
        <img class="foto" src="yoo.png" alt="Foto de perfil">
        <h1>¡Bienvenido, <?= e($nombre) ?>!</h1>
        <p>Selecciona la sección a la que deseas acceder:</p>

        <a class="opcion oscuro" href="crud/index.php"><i class="fa-solid fa-table-cells"></i>📦 Módulo CRUD (Productos)</a>
        <a class="opcion claro"  href="mapa/mapa.php"><i class="fa-solid fa-location-dot"></i>🗺️ Ver Mapa / GeoUbicación</a>
        <a class="opcion claro"  href="encuesta/encuesta.php"><i class="fa-solid fa-pen"></i>📋 Realizar Encuesta</a>
        <a class="opcion oscuro" href="chat.php"><i class="fa-solid fa-comment"></i>💬 Chat Grupal (En Vivo)</a>
        <a class="opcion claro" href="video.php"><i class="fa-solid fa-video"></i>🎥 Ver mi video</a>
        <a class="opcion oscuro" href="cursos.php"><i class="fa-solid fa-book"></i>📚 Catálogo de cursos</a>
        <a class="opcion claro"  href="dashboard.php"><i class="fa-solid fa-chart-line"></i>📊 Métricas del sitio</a> 
    </main>
    <script src="tracker.js"></script>
</body>
</html>