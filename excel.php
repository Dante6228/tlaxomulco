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
    <link rel="stylesheet" href="css/importarExcel.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Importar excel</title>
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

    <main>
        <div class="container">

            <?php
                $mensajes = [
                    "error" => ["¡Error!", "¡Hubo un error al subir el archivo excel, por favor, intentelo de nuevo.", "error"],
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
            
            <form action="php/excel/importar.php" method="post" enctype="multipart/form-data">
                <div class="container">
                    <div class="option-box">
                        <h3>Archivo de excel</h3>
                        <input type="file" name="excelFile" id="excelFile" accept=".xlsx, .xls" class="custom-file-input" required>
                        <label for="excelFile" id="excelFile2" class="custom-file-label">Seleccionar archivo</label>
                    </div>
                    <p id="filePreview" class="file-preview"></p>
                </div>
                <button type="submit">Importar excel</button>
            </form>
            
        </div>
        <a href="alumnos.php" id="regresar">Regresar</a>
    </main>

    <script src="js/theme.js"></script>
    <script>
        document.getElementById('excelFile').addEventListener('change', function(event) {
            const fileInput = event.target;
            const filePreview = document.getElementById('filePreview');
            const label = document.getElementById('excelFile2');
            const fileName = fileInput.files[0] ? fileInput.files[0].name : 'No se ha seleccionado ningún archivo';
            filePreview.textContent = `Archivo seleccionado: ${fileName}`;
            label.textContent = "Cambiar archivo";
        });
    </script>
</body>
</html>
