<?php
// Servicio que RECIBE una ubicación:  POST api/guardar.php  (cuerpo JSON)

require __DIR__ . '/../../conexion.php';
header('Content-Type: application/json; charset=utf-8');

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

// fetch manda JSON, no un formulario: por eso se lee el cuerpo crudo.
$datos = json_decode(file_get_contents('php://input'), true);
$lat   = $datos['latitud'] ?? null;
$lng   = $datos['longitud'] ?? null;

// Nunca confiar en el cliente.
if (!is_numeric($lat) || !is_numeric($lng)
    || $lat < -90 || $lat > 90 || $lng < -180 || $lng > 180) {
    responder(400, ['error' => 'Coordenadas inválidas.']);
}

$precision = max(0, min(100000, (int) round((float) ($datos['precision'] ?? 0))));

// El usuario lo decide el SERVIDOR con la sesión de PHP.
$usuarioId = $_SESSION['usuario_id'];

$sql = 'INSERT INTO ubicaciones (usuario_id, nombre, latitud, longitud, precision_m)
        VALUES (?, ?, ?, ?, ?)';
$pdo->prepare($sql)->execute([$usuarioId, $_SESSION['nombre'], $lat, $lng, $precision]);

responder(201, ['id' => (int) $pdo->lastInsertId()]);