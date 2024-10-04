<?php

require_once __DIR__ . "/conexion.php";

$pdo = Conexion::connection();

if (!$pdo) {
    throw new UnexpectedValueException("Error de conexión a la base de datos");
}

if (isset($_POST['gradoId'])) {
    $gradoId = $_POST['gradoId'];

    $query = "SELECT ciclo.id, ciclo.descripcion
                FROM nivel_grado_ciclo AS ngc
                JOIN ciclo ON ngc.ciclo_id = ciclo.id
                WHERE ngc.grado_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$gradoId]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $options = "";
    
    foreach ($result as $row) {
        $options .= "<option value='" . $row['id'] . "'>" . $row['descripcion'] . "</option>";
    }

    echo $options;
}
