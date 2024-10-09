<?php

require_once __DIR__ . "/conexion.php";

$pdo = Conexion::connection();

if (!$pdo) {
    throw new UnexpectedValueException("Error de conexión a la base de datos");
}

if (isset($_POST['municipio'])) {
    $municipio = $_POST['municipio'];

    $query = "SELECT id, descripcion FROM colonia WHERE municipio_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$municipio]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $options = "<option value=''>Selecciona una colonia</option>";
    
    foreach ($result as $row) {
        $options .= "<option value='" . $row['id'] . "'>" . $row['descripcion'] . "</option>";
    }

    echo $options;
}
