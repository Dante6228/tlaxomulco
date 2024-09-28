<?php

session_start();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/inicio.css">
    <title>Página de Bienvenida</title>
</head>
<body>
    <header>
        <h1>Bienvenido <?php echo $_SESSION["usuario"]?></h1>
        <a href="usuario.php">
            <img src="img/usuario.png" alt="Cuenta de usuario">
        </a>
    </header>
    <main>
        <div class="links">
            <a href="Alumnos.html" class="btn alumno"> Alumnos </a>
            <a href="Datos.html" class="btn dato"> Datos </a>
            <a href="Consulta_especifica.html" class="btn consulta"> Consulta especifica </a>
        </div>
    </main>
</body>
</html>
