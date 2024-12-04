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
    <link rel="stylesheet" href="css/datos.css">
    <link rel="stylesheet" href="css/header.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Datos</title>
</head>
<body>
    <header>
        <h1>Datos</h1>
        <a href="Bienvenida.php" class="botonInicio">Inicio</a>
        <a href="usuario.php"><img src="img/usuario.png" alt="Perfil"></a>
    </header>

    <?php
        $mensajes = [
            "actualizacion" => "Dato actualizado correctamente!",
            "registro" => "Dato creado correctamente!",
        ];

        if (isset($_GET["mensaje"]) && isset($mensajes[$_GET["mensaje"]])) {
            ?>
            <div class="<= mensaje ?>">
                <p><?= $mensajes[$_GET["mensaje"]] ?></p>
            </div>
            <?php
        }
    ?>

    <main>
        <div class="container">
            <div class="button-container">
                <a href="registrar_dato.php">
                    <button class="register-btn">Registrar nuevo dato</button>
                </a>
            </div>
            <section class="filter-section">
                <h2>Dato a mostrar</h2>
                <select name="dato" id="dato">
                    <option value="">Selecciona un dato</option>
                    <option value="medio_enterado">Medio enterado</option>
                    <option value="municipio">Municipio</option>
                    <option value="colonia">Colonia</option>
                    <option value="promocion">Promocion</option>
                    <option value="ciclo">Ciclo escolar</option>
                    <option value="estado">Estado de alumno</option>
                    <option value="genero">Género</option>
                </select>
                <button type="button" class="search-btn" onclick="filtrarDatos()">Buscar</button>
            </section>
    
            <section class="data-section">
                <table>
                    <thead>
                        <tr>
                            <th>Dato</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="dataRows">
                        <!-- Aquí se mostrarán los datos filtrados -->
                    </tbody>
                </table>
            </section>
        </div>
        <div id="modalForm" class="modal">
</div>

    </main>

    <script src="js/datos.js"></script>
</body>
</html>
