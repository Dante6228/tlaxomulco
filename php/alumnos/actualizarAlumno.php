<?php

require_once __DIR__ . "/../conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $datos = [
        'id' => $_POST["id"],
        'nombre' => $_POST["nombre"],
        'ap' => $_POST["ap"],
        'am' => $_POST["am"],
        'matricula' => $_POST["matricula"],
        'genero' => $_POST["genero"],
        'estado' => $_POST["estado"],
        'nivel_escolar' => $_POST["nivel_escolar"],
        'grado' => $_POST["grado"],
        'ciclo' => $_POST["ciclo"],
        'municipio' => $_POST["municipio"],
        'colonia' => $_POST["colonia"],
        'medio_enterado' => $_POST["medio_enterado"],
        'promocion' => $_POST["promocion"]
    ];

    actualizar($datos);

} else {
    header("Location: ../../index.php?mensaje=err1");
    exit();
}

function obtenerNivelGradoCicloId($pdo, $nivel_escolar, $grado, $ciclo) {
    try {
        $stmt = $pdo->prepare("SELECT id FROM nivel_grado_ciclo WHERE nivel_educativo_id = ? AND grado_id = ? AND ciclo_id = ?");
        $stmt->execute([$nivel_escolar, $grado, $ciclo]);
        $nivelGradoCiclo = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($nivelGradoCiclo) {
            return $nivelGradoCiclo['id'];
        }
    } catch (\Throwable $th) {
        echo "Error al obtener el id de nivelGradoCiclo del registro: " . $th->getMessage();
        exit();
    }
    
}

function actualizar($datos) {
    try {
        $pdo = Conexion::connection();

        if (!$pdo) {
            throw new UnexpectedValueException("Error en la conexión a la base de datos");
        }

        $nivelGradoCicloId = obtenerNivelGradoCicloId($pdo, $datos['nivel_escolar'], $datos['grado'], $datos['ciclo']);

        $stmt = $pdo->prepare("INSERT INTO alumno (nombre, Ap, Am, matricula, genero, estado, nivel_grado_ciclo_id, municipio, colonia, medio_enterado, promocion)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt = $pdo->prepare("UPDATE alumno SET
        nombre = ?,
        Ap = ?,
        Am = ?,
        matricula = ?,
        genero = ?,
        estado = ?,
        nivel_grado_ciclo_id = ?,
        municipio = ?,
        colonia = ?,
        medio_enterado = ?,
        promocion = ?
        WHERE id = ?");

        $stmt->execute([
        $datos['nombre'],
        $datos['ap'],
        $datos['am'],
        $datos['matricula'],
        $datos['genero'],
        $datos['estado'],
        $nivelGradoCicloId,
        $datos['municipio'],
        $datos['colonia'],
        $datos['medio_enterado'],
        $datos['promocion'],
        $datos['id']
        ]);

        header("Location: ../../alumnos.php?mensaje=actualizado");
        exit();
    } catch (\Throwable $th) {
        echo "Error al actualizar al alumno: " . $th->getMessage();
        exit();
    }
}
