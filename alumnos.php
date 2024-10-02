<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos</title>
    <link rel="stylesheet" href="css/alumnos.css">
</head>
<body>
    <header>
        <h1>Alumnos</h1>
        <a href="Bienvenida.php" class="profile-btn">Inicio</a>
        <!-- Enlace para que la imagen te mande a otra página (cambia href para tu URL) -->
        <a href="Perfil_usuario.html"><img src="imagenes/perfil1.jpg" alt="Perfil"></a>
    </header>

    <div class="container">
        <div class="button-container">
            <a href="Registrar_alumno.html">
                <button class="register-btn">Registrar nuevo alumno</button>
            </a>
        </div>
        
        <div class="options-container">
            <div class="option-box">
                <h3>Nivel Educativo</h3>
                <select>
                    <option value="preescolar">Preescolar</option>
                    <option value="primaria">Primaria</option>
                    <option value="secundaria">Secundaria</option>
                    <option value="bachillerato">Bachillerato</option>
                </select>
            </div>

            <div class="option-box">
                <h3>Grado</h3>
                <select>
                    <option value="primero">Primero</option>
                    <option value="segundo">Segundo</option>
                    <option value="tercero">Tercero</option>
                    <option value="cuarto">Cuarto</option>
                </select>
            </div>

            <div class="option-box">
                <h3>Ciclo Escolar</h3>
                <select>
                    <option value="2022-2023">2022 - 2023</option>
                    <option value="2021-2022">2021 - 2022</option>
                    <option value="2020-2021">2020 - 2021</option>
                    <option value="2019-2020">2019 - 2020</option>
                </select>
            </div>
        </div>

        <!-- Tabla de alumnos -->
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Matrícula</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Dante Alejandro Viveros</td>
                    <td>135EFAS21</td>
                    <td>
                        <button class="delete-btn">Eliminar</button>
                        <button class="update-btn">Actualizar</button>
                    </td>
                </tr>
                <tr>
                    <td>Luis Emiliano Romero</td>
                    <td>15ASIO02C</td>
                    <td>
                        <button class="delete-btn">Eliminar</button>
                        <button class="update-btn">Actualizar</button>
                    </td>
                </tr>
                <tr>
                    <td>Ian Viveros Rodríguez</td>
                    <td>937AJS214</td>
                    <td>
                        <button class="delete-btn">Eliminar</button>
                        <button class="update-btn">Actualizar</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Botón para generar PDF -->
        <button class="btn" onclick="generatePDF()">Generar PDF</button>
    </div>

    <script>
        // Función de PHP para generar PDF - Colocar en el archivo PHP correspondiente.
        function generatePDF() {
            window.location.href = 'generar_pdf.php'; // Aquí debe ir la lógica de tu PHP para generar el PDF.
        }
    </script>
</body>
</html>
