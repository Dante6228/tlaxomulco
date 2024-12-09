<?php

require_once __DIR__ . "/../php/conexion.php";

session_start();

if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
    header("Location: Index.php?mensaje=error");
    exit();
}

$pdo = Conexion::connection();

if (!$pdo) {
    throw new UnexpectedValueException("Error de conexión a la base de datos");
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM genero WHERE id = :id");
$stmt->execute(['id' => $id]);
$genero = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/general.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Actualizar Género</title>
</head>
<body>
    <header>
        <div class="logo">
            <img src="../img/logo.png" alt="Logo del instituto Tlaxomulco">
            <h1>Instituto Tlaxomulco</h1>
        </div>
        <nav>
            <ul>
                <li><a href="../Bienvenida.php">Inicio</a></li>
                <li><a href="../alumnos.php">Alumnos</a></li>
                <li><a href="../Datos.php">Datos</a></li>
                <li><a href="../consulta.php">Consulta específica</a></li>
            </ul>
        </nav>
        <div class="saludoContainer">
            <a href="../usuario.php">
                <img src="../img/usuario.png" alt="Foto de usuario">
            </a>
            <div class="saludo">
                <h2>Hola</h2>
                <p><?php echo $_SESSION["nombre"]?></p>
            </div>
        </div>
    </header>
    <div class="container">
        <main>
            <form action="../php/datos/acciones/actualizar_dato.php" method="POST">
                <input type="hidden" name="tipo" value="4" required>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($genero['id']); ?>" required>
                <div class="form-group">
                    <label for="descripcion">Género</label>
                    <input type="text" id="descripcion" name="descripcion" value="<?php echo htmlspecialchars($genero['descripcion']); ?>" required>
                </div>
                <button type="submit">Actualizar</button>
            </form>
        </main>
    </div>
</body>
</html>
