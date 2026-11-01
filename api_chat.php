<?php
require 'conexion.php';
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado.']);
    exit;
}

$miId     = (int) $_SESSION['usuario_id'];
$miNombre = $_SESSION['nombre'];
session_write_close();

// Enviar mensaje
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = json_decode(file_get_contents('php://input'), true) ?: [];
    $texto = trim((string) ($datos['texto'] ?? ''));

    if ($texto === '' || mb_strlen($texto) > 500) {
        http_response_code(400);
        echo json_encode(['error' => 'El mensaje es obligatorio y máximo de 500 caracteres.']);
        exit;
    }

    $stmt = $pdo->prepare('INSERT INTO mensajes_chat (usuario_id, usuario, texto) VALUES (?, ?, ?)');
    $stmt->execute([$miId, $miNombre, $texto]);

    http_response_code(201);
    echo json_encode(['ok' => true]);
    exit;
}

// Consultar mensajes nuevos
$desde = (int) ($_GET['desde'] ?? 0);

$stmt = $pdo->prepare(
    'SELECT id, usuario_id, usuario, texto, UNIX_TIMESTAMP(fecha) AS ts
     FROM mensajes_chat WHERE id > ? ORDER BY id DESC LIMIT 200'
);
$stmt->execute([$desde]);
$mensajes = array_reverse($stmt->fetchAll(PDO::FETCH_ASSOC));

foreach ($mensajes as &$m) {
    $m['id']     = (int) $m['id'];
    $m['ts']     = (int) $m['ts'];
    $m['propio'] = ((int) $m['usuario_id'] === $miId);
    unset($m['usuario_id']);
}

echo json_encode($mensajes);