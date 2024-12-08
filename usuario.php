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
    <title>Cuenta de usuario</title>
</head>
<body>
    <header>
        <h1>Cuenta de usuario</h1>
        <a href="Bienvenida.php" class="botonInicio">Inicio</a>
        <a href="usuario.php">
            <img src="img/usuario.png" alt="Cuenta de usuario">
        </a>
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
                <img src="img/usuario.png" alt="Foto de perfil">
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
