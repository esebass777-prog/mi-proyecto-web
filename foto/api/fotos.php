<?php
// Servicio que ENTREGA la lista de fotos:  GET api/fotos.php  → JSON

require __DIR__ . '/../../conexion.php';
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Inicia sesión.']);
    exit;
}

$fotos = $pdo->query('SELECT nombre, archivo FROM fotos ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(array_map(fn($foto) => [
    'url'     => 'subidas/' . $foto['archivo'],
    'usuario' => $foto['nombre'],
], $fotos));
