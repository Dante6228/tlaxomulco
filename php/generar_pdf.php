<?php

require_once __DIR__ . '/fpdf/fpdf.php';
require_once __DIR__ . '/conexion.php';

$pdo = Conexion::connection();

if (!$pdo) {
    throw new UnexpectedValueException("Error de conexión a la base de datos");
}

if (isset($_GET['alumnos'])) {
    $alumnos = json_decode($_GET['alumnos'], true);
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
                a.nivel_grado_ciclo_id = :ngc
        ";
        $stmtAlumnos = $pdo->prepare($queryAlumnos);
        $stmtAlumnos->bindParam(':ngc', $ngc, PDO::PARAM_INT);
        $stmtAlumnos->execute();
        $alumnosData = $stmtAlumnos->fetchAll(PDO::FETCH_ASSOC);

        $pdf = new FPDF('L');
        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 24);
        $pdf->SetTextColor(80, 80, 80);
        $titulo = mb_convert_encoding('Listado de Alumnos - ' . implode(', ', $nivel_grado_ciclo), 'ISO-8859-1', 'UTF-8');
        $pdf->Cell(0, 10, $titulo, 0, 1, 'C');
        $pdf->Ln(10);

        $ancho_columna_nombre = 70;
        $ancho_columna_matricula = 25;
        $ancho_columna_ubicacion = 65;
        $ancho_columna_genero = 20;
        $ancho_columna_estado_alumno = 30;
        $ancho_columna_medio_enterado = 40;
        $ancho_columna_promocion = 45;

        $ancho_total = $ancho_columna_nombre + $ancho_columna_matricula + $ancho_columna_ubicacion + $ancho_columna_genero + $ancho_columna_estado_alumno + $ancho_columna_medio_enterado + $ancho_columna_promocion;

        $x_inicio = ($pdf->GetPageWidth() - $ancho_total) / 2;

        $pdf->SetFillColor(217, 230, 255);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', 'B', 12);

        $pdf->SetX($x_inicio);
        
        $pdf->Cell($ancho_columna_nombre, 10, mb_convert_encoding('Nombre Completo', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', true);
        $pdf->Cell($ancho_columna_matricula, 10, mb_convert_encoding('Matrícula', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', true);
        $pdf->Cell($ancho_columna_ubicacion, 10, mb_convert_encoding('Ubicación', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', true);
        $pdf->Cell($ancho_columna_genero, 10, mb_convert_encoding('Género', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', true);
        $pdf->Cell($ancho_columna_estado_alumno, 10, mb_convert_encoding('Estado', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', true);
        $pdf->Cell($ancho_columna_medio_enterado, 10, mb_convert_encoding('Medio Enterado', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', true);
        $pdf->Cell($ancho_columna_promocion, 10, mb_convert_encoding('Promoción', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', true);
        $pdf->Ln();

        $pdf->SetTextColor(50, 50, 50);
        $pdf->SetFont('Arial', '', 10);

        foreach ($alumnosData as $alumno) {
            $nombre_completo = $alumno['nombre'] . ' ' . $alumno['Ap'] . ' ' . $alumno['Am'];
            $ubicacion = $alumno['municipio'] . ', ' . $alumno['colonia'];
            $pdf->SetX($x_inicio);
            $pdf->Cell($ancho_columna_nombre, 10, mb_convert_encoding($nombre_completo, 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
            $pdf->Cell($ancho_columna_matricula, 10, $alumno['matricula'], 1, 0, 'C');
            $pdf->Cell($ancho_columna_ubicacion, 10, mb_convert_encoding($ubicacion, 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
            $pdf->Cell($ancho_columna_genero, 10, mb_convert_encoding($alumno['genero'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
            $pdf->Cell($ancho_columna_estado_alumno, 10, mb_convert_encoding($alumno['estado_alumno'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
            $pdf->Cell($ancho_columna_medio_enterado, 10, mb_convert_encoding($alumno['medio_enterado'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
            $pdf->Cell($ancho_columna_promocion, 10, mb_convert_encoding($alumno['promocion'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
            $pdf->Ln();
        }

        $pdf->Output('D', 'Listado_de_Alumnos.pdf');
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo 'No se recibieron alumnos.';
}

