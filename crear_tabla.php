<?php
require 'conexion.php';

$pdo->exec("
CREATE TABLE IF NOT EXISTS eventos (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    visitante_id CHAR(36)    NOT NULL,
    sesion_id    CHAR(36)    NOT NULL,
    usuario_id   INT         NULL,
    tipo         ENUM('vista', 'clic', 'tiempo') NOT NULL,
    pagina       VARCHAR(200) NOT NULL,
    elemento     VARCHAR(100) NULL,
    segundos     SMALLINT UNSIGNED NULL,
    creado_en    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX (visitante_id),
    INDEX (sesion_id)
)");

echo 'Tabla eventos creada correctamente.';