<?php

require_once __DIR__ . "/../conexion.php";

$pdo = Conexion::connection();

if (!$pdo) {
    echo json_encode(['error' => 'Error de conexión a la base de datos']);
    exit();
}

$query = "SELECT id, descripcion FROM municipio";
$stmt = $pdo->query($query);
$municipios = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($municipios);
