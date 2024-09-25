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
        <table>
            <thead>
                <th colspan="2">
                    <h1>
                        Iniciar sesión
                    </h1>
                </th>
            </thead>
            <tbody>
                <form action="php/iniciar.php" method="POST">
                    <tr>
                        <td>
                            <label for="usuario">Usuario: </label>
                        </td>
                        <td>
                            <input type="text" name="usuario" id="usuario">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="contraseña">Contraseña: </label>
                        </td>
                        <td>
                            <input type="password" name="contraseña" id="contraseña">
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
    <footer>

    </footer>
</body>
</html>
