<?php

require_once __DIR__ . "/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dato = $_POST["dato"];

    try {
        $pdo = Conexion::connection();
        
        if (!$pdo) {
            throw new UnexpectedValueException("Error de conexión a la base de datos");
        }

        $query = "SELECT * FROM $dato";
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($resultados);

    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}

