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
    <title>Cuenta de usuario</title>
</head>
<body>
    <header>
        <h1>Cuenta de usuario</h1>
        <a href="Bienvenida.php">Regresar</a>
        <a href="usuario.php">
            <img src="img/usuario.png" alt="Cuenta de usuario">
        </a>
    </header>
    <main>

        <?php if (isset($_GET["mensaje"]) && $_GET["mensaje"] == "actualizacion") { ?>
            <div class="actualizacion">
                <p>¡Datos de usuario actualizados correctamente!</p>
            </div>
        <?php } ?>

        <?php if (isset($_GET["mensaje"]) && $_GET["mensaje"] == "error") { ?>
            <div class="error">
                <p>Error al intentar actualizar los datos de usuario</p>
            </div>
        <?php } ?>

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
                                <label for="Usuario">Usuario:</label>
                            </td>
                            <td> <?php echo $_SESSION['usuario'];?> </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="contraseña">Contraseña:</label>
                            </td>
                            <td> <?php echo $_SESSION['contraseña'];?> </td>
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
                <form action="php/actualizarUsuario.php" method="POST">
                    <label for="nuevoUsuario">Nuevo Usuario:</label>
                    <input type="text" id="nuevoUsuario" name="usuario"><br>

                    <label for="nuevaContraseña">Nueva Contraseña:</label>
                    <input type="password" id="nuevaContraseña" name="contrasena"><br>

                    <input type="submit" value="Guardar Cambios">
                </form>
            </div>
        </div>

        <script src="js/usuario.js"></script>
        
        <a href="php/cerrar.php" id="cerrar">Cerrar sesión</a>
    </main>
</body>
</html>
