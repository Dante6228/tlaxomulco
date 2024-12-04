<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/iniciarSesion.css">
    <title>Iniciar sesión</title>
</head>
<body>
    
    <header>
        <div class="cabecera">
            <h1>
                Sistema de gestión de datos Tlaxomulco
            </h1>
            <img src="img/logo.png" alt="Logotipo del Instituto Tlaxomulco">
        </div>
    </header>

    <main>

        <?php
            $mensajes = [
                "0" => "Inicio de sesión fallido, por favor vuelve a intentarlo",
                "cierre" => "Sesión cerrada exitosamente",
                "error" => "Debes iniciar sesión para entrar al sitio web",
                "err1" => "No dispones de los permisos necesarios para acceder a esa URL"
            ];

            if (isset($_GET["mensaje"]) && isset($mensajes[$_GET["mensaje"]])) {
                $tipoClase = ($_GET["mensaje"] === "cierre") ? "cierre" : "error";
                ?>
                <div class="<?= $tipoClase ?>">
                    <p><?= $mensajes[$_GET["mensaje"]] ?></p>
                </div>
                <?php
            }
        ?>

        <table>
            <thead>
                <th colspan="2">
                    <h1>
                        Iniciar sesión
                    </h1>
                </th>
            </thead>
            <tbody>
                <form action="php/usuario/iniciar.php" method="POST">
                    <tr>
                        <td>
                            <label for="usuario">Usuario: </label>
                        </td>
                        <td>
                            <input type="text" name="usuario" id="usuario" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="contraseña">Contraseña: </label>
                        </td>
                        <td>
                            <input type="password" name="contraseña" id="contraseña" required>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" value="Iniciar sesión">
                        </td>
                    </tr>
                </form>
            </tbody>
        </table>
    </main>
</body>
</html>
