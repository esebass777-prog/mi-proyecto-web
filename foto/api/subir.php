<?php
// Servicio que RECIBE una foto:  POST api/subir.php  (multipart/form-data, campo "foto")

require __DIR__ . '/../../conexion.php';
header('Content-Type: application/json; charset=utf-8');
date_default_timezone_set('America/Mexico_City');

function responder($codigo, $datos)
{
    http_response_code($codigo);
    echo json_encode($datos);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    responder(405, ['error' => 'Usa POST.']);
}

if (!isset($_SESSION['usuario_id'])) {
    responder(401, ['error' => 'Inicia sesión.']);
}

$foto = $_FILES['foto'] ?? null;
if (!$foto || $foto['error'] !== UPLOAD_ERR_OK) {
    responder(400, ['error' => 'No llegó ninguna foto.']);
}

if ($foto['size'] > 5 * 1024 * 1024) {
    responder(400, ['error' => 'La foto pesa más de 5 MB.']);
}

// Nunca confiar en el cliente: finfo revisa el CONTENIDO real del archivo.
$tipos = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp', 'image/gif' => 'gif'];
$tipo  = (new finfo(FILEINFO_MIME_TYPE))->file($foto['tmp_name']);
if (!isset($tipos[$tipo])) {
    responder(400, ['error' => 'Eso no es una imagen.']);
}

// El nombre lo pone el SERVIDOR: usuario + fecha + 4 caracteres al azar.
$usuario = preg_replace('/[^A-Za-z0-9]/', '', $_SESSION['nombre']) ?: 'usuario';
$archivo = $usuario . '_' . date('Ymd-His') . '_' . bin2hex(random_bytes(2)) . '.' . $tipos[$tipo];

$ruta = __DIR__ . '/../subidas/' . $archivo;
if (!move_uploaded_file($foto['tmp_name'], $ruta)) {
    responder(500, ['error' => 'No se pudo guardar la foto en el servidor.']);
}

// El archivo ya está en el disco; ahora se REGISTRA en la tabla fotos.
$sql = 'INSERT INTO fotos (usuario_id, nombre, archivo, tipo, bytes) VALUES (?, ?, ?, ?, ?)';
try {
    $pdo->prepare($sql)->execute([$_SESSION['usuario_id'], $_SESSION['nombre'], $archivo, $tipo, $foto['size']]);
} catch (PDOException $error) {
    unlink($ruta);
    responder(500, ['error' => 'No se pudo registrar la foto en la base de datos.']);
}

responder(201, ['archivo' => $archivo, 'url' => 'subidas/' . $archivo]);
