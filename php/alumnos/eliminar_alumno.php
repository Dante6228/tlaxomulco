<?php

include_once __DIR__ . '/../conexion.php';

$pdo = Conexion::connection();

if (!$pdo) {
    throw new UnexpectedValueException("Error de conexión a la base de datos");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $id = $_POST['id'];
        
        // Esto es un pedazo de codigo que funciona solo si tenemos la tabla "registro" hecha
        // $deleteRegistroQuery = "DELETE FROM registro WHERE alumno = :id";
        // $deleteStmt = $pdo->prepare($deleteRegistroQuery);
        // $deleteStmt->bindParam(':id', $id);
        // $deleteStmt->execute();

        $query = "DELETE FROM alumno WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

    
        if ($stmt->rowCount() > 0) {
            echo "Alumno eliminado con éxito.";
        } else{
            echo "No se encontró al alumno con el ID ". $id;
        }
    } catch (\Throwable $th) {
        echo "Error al eliminar al alumno: " . $th->getMessage();
    }
}
