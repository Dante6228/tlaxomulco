<?php

include_once __DIR__ . '/conexion.php';

$pdo = Conexion::connection();

if (!$pdo) {
    throw new UnexpectedValueException("Error de conexión a la base de datos");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
        $dato = $_POST['dato'];

        $query = "DELETE FROM $dato WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "Dato eliminado con éxito.";
        } else {
            echo "No se encontró el dato $dato con el ID " . $id;
        }
    } catch (\Throwable $th) {
        echo "Error al eliminar el dato: " . $th->getMessage();
    }
}
