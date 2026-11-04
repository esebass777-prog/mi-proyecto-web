<?php
require 'conexion.php';

$pdo->exec("
CREATE TABLE IF NOT EXISTS ubicaciones (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id  INT           NULL,
    nombre      VARCHAR(100)  NOT NULL,
    latitud     DECIMAL(9, 6) NOT NULL,
    longitud    DECIMAL(9, 6) NOT NULL,
    precision_m INT UNSIGNED  NOT NULL,
    creado_en   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

echo 'Tabla ubicaciones creada correctamente.';