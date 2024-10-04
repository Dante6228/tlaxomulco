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

    // Modificación en la consulta
    $query = "
        SELECT a.nombre, a.matricula
        FROM alumno a
        JOIN nivel_grado_ciclo ngc ON a.grado_id = ngc.grado_id
        WHERE a.nivel = ? AND a.grado_id = ? AND ngc.ciclo_id = ?";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute([$nivelEducativoId, $gradoId, $cicloId]);
    
    $alumnos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($alumnos);
}

