<?php

require_once __DIR__ . "/../../php/conexion.php";
require_once __DIR__ . "/../../vendor/autoload.php";

$pdo = Conexion::connection();

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

// =================================================================
// CONSULTAS NECESARIAS A LA BASE DE DATOS
// =================================================================

// Conseguimos los niveles educativos
$query = "SELECT descripcion FROM nivel_educativo";

$stmt = $pdo->prepare($query);
$stmt->execute();

$niveles = $stmt->fetchAll(PDO::FETCH_ASSOC);
$nivelesDescripcion = array_column($niveles, 'descripcion');

// Conseguimos los grados escolares
$query = "SELECT descripcion FROM grado";

$stmt = $pdo->prepare($query);
$stmt->execute();

$grados = $stmt->fetchAll(PDO::FETCH_ASSOC);
$gradosDescripcion = array_column($grados, 'descripcion');

// Conseguimos los ciclos escolares
$query = "SELECT descripcion FROM ciclo";

$stmt = $pdo->prepare($query);
$stmt->execute();

$ciclos = $stmt->fetchAll(PDO::FETCH_ASSOC);
$ciclosDescripcion = array_column($ciclos, 'descripcion');

// Conseguimos los géneros
$query = "SELECT descripcion FROM genero";

$stmt = $pdo->prepare($query);
$stmt->execute();

$generos = $stmt->fetchAll(PDO::FETCH_ASSOC);
$generosDescripcion = array_column($generos, 'descripcion');

// Conseguimos los municipios
$query = "SELECT descripcion FROM municipio";

$stmt = $pdo->prepare($query);
$stmt->execute();

$municipios = $stmt->fetchAll(PDO::FETCH_ASSOC);
$municipiosDescripcion = array_column($municipios, 'descripcion');

//Conseguimos las colonias
$query = "SELECT * FROM colonia";

$stmt = $pdo->prepare($query);
$stmt->execute();

$colonias = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Conseguimos los medios enterados
$query = "SELECT descripcion FROM medio_enterado";

$stmt = $pdo->prepare($query);
$stmt->execute();

$medios = $stmt->fetchAll(PDO::FETCH_ASSOC);
$mediosDescripcion = array_column($medios, 'descripcion');

// Conseguimos las promociones
$query = "SELECT descripcion FROM promocion";

$stmt = $pdo->prepare($query);
$stmt->execute();

$promociones = $stmt->fetchAll(PDO::FETCH_ASSOC);
$promocionesDescripcion = array_column($promociones, 'descripcion');

// Conseguimos los estados
$query = "SELECT descripcion FROM estado";

$stmt = $pdo->prepare($query);
$stmt->execute();

$estados = $stmt->fetchAll(PDO::FETCH_ASSOC);
$estadosDescripcion = array_column($estados, 'descripcion');

// =================================================================
// CREACIÓN DEL EXCEL
// =================================================================

// Crear una nueva instancia de la hoja de cálculo
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Establecer el encabezado fusionando las celdas A2 hasta M2
$sheet->mergeCells('A2:M2');

// Escribir titulo ALUMNOS
$sheet->setCellValue('A2', 'ALUMNOS');

// Aplicar formato de fondo amarillo
$sheet->getStyle('A2:M2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FDD868');
$sheet->getStyle('A3:M3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FDE49B');

// Aplicar negrita
$sheet->getStyle('A2')->getFont()->setBold(true);
$sheet->getStyle('A3:M3')->getFont()->setBold(true);

// Ajustar el tamaño de la fuente y el alineado
$sheet->getStyle('A2:M2')->getFont()->setSize(13);
$sheet->getStyle('A3:M3')->getFont()->setSize(10);
$sheet->getStyle('A2:M2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A2:M2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$sheet->getStyle('A3:M3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

// Agregar bordes a las celdas
$sheet->getStyle('A2:M2')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
$sheet->getStyle('A2:M2')->getBorders()->getAllBorders()->getColor()->setRGB('000000');
$sheet->getStyle('A3:M3')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
$sheet->getStyle('A3:M3')->getBorders()->getAllBorders()->getColor()->setRGB('000000');

// Establecer el ancho de las columnas de A a M (puedes ajustarlo según sea necesario)
foreach (range('A3', 'M3') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(false);
    $sheet->getColumnDimension($columnID)->setWidth(18);
}

// Encabezados de título de datos
$sheet->setCellValue('A3', 'Nombre');
$sheet->setCellValue('B3', 'Apellido paterno');
$sheet->setCellValue('C3', 'Apellido materno');
$sheet->setCellValue('D3', 'Matrícula');
$sheet->setCellValue('E3', 'Nivel escolar');
$sheet->setCellValue('F3', 'Grado escolar');
$sheet->setCellValue('G3', 'Ciclo escolar');
$sheet->setCellValue('H3', 'Género');
$sheet->setCellValue('I3', 'Municipio');
$sheet->setCellValue('J3', 'Colonia');
$sheet->setCellValue('K3', 'Medio enterado');
$sheet->setCellValue('L3', 'Promoción');
$sheet->setCellValue('M3', 'Estado');

// Adición de validación de datos
function validarLista($column, $errorTitle, $error, $promptTitle, $prompt, $datos, $spreadsheet){
    // Agregar la validación de datos para la lista desplegable en la columna
    for ($row = 4; $row <= 100; $row++) {
        $cell = $column . $row;
        $validation = $spreadsheet->getActiveSheet()->getCell($cell)->getDataValidation();
        
        // Establecer la validación de tipo lista
        $validation->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
        $validation->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION );
        $validation->setAllowBlank(false);
        $validation->setShowInputMessage(true);
        $validation->setShowErrorMessage(true);
        $validation->setShowDropDown(true);
        $validation->setErrorTitle($errorTitle);
        $validation->setError($error);
        $validation->setPromptTitle($promptTitle);
        $validation->setPrompt($prompt);
        $validation->setFormula1('"' . implode(',', array_map('addslashes', $datos)) . '"');
    }
}

$column = "E";
$errorTitle = "Dato inválido";
$error = "El valor no es alguno dentro de la lista";
$prompTitle = "Seleccione un elemento";
$prompt = "Por favor seleccione un elemento de la lista";

validarLista($column, $errorTitle, $error, $prompTitle, $prompt, $nivelesDescripcion, $spreadsheet);

$column = "F";
validarLista($column, $errorTitle, $error, $prompTitle, $prompt, $gradosDescripcion, $spreadsheet);

$column = "G";
validarLista($column, $errorTitle, $error, $prompTitle, $prompt, $ciclosDescripcion, $spreadsheet);

$column = "H";
validarLista($column, $errorTitle, $error, $prompTitle, $prompt, $generosDescripcion, $spreadsheet);

$column = "I";
validarLista($column, $errorTitle, $error, $prompTitle, $prompt, $municipiosDescripcion, $spreadsheet);

// FALTA COLONIAS

$column = "K";
validarLista($column, $errorTitle, $error, $prompTitle, $prompt, $mediosDescripcion, $spreadsheet);

// FALTA PROMOCION

$column = "M";
validarLista($column, $errorTitle, $error, $prompTitle, $prompt, $estadosDescripcion, $spreadsheet);

// Guardar el archivo Excel
$writer = new Xlsx($spreadsheet);

// Forzar descarga del archivo Excel generado
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Excel_De_Importacion.xlsx"');
header('Cache-Control: max-age=0');

// Guardar el archivo directamente en el flujo de salida para que el usuario lo descargue
$writer->save('php://output');
exit;
