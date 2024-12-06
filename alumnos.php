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

$query = "SELECT * FROM nivel_educativo";

$stmt = $pdo->prepare($query);
$stmt->execute();

$nivel = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/alumnos.css">
    <link rel="stylesheet" href="css/header.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Alumnos</title>
</head>
<body>
    <header>
        <h1>Alumnos</h1>
        <a href="Bienvenida.php" class="botonInicio">Inicio</a>
        <a href="usuario.php"><img src="img/usuario.png" alt="Perfil"></a>
    </header>

    <main>
        <div class="container">

            <?php
                $mensajes = [
                    "registro" => "¡Alumno registrado correctamente!",
                    "actualizado" => "¡Alumno actualizado correctamente!",
                    "pdf"=> "¡PDF generado correctamente!",
                    "insercion"=> "¡Excel importado correctamente!",
                ];

                if (isset($_GET["mensaje"]) && isset($mensajes[$_GET["mensaje"]])) {
                    ?>
                    <div class="<= mensaje ?>">
                        <p><?= $mensajes[$_GET["mensaje"]] ?></p>
                    </div>
                    <?php
                }
            ?>

            <div class="button-container">
                <a href="Registrar_alumno.php">
                    <button class="register-btn">Registrar nuevo alumno</button>
                </a>
            </div>
            <div class="button-container">
                <a href="excel.php">
                    <button class="register-btn">Importar archivo excel</button>
                </a>
            </div>
            <div class="button-container">
                <a href="php/excel/generar.php">
                    <button class="register-btn">Generar excel</button>
                </a>
            </div>
            
            <div class="options-container">
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
                    <h3>Grado</h3>
                    <select id="grado" onchange="cargarCiclos()">
                        <option value="">Selecciona un grado</option>
                    </select>
                </div>

                <div class="option-box">
                    <h3>Ciclo Escolar</h3>
                    <select id="ciclo-escolar">
                        <option value="">Selecciona un ciclo</option>
                    </select>
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

    <script src="js/alumnos.js"></script>

</body>
</html>
