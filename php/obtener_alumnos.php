<?php

require_once __DIR__ . "/conexion.php";

$pdo = Conexion::connection();

if (!$pdo) {
    throw new UnexpectedValueException("Error de conexión a la base de datos");
}

if (isset($_POST['nivelEducativoId'], $_POST['gradoId'], $_POST['cicloId'])) {
    $nivelEducativoId = $_POST['nivelEducativoId'];
    $gradoId = $_POST['gradoId'];
    $cicloId = $_POST['cicloId'];

    $query = " SELECT a.nombre, a.matricula
        FROM alumno a
        JOIN nivel_grado_ciclo ngc ON a.nivel_grado_ciclo_id = ngc.id
        WHERE ngc.nivel_educativo_id = ? AND ngc.grado_id = ? AND ngc.ciclo_id = ?";

    
    $stmt = $pdo->prepare($query);
    $stmt->execute([$nivelEducativoId, $gradoId, $cicloId]);
    
    $alumnos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($alumnos);
}

