<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/iniciarSesion.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Iniciar sesión</title>
</head>
<body>

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

        <div class="container">
            <form action="php/usuario/iniciar.php" method="POST">
                <img src="img/logo.png" alt="Logo del instituto Tlaxomulco">
                <h1 class="inter-newFont">Iniciar sesión</h1>
                <div class="form-input">
                    <label for="usuario">Usuario</label>
                    <input type="text" name="usuario" id="usuario" placeholder="User" required>
                </div>
                <div class="form-input">
                    <label for="contraseña">Contraseña</label>
                    <input type="password" name="contraseña" id="contraseña" placeholder="Password" required>
                </div>
                <div class="form-input">
                    <a href="#">¿Olvidaste la contraseña?</a>
                </div>
                <div class="form-input">
                    <input type="submit" value="Iniciar sesión">
                </div>
            </form>
        </div>
        
    </main>
</body>
</html>
