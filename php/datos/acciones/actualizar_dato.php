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
    case '1': // Tipo 1: Actualizar la tabla de 'ciclo'
        if (isset($_POST['descripcion'])) {
            $id = $_POST["id"];
            $descripcion = $_POST["descripcion"];
            
            try {
                $stmt = $pdo->prepare("UPDATE ciclo SET descripcion = :descripcion WHERE id = :id");
                $stmt->bindParam(":descripcion", $descripcion);
                $stmt->bindParam(":id", $id);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    header("Location: ../../../datos.php?mensaje=actualizacion");
                    exit();
                }
            } catch (PDOException $e) {
                echo "Error al actualizar el ciclo: " . $e->getMessage();
            }
        }
        break;
    case '2': // Tipo 2: Actualizar la tabla de 'colonia'
        if (isset($_POST['descripcion'])) {
            $id = $_POST["id"];
            $descripcion = $_POST["descripcion"];
            $municipio = $_POST["municipio"];
            
            try {
                $stmt = $pdo->prepare("UPDATE colonia SET descripcion = :descripcion, municipio_id = :municipio WHERE id = :id");
                $stmt->bindParam(":descripcion", $descripcion);
                $stmt->bindParam(":municipio", $municipio);
                $stmt->bindParam(":id", $id);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    header("Location: ../../../datos.php?mensaje=actualizacion");
                    exit();
                }
            } catch (PDOException $e) {
                echo "Error al actualizar la colonia: " . $e->getMessage();
            }
        }
        break;

    case '3': // Tipo 3: Actualizar la tabla de 'estado'
        if (isset($_POST['descripcion'])) {
            $id = $_POST["id"];
            $descripcion = $_POST["descripcion"];

            try {
                $stmt = $pdo->prepare("UPDATE estado SET descripcion = :descripcion WHERE id = :id");
                $stmt->bindParam(":descripcion", $descripcion);
                $stmt->bindParam(":id", $id);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    header("Location: ../../../datos.php?mensaje=actualizacion");
                    exit();
                }
            } catch (PDOException $e) {
                echo "Error al actualizar el estado: " . $e->getMessage();
            }
        }
        break;
    
        case '4': // Tipo 4: Actualizar la tabla de 'genero'
            if (isset($_POST['descripcion'])) {
                $id = $_POST["id"];
                $descripcion = $_POST["descripcion"];
                
                try {
                    $stmt = $pdo->prepare("UPDATE genero SET descripcion = :descripcion WHERE id = :id");
                    $stmt->bindParam(":descripcion", $descripcion);
                    $stmt->bindParam(":id", $id);
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {
                        header("Location: ../../../datos.php?mensaje=actualizacion");
                        exit();
                    }
                } catch (PDOException $e) {
                    echo "Error al actualizar el genero: " . $e->getMessage();
                }
            }
            break;
        

    case '5': // Tipo 5: Actualizar en la tabla de 'promocion'
        if (isset($_POST['descripcion'])) {
            $id = $_POST["id"];
            $descripcion = $_POST["descripcion"];
            
            try {
                $stmt = $pdo->prepare("UPDATE medio_enterado SET descripcion = :descripcion WHERE id = :id");
                $stmt->bindParam(":descripcion", $descripcion);
                $stmt->bindParam(":id", $id);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    header("Location: ../../../datos.php?mensaje=actualizacion");
                    exit();
                }
            } catch (PDOException $e) {
                echo "Error al actualizar el medio enterado: " . $e->getMessage();
            }
        } //////////////////////////////////////////////////////////////////
            break;

    case '6': // Tipo 6: Actualizar en la tabla de 'medio'
        if (isset($_POST['descripcion'])) {
            $id = $_POST["id"];
            $descripcion = $_POST["descripcion"];
            
            try {
                $stmt = $pdo->prepare("UPDATE municipio SET descripcion = :descripcion WHERE id = :id");
                $stmt->bindParam(":descripcion", $descripcion);
                $stmt->bindParam(":id", $id);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    header("Location: ../../../datos.php?mensaje=actualizacion");
                    exit();
                }
            } catch (PDOException $e) {
                echo "Error al actualizar el municipio: " . $e->getMessage();
            }
        }
        break;

    case '7': // Tipo 7: Actualizar en la tabla de 'promocion'
        if (isset($_POST['descripcion'])) {
            $id = $_POST["id"];
            $descripcion = $_POST["descripcion"];
            
            try {
                $stmt = $pdo->prepare("UPDATE promocion SET descripcion = :descripcion WHERE id = :id");
                $stmt->bindParam(":descripcion", $descripcion);
                $stmt->bindParam(":id", $id);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    header("Location: ../../../datos.php?mensaje=actualizacion");
                    exit();
                }
            } catch (PDOException $e) {
                echo "Error al actualizar la promoción: " . $e->getMessage();
            }
        }
        break;

    default:
        echo "Tipo no válido";
        break;
}

