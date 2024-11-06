<?php

include_once __DIR__ . '/php/conexion.php';

session_start();

if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
    header("Location: Index.php?mensaje=error");
    exit();
}

$pdo = Conexion::connection();

if (!$pdo) {
    throw new UnexpectedValueException("Error de conexión a la base de datos");
}

if (!$_SERVER["REQUEST_METHOD"] === "GET") {
    header("Location: ../index.php?mensaje=err1");
    exit();
} else{
    try {
        $id = $_GET['id'];
        $stmt = $pdo->prepare(
            "SELECT a.*,
                    g.descripcion as genero_descripcion,
                    me.descripcion as medio_descripcion,
                    mu.descripcion as municipio_descripcion,
                    col.descripcion as colonia_descripcion,
                    e.descripcion as estado_descripcion,
                    p.descripcion as promocion_descripcion
            FROM alumno a
            INNER JOIN genero g ON a.genero = g.id
            INNER JOIN medio_enterado me ON a.medio_enterado = me.id
            INNER JOIN municipio mu ON a.municipio = mu.id
            INNER JOIN colonia col ON a.colonia = col.id
            INNER JOIN estado e ON a.estado = e.id
            INNER JOIN promocion p ON a.promocion = p.id
            WHERE a.id = :id"
        );
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $alumno = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$alumno) {
            die("No se encontró el alumno con el ID: $id");
        }
    } catch (\Throwable $th) {
        echo "Error: ". $th->getMessage();
        exit();
    }

    try {
        $stmt = $pdo->prepare(
            "SELECT ngc.id as nivel_grado_ciclo_id,
                    c.id as ciclo_id,
                    n.id as nivel_educativo_id,
                    g.id as grado_id,
                    c.descripcion as ciclo_descripcion,
                    n.descripcion as nivel_descripcion,
                    g.descripcion as grado_descripcion
            FROM nivel_grado_ciclo ngc
            INNER JOIN ciclo c ON ngc.ciclo_id = c.id
            INNER JOIN nivel_educativo n ON ngc.nivel_educativo_id = n.id
            INNER JOIN grado g ON ngc.grado_id = g.id
            WHERE ngc.id = :id"
        );
        $stmt->bindParam(':id', $alumno['nivel_grado_ciclo_id']);
        $stmt->execute();
        $nivel_grado_ciclo = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$nivel_grado_ciclo) {
            die("No se encontró el nivel grado ciclo con el ID: " . $alumno['nivel_grado_ciclo_id']);
        }
    } catch (\Throwable $th) {
        echo "Error: ". $th->getMessage();
        exit();
    }
}

