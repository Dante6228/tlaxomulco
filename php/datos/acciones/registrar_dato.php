<?php

require_once __DIR__ . '/../../conexion.php';

$pdo = Conexion::connection();

if (!$pdo) {
    throw new UnexpectedValueException("Error de conexión a la base de datos");
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header("Location: Index.php?mensaje=err1");
    exit();
}

$tipo = $_POST['tipo'];

switch ($tipo) {
    case '1': // Tipo 1: Crear en la tabla de 'estado'
        if (isset($_POST['estado'])) {
            $estado = $_POST['estado'];
            
            try {
                $sql = "INSERT INTO estado (descripcion) VALUES (:descripcion)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':descripcion' => $estado]);
                
                header("Location: ../../../datos.php?mensaje=registro");
            } catch (PDOException $e) {
                echo "Error al insertar el estado: " . $e->getMessage();
            }
        }
        break;
    case '2': // Tipo 2: Cambiar en la tabla de 'colonias'
        if (isset($_POST['colonia']) && isset($_POST['municipio'])) {
            $colonia = $_POST['colonia'];
            $municipio = $_POST['municipio'];
            
            try {
                $sql = "INSERT INTO colonia (descripcion, municipio_id) VALUES (:descripcion, :municipio_id)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':descripcion' => $colonia, ':municipio_id' => $municipio]);
                
                header("Location: ../../../datos.php?mensaje=registro");
            } catch (PDOException $e) {
                echo "Error al insertar la colonia: " . $e->getMessage();
            }
        }
        break;

    case '3': // Tipo 3: Crear en la tabla de 'municipio'
        if (isset($_POST['municipio'])) {
            $municipio = $_POST['municipio'];

            try {
                $sql = "INSERT INTO municipio (descripcion) VALUES (:descripcion)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':descripcion' => $municipio]);
                
                header("Location: ../../../datos.php?mensaje=registro");
            } catch (PDOException $e) {
                echo "Error al insertar el municipio: " . $e->getMessage();
            }
        }
        break;

    case '4': // Tipo 4: Crear en la tabla de 'nivel_educativo'
        if (isset($_POST['nivel'])) {
            $nivel = $_POST['nivel'];
            
            try {
                $sql = "INSERT INTO nivel_educativo (descripcion) VALUES (:descripcion)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':descripcion' => $nivel]);
                
                header("Location: ../../../datos.php?mensaje=registro");
            } catch (PDOException $e) {
                echo "Error al insertar el nivel educativo: " . $e->getMessage();
            }
        }
        break;

    case '5': // Tipo 5: Crear en la tabla de 'grado'
        if (isset($_POST['nivel2']) && isset($_POST['grado'])) {
            $nivel = $_POST['nivel2'];
            $grado = $_POST['grado'];
                    
            try {
                $sql = "INSERT INTO grado (descripcion, nivel_educativo_id) VALUES (:descripcion, :nivel_educativo_id)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':descripcion' => $grado, ':nivel_educativo_id' => $nivel]);
                
                header("Location: ../../../datos.php?mensaje=registro");
            } catch (PDOException $e) {
                echo "Error al insertar el grado: " . $e->getMessage();
            }
        }
        break;
    
    case '6': // Tipo 6: Crear en la tabla de 'ciclo'
        if (isset($_POST['ciclo'])) {
            $ciclo = $_POST['ciclo'];
            
            try {
                $sql = "INSERT INTO ciclo (descripcion) VALUES (:descripcion)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':descripcion' => $ciclo]);
                
                header("Location: ../../../datos.php?mensaje=registro");
            } catch (PDOException $e) {
                echo "Error al insertar el ciclo escolar: " . $e->getMessage();
            }
        }
        break;

    case '7': // Tipo 7: Crear en la tabla de 'promocion'
            if (isset($_POST['promocion'])) {
                $promocion = $_POST['promocion'];
                
                try {
                    $sql = "INSERT INTO promocion (descripcion) VALUES (:descripcion)";
                    $stmt = $pdo->prepare(query: $sql);
                    $stmt->execute([':descripcion' => $promocion]);
                    
                    header("Location: ../../../datos.php?mensaje=registro");
                } catch (PDOException $e) {
                    echo "Error al insertar la promoción: " . $e->getMessage();
                }
            }
            break;

    case '8': // Tipo 8: Crear en la tabla de 'medio'
        if (isset($_POST['medio'])) {
            $medio = $_POST['medio'];
            
            try {
                $sql = "INSERT INTO medio_enterado (descripcion) VALUES (:descripcion)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':descripcion' => $medio]);
                
                header("Location: ../../../datos.php?mensaje=registro");
            } catch (PDOException $e) {
                echo "Error al insertar el medio enterado: " . $e->getMessage();
            }
        }
        break;

    case '9': // Tipo 9: Crear en la tabla de 'genero'
        if (isset($_POST['genero'])) {
            $genero = $_POST['genero'];
            
            try {
                $sql = "INSERT INTO genero (descripcion) VALUES (:descripcion)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':descripcion' => $genero]);
                
                header("Location: ../../../datos.php?mensaje=registro");
            } catch (PDOException $e) {
                echo "Error al insertar el género: " . $e->getMessage();
            }
        }
        break;

    default:
        echo "Tipo no válido";
        break;
}

