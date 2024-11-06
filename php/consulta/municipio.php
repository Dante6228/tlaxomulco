<?php

require_once __DIR__ . "/../conexion.php";

$pdo = Conexion::connection();

if (!$pdo) {
    throw new UnexpectedValueException("Error de conexión a la base de datos");
}

if (isset($_POST['nivelEducativoId'], $_POST['gradoId'], $_POST['cicloId'], $_POST['municipioId'])) {
    
    $nivelEducativoId = $_POST['nivelEducativoId'];
    $gradoId = $_POST['gradoId'];
    $cicloId = $_POST['cicloId'];
    $municipioId = $_POST['municipioId'];

    $query = "SELECT
        a.id,
        a.nombre,
        a.Ap,
        a.Am,
        a.matricula,
        mu.descripcion AS municipio,
        g.descripcion AS genero,
        co.descripcion AS colonia,
        me.descripcion AS medio_enterado,
        p.descripcion AS promocion,
        e.descripcion AS estado_alumno,
        ngc.id AS nivel_grado_ciclo_id
    FROM alumno a
    JOIN nivel_grado_ciclo ngc ON a.nivel_grado_ciclo_id = ngc.id
    LEFT JOIN municipio mu ON a.municipio = mu.id
    LEFT JOIN genero g ON a.genero = g.id
    LEFT JOIN colonia co ON a.colonia = co.id
    LEFT JOIN medio_enterado me ON a.medio_enterado = me.id
    LEFT JOIN promocion p ON a.promocion = p.id
    LEFT JOIN estado e ON a.estado = e.id
    WHERE ngc.nivel_educativo_id = ?
    AND ngc.grado_id = ?
    AND ngc.ciclo_id = ?
    AND a.municipio = ?";

    $stmt = $pdo->prepare($query);
    $stmt->execute([$nivelEducativoId, $gradoId, $cicloId, $municipioId]);
    
    $alumnos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($alumnos);
}
