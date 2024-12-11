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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Consulta específica</title>
</head>
<body>
    <header>
        <div class="logo">
            <img src="img/logo.png" alt="Logo del instituto Tlaxomulco">
            <h1>Instituto Tlaxomulco</h1>
        </div>
        <nav>
            <ul>
                <li><a href="Bienvenida.php">Inicio</a></li>
                <li><a href="alumnos.php">Alumnos</a></li>
                <li><a href="Datos.php">Datos</a></li>
                <li><a href="consulta.php">Consulta específica</a></li>
            </ul>
        </nav>
        <div class="saludoContainer">
            <a href="usuario.php">
                <img src="<?php echo $_SESSION['picture']; ?>" alt="Foto de usuario">
            </a>
            <div class="saludo">
                <h2>Hola</h2>
                <p><?php echo $_SESSION["nombre"]?></p>
            </div>
        </div>
    </header>
    <main>
        <section>
            <div class="card">
                <div class="icon">
                    <img src="img/campaña.png" alt="Icono de información">
                </div>
                <div class="content">
                    <h3>Consulta por medio enterado</h3>
                    <p>Filtra los datos de los alumnos según cómo se enteraron del instituto.</p>
                    <div class="links">
                        <a href="consulta/medio.php">Ir allá</a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="icon">
                    <img src="img/person.png" alt="Icono de información">
                </div>
                <div class="content">
                    <h3>Consulta por estado del alumno</h3>
                    <p>Filtra los datos de los alumnos según el estado del mismo.</p>
                    <div class="links">
                        <a href="consulta/estado.php">Ir allá</a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="icon">
                    <img src="img/location.png" alt="Icono de información">
                </div>
                <div class="content">
                    <h3>Consulta por colonia</h3>
                    <p>Filtra los datos de los alumnos según la colonia en la que viven.</p>
                    <div class="links">
                        <a href="consulta/colonia.php">Ir allá</a>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="card">
                <div class="icon">
                    <img src="img/global.png" alt="Icono de información">
                </div>
                <div class="content">
                    <h3>Consulta por municipio</h3>
                    <p>Filtra los datos de los alumnos según el municipio en el que que viven.</p>
                    <div class="links">
                        <a href="consulta/municipio.php">Ir allá</a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="icon">
                    <img src="img/tag.png" alt="Icono de información">
                </div>
                <div class="content">
                    <h3>Consulta por promoción</h3>
                    <p>Filtra los datos de los alumnos según la promoción que tienen.</p>
                    <div class="links">
                        <a href="consulta/promocion.php">Ir allá</a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="icon">
                    <img src="img/genero.png" alt="Icono de información">
                </div>
                <div class="content">
                    <h3>Consulta por género</h3>
                    <p>Filtra los datos de los alumnos según el género al que pertenecen.</p>
                    <div class="links">
                        <a href="consulta/genero.php">Ir allá</a>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
