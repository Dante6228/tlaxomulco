<?php

session_start();

if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
    header("Location: Index.php?mensaje=error");
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/inicio.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Inicio</title>
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
                <img src="img/usuario.png" alt="Foto de usuario">
            </a>
            <div class="saludo">
                <h2>Hola</h2>
                <p><?php echo $_SESSION["nombre"]?></p>
            </div>
        </div>
    </header>

    <main>
        <h1>¡Bienvenido <?php echo $_SESSION["nombre"]?>!</h1>
        <div class="master">
            <div class="cards">
                <div class="card">
                    <div class="icon">
                        <img src="img/user.png" alt="Icono de alumnos">
                    </div>
                    <div class="content">
                        <h3>Alumnos</h3>
                        <p>Crear alumno, importar excel, generar excel de importación, generar pdf/excel a partir de consulta de alumno o actualizar datos de alumno.</p>
                        <div class="link">
                            <a href="alumnos.php">ir allá</a>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="icon">
                        <img src="img/info.png" alt="Icono de alumnos">
                    </div>
                    <div class="content">
                        <h3>Datos</h3>
                        <p>Crear un nuevo dato o actualizar algún dato ya existente.</p>
                        <div class="link">
                            <a href="Datos.php">ir allá</a>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="icon">
                        <img src="img/search.png" alt="Icono de alumnos">
                    </div>
                    <div class="content">
                        <h3>Consulta específica</h3>
                        <p>Filtrar la búsqueda de alumnos a partir de algún dato específico.</p>
                        <div class="link">
                            <a href="consulta.php">ir allá</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="graphics">
                <section>
                    <div class="graphic">
                        <h3>Gráfica 1</h3>
                        <img src="img/graphic.png" alt="Gráfica de prueba">
                    </div>
                    <div class="graphic">
                        <h3>Gráfica 2</h3>
                        <img src="img/graphic.png" alt="Gráfica de prueba">
                    </div>
                </section>
                <section>
                    <div class="graphic">
                        <h3>Gráfica 3</h3>
                        <img src="img/graphic.png" alt="Gráfica de prueba">
                    </div>
                    <div class="graphic">
                        <h3>Gráfica 4</h3>
                        <img src="img/graphic.png" alt="Gráfica de prueba">
                    </div>
                </section>
            </div>
        </div>
    </main>
</body>
</html>
