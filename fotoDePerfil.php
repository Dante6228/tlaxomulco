<?php

session_start();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/usuarioFoto.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Actualizar foto de perfil</title>
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
        <form action="php/usuario/actualizarImagen.php" method="POST" enctype="multipart/form-data">
            <h3>Nueva foto de perfil</h3>
            <div class="form-group">
                <label for="nuevaImagen">Seleccionar nueva Imagen de Perfil</label>
                <input type="file" id="nuevaImagen" name="nuevaImagen" accept="image/*" required>
            </div>
            <p id="filePreview"></p>
            <div class="form-group">
                <input type="submit" value="Subir Imagen">
            </div>
        </form>
        <a href="usuario.php">Regresar</a>
    </main>

    <script src="js/theme.js"></script>
    <script>
        document.getElementById('nuevaImagen').addEventListener('change', function(event) {
            const fileInput = event.target;
            const filePreview = document.getElementById('filePreview');
            const fileName = fileInput.files[0] ? fileInput.files[0].name : 'No se ha seleccionado ningún archivo';
            filePreview.textContent = `Archivo seleccionado: ${fileName}`;
        });
    </script>
</body>
</html>
