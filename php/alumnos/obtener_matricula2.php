<?php

require_once __DIR__ . "/../conexion.php";

$pdo = Conexion::connection();

if (!$pdo) {
    throw new UnexpectedValueException("Error de conexión a la base de datos");
}

if (isset($_POST['matricula']) && isset($_POST['excluir'])) {
    $matricula = $_POST['matricula'];
    $excluir = $_POST['excluir'];

    $query = "SELECT COUNT(*) as total FROM alumno WHERE matricula = ? AND matricula != ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$matricula, $excluir]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['total'] > 0) {
        echo "ya existe";
    } else {
        echo "es valida";
    }
} else {
    echo "Error: Faltan datos.";
}

