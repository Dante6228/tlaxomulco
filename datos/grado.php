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
$stmt = $pdo->prepare("SELECT * FROM grado WHERE id = :id");
$stmt->execute(['id' => $id]);
$grado = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/grado.css">
    <link rel="stylesheet" href="css/header.css">
    <title>Actualizar Grado</title>
</head>
<body>
    <header>
        <h1>Actualizar grado</h1>
        <a href="../datos.php" class="botonInicio">Regresar</a>
        <a href="../usuario.php"><img src="../img/usuario.png" alt="Perfil"></a>
    </header>
    <main>
        <form action="../php/datos/acciones/actualizar_grado.php" method="GET">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($grado['id']); ?>" required>
            <label for="descripcion">Descripción</label>
            <input type="text" id="descripcion" name="descripcion" value="<?php echo htmlspecialchars($grado['descripcion']); ?>" required>
            <label for="municipio">Municipio</label>
            <input type="text" id="municipio" name="municipio" value="<?php echo htmlspecialchars($grado['nivel_educativo_id']); ?>" required>
            <button type="submit" class="submit-btn">Actualizar</button>
        </form>
    </main>
</body>
</html>
