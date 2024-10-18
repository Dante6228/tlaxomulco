<?php

require_once __DIR__ . "/../conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {
        $pdo = Conexion::connection();
        
        if (!$pdo) {
            throw new UnexpectedValueException("Error de conexión a la base de datos");
        }

        $query = "SELECT grado.descripcion AS grado, nivel_educativo.descripcion AS nivel_educativo, grado.id AS id
                FROM grado
                INNER JOIN nivel_educativo ON grado.nivel_educativo_id = nivel_educativo.id";
        
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($resultados ?: []);

    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}
