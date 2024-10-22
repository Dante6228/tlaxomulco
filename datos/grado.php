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
$stmt = $pdo->prepare("SELECT grado.*, nivel_educativo.descripcion AS nivel_educativo_descripcion
    FROM grado
    INNER JOIN nivel_educativo ON grado.nivel_educativo_id = nivel_educativo.id
    WHERE grado.id = :id
");
$stmt->execute(['id' => $id]);
$grado = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/general.css">
    <title>Actualizar Grado</title>
</head>
<body>
    <header>
        <h1>Actualizar grado</h1>
        <a href="../datos.php" class="botonInicio">Regresar</a>
        <a href="../usuario.php"><img src="../img/usuario.png" alt="Perfil"></a>
    </header>
    <div class="container">
        <main>
            <form action="../php/datos/acciones/actualizar_grado.php" method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($grado['id']); ?>" required>
                <div class="form-group">
                    <label for="descripcion">Grado escolar</label>
                    <input type="text" id="descripcion" name="descripcion" value="<?php echo htmlspecialchars($grado['descripcion']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="municipio">Nivel escolar</label>
                    <select name="nivel_educativo" id="nivel_educativo">
                        <option value="<?php echo htmlspecialchars($grado['nivel_educativo_id']); ?>" >
                            <?php echo htmlspecialchars($grado['nivel_educativo_descripcion']); ?>
                        </option>
                        <?php

                        $query = "SELECT * FROM nivel_educativo";
                        $stmt = $pdo->query($query);
                        $niveles = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($niveles as $nivel) {
                            echo '<option value="'. htmlspecialchars($nivel['id']). '">'. htmlspecialchars($nivel['descripcion']). '</option>';
                        }

                        ?>
                    </select>
                </div>
                <button type="submit" class="submit-btn">Actualizar</button>
            </form>
        </main>
    </div>
</body>
</html>
