<?php

require_once __DIR__ . "/../php/conexion.php";

session_start();

if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
    header("Location: Index.php?mensaje=error");
    exit();
}

$pdo = Conexion::connection();

if (!$pdo) {
    throw new UnexpectedValueException("Error de conexión a la base de datos");
}

$query = "SELECT * FROM nivel_educativo";

$stmt = $pdo->prepare($query);
$stmt->execute();

$nivel = $stmt->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT * FROM medio_enterado";

$stmt = $pdo->prepare($query);
$stmt->execute();

$medio = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/alumnos.css">
    <link rel="stylesheet" href="../css/header.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Consulta por medio enterado</title>
</head>
<body>
    <header>
        <h1>Consulta por medio enterado</h1>
        <a href="../consulta.php" class="botonInicio">Regresar</a>
        <a href="../usuario.php"><img src="../img/usuario.png" alt="Perfil"></a>
    </header>

    <main>
        <div class="container">

            <?php if (isset($_GET["mensaje"]) && $_GET["mensaje"] == "pdf") { ?>
                <div style="margin-bottom: 25px;" class="mensaje">
                    <p>¡PDF generado correctamente!</p>
                </div>
            <?php } ?>
            
            <div class="options-container">
                <div>
                    <div class="option-box">
                        <h3>Nivel Educativo</h3>
                        <select id="nivel-educativo" onchange="cargarGrados()">
                            <option value="">Selecciona un nivel</option>
                            <?php
                                foreach ($nivel as $item) {
                                    echo "<option value='" . $item['id'] . "'>" . $item['descripcion'] . "</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="option-box">
                        <h3>Ciclo Escolar</h3>
                        <select id="ciclo-escolar">
                            <option value="">Selecciona un ciclo</option>
                        </select>
                    </div>
                </div>
                <div>
                    <div class="option-box">
                        <h3>Grado</h3>
                        <select id="grado" onchange="cargarCiclos()">
                            <option value="">Selecciona un grado</option>
                        </select>
                    </div>
                    <div class="option-box">
                        <h3>Medio enterado</h3>
                        <select id="medio-enterado">
                            <option value="">Selecciona un medio</option>
                            <?php
                                foreach ($medio as $item) {
                                    echo "<option value='" . $item['id'] . "'>" . $item['descripcion'] . "</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <button id="mostrar-alumnos-btn" onclick="mostrarAlumnos()">Mostrar Alumnos</button>

            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido paterno</th>
                        <th>Apellido materno</th>
                        <th>Matrícula</th>
                        <th>Género</th>
                        <th>Municipio</th>
                        <th>Colonia</th>
                        <th>Medio enterado</th>
                        <th>Promoción</th>
                        <th>Estado del alumno</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- La consulta al registro de alumnos se mostrará aquí -->
                </tbody>
            </table>

            <button id="mostrar-alumnos-btn" class="btn" onclick="generarPDF()">Generar PDF</button>
        </div>
    </main>

    <script src="js/medio.js"></script>

</body>
</html>
