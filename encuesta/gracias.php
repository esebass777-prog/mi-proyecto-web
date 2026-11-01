<?php
require '../conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Gracias por participar!</title>
    <link rel="stylesheet" href="estilos_encuesta.css">
    <style>
        .regalo-box { background: #f8f9fa; border: 2px dashed #0056b3; border-radius: 12px; padding: 20px; text-align: center; margin-top: 20px; }
        .regalo-box h3 { color: #0056b3; margin-bottom: 10px; font-size: 1.2rem; }
        .img-regalo { max-width: 200px; width: 100%; height: auto; border-radius: 8px; margin: 15px auto; display: block; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <img src="/yoo.png" alt="Mi Foto" class="perfil-img">
            <h1>¡Muchas Gracias, <?= e($_SESSION['nombre']) ?>!</h1>
        </header>
        <main>
            <p>Tus respuestas han sido registradas exitosamente.</p>

            <div class="regalo-box">
                <h3>🎁 ¡Aquí está tu regalo!</h3>
                <p style="font-size: 0.95rem; color: #555; margin-bottom: 5px;">Gracias por completar la encuesta de la UPVM.</p>
                <img src="regalo.png" alt="Tu Regalo Sorpresa" class="img-regalo">
                <a href="../menu.php" class="btn" style="margin-top: 15px;">Volver al Menú</a>
            </div>
        </main>
    </div>
</body>
</html>