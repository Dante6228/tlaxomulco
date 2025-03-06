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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Registrar nuevo Alumno</title>
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
    
    <div class="container">
        <form action="php/alumnos/registrarAlumno.php" method="POST">
            <div id="nombre-error"></div>
            <div id="matricula-error"></div>
            <div id="matricula-error2"></div>
            <div id="error-general"></div>
            <div class="form-group">
                <a href="alumnos.php" id="regresar">Regresar</a>
            </div>
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
    <script src="js/theme.js"></script>

</body>
</html>
