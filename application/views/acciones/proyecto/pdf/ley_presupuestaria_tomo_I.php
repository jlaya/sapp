<?php

$this->load->model('model_standard/ModelStandard'); # Llamado a el modelo Estandard

$this->pdf   = new PdfLey($orientation = 'L', $unit        = 'mm', $format      = 'A4');
// Agregamos una página
$this->pdf->AddPage();
// Define el alias para el número de página que se imprimirá en el pie
$this->pdf->AliasNbPages();

/* Se define el titulo, márgenes izquierdo, derecho y
 * el color de relleno predeterminado
 */
$this->pdf->SetTitle(utf8_decode("Tomo I"));
$this->pdf->SetLeftMargin(15);
$this->pdf->SetRightMargin(15);
$this->pdf->SetFillColor(56, 119, 119);
// Se define el formato de fuente: Arial, negritas, tamaño 9
$this->pdf->SetFont('Arial', 'B', 9);
/*
 * Encabezado principal del Tomo (Ley Presupuestaria)
 */
$this->pdf->Ln(3);
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Ln(7);
$this->pdf->Cell(180, 7, utf8_decode('Presupuestos de Ingresos, Gastos y Operaciones de Financiamiento de los Órganos y Unidades de'), '', 0, 'C', '1');
$this->pdf->Ln(7);
$this->pdf->Cell(180, 7, utf8_decode('Apoyo del Estado Bolivariano de Aragua'), '', 1, 'C', '1');


/*
 * Información pre-liminar de los proyectos
 */
$this->pdf->AddPage();
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(56, 119, 119);
$this->pdf->Ln(9);
$this->pdf->Cell(180,5, utf8_decode('RESUMEN DE PROYECTOS'), 'TBLR', 0, 'L', '1');
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Ln(5);
$this->pdf->SetFont('Arial', '', 6);
/*$this->pdf->Cell(180, 5, utf8_decode('DENOMINACIÓN'), 'TRLB', 1, 'C', '1');
$this->pdf->MultiCell(180, 5, utf8_decode("ARAGUA, CIUDAD JARDÍN"), 'LTBR', 'J', 0);*/
//$this->pdf->Cell(21,3, utf8_decode('ESTRUCTURA'), 'LRT', 1, 'C', '1');
//$this->pdf->Cell(21,3, utf8_decode('PRESUPUESTARIA'), 'LRB', 1, 'C', '1');
$this->pdf->SetFillColor(190, 190, 190);
$this->pdf->MultiCell(180, 6, utf8_decode("FUENTE DE FINANCIAMIENTO"), 'LTBR', 'C', 1);
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->SetFont('Arial', 'B', 5);
$this->pdf->Cell(21,6, utf8_decode('ESTRUCTURA'), 'LTBR', 0, 'C', '1');
$this->pdf->Cell(23,3, utf8_decode('SITUADO'), 'LRT', 1, 'C', '1');
$this->pdf->Cell(21,5);
$this->pdf->Cell(23,3, utf8_decode('CONSTITUCIONAL'), 'LRB', 1, 'C', '1');
$this->pdf->Cell(21,5);
$this->pdf->SetY(82);
$this->pdf->SetX(59.0);
$this->pdf->Cell(23,3, utf8_decode('GESTIÓN'), 'LRT', 1, 'C', '1');
$this->pdf->Cell(21,5);
$this->pdf->SetY(85);
$this->pdf->SetX(59.0);
$this->pdf->Cell(23,3, utf8_decode('FISCAL'), 'LRB', 0, 'C', '0');
$this->pdf->SetY(82);
$this->pdf->SetX(86);
$this->pdf->Cell(32,3, utf8_decode('FONDO DE COMPENSACIÓN'), 'TR', 1, 'C', '1');
$this->pdf->Cell(21,5);
$this->pdf->SetY(85);
$this->pdf->SetX(82);
$this->pdf->Cell(36,3, utf8_decode('INTERTERRITORIAL'), 'LRB', 0, 'C', '1');
$this->pdf->SetY(82);
$this->pdf->SetX(120);
$this->pdf->Cell(35,3, utf8_decode('TRANSFERENCIAS CORRIENTES'), 'TR', 1, 'C', '1');
$this->pdf->Cell(21,5);
$this->pdf->SetY(85);
$this->pdf->SetX(118);
$this->pdf->Cell(37,3, utf8_decode('INTERNAS DE LA REPÚBLICA'), 'LRB', 0, 'C', '1');
$this->pdf->SetY(82);
$this->pdf->SetX(160);
$this->pdf->Cell(35,3, utf8_decode('TOTAL PRESUPUESTARIO'), 'TR', 1, 'C', '1');
$this->pdf->Cell(21,5);
$this->pdf->SetY(85);
$this->pdf->SetX(155);
$this->pdf->Cell(40,3, utf8_decode('2016'), 'LRB', 0, 'C', '1');


// Ciclo foreach recorrido de los datos pertenecientes a los proyectos

$this->pdf->SetLineWidth(0.0);
$this->pdf->Line(15, 75, 15, 280);  #LINEA DE MARGEN IZQUIERDO
$this->pdf->Line(195, 75, 195, 280);  #LINEA DE MARGEN DERECHO

$this->pdf->SetY(89);
foreach (range(1, 4) as $row) {
    $this->pdf->SetFont('Arial', '', 6);
    $this->pdf->Ln(0);
    $this->pdf->Cell(21,5, utf8_decode('01-04-03-01'), '', 0, 'C', '1');
    $this->pdf->Cell(23,5, utf8_decode('3.111.078.380,82'), '', 0, 'C', '1');
    $this->pdf->Cell(23,5, utf8_decode('0.00'), '', 0, 'C', '1');
    $this->pdf->Cell(36,5, utf8_decode('0.00'), '', 0, 'C', '1');
    $this->pdf->Cell(37,5, utf8_decode('0.00'), '', 0, 'C', '1');
    $this->pdf->Cell(40,5, utf8_decode('0.00'), '', 1, 'C', '1');
    
}
$this->pdf->Ln(65);
$this->pdf->Cell(180,5, utf8_decode('Sub-Total de Proyectos'), '', 0, 'L', '1');
// Salida del Formato PDF

$this->pdf->Output("Ley Presupuestaria 2016.pdf", 'I');
