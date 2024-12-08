<?php

require_once __DIR__ . "/php/conexion.php";

session_start();

if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
    header("Location: Index.php?mensaje=error");
    exit();
}

$pdo = Conexion::connection();

if (!$pdo) {
    throw new UnexpectedValueException("Error de conexión a la base de datos");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/consulta.css">
    <link rel="stylesheet" href="css/header.css">
    <title>Consulta específica</title>
</head>
<body>
    <header>
        <h1>Consulta específica</h1>
        <a href="Bienvenida.php" class="botonInicio">Inicio</a>
        <a href="usuario.php"><img src="img/usuario.png" alt="Perfil"></a>
    </header>
    <main>
        <div class="links">
            <a href="consulta/medio.php"> Consulta por medio enterado </a>
            <a href="consulta/estado.php"> Consulta por estado </a>
            <a href="consulta/colonia.php"> Consulta por colonia </a>
            <a href="consulta/municipio.php"> Consulta por municipio </a>
            <a href="consulta/promocion.php"> Consulta por promoción </a>
            <a href="consulta/genero.php"> Consulta por género </a>
        </div>
    </main>
</body>
</html>
