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

function obtenerDescripciones($pdo, $tabla) {
    $query = "SELECT descripcion FROM $tabla";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return array_column($resultados, 'descripcion');
}

$nivelesDescripcion = obtenerDescripciones($pdo, 'nivel_educativo');

$gradosDescripcion = obtenerDescripciones($pdo, 'grado');

$ciclosDescripcion = obtenerDescripciones($pdo, 'ciclo');

$generosDescripcion = obtenerDescripciones($pdo, 'genero');

$municipiosDescripcion = obtenerDescripciones($pdo, 'municipio');

$coloniasDescripcion = obtenerDescripciones($pdo, 'colonia');

$mediosDescripcion = obtenerDescripciones($pdo, 'medio_enterado');

$promocionesDescripcion = obtenerDescripciones($pdo, 'promocion');

$estadosDescripcion = obtenerDescripciones($pdo, 'estado');

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

for ($i = 4; $i <= 100; $i++) {
    $color = $i % 2 === 0 ? 'FCD5B4' : 'FDE9D9';
    $sheet->getStyle("A$i:M$i")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($color);
    $sheet->getStyle("A$i:M$i")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle("A$i:M$i")->getBorders()->getAllBorders()->getColor()->setRGB('000000');
}

// Aplicar negrita
$sheet->getStyle('A2')->getFont()->setBold(true);
$sheet->getStyle('A3:M3')->getFont()->setBold(true);

// Ajustar el tamaño de la fuente y el alineado
$sheet->getStyle('A2:M2')->getFont()->setSize(24);
$sheet->getStyle('A3:M3')->getFont()->setSize(12);
$sheet->getStyle('A2:M2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A2:M2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$sheet->getStyle('A3:M3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

// Agregar bordes a las celdas
$sheet->getStyle('A2:M2')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
$sheet->getStyle('A2:M2')->getBorders()->getAllBorders()->getColor()->setRGB('000000');
$sheet->getStyle('A3:M3')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
$sheet->getStyle('A3:M3')->getBorders()->getAllBorders()->getColor()->setRGB('000000');

// Establecer el ancho de las columnas de A a M
foreach (range('A3', 'M3') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(false);
    $sheet->getColumnDimension($columnID)->setWidth(21);
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
        $spreadsheet->getActiveSheet()->getRowDimension($row)->setRowHeight(20);
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

function addError($column, $sheet){
    for($row = 4; $row <= 100; $row){
        $cell = $column . $row;
        $comment = $sheet->getComment($cell);
        $comment->getText()->createTextRun('Demasiados datos en la base de datos, error de importación.');

        $comment->setWidth('150pt');
        $comment->setHeight('50pt');
    }
}

function contarCaracteresDatos($datos) {
    $datosCadena = implode(',', array_map('addslashes', $datos));
    return strlen($datosCadena);
}

$column = "E";
$errorTitle = "Dato inválido";
$error = "El valor no es alguno dentro de la lista";
$prompTitle = "Seleccione un elemento";
$prompt = "Por favor seleccione un elemento de la lista";

if (contarCaracteresDatos($nivelesDescripcion) <= 255) {
    validarLista($column, $errorTitle, $error, $prompTitle, $prompt, $nivelesDescripcion, $spreadsheet);
}

if (contarCaracteresDatos($gradosDescripcion) <= 255) {
    $column = "F";
    validarLista($column, $errorTitle, $error, $prompTitle, $prompt, $gradosDescripcion, $spreadsheet);
}

if (contarCaracteresDatos($ciclosDescripcion) <= 255) {
    $column = "G";
    validarLista($column, $errorTitle, $error, $prompTitle, $prompt, $ciclosDescripcion, $spreadsheet);
}

if (contarCaracteresDatos($generosDescripcion) <= 255) {
    $column = "H";
    validarLista($column, $errorTitle, $error, $prompTitle, $prompt, $generosDescripcion, $spreadsheet);
}

if (contarCaracteresDatos($municipiosDescripcion) <= 255) {
    $column = "I";
    validarLista($column, $errorTitle, $error, $prompTitle, $prompt, $municipiosDescripcion, $spreadsheet);
}

if (contarCaracteresDatos($coloniasDescripcion) <= 255) {
    $column = "J";
    validarLista($column, $errorTitle, $error, $prompTitle, $prompt, $coloniasDescripcion, $spreadsheet);
}

if (contarCaracteresDatos($mediosDescripcion) <= 255) {
    $column = "K";
    validarLista($column, $errorTitle, $error, $prompTitle, $prompt, $mediosDescripcion, $spreadsheet);
}

if (contarCaracteresDatos($promocionesDescripcion) <= 255) {
    $column = "L";
    validarLista($column, $errorTitle, $error, $prompTitle, $prompt, $promocionesDescripcion, $spreadsheet);
}

if (contarCaracteresDatos($estadosDescripcion) <= 255) {
    $column = "M";
    validarLista($column, $errorTitle, $error, $prompTitle, $prompt, $estadosDescripcion, $spreadsheet);
}

$writer = new Xlsx($spreadsheet);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Excel_De_Importacion.xlsx"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;
