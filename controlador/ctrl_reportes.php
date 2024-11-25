<?php
require_once('../modelo/modelo.php');
require_once('../fpdf/fpdf.php');

// Ocultar errores y advertencias mientras se genera el PDF
error_reporting(0);

// Obtener los filtros desde la URL
$integrador = isset($_GET['integrador']) ? $_GET['integrador'] : '';
$estado = isset($_GET['estado']) ? $_GET['estado'] : '';
$semestre = isset($_GET['semestre']) ? $_GET['semestre'] : '';

// Construir la consulta con filtros
$sql = "SELECT codigo_sis, nombre_proyecto, descripcion, palabras_clave, area_enfoque, integrador, estado, semestre, sede 
        FROM proyectos_integradores 
        WHERE 1";
$parametros = [];

// Filtrar por Integrador
if (!empty($integrador)) {
    $sql .= " AND integrador = ?";
    $parametros[] = $integrador;
}

// Filtrar por Estado
if (!empty($estado)) {
    $sql .= " AND estado = ?";
    $parametros[] = $estado;
}

// Filtrar por Semestre
if (!empty($semestre)) {
    $sql .= " AND semestre = ?";
    $parametros[] = $semestre;
}

// Obtener proyectos filtrados
$proyectos = $_DB->select($sql, $parametros);

// Generar reporte PDF
if (isset($_GET['action']) && $_GET['action'] == 'pdf') {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    // Encabezado del reporte
    $pdf->SetTextColor(50, 50, 50);
    $pdf->Cell(0, 10, 'Reporte de Proyectos Integradores', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Fecha: ' . date('d-m-Y'), 0, 1, 'C');
    $pdf->Ln(5);

    // Mostrar filtros aplicados
    $pdf->SetFont('Arial', '', 10);
    $filtros = "Filtros aplicados: ";
    if ($integrador) $filtros .= "Integrador: $integrador, ";
    if ($estado) $filtros .= "Estado: $estado, ";
    if ($semestre) $filtros .= "Semestre: $semestre, ";
    $filtros = rtrim($filtros, ", ");
    if ($filtros === "Filtros aplicados:") $filtros .= "Ninguno";
    $pdf->Cell(0, 10, utf8_decode($filtros), 0, 1, 'C');
    $pdf->Ln(10);

    // Configuración de la tabla
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetFillColor(200, 200, 200);
    $pdf->Cell(25, 10, 'Código SIS', 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'Nombre', 1, 0, 'C', true);
    $pdf->Cell(55, 10, 'Descripción', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Palabras Clave', 1, 0, 'C', true);
    $pdf->Cell(25, 10, 'Integrador', 1, 0, 'C', true);
    $pdf->Cell(20, 10, 'Estado', 1, 0, 'C', true);
    $pdf->Cell(15, 10, 'Sem.', 1, 0, 'C', true);
    $pdf->Cell(25, 10, 'Sede', 1, 1, 'C', true);

    // Contenido de los proyectos
    $pdf->SetFont('Arial', '', 10);
    foreach ($proyectos as $proyecto) {
        $pdf->Cell(25, 10, $proyecto['codigo_sis'], 1);
        $pdf->Cell(40, 10, mb_convert_encoding($proyecto['nombre_proyecto'], 'ISO-8859-1', 'UTF-8'), 1);
        $pdf->Cell(55, 10, mb_convert_encoding($proyecto['descripcion'], 'ISO-8859-1', 'UTF-8'), 1);
        $pdf->Cell(30, 10, mb_convert_encoding($proyecto['palabras_clave'], 'ISO-8859-1', 'UTF-8'), 1);
        $pdf->Cell(25, 10, $proyecto['integrador'], 1);
        $pdf->Cell(20, 10, $proyecto['estado'], 1);
        $pdf->Cell(15, 10, $proyecto['semestre'], 1);
        $pdf->Cell(25, 10, $proyecto['sede'], 1, 1);
    }

    // Salida del PDF
    $pdf->Output();
    // Reactivar la visualización de errores después del PDF
    error_reporting(E_ALL);
    exit;
}

// Generar reporte CSV
if (isset($_GET['action']) && $_GET['action'] == 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=reportes.csv');

    $output = fopen('php://output', 'w');

    // Encabezados del CSV
    fputcsv($output, ['Código SIS', 'Nombre', 'Descripción', 'Palabras Clave', 'Área / Enfoque', 'Integrador', 'Estado', 'Semestre', 'Sede']);

    // Contenido del CSV
    foreach ($proyectos as $proyecto) {
        fputcsv($output, [
            $proyecto['codigo_sis'],
            $proyecto['nombre_proyecto'],
            $proyecto['descripcion'],
            $proyecto['palabras_clave'],
            $proyecto['area_enfoque'],
            $proyecto['integrador'],
            $proyecto['estado'],
            $proyecto['semestre'],
            $proyecto['sede']
        ]);
    }

    fclose($output);
    // Reactivar la visualización de errores después del CSV
    error_reporting(E_ALL);
    exit;
}
?>
