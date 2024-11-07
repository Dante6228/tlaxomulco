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
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/registrar_dato.css">
    <title>Registrar dato</title>
</head>
<body>
    <header>
        <h1>Registrar nuevo dato</h1>
        <a href="Datos.php" class="botonInicio">Regresar</a>
        <a href="usuario.php"><img src="img/usuario.png" alt="Perfil"></a>
    </header>

    <main>
    <div class="container1">
        <form onchange="actualizarFormulario()">
            <ul>
                <div class="div">
                    <li>
                        <input type="radio" id="estado" name="opcion" value="estado" checked>
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
                </div>
                <div class="div">
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
                </div>
            </ul>
        </form>
    </div>

        <div class="container2">
            <strong>Selecciona alguna opción</strong>
        </div>
    </main>

    <script src="js/registrar_dato.js"></script>
</body>
</html>
