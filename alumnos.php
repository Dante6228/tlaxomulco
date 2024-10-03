<?php

require_once __DIR__ . "/php/conexion.php";

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
            <div class="button-container">
                <a href="Registrar_alumno.html">
                    <button class="register-btn">Registrar nuevo alumno</button>
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
                    <select id="grado">
                        <option value="">Selecciona un grado</option>
                    </select>
                </div>


                <div class="option-box">
                    <h3>Ciclo Escolar</h3>
                    <select>
                        <option value="">Selecciona un ciclo</option>
                    </select>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Matrícula</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Dante Alejandro Viveros</td>
                        <td>135EFAS21</td>
                        <td>
                            <button class="delete-btn">Eliminar</button>
                            <button class="update-btn">Actualizar</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Luis Emiliano Romero</td>
                        <td>15ASIO02C</td>
                        <td>
                            <button class="delete-btn">Eliminar</button>
                            <button class="update-btn">Actualizar</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Ian Viveros Rodríguez</td>
                        <td>937AJS214</td>
                        <td>
                            <button class="delete-btn">Eliminar</button>
                            <button class="update-btn">Actualizar</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <button class="btn">Generar PDF</button>
        </div>
    </main>

    <script src="js/alumnos.js"></script>

</body>
</html>
