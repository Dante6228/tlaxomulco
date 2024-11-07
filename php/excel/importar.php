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

if ($data) {
    $pdo = Conexion::connection();

    if (!$pdo) {
        throw new UnexpectedValueException("Error de conexión a la base de datos");
    }

    for ($i = 1; $i < count($data); $i++) {
        $row = $data[$i];

        // Verificar que el índice existe antes de acceder a él
        $nombre = isset($row[0]) ? $row[0] : '';
        $apellidoPaterno = isset($row[1]) ? $row[1] : '';
        $apellidoMaterno = isset($row[2]) ? $row[2] : '';
        $matricula = isset($row[3]) ? $row[3] : '';

        $query = "INSERT INTO alumno (nombre, Ap, Am, matricula) VALUES (?, ?, ?, ?)";


        $nivel = isset($row[4]) ? $row[4] : '';
        $grado = isset($row[5]) ? $row[5] : '';
        $ciclo = isset($row[6]) ? $row[6] : '';

        


        $genero = isset($row[7]) ? $row[7] : '';
        $municipio = isset($row[8]) ? $row[8] : '';
        $colonia = isset($row[9]) ? $row[9] : '';
        $medioEnterado = isset($row[10]) ? $row[10] : '';
        $promocion = isset($row[11]) ? $row[11] : '';
        $estado = isset($row[12]) ? $row[12] : '';

        // Imprimir los valores
        
        $nivel2 = obtenerNivel($nivel);
        $grado = obtenerGrado($grado, $nivel);
        $grado2 = obtenerGrado2($nivel2, $grado);

        echo "Nivel: " . $nivel2 . "<br>" . "Grado: " . $grado . " " . $grado2;

    }

    echo "<br>Datos importados exitosamente.";
} else {
    echo "No hay datos para importar.";
}

function obtenerNivel($nivel){
    switch($nivel){
        case 'Preescolar':
            return '1';
        case 'Primaria':
            return '2';
        case 'Secundaria':
            return '3';
        case 'Bachillerato':
            return '4';
        default:
            return null;
    }
}

function obtenerGrado($grado, $nivel){
    if (strpos($grado, 'grado') !== false) {
        switch($nivel){
            case 'Preescolar':
                return '1';
            case 'Primaria':
                return '2';
            case 'Secundaria':
                return '3';
            default:
                return null;
        }
    } else {
        switch($grado){
            case '1er semestre':
                return '13';
            case '2do semestre':
                return '14';
            case '3er semestre':
                return '15';
            case '4to semestre':
                return '16';
            case '5to semestre':
                return '17';
            case '6to semestre':
                return '18';
            default:
                return null;
        }
    }
}

function obtenerGrado2($nivel, $grado){
    if($nivel === 1){
        switch($grado){
            case '1er grado':
                return '1';
            case '2do grado':
                return '2';
            case '3er grado':
                return '3';
            default:
                return null;
        }
    } elseif ($nivel === 2){
        switch($grado){
            case '1er grado':
                return '4';
            case '2do grado':
                return '5';
            case '3er grado':
                return '6';
            case '4to grado':
                return '7';
            case '5to grado':
                return '8';
            case '6to grado':
                return '9';
            default:
                return null;
        }
    } elseif ($nivel === 3){
        switch($grado){
            case '1er grado':
                return '10';
            case '2do grado':
                return '11';
            case '3er grado':
                return '12';
            default:
                return null;
        }
    }
}
