<?php
require 'conexion.php';

$pdo->exec("
CREATE TABLE IF NOT EXISTS fotos (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT          NULL,
    nombre     VARCHAR(100) NOT NULL,
    archivo    VARCHAR(150) NOT NULL UNIQUE,
    tipo       VARCHAR(20)  NOT NULL,
    bytes      INT UNSIGNED NOT NULL,
    creado_en  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

echo 'Tabla fotos creada correctamente.';
