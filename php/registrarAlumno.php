<?php

require_once __DIR__ . "/conexion.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nombre = $_POST["nombre"];
    $ap = $_POST["ap"];
    $am = $_POST["am"];
    $matricula = $_POST["matricula"];
    $genero = $_POST["genero"];
    $nivel_escolar = $_POST["nivel_escolar"];
    $grado = $_POST["grado"];
    $municipio = $_POST["municipio"];
    $colonia = $_POST["colonia"];
    $medio_enterado = $_POST["medio_enterado"];
    $promocion = $_POST["promocion"];

    $datos_personales = [$nombre, $ap, $am, $matricula, $genero];
    $direccion = [$municipio, $colonia];
    $extra_info = [$nivel_escolar, $grado, $medio_enterado, $promocion];

    registrar($datos_personales, $direccion, $extra_info);

} else {
    header("Location: ../index.php?mensaje=err1");
    exit();
}

function registrar($datos_personales, $direccion, $extra_info) {
    try {
        $pdo = Conexion::connection();

        if (!$pdo) {
            throw new UnexpectedValueException("Error en la conexión a la base de datos");
        }

        $stmt = $pdo->prepare("INSERT INTO alumno (nombre, Ap, Am, matricula, genero, nivel, grado_id, municipio, colonia, medio_enterado, promocion) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        
        $stmt->execute(array_merge($datos_personales, $direccion, $extra_info));

        header("Location: ../alumnos.php?mensaje=registro");
        exit();
    } catch (\Throwable $th) {
        echo "Error al registrar al alumno: " . $th->getMessage();
        exit();
    }
}