function generarOpciones($tabla, $pdo, $valorSeleccionado = null) {
    $stmt = $pdo->query("SELECT * FROM $tabla");
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($resultados as $row) {
        if ($row['id'] != $valorSeleccionado) {
            echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['descripcion']) . "</option>";
        }
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
    <title>Actualizar alumno</title>
</head>
<body>
    <header>
        <h1>Actualizar alumno <?php echo htmlspecialchars($alumno['nombre']); ?></h1>
        <?php
            switch ($_GET['from']){
                case '0':
                    echo "<a href='alumnos.php' class='botonInicio'>Regresar</a>";
                    break;
                case '1':
                    echo "<a href='consulta/medio.php' class='botonInicio'>Regresar</a>";
                    break;
                case '2':
                    echo "<a href='consulta/estado.php' class='botonInicio'>Regresar</a>";
                    break;
                default:
                    echo "Error inesperado";
                    break;
            }
        ?>
        <a href="usuario.php">
            <img src="img/usuario.png" alt="Cuenta de usuario">
        </a>
    </header>

    <div class="container">
        <form action="php/alumnos/actualizarAlumno.php" method="POST">
            <div class="form-group">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($alumno['id']); ?>" required>
                <label for="nombre">Nombre completo</label>
                <input type="text" id="nombre" name="nombre" placeholder="Nombre(s)" value="<?php echo htmlspecialchars($alumno['nombre']); ?>" required>
                
                <input type="text" id="ap" name="ap" placeholder="Apellido Paterno" value="<?php echo htmlspecialchars($alumno['Ap']); ?>" required>
                
                <input type="text" id="am" name="am" placeholder="Apellido Materno" value="<?php echo htmlspecialchars($alumno['Am']); ?>" required>
            </div>
            <div class="form-group">
                <label for="matricula">Matrícula</label>
                <input type="text" id="matricula" name="matricula" value="<?php echo htmlspecialchars($alumno['matricula']); ?>" placeholder="0000" required>
            </div>
            <div class="form-group">
                <label for="genero">Género:</label>
                <select name="genero" id="genero" required onchange="limpiarSelect('genero')">
                    <option value="<?php echo htmlspecialchars($alumno['genero']); ?>">
                        <?php echo htmlspecialchars($alumno['genero_descripcion']); ?>
                    </option>
                    <?php
                        generarOpciones('genero', $pdo, $alumno['genero']);
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="medio_enterado">Medio Enterado</label>
                <select name="medio_enterado" id="medio_enterado" required onchange="limpiarSelect('medio_enterado')">
                    <option value="<?php echo htmlspecialchars($alumno['medio_enterado']); ?>">
                        <?php echo htmlspecialchars($alumno['medio_descripcion']); ?>
                    </option>
                    <?php
                        generarOpciones('medio_enterado', $pdo, $alumno['medio_enterado']);
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="ciclo">Ciclo escolar</label>
                <select name="ciclo" id="ciclo" required onchange="limpiarSelect('ciclo')">
                    <option value="<?php echo htmlspecialchars($nivel_grado_ciclo['ciclo_id']); ?>">
                        <?php echo htmlspecialchars($nivel_grado_ciclo['ciclo_descripcion']); ?>
                    </option>
                    <?php
                        generarOpciones('ciclo', $pdo, $nivel_grado_ciclo['ciclo_id']);
                    ?>
                </select>
            </div>
            <div class="group-1">
                <div class="form-group">
                    <label for="nivel_escolar">Nivel Escolar</label>
                    <select name="nivel_escolar" id="nivel_escolar" onchange="cargarGrados()" required>
                        <option value="<?php echo htmlspecialchars($nivel_grado_ciclo['nivel_educativo_id']);?>">
                            <?php echo htmlspecialchars($nivel_grado_ciclo['nivel_descripcion']); ?>
                        </option">
                        <?php
                            generarOpciones('nivel_educativo', $pdo, $nivel_grado_ciclo['nivel_educativo_id']);
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="grado">Grado</label>
                    <select name="grado" id="grado" required onchange="limpiarSelect('grado')">
                        <option value="<?php echo htmlspecialchars($nivel_grado_ciclo['grado_id']);?>">
                            <?php echo htmlspecialchars($nivel_grado_ciclo['grado_descripcion']); ?>
                        </option>
                    </select>
                </div>
            </div>
            <div class="group-1">
                <div class="form-group">
                    <label for="municipio">Municipio</label>
                    <select name="municipio" id="municipio" onchange="cargarColonias()" required>
                        <option value="<?php echo htmlspecialchars($alumno['municipio']);?>">
                            <?php echo htmlspecialchars($alumno['municipio_descripcion']); ?>
                        </option>
                        <?php
                            generarOpciones('municipio', $pdo, $alumno['municipio']);
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="colonia">Colonia</label>
                    <select name="colonia" id="colonia" required onchange="limpiarSelect('colonia')">
                        <option value="<?php echo htmlspecialchars($alumno['colonia']);?>">
                            <?php echo htmlspecialchars($alumno['colonia_descripcion']); ?>
                        </option>
                    </select>
                </div>
                
            </div>
            <div class="group-1">
                <div class="form-group">
                    <label for="estado">Estado</label>
                    <select name="estado" id="estado" required onchange="limpiarSelect('estado')">
                        <option value="<?php echo htmlspecialchars($alumno['estado']);?>">
                            <?php echo htmlspecialchars($alumno['estado_descripcion']); ?>
                        </option>
                        <?php
                            generarOpciones('estado', $pdo, $alumno['estado']);
                        ?>
                    </select>
                </div>
                <div class="form-group">
                <label for="promocion">Promoción</label>
                <select name="promocion" id="promocion" required onchange="limpiarSelect('promocion')">
                    <option value="<?php echo htmlspecialchars($alumno['promocion']);?>">
                        <?php echo htmlspecialchars($alumno['promocion_descripcion']); ?>
                    </option>
                    <?php
                        generarOpciones('promocion', $pdo, $alumno['promocion']);
                    ?>
                </select>
                </div>
            </div>
            <button type="submit" class="submit-btn">Actualizar alumno</button>
        </form>
    </div>

    <script src="js/registrarAlumno.js"></script>
</body>
</html>
