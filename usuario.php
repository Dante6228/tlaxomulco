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

$query = "SELECT * FROM usuario WHERE id = :id";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $_SESSION["idUsuario"]);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION["nombre"] = $row["nombre"];
    $_SESSION["usuario"] = $row['usuario'];
    $_SESSION["contraseña"] = $row['contraseña'];
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/usuario.css">
    <link rel="stylesheet" href="css/header.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Cuenta de usuario</title>
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

        <?php
            $mensajes = [
                "actualizacion" => ["¡Actualizado!", "¡Datos de usuario actualizados correctamente!", "info"],
                "error" => ["¡Error!", "Error al intentar actualizar los datos de usuario.", "error"],
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

        <div class="master">
            <div class="seccion1">
                <img src="<?php echo isset($_SESSION['picture']) && !empty($_SESSION['picture']) ? $_SESSION['picture'] : 'img/default.webp'; ?>" alt="Foto de usuario">
                <a href="fotoDePerfil.php">Actualizar foto de perfil</a>
            </div>
            <div class="seccion2">
                <table>
                    <thead>
                        <th colspan="2">
                            <h2>Datos de usuario</h2>
                            <hr>
                        </th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <p>Nombre:</p>
                            </td>
                            <td> <?php echo $_SESSION['nombre'];?> </td>
                        </tr>
                        </tr>
                        <tr>
                            <td>
                                <p>Usuario:</p>
                            </td>
                            <td> <?php echo $_SESSION['usuario'];?> </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <br>
                                <a href="#">Cambiar datos</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div id="editarDatosModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Editar Datos</h2>
                <form action="php/usuario/actualizarUsuario.php" method="POST">
                    <label for="nuevoNombre">Nuevo Nombre:</label>
                    <input type="text" id="nuevoNombre" name="nuevoNombre">
                    <div id="nombreUs-error" class="nombreUs-error"></div><br>

                    <label for="nuevoUsuario">Nuevo Usuario:</label>
                    <input type="text" id="nuevoUsuario" name="nuevoUsuario">
                    <div id="nombre-error" class="nombre-error"></div><br>

                    <label for="nuevaContraseña">Nueva Contraseña:</label>
                    <input type="password" id="nuevaContraseña" name="nuevaContraseña">
                    <div id="contrasena-error" class="contrasena-error"></div><br>

                    <input type="submit" value="Guardar Cambios">
                </form>
            </div>
        </div>

        <script src="js/usuario.js"></script>
        
        <a href="php/usuario/cerrar.php" id="cerrar">Cerrar sesión</a>
    </main>
</body>
</html>
