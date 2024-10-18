<?php

require_once __DIR__ . "/../conexion.php";

session_start();

if ($_SESSION["usuario"] === "") {
    header("Location: ../../index.php?mensaje=error");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST["usuario"];
    $contrasena = $_POST["contrasena"];
    $idUsuario = $_SESSION["idUsuario"];
    $actualizacion = actualizarUsuario($usuario, $contrasena, $idUsuario);
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

function actualizarUsuario($usuario, $contrasena, $idUsuario) {
    try {
        $pdo = Conexion::connection();

        if (!$pdo) {
            throw new UnexpectedValueException("Error de conexión a la base de datos");
        }

        $query = "UPDATE usuario SET contraseña = :contrasena, usuario = :usuario WHERE id = :id";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":contrasena", $contrasena);
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

