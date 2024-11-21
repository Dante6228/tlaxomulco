<?php

require_once __DIR__ . "/../conexion.php";

$pdo = Conexion::connection();

if (!$pdo) {
    throw new UnexpectedValueException("Error de conexión a la base de datos");
}

if (isset($_POST['matricula'])) {
    $matricula = $_POST['matricula'];

    $query = "SELECT * FROM alumno WHERE matricula = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$matricula]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo "La matrícula ya existe";
    } else {
        echo "La matrícula es válida";
    }
}
