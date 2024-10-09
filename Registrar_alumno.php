<?php

require_once __DIR__ . "/php/conexion.php";

$pdo = Conexion::connection();

if (!$pdo) {
    throw new UnexpectedValueException("Error de conexión a la base de datos");
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/registrarAlumno.css">
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

    <div class="container">
        <form action="registrarAlumno.php" method="POST">
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
                <label for="genero">Género:</label>
                <select name="genero" id="genero" required>
                    <option value="1">Masculino</option>
                    <option value="2">Femenino</option>
                    <option value="3">Otro</option>
                </select>
            </div>
            <div class="group-1">
                <div class="form-group">
                    <label for="nivel_escolar">Nivel Escolar</label>
                    <select name="nivel_escolar" id="nivel_escolar" onchange="cargarGrados()" required>
                        <option value="">Selecciona un nivel escolar</option">
                        <?php
                            $stmt = $pdo->query("SELECT * FROM nivel_educativo");
                            $niveles = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($niveles as $nivel) {
                                echo "<option value='". $nivel['id']. "'>". $nivel['descripcion']. "</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="grado">Grado</label>
                    <select id="grado" required>
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
                            $stmt = $pdo->query("SELECT * FROM municipio");
                            $municipios = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($municipios as $municipio) {
                                echo "<option value='". $municipio['id']. "'>". $municipio['descripcion']. "</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="colonia">Colonia</label>
                    <select name="colonia" id="colonia" required>
                        <option value="">Selecciona un municipio primero</option>
                    </select>
                </div>
                
            </div>
            <div class="form-group">
                <label for="medio_enterado">Medio Enterado</label>
                <select name="medio_enterado" id="medio_enterado" required>
                    <?php
                        $stmt = $pdo->query("SELECT * FROM medio_enterado");
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) {
                            echo "<option value='" . $row['id'] . "'>" . $row['descripcion'] . "</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="promocion">Promoción</label>
                <select name="promocion" id="promocion" required>
                    <?php
                        $stmt = $pdo->query("SELECT * FROM promocion");
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) {
                            echo "<option value='" . $row['id'] . "'>" . $row['descripcion'] . "</option>";
                        }
                    ?>
                </select>
            </div>
            <button type="submit" class="submit-btn">Registrar</button>
        </form>
    </div>

    <script src="js/registrarAlumno.js"></script>

</body>
</html>
