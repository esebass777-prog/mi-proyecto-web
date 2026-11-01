<?php
require '../conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $instalaciones = trim($_POST['instalaciones'] ?? '');
    $profesores    = $_POST['profesores'] ?? '';
    $propuestas    = trim($_POST['propuestas'] ?? '');
    $frecuencia    = $_POST['frecuencia'] ?? '';
    $comentarios   = trim($_POST['comentarios'] ?? '');

    if ($instalaciones === '' || $propuestas === '' || $comentarios === ''
        || !in_array($profesores, ['Siempre', 'A veces', 'Nunca'], true)
        || !in_array($frecuencia, ['Diariamente', 'Semanalmente', 'Rara vez', 'Nunca'], true)) {
        $error = 'Revisa que todas las respuestas estén completas.';
    } else {
        $sql = 'INSERT INTO encuesta_respuestas
                (usuario_id, usuario, instalaciones, profesores, propuestas, frecuencia, comentarios)
                VALUES (?, ?, ?, ?, ?, ?, ?)';
        try {
            $pdo->prepare($sql)->execute([
                $_SESSION['usuario_id'], $_SESSION['nombre'],
                $instalaciones, $profesores, $propuestas, $frecuencia, $comentarios
            ]);
            header('Location: gracias.php');
            exit;
        } catch (PDOException $ex) {
            $error = 'Error al guardar la encuesta.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta UPVM</title>
    <link rel="stylesheet" href="estilos_encuesta.css">
</head>
<body>
    <div class="container">
        <header>
            <img src="/yoo.png" alt="Mi Foto" class="perfil-img">
            <h2>Encuesta de Satisfacción UPVM</h2>
        </header>

        <?php if ($error): ?>
            <p class="error"><?= e($error) ?></p>
        <?php endif; ?>

        <form action="encuesta.php" method="POST">
            <label>1. ¿Cómo calificarías las instalaciones de los laboratorios de la UPVM?</label>
            <input type="text" name="instalaciones" required maxlength="255" placeholder="Ej. Excelentes, Buenas..." value="<?= e($_POST['instalaciones'] ?? '') ?>">

            <label>2. ¿El desempeño de los profesores en tu carrera cumple con tus expectativas?</label>
            <select name="profesores" required>
                <option value="">Selecciona una opción</option>
                <?php foreach (['Siempre', 'A veces', 'Nunca'] as $op): ?>
                    <option value="<?= $op ?>" <?= ($_POST['profesores'] ?? '') === $op ? 'selected' : '' ?>><?= $op ?></option>
                <?php endforeach; ?>
            </select>

            <label>3. ¿Qué propuestas o áreas de oportunidad sugieres para mejorar la universidad?</label>
            <input type="text" name="propuestas" required maxlength="255" placeholder="Tu opinión corta" value="<?= e($_POST['propuestas'] ?? '') ?>">

            <label>4. ¿Con qué frecuencia utilizas las plataformas digitales y herramientas tecnológicas de la UPVM?</label>
            <select name="frecuencia" required>
                <option value="">Selecciona una opción</option>
                <?php foreach (['Diariamente', 'Semanalmente', 'Rara vez', 'Nunca'] as $op): ?>
                    <option value="<?= $op ?>" <?= ($_POST['frecuencia'] ?? '') === $op ? 'selected' : '' ?>><?= $op ?></option>
                <?php endforeach; ?>
            </select>

            <label>5. Comentarios adicionales para mejorar la UPVM:</label>
            <textarea name="comentarios" required placeholder="Escribe tus sugerencias..."><?= e($_POST['comentarios'] ?? '') ?></textarea>

            <button type="submit" class="btn">Enviar Encuesta</button>
        </form>

        <a href="../menu.php" class="btn" style="background:#495057;">Volver al Menú</a>
    </div>
</body>
</html>