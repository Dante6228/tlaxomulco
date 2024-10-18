<?php

require_once __DIR__ . "/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {
        $pdo = Conexion::connection();
        
        if (!$pdo) {
            throw new UnexpectedValueException("Error de conexión a la base de datos");
        }

        $query = "SELECT colonia.descripcion AS colonia, municipio.descripcion AS municipio, colonia.id AS id
                FROM colonia
                INNER JOIN municipio ON colonia.municipio_id = municipio.id";
        
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($resultados ?: []);

    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}
