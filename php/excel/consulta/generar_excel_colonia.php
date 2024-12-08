<?php

require_once __DIR__ . '/../../conexion.php';

require_once __DIR__ . "/../../../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

$pdo = Conexion::connection();

if (!$pdo) {
    throw new UnexpectedValueException("Error de conexión a la base de datos");
}

if (!isset($_POST['alumnos'])){
    exit('No hay alumnos seleccionados');
}

$alumnos = json_decode($_POST['alumnos'], true);
$ngc = $alumnos[0]['ngc'];

try {
    $query = "
        SELECT
            ne.descripcion AS nivel_educativo,
            g.descripcion AS grado,
            c.descripcion AS ciclo
        FROM
            nivel_grado_ciclo ngc
        INNER JOIN
            nivel_educativo ne ON ngc.nivel_educativo_id = ne.id
        INNER JOIN
            grado g ON ngc.grado_id = g.id
        INNER JOIN
            ciclo c ON ngc.ciclo_id = c.id
        WHERE
            ngc.id = :ngc
    ";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':ngc', $ngc, PDO::PARAM_INT);
    $stmt->execute();
    $nivel_grado_ciclo = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$nivel_grado_ciclo) {
        throw new UnexpectedValueException("No se encontraron datos para el NGC: $ngc");
    }

    $ids = array_column($alumnos, 'id');
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    
    $queryAlumnos = "
        SELECT
            a.nombre,
            a.Ap,
            a.Am,
            a.matricula,
            m.descripcion AS municipio,
            c.descripcion AS colonia,
            g.descripcion AS genero,
            e.descripcion AS estado_alumno,
            me.descripcion AS medio_enterado,
            p.descripcion AS promocion
        FROM
            alumno a
        INNER JOIN
            municipio m ON a.municipio = m.id
        INNER JOIN
            colonia c ON a.colonia = c.id
        INNER JOIN
            genero g ON a.genero = g.id
        INNER JOIN
            estado e ON a.estado = e.id
        INNER JOIN
            medio_enterado me ON a.medio_enterado = me.id
        INNER JOIN
            promocion p ON a.promocion = p.id
        WHERE
            a.id IN ($placeholders) -- Usar los placeholders para los IDs
    ";
    $stmtAlumnos = $pdo->prepare($queryAlumnos);
    $stmtAlumnos->execute($ids); // Pasar los IDs como parámetros
    $alumnosData = $stmtAlumnos->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->mergeCells('A2:J2');

$sheet->setCellValue('A2', 'ALUMNOS ' . $nivel_grado_ciclo['nivel_educativo'] . ' - ' . $nivel_grado_ciclo['grado'] . ' - ' . $nivel_grado_ciclo['ciclo']);

$sheet->getStyle('A2:J2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FDD868');
$sheet->getStyle('A3:J3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FDE49B');

$sheet->getStyle('A2')->getFont()->setBold(true);
$sheet->getStyle('A3:J3')->getFont()->setBold(true);

$sheet->getStyle('A2:J2')->getFont()->setSize(24);
$sheet->getStyle('A3:J3')->getFont()->setSize(12);
$sheet->getStyle('A2:J2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A2:J2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$sheet->getStyle('A3:J3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

$sheet->getStyle('A2:J2')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
$sheet->getStyle('A2:J2')->getBorders()->getAllBorders()->getColor()->setRGB('000000');
$sheet->getStyle('A3:J3')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
$sheet->getStyle('A3:J3')->getBorders()->getAllBorders()->getColor()->setRGB('000000');

foreach (range('A3', 'J3') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(false);
    $sheet->getColumnDimension($columnID)->setWidth(21);
}

$sheet->setCellValue('A3', 'Nombre');
$sheet->setCellValue('B3', 'Apellido paterno');
$sheet->setCellValue('C3', 'Apellido materno');
$sheet->setCellValue('D3', 'Matrícula');
$sheet->setCellValue('E3', 'Género');
$sheet->setCellValue('F3', 'Municipio');
$sheet->setCellValue('G3', 'Colonia');
$sheet->setCellValue('H3', 'Medio enterado');
$sheet->setCellValue('I3', 'Promoción');
$sheet->setCellValue('J3', 'Estado');

$row = 4;
foreach ($alumnosData as $alumno) {
    $sheet->setCellValue('A' . $row, $alumno['nombre']);
    $sheet->setCellValue('B' . $row, $alumno['Ap']);
    $sheet->setCellValue('C' . $row, $alumno['Am']);
    $sheet->setCellValue('D' . $row, $alumno['matricula']);
    $sheet->setCellValue('E' . $row, $alumno['genero']);
    $sheet->setCellValue('F' . $row, $alumno['municipio']);
    $sheet->setCellValue('G' . $row, $alumno['colonia']);
    $sheet->setCellValue('H' . $row, $alumno['medio_enterado']);
    $sheet->setCellValue('I' . $row, $alumno['promocion']);
    $sheet->setCellValue('J' . $row, $alumno['estado_alumno']);

    $color = ($row % 2 === 0) ? 'FCD5B4' : 'FDE9D9';
    $sheet->getStyle("A$row:J$row")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($color);
    $sheet->getStyle("A$row:J$row")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle("A$row:J$row")->getBorders()->getAllBorders()->getColor()->setRGB('000000');

    $spreadsheet->getActiveSheet()->getRowDimension($row)->setRowHeight(18);
    $sheet->getStyle('A' . $row . ":J" . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    
    $row++;
}

$writer = new Xlsx($spreadsheet);
$fileName = 'Listado_de_Alumnos.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $fileName . '"');
header('Cache-Control: max-age=0');
$writer->save('php://output');

exit();
