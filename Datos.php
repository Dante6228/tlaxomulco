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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Datos</title>
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
                <img src="img/usuario.png" alt="Foto de usuario">
            </a>
            <div class="saludo">
                <h2>Hola</h2>
                <p><?php echo $_SESSION["nombre"]?></p>
            </div>
        </div>
    </header>

    <?php

        $mensajes = [
            "registro" => ["¡Éxito!", "¡Dato registrado correctamente!", "success"],
            "actualizacion" => ["¡Actualizado!", "¡Dato actualizado correctamente!", "info"],
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
    </main>

    <script src="js/datos.js"></script>
</body>
</html>
