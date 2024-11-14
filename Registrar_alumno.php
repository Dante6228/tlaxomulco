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

function generarOpciones($tabla, $pdo) {
    $stmt = $pdo->query("SELECT * FROM $tabla");
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($resultados as $row) {
        echo "<option value='" . $row['id'] . "'>" . $row['descripcion'] . "</option>";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/registrarAlumno.css">
    <link rel="stylesheet" href="css/header.css">
    <title>Registrar nuevo Alumno</title>
</head>
<body>

    <header>
        <h1>Registrar alumno</h1>
        <a href="alumnos.php" class="botonInicio">Regresar</a>
        <a href="usuario.php">
            <img src="img/usuario.png" alt="Cuenta de usuario">
        </a>
    </header>

        <?php if (isset($_GET["mensaje"]) && $_GET["mensaje"] == "matricula") { ?>
            <div class="error-message" style="margin-top: 20px;">
                <p>¡La matricula ya está registrada!</p>
            </div>
        <?php } ?>
    
    <div class="container">
        <form action="php/alumnos/registrarAlumno.php" method="POST">
            <div id="nombre-error"></div>
            <div id="matricula-error"></div>
            <div id="error-general"></div>
            <div class="form-group">
                <label for="nombre">Nombre completo</label>
                <input type="text" id="nombre" name="nombre" placeholder="Nombre(s)" required>
                <input type="text" id="ap" name="ap" placeholder="Apellido Paterno" required>
                <input type="text" id="am" name="am" placeholder="Apellido Materno" required>
            </div>
            <div class="form-group">
                <label for="matricula">Matrícula</label>
                <input type="text" id="matricula" name="matricula" placeholder="0000" required>
            </div>
            <div class="form-group">
                <label for="genero">Género</label>
                <select name="genero" id="genero" onchange="limpiarSelect('genero')" required>
                    <option value="">Selecciona un genero</option>
                    <?php
                        generarOpciones('genero', $pdo);
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="medio_enterado">Medio Enterado</label>
                <select name="medio_enterado" id="medio_enterado" onchange="limpiarSelect('medio_enterado')" required>
                    <option value="">Selecciona un medio</option>
                    <?php
                        generarOpciones('medio_enterado', $pdo);
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="ciclo">Ciclo escolar</label>
                <select name="ciclo" id="ciclo" onchange="limpiarSelect('ciclo')" required>
                    <option value="">Selecciona un ciclo escolar</option>
                    <?php
                        generarOpciones('ciclo', $pdo);
                    ?>
                </select>
            </div>
            <div class="group-1">
                <div class="form-group">
                    <label for="nivel_escolar">Nivel Escolar</label>
                    <select name="nivel_escolar" id="nivel_escolar" onchange="cargarGrados()" required>
                        <option value="">Selecciona un nivel escolar</option">
                        <?php
                            generarOpciones('nivel_educativo', $pdo);
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="grado">Grado</label>
                    <select name="grado" id="grado" onchange="limpiarSelect('grado')" required>
                        <option value="">Selecciona un nivel escolar primero</option>
                    </select>
                </div>
            </div>
            <div class="group-1">
                <div class="form-group">
                    <label for="municipio">Municipio</label>
                    <select name="municipio" id="municipio" onchange="cargarColonias()" required>
                        <option value="">Selecciona un municipio</option>
                        <?php
                            generarOpciones('municipio', $pdo);
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="colonia">Colonia</label>
                    <select name="colonia" id="colonia" onchange="limpiarSelect('colonia')" required>
                        <option value="">Selecciona un municipio primero</option>
                    </select>
                </div>
                
            </div>
            <div class="group-1">
                <div class="form-group">
                    <label for="estado">Estado</label>
                    <select name="estado" id="estado" onchange="limpiarSelect('estado')" required>
                        <option value="">Selecciona un estado</option>
                        <?php
                            generarOpciones('estado', $pdo);
                        ?>
                    </select>
                </div>
                <div class="form-group">
                <label for="promocion">Promoción</label>
                <select name="promocion" id="promocion" onchange="limpiarSelect('promocion')" required>
                    <option value="">Selecciona una promoción</option>
                    <?php
                        generarOpciones('promocion', $pdo);
                    ?>
                </select>
                </div>
            </div>
            <button type="submit" class="submit-btn">Registrar</button>
        </form>
    </div>

    <script src="js/registrarAlumno.js"></script>

</body>
</html>
