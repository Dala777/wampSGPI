<?php

require('./fpdf.php');
require('../modelo/modelo.php'); // Incluimos el archivo con la clase DB




class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        global $_DB; // Accedemos a la instancia de la base de datos

        // Obtener un proyecto para mostrar en la cabecera
        if ($proyectos = $_DB->obtenerProyectos()) {
            $sql = current($proyectos); // Tomamos el primer proyecto
        } else {
            die("Error en la consulta: " . $_DB->error);
        }

        $this->Image('logo.png', 240, 5, 30); // Ajustamos el logo
        $this->SetFont('Arial', 'B', 14); // Tipo fuente, negrita, tamaño
        $this->Cell(100); // Movernos a la derecha
        $this->SetTextColor(0, 0, 0); // Color

        // Celda con el nombre 
        $this->Cell(130, 10, utf8_decode('GESTION DE PROYECTOS INTEGRADORES'), 1, 1, 'C', 0); 
        $this->Ln(3); // Salto de línea
        $this->SetTextColor(103); // Color

        // Información adicional del proyecto
        $info_labels = [
            "Cantidad de Proyectos : " => '',
            "Palabras clave : " => $sql['palabras_clave'] ?? ''
        ];
        
        foreach ($info_labels as $label => $value) {
            $this->Cell(80); // Movernos a la derecha
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(130, 10, utf8_decode($label . $value), 0, 1, 'C', 0);
        }

        $this->Ln(10);

        // Título de la tabla
        $this->SetTextColor(228, 100, 0);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(20); // Movernos a la derecha
        $this->Cell(250, 10, utf8_decode("REPORTE DE PROYECTOS"), 0, 1, 'C', 0);
        $this->Ln(7);

        // Campos de la tabla con anchos ajustados
        $this->SetFillColor(228, 100, 0); // Color fondo
        $this->SetTextColor(255, 255, 255); // Color texto
        $this->SetDrawColor(163, 163, 163); // Color borde
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(15, 8, utf8_decode('ID'), 1, 0, 'C', 1);
        $this->Cell(20, 8, utf8_decode('Codigo SIS'), 1, 0, 'C', 1);
        $this->Cell(35, 8, utf8_decode('Nombre del Proyecto'), 1, 0, 'C', 1);
        $this->Cell(45, 8, utf8_decode('Descripcion'), 1, 0, 'C', 1);
        $this->Cell(35, 8, utf8_decode('Palabras Clave'), 1, 0, 'C', 1);
        $this->Cell(35, 8, utf8_decode('Area / Enfoque'), 1, 0, 'C', 1);
        $this->Cell(25, 8, utf8_decode('Integrador'), 1, 0, 'C', 1);
        $this->Cell(20, 8, utf8_decode('Estado'), 1, 0, 'C', 1);
        $this->Cell(20, 8, utf8_decode('Semestre'), 1, 0, 'C', 1);
        $this->Cell(20, 8, utf8_decode('Sede'), 1, 1, 'C', 1);
    }

    // Pie de página
    function Footer()
    {
        $this->SetY(-15); // Posición a 1,5 cm del final
        $this->SetFont('Arial', 'I', 8); // Tipo fuente, cursiva, tamaño texto
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); // Pie de página

        $this->SetY(-15); // Posición a 1,5 cm del final
        $this->SetFont('Arial', 'I', 8); // Tipo fuente, cursiva, tamaño texto
        $hoy = date('d/m/Y');
        $this->Cell(0, 10, utf8_decode($hoy), 0, 0, 'C'); // Pie de página con la fecha
    }
}

$pdf = new PDF();
$pdf->AddPage("landscape"); // Orientación y tamaño
$pdf->AliasNbPages(); // Muestra la página / y total de páginas

$pdf->SetFont('Arial', '', 8); // Reducimos el tamaño de la fuente para que se ajuste mejor
$pdf->SetDrawColor(163, 163, 163); // Color borde

$datos_reporte = $_DB->obtenerProyectos(); // Obtenemos todos los proyectos

foreach ($datos_reporte as $fila) {
    $pdf->Cell(15, 8, utf8_decode($fila['id_proyecto']), 1, 0, 'C', 0);
    $pdf->Cell(20, 8, utf8_decode($fila['codigo_sis']), 1, 0, 'C', 0);
    $pdf->Cell(35, 8, utf8_decode($fila['nombre_proyecto']), 1, 0, 'C', 0);
    $pdf->Cell(45, 8, utf8_decode($fila['descripcion']), 1, 0, 'C', 0);
    $pdf->Cell(35, 8, utf8_decode($fila['palabras_clave']), 1, 0, 'C', 0);
    $pdf->Cell(35, 8, utf8_decode($fila['area_enfoque']), 1, 0, 'C', 0);
    $pdf->Cell(25, 8, utf8_decode($fila['integrador']), 1, 0, 'C', 0);
    $pdf->Cell(20, 8, utf8_decode($fila['estado']), 1, 0, 'C', 0);
    $pdf->Cell(20, 8, utf8_decode($fila['semestre']), 1, 0, 'C', 0);
    $pdf->Cell(20, 8, utf8_decode($fila['sede']), 1, 1, 'C', 0);
}

$pdf->Output('Prueba2.pdf', 'I'); // nombreDescarga, Visor(I->visualizar - D->descargar)
?>
Este código incluye un contador de filas (total_proyectos) que