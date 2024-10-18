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
$stmt = $pdo->prepare("SELECT * FROM medio_enterado WHERE id = :id");
$stmt->execute(['id' => $id]);
$medio_enterado = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/medio_enterado.css">
    <link rel="stylesheet" href="css/header.css">
    <title>Actualizar medio enterado</title>
</head>
<body>
    <header>
        <h1>Actualizar medio enterado</h1>
        <a href="../datos.php" class="botonInicio">Regresar</a>
        <a href="../usuario.php"><img src="../img/usuario.png" alt="Perfil"></a>
    </header>
    <main>
        <form action="php/actualizar_medio.php" method="GET">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($medio_enterado['id']); ?>" required>
            <label for="descripcion">Descripción</label>
            <input type="text" id="descripcion" name="descripcion" value="<?php echo htmlspecialchars($medio_enterado['descripcion']); ?>" required>
            <button type="submit" class="submit-btn">Actualizar</button>
        </form>
    </main>
</body>
</html>
