<?php

session_start();

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
        <a href="usuario.php">
            <img src="img/usuario.png" alt="Cuenta de usuario">
        </a>
    </header>
    <main>
        <div class="master">
            <div class="seccion1">
                <img src="img/usuario.png" alt="Foto de perfil">
            </div>
            <div class="seccion2">
                <table>
                    <thead>
                        <th colspan="2">
                            <h2>Datos de usuario</h2>
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
                    <input type="text" id="nuevoUsuario" name="nuevoUsuario"><br>

                    <label for="nuevaContraseña">Nueva Contraseña:</label>
                    <input type="password" id="nuevaContraseña" name="nuevaContraseña"><br>

                    <input type="submit" value="Guardar Cambios">
                </form>
            </div>
        </div>

        <script>
            var modal = document.getElementById("editarDatosModal");
            var btn = document.querySelector("a[href='#']");
            var span = document.getElementsByClassName("close")[0];

            btn.onclick = function() {
                modal.style.display = "block";
            }

            span.onclick = function() {
                modal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>
        <a href="php/cerrar.php" id="cerrar">Cerrar sesión</a>
    </main>
</body>
</html>
