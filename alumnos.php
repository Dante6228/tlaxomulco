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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Alumnos</title>
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
                <li><button id="toggleTheme">🌙</button></li>
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
        <div class="container">

            <?php
                $mensajes = [
                    "registro" => ["¡Éxito!", "¡Alumno registrado correctamente!", "success"],
                    "actualizado" => ["¡Actualizado!", "¡Alumno actualizado correctamente!", "info"],
                    "pdf" => ["¡PDF Generado!", "El archivo PDF se generó correctamente.", "success"],
                    "excel" => ["Éxito!", "¡Excel generado correctamente!", "success"],
                    "insercion"=> ["Éxito", "¡Excel importado correctamente!", "info"],
                ];

                if (isset($_GET['mensaje']) && isset($mensajes[$_GET['mensaje']])) {
                    $mensaje = $mensajes[$_GET['mensaje']];
                }
            ?>

            <?php if (isset($mensaje)): ?>
                <script>
                    Swal.fire({
                        title: "<?= $mensaje[0] ?>",
                        text: "<?= $mensaje[1] ?>",
                        icon: "<?= $mensaje[2] ?>",
                        timer: 4000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                </script>
            <?php endif; ?>

            <div class="button-container">
                <a href="Registrar_alumno.php" class="linksNav">Registrar nuevo alumno</a>
                <a href="excel.php" class="linksNav">Importar archivo excel</a>
                <a href="php/excel/generar.php" class="linksNav">Generar excel de importación</a>
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

            <div class="second-button-container">
                <button id="mostrar-alumnos-btn" class="secondBtn" onclick="mostrarAlumnos()">Mostrar Alumnos</button>
                <button id="mostrar-alumnos-btn" class="secondBtn" onclick="generarPDF()">
                    <img src="img/pdfico.png" alt="Icono de pdf">Generar PDF
                </button>
                <button id="mostrar-alumnos-btn" class="secondBtn" onclick="generarExcel()">
                    <img src="img/excelico.png" alt="Icono de Excel"> Generar Excel
                </button>
            </div>

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
        </div>
    </main>

    <script src="js/alumnos.js"></script>
    <script src="js/theme.js"></script>
</body>
</html>
