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
                            <label>
                                <input type="radio" name="opcion" value="estado" checked>
                                Estado del alumno
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="radio" name="opcion" value="colonia">
                                Colonia
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="radio" name="opcion" value="municipio">
                                Municipio
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="radio" name="opcion" value="ciclo">
                                Ciclo escolar
                            </label>
                        </li>
                    </div>
                    <div class="div">
                        <li>
                            <label>
                                <input type="radio" name="opcion" value="promocion">
                                Promoción
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="radio" name="opcion" value="medio">
                                Medio de enterado
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="radio" name="opcion" value="genero">
                                Género
                            </label>
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
