<?php

require_once __DIR__ . "/..//../php/conexion.php";
require_once __DIR__ . "/../../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_FILES['excelFile']) && $_FILES['excelFile']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['excelFile']['tmp_name'];
    $fileName = $_FILES['excelFile']['name'];
} else {
    die("Error al subir el archivo.");
}

try {
    $spreadsheet = IOFactory::load($fileTmpPath);
    $worksheet = $spreadsheet->getActiveSheet();
} catch (Exception $e) {
    die("Error al cargar el archivo: " . $e->getMessage());
}

$data = [];
foreach ($worksheet->getRowIterator() as $row) {
    $cellIterator = $row->getCellIterator();
    $cellIterator->setIterateOnlyExistingCells(true);
    
    $rowData = [];
    foreach ($cellIterator as $cell) {
        $rowData[] = $cell->getValue();
    }

    if (!empty($rowData)) {
        $data[] = $rowData;
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/header.css">
    <link rel="stylesheet" href="../../css/log.css">
    <title>Log de inserción</title>
</head>
<body>
    <header>
        <h1>Estado de inserción</h1>
        <a href="../../excel.php" class="botonInicio">Regresar</a>
        <a href="../../usuario.php"><img src="../../img/usuario.png" alt="Perfil"></a>
    </header>

    <main>
        <div class="container">
            <?php

            if ($data) {
                $pdo = Conexion::connection();

                if (!$pdo) {
                    throw new UnexpectedValueException("Error de conexión a la base de datos");
                }

                // Función para obtener el ID del grado/semestre basándose en el nivel escolar y el grado dado
                function obtenerIDGrado($nivel, $grado) {
                    $gradosPorNivel = [
                        "Preescolar" => [
                            "1er grado" => 1,
                            "2do grado" => 2,
                            "3er grado" => 3
                        ],
                        "Primaria" => [
                            "1er grado" => 4,
                            "2do grado" => 5,
                            "3er grado" => 6,
                            "4to grado" => 7,
                            "5to grado" => 8,
                            "6to grado" => 9
                        ],
                        "Secundaria" => [
                            "1er grado" => 10,
                            "2do grado" => 11,
                            "3er grado" => 12
                        ],
                        "Bachillerato" => [
                            "1er semestre" => 13,
                            "2do semestre" => 14,
                            "3er semestre" => 15,
                            "4to semestre" => 16,
                            "5to semestre" => 17,
                            "6to semestre" => 18
                        ]
                    ];

                    // Comprobar si el nivel existe en el arreglo y si el grado existe en ese nivel
                    if (isset($gradosPorNivel[$nivel]) && isset($gradosPorNivel[$nivel][$grado])) {
                        return $gradosPorNivel[$nivel][$grado];
                    } else {
                        return 'Grado no existente'; // Retorna null si el nivel o grado no es válido
                    }
                }

                // Bucle for desde el indice 2 para evitar la inserción de encabezados
                for ($i = 2; $i < count($data); $i++) {
                    $row = $data[$i];

                    $nombre = isset($row[0]) ? $row[0] : '';
                    $apellidoPaterno = isset($row[1]) ? $row[1] : '';
                    $apellidoMaterno = isset($row[2]) ? $row[2] : '';
                    $matricula = isset($row[3]) ? $row[3] : '';

                    $nivel = (string)(isset($row[4]) ? $row[4] : '');
                    $grado = (string)(isset($row[5]) ? $row[5] : '');
                    $ciclo = (string)(isset($row[6]) ? $row[6] : '');

                    $genero = isset($row[7]) ? $row[7] : '';
                    $municipio = isset($row[8]) ? $row[8] : '';
                    $colonia = isset($row[9]) ? $row[9] : '';
                    $medioEnterado = isset($row[10]) ? $row[10] : '';
                    $promocion = isset($row[11]) ? $row[11] : '';
                    $estado = isset($row[12]) ? $row[12] : '';

                    if(!$nombre){
                        echo "Sin datos por registrar";
                        exit();
                    }

                    echo  "<h1>" . "Alumno ", ($i - 1) . "</h1>";

                    /////////////////////////////////////////////////////////////////
                    // INSERCIÓN DE CICLO //
                    /////////////////////////////////////////////////////////////////

                    // Verificar si el ciclo ya existe en la base de datos
                    $query = "SELECT id FROM ciclo WHERE descripcion = :descripcion";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':descripcion', $ciclo);
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {
                        // El ciclo ya existe; obtener el ID
                        $cicloData = $stmt->fetch(PDO::FETCH_ASSOC);
                        $cicloId = $cicloData['id'];
                        echo "Ciclo existente: $ciclo con ID: $cicloId <br>";
                    } else {
                        // 1. Insertar el ciclo escolar
                        $sql = "INSERT INTO ciclo (descripcion) VALUES (:descripcion)";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([':descripcion' => $ciclo]);
                        $cicloId = $pdo->lastInsertId();
                        echo "Ciclo $ciclo creado con ID: $cicloId <br>";

                        // 2. Relacionar todos los grados con el nuevo ciclo escolar
                        $sqlGrados = "SELECT id, nivel_educativo_id FROM grado";
                        $stmtGrados = $pdo->prepare($sqlGrados);
                        $stmtGrados->execute();
                        $grados = $stmtGrados->fetchAll(PDO::FETCH_ASSOC);

                        // 3. Insertar relaciones en nivel_grado_ciclo
                        foreach ($grados as $grado) {
                            $sqlRelacion = "INSERT INTO nivel_grado_ciclo (nivel_educativo_id, grado_id, ciclo_id) VALUES (:nivel_educativo_id, :grado_id, :ciclo_id)";
                            $stmtRelacion = $pdo->prepare($sqlRelacion);
                            $stmtRelacion->execute([
                                ':nivel_educativo_id' => $grado['nivel_educativo_id'],
                                ':grado_id' => $grado['id'],
                                ':ciclo_id' => $cicloId,
                            ]);
                        }
                    }

                    /////////////////////////////////////////////////////////////////
                    // OBTENCIÓN DE ID DE GRADO Y NIVEL //
                    /////////////////////////////////////////////////////////////////

                    
                    // Verificar si el nivel ya existe en la base de datos
                    $query = "SELECT id FROM nivel_educativo WHERE descripcion = :descripcion";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':descripcion', $nivel);
                    $stmt->execute();
                    
                    if ($stmt->rowCount() > 0) {
                        // El nivel ya existe; obtener el ID
                        $nivelData = $stmt->fetch(PDO::FETCH_ASSOC);
                        $nivelId2 = $nivelData['id'];
                        echo "Nivel existente: $nivel con ID: $nivelId2 <br>";
                        echo $nivel;
                    } else{
                        var_dump($nivel);
                        echo "Error: Nivel educativo no existente <br>";
                    }

                    $grado = isset($row[5]) ? $row[5] : '';

                    if (is_array($grado)) {
                        $grado = implode(',', $grado); // Convierte el array en una cadena
                    }

                    if (!is_string($grado)) {
                        echo "Error: grado no es una cadena válida <br>";
                    }

                    // Verificar si el grado ya existe en la base de datos
                    $query = "SELECT id FROM grado WHERE nivel_educativo_id = :nivelId AND descripcion = :grado";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':nivelId', $nivelId2);
                    $stmt->bindParam(':grado', $grado);
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {
                        // El grado ya existe; obtener el ID
                        $gradoData = $stmt->fetch(PDO::FETCH_ASSOC);
                        $gradoId = $gradoData['id'];
                        echo "Grado existente: $grado con ID: $gradoId<br>";
                    } else{
                        echo "Error: grado no existente <br>";
                    }

                    /////////////////////////////////////////////////////////////////
                    // OBTENCIÓN DE NIVEL_GRADO_CICLO //
                    /////////////////////////////////////////////////////////////////

                    // Verificar si el nivel_grado_ciclo ya existe en la base de datos
                    $query = "SELECT id FROM nivel_grado_ciclo WHERE nivel_educativo_id = :nivelId AND grado_id = :gradoId AND ciclo_id = :cicloId";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':nivelId', $nivelId2);
                    $stmt->bindParam(':gradoId', $gradoId);
                    $stmt->bindParam(':cicloId', $cicloId);
                    $stmt->execute();
                    
                    if ($stmt->rowCount() > 0) {
                        // El nivel_grado_ciclo ya existe; obtener el ID
                        $nivelGrcicloData = $stmt->fetch(PDO::FETCH_ASSOC);
                        $nivelGrcicloId = $nivelGrcicloData['id'];
                        echo "Nivel_grado_ciclo existente: $nivelGrcicloId <br>";
                    }

                    echo "<br><strong>Datos nivel, grado y ciclo extraidos correctamete</strong><br>";

                    /////////////////////////////////////////////////////////////////
                    // OBTENCIÓN DE COLONIA Y MUNICIPIO //
                    /////////////////////////////////////////////////////////////////

                    // Verificar si el municipio ya existe en la base de datos
                    $query = "SELECT id FROM municipio WHERE descripcion = :descripcion";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':descripcion', $municipio);
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {
                        // El municipio ya existe; obtener el ID
                        $municipioData = $stmt->fetch(PDO::FETCH_ASSOC);
                        $municipioId = $municipioData['id'];
                        echo "Municipio existente: $municipio con ID: $municipioId <br>";
                    } else{
                        $query = "INSERT INTO municipio (descripcion) VALUES (:municipio)";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute([':municipio' => $municipio]);
                        $municipioId = $pdo->lastInsertId();
                        echo "Municipio $municipio creado con ID: $municipioId <br>";
                    }

                    // Verificar si la colonia ya existe en la base de datos
                    $query = "SELECT id FROM colonia WHERE descripcion = :descripcion AND municipio_id = :municipioId";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':descripcion', $colonia);
                    $stmt->bindParam(':municipioId', $municipioId);
                    $stmt->execute();
                    
                    if ($stmt->rowCount() > 0) {
                        // La colonia ya existe; obtener el ID
                        $coloniaData = $stmt->fetch(PDO::FETCH_ASSOC);
                        $coloniaId = $coloniaData['id'];
                        echo "Colonia existente: $colonia con ID: $coloniaId <br>";
                    } else{
                        $query = "INSERT INTO colonia (descripcion, municipio_id) VALUES (:colonia, :municipioId)";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute([':colonia' => $colonia, ':municipioId' => $municipioId]);
                        $coloniaId = $pdo->lastInsertId();
                        echo "Colonia $colonia creada con ID: $coloniaId <br>";
                    }

                    /////////////////////////////////////////////////////////////////
                    // OBTENCIÓN DE GÉNERO //
                    /////////////////////////////////////////////////////////////////

                    // Verificar si el género ya existe en la base de datos
                    $query = "SELECT id FROM genero WHERE descripcion = :descripcion";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':descripcion', $genero);
                    $stmt->execute();
                    
                    if ($stmt->rowCount() > 0) {
                        // El género ya existe; obtener el ID
                        $generoData = $stmt->fetch(PDO::FETCH_ASSOC);
                        $generoId = $generoData['id'];
                        echo "Género existente: $genero con ID: $generoId <br>";
                    } else{
                        $query = "INSERT INTO genero (descripcion) VALUES (:genero)";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute([':genero' => $genero]);
                        $generoId = $pdo->lastInsertId();
                        echo "Género $genero creado con ID: $generoId <br>";
                    }

                    /////////////////////////////////////////////////////////////////
                    // OBTENCIÓN DE PROMOCIÓN //
                    /////////////////////////////////////////////////////////////////

                    // Verificar si la promoción ya existe en la base de datos
                    $query = "SELECT id FROM promocion WHERE descripcion = :descripcion";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':descripcion', $promocion);
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {
                        // La promoción ya existe; obtener el ID
                        $promocionData = $stmt->fetch(PDO::FETCH_ASSOC);
                        $promocionId = $promocionData['id'];
                        echo "Promoción existente: $promocion con ID: $promocionId <br>";
                    } else{
                        $query = "INSERT INTO promocion (descripcion) VALUES (:descripcion)";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute([':descripcion' => $promocion]);
                        $promocionId = $pdo->lastInsertId();
                        echo "Promoción $promocion creada con ID: $promocionId <br>";
                    }

                    /////////////////////////////////////////////////////////////////
                    // OBTENCIÓN DE MEDIO ENTERADO //
                    /////////////////////////////////////////////////////////////////

                    // Verificar si el medio de enterado ya existe en la base de datos
                    $query = "SELECT id FROM medio_enterado WHERE descripcion = :descripcion";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':descripcion', $medioEnterado);
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {
                        // El medio de enterado ya existe; obtener el ID
                        $medioEnteradoData = $stmt->fetch(PDO::FETCH_ASSOC);
                        $medioEnteradoId = $medioEnteradoData['id'];
                        echo "Medio de enterado existente: $medioEnterado con ID: $medioEnteradoId <br>";
                    } else{
                        $query = "INSERT INTO medio_enterado (descripcion) VALUES (:descripcion)";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute([':descripcion' => $medioEnterado]);
                        $medioEnteradoId = $pdo->lastInsertId();
                        echo "Medio de enterado $medioEnterado creado con ID: $medioEnteradoId <br>";
                    }

                    /////////////////////////////////////////////////////////////////
                    // OBTENCIÓN DE ESTADO //
                    /////////////////////////////////////////////////////////////////

                    // Verificar si el estado ya existe en la base de datos
                    $query = "SELECT id FROM estado WHERE descripcion = :descripcion";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':descripcion', $estado);
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {
                        // El estado ya existe; obtener el ID
                        $estadoData = $stmt->fetch(PDO::FETCH_ASSOC);
                        $estadoId = $estadoData['id'];
                        echo "Estado existente: $estado con ID: $estadoId <br>";
                    } else{
                        $query = "INSERT INTO estado (descripcion) VALUES (:descripcion)";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute([':descripcion' => $estado]);
                        $estadoId = $pdo->lastInsertId();
                        echo "Estado $estado creado con ID: $estadoId <br>";
                    }

                    echo "<br><strong>Datos genero, municipio, colonia, estado, medio enterado y promoción extraidos correctamete</strong><br>";

                    /////////////////////////////////////////////////////////////////
                    // INSERCIÓN DE ALUMNO //
                    /////////////////////////////////////////////////////////////////

                    try {
                        $query = "INSERT INTO alumno (nombre, Ap, Am, matricula, municipio, genero, colonia, medio_enterado, promocion, estado, nivel_grado_ciclo_id) VALUES (:nombre, :ap, :am, :matricula, :municipio, :genero, :colonia, :medio_enterado, :promocion, :estado, :nivel_grado_ciclo_id)";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute([
                            ':nombre' => $nombre,
                            ':ap' => $apellidoPaterno,
                            ':am' => $apellidoMaterno,
                            ':matricula' => $matricula,
                            ':municipio' => $municipioId,
                            ':genero' => $generoId,
                            ':colonia' => $coloniaId,
                            ':medio_enterado' => $medioEnteradoId,
                            ':promocion' => $promocionId,
                            ':estado' => $estadoId,
                            ':nivel_grado_ciclo_id' => $nivelGrcicloId
                        ]);

                        echo "<p class = 'succes'>Alumno creado correctamente </p>";
                        
                    } catch (\PDOException $e) {
                        if ($e->getCode() == 23000) {
                            echo "<p class='error'>Error al crear el alumno " . $nombre . ", el alumno con la matricula " . $matricula . " ya existe.</p>";
                        } else{
                            echo "<p class='error'>Error al crear el alumno " . $nombre . "</p>";
                        }
                    } catch (\Throwable $th) {
                        echo "<p class='error'>Error al crear el alumno " .  $nombre . "</p>";
                    }

                    echo "<hr> <br>";
                    
                }

                exit();
                
            } else {
                echo "No hay datos para importar.";
            }

            ?>
        </div>
    </main>
</body>
</html>


