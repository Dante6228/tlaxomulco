<?php

require_once __DIR__ . "/conexion.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $usuario = $_POST["usuario"];
    $contraseña = $_POST["contraseña"];
    $inicio = iniciar($usuario,$contraseña);
    if ($inicio === 1){
        header("Location: ../index.php?mensaje=1");
        exit();
    } else{
        header("Location: ../index.php?mensaje=error");
        exit();
    }
} else{
    header("Location: ../index.php?mensaje=err1");
    exit();
}

function iniciar($usuario, $contrasena){
    try {
        $pdo = Conexion::connection();

        if (!$pdo) {
            throw new UnexpectedValueException("Error de conexión a la base de datos");
        }

        $query = "SELECT * FROM usuario WHERE usuario = :usuario AND contraseña = :contraseña";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':contraseña', $contrasena);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            session_start();
            $_SESSION["usuario"] = $row['usuario'];
            $_SESSION["contraseña"] = $row['contraseña'];
            return 1;
        }

    } catch (PDOException $e) {
        echo "Error en la consulta: " . $e->getMessage();
    }
}
