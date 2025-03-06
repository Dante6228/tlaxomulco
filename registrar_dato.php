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
    <link rel="stylesheet" href="css/registrar_dato.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Registrar dato</title>
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
            <div class="container1">
                <form onchange="actualizarFormulario()">
                    <ul>
                        <li>
                            <input type="radio" id="estado" name="opcion" value="estado">
                            <label for="estado" class="radio-label"></label>
                            <span>Estado del alumno</span>
                        </li>
                        <li>
                            <input type="radio" id="colonia" name="opcion" value="colonia">
                            <label for="colonia" class="radio-label"></label>
                            <span>Colonia</span>
                        </li>
                        <li>
                            <input type="radio" id="municipio" name="opcion" value="municipio">
                            <label for="municipio" class="radio-label"></label>
                            <span>Municipio</span>
                        </li>
                        <li>
                            <input type="radio" id="ciclo" name="opcion" value="ciclo">
                            <label for="ciclo" class="radio-label"></label>
                            <span>Ciclo escolar</span>
                        </li>
                        <li>
                            <input type="radio" id="promocion" name="opcion" value="promocion">
                            <label for="promocion" class="radio-label"></label>
                            <span>Promoción</span>
                        </li>
                        <li>
                            <input type="radio" id="medio" name="opcion" value="medio">
                            <label for="medio" class="radio-label"></label>
                            <span>Medio de enterado</span>
                        </li>
                        <li>
                            <input type="radio" id="genero" name="opcion" value="genero">
                            <label for="genero" class="radio-label"></label>
                            <span>Género</span>
                        </li>
                    </ul>
                </form>
            </div>
    
            <div class="container2">
                <strong>Selecciona alguna opción</strong>
            </div>
        </section>
        <a href="Datos.php" id="regresar">Regresar</a>
    </main>

    <script src="js/registrar_dato.js"></script>
    <script src="js/theme.js"></script>
</body>
</html>
