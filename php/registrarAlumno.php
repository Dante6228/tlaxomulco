<?php

require_once __DIR__ . "/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $datos = [
        'nombre' => $_POST["nombre"],
        'ap' => $_POST["ap"],
        'am' => $_POST["am"],
        'matricula' => $_POST["matricula"],
        'genero' => $_POST["genero"],
        'estado' => $_POST["estado"],
        'nivel_escolar' => $_POST["nivel_escolar"],
        'grado' => $_POST["grado"],
        'municipio' => $_POST["municipio"],
        'colonia' => $_POST["colonia"],
        'medio_enterado' => $_POST["medio_enterado"],
        'promocion' => $_POST["promocion"]
    ];

    registrar($datos);

} else {
    header("Location: ../index.php?mensaje=err1");
    exit();
}

function registrar($datos) {
    try {
        $pdo = Conexion::connection();

        if (!$pdo) {
            throw new UnexpectedValueException("Error en la conexión a la base de datos");
        }

        $stmt = $pdo->prepare("INSERT INTO alumno (nombre, Ap, Am, matricula, genero, estado, nivel, grado_id, municipio, colonia, medio_enterado, promocion) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");

        $stmt->execute([
            $datos['nombre'],
            $datos['ap'],
            $datos['am'],
            $datos['matricula'],
            $datos['genero'],
            $datos['estado'],
            $datos['nivel_escolar'],
            $datos['grado'],
            $datos['municipio'],
            $datos['colonia'],
            $datos['medio_enterado'],
            $datos['promocion']
        ]);

        header("Location: ../alumnos.php?mensaje=registro");
        exit();
    } catch (\Throwable $th) {
        echo "Error al registrar al alumno: " . $th->getMessage();
        exit();
    }
}
