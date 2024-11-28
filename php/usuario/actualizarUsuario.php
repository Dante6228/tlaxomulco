<?php

require_once __DIR__ . "/../conexion.php";

session_start();

if ($_SESSION["usuario"] === "") {
    header("Location: ../../index.php?mensaje=error");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST["nuevoUsuario"];
    $contrasena = $_POST["nuevaContraseña"];
    $nombre = $_POST["nuevoNombre"];
    $idUsuario = $_SESSION["idUsuario"];
    $actualizacion = actualizarUsuario($nombre, $usuario, $contrasena, $idUsuario);
    if ($actualizacion === 1) {
        header("Location: ../../usuario.php?mensaje=actualizacion");
        exit();
    } else{
        header("Location: ../../usuario.php?mensaje=error");
        exit();
    }
} else{
    header("Location: ../../index.php?mensaje=err1");
    exit();
}

function actualizarUsuario($nombre, $usuario, $contrasena, $idUsuario) {
    try {
        $pdo = Conexion::connection();

        if (!$pdo) {
            throw new UnexpectedValueException("Error de conexión a la base de datos");
        }

        $hashedPassword = password_hash($contrasena, PASSWORD_BCRYPT);

        $query = "UPDATE usuario SET nombre = :nombre, contraseña = :contrasena, usuario = :usuario WHERE id = :id";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":contrasena", $hashedPassword);
        $stmt->bindParam(":usuario", $usuario);
        $stmt->bindParam(":id", $idUsuario);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return 1;
        }

    } catch (Exception $e) {
        echo "Error en la actualización: " . $e->getMessage();
        exit();
    }
}

