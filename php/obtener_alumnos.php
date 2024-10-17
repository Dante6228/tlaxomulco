<?php

require_once __DIR__ . "/conexion.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$pdo = Conexion::connection();

if (!$pdo) {
    throw new UnexpectedValueException("Error de conexión a la base de datos");
}

if (isset($_POST['nivelEducativoId'], $_POST['gradoId'], $_POST['cicloId'])) {
    
    $nivelEducativoId = $_POST['nivelEducativoId'];
    $gradoId = $_POST['gradoId'];
    $cicloId = $_POST['cicloId'];

    // Se incluye ngc.id para recuperar el nivel_grado_ciclo_id
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
        ngc.id AS nivel_grado_ciclo_id  -- Agregado aquí
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
    AND ngc.ciclo_id = ?";

    $stmt = $pdo->prepare($query);
    $stmt->execute([$nivelEducativoId, $gradoId, $cicloId]);
    
    $alumnos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($alumnos);
}
