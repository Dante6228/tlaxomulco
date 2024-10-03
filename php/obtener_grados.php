<?php

require_once __DIR__ . "/conexion.php";

$pdo = Conexion::connection();

if (!$pdo) {
    throw new UnexpectedValueException("Error de conexión a la base de datos");
}

if (isset($_POST['nivelEducativoId'])) {
    $nivelEducativoId = $_POST['nivelEducativoId'];

    $query = "SELECT id, descripcion FROM grado WHERE nivel_educativo_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$nivelEducativoId]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $options = "<option value=''>Selecciona un grado</option>";
    foreach ($result as $row) {
        $options .= "<option value='" . $row['id'] . "'>" . $row['descripcion'] . "</option>";
    }

    echo $options;
}
