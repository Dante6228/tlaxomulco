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
    <link rel="stylesheet" href="css/alumnos.css">
    <link rel="stylesheet" href="css/header.css">
    <title>Importar excel</title>
</head>
<body>
    <header>
        <h1>Importar excel</h1>
        <a href="alumnos.php" class="botonInicio">Regresar</a>
        <a href="usuario.php"><img src="img/usuario.png" alt="Perfil"></a>
    </header>

    <main>
        <div class="container">
            
            <form action="php/excel/importar.php" method="post" enctype="multipart/form-data">
                <div class="options-container">
                    <div class="option-box">
                        <h3>Archivo de excel</h3>
                        <input type="file" name="excelFile" id="excelFile" accept=".xlsx, .xls" required>
                    </div>
                </div>
                <button type="submit">Importar excel</button>
            </form>
            
        </div>
    </main>
</body>
</html>
