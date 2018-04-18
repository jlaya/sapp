<?php

$this->pdf   = new Pdf($orientation = 'L', $unit        = 'mm', $format      = 'A4');
// Agregamos una página
$this->pdf->AddPage();
// Define el alias para el número de página que se imprimirá en el pie
$this->pdf->AliasNbPages();

/* Se define el titulo, márgenes izquierdo, derecho y
 * el color de relleno predeterminado
 */
$this->pdf->SetTitle(utf8_decode("Acción Centralizada"));
$this->pdf->SetLeftMargin(15);
$this->pdf->SetRightMargin(15);
$this->pdf->SetFillColor(139, 28, 28);
// Se define el formato de fuente: Arial, negritas, tamaño 9
$this->pdf->SetFont('Arial', 'B', 9);
/*
 * TITULOS DE COLUMNAS
 *
 * $this->pdf->Cell(Ancho, Alto,texto,borde,posición,alineación,relleno);
 */
// El encabezado del PDF
#$this->Image('imagenes/logo.png',10,8,22);
$this->pdf->SetFont('Arial', 'B', 13);
$this->pdf->Cell(30);
$this->pdf->Cell(180, 7, utf8_decode('Dirección General de Planificación, Presupuesto'), '', 0, 'L', '0');
$this->pdf->Ln('5');
$this->pdf->Cell(50);
$this->pdf->Cell(180, 7, utf8_decode(' y Optimización Organizacional'), '', 1, 'L', '0');
$this->pdf->Ln('1');
$this->pdf->SetFont('Arial', 'B', 12);
$this->pdf->Cell(30);
$this->pdf->Cell(120, 10, utf8_decode('Acción Centralizada'), 0, 0, 'C');
$this->pdf->Ln(10);
$this->pdf->SetFont('Arial', 'B', 10);
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->Cell(180.2, 5, utf8_decode('1. IDENTIFICACIÓN DEL PROPONENTE'), 'TBL', 1, 'C', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
if (strlen($row->nom_ins) > 80) {
    $x = 10;
} else {
    $x = 7;
}
$this->pdf->Cell(45, $x, utf8_decode('1.1 Organismo/Ente/Empresa:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->MultiCell(135, 5, utf8_decode($row->nom_ins), 'TBR', 'J', 1);
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(50, 7, utf8_decode('1.2 Nombre de la Máxima Autoridad:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(90, 7, utf8_decode($row->m_autoridad), 'TBR', 0, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(10, 7, utf8_decode('1.3. C.I.:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(30, 7, $row->cedula, 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(20, 7, utf8_decode('1.4 Cargo:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(160, 7, utf8_decode($row->cargo), 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(40, 7, utf8_decode('1.5. Correo Electrónico:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(95, 7, utf8_decode($row->correo), 'TBRL', 0, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(20, 7, utf8_decode('1.6. Teléfono:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(25, 7, utf8_decode($row->tlf), 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 10);
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(139, 28, 28);
$this->pdf->Cell(180.2, 6.5, utf8_decode('2. POLÍTICA PRESUPUESTARIA'), 'TBL', 0, 'C', '1');
$this->pdf->Ln(7);
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->MultiCell(180, 5, utf8_decode($row->politica_presupuestaria), 'LBR', 'J', 1);
$this->pdf->SetFont('Arial', 'B', 10);
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(139, 28, 28);
$this->pdf->Cell(180.2, 5, utf8_decode('3. DATOS BÁSICOS DE LA ACCIÓN CENTRALIZADA'), 'TBL', 1, 'C', '1');
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(191, 191, 191);
$this->pdf->Cell(180.2, 5, utf8_decode('3.1 ACCIÓN CENTRALIZADA'), 'TBLR', 1, 'C', '1');
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(55, 7, utf8_decode('3.1 Nombre de la Accion Centralizada:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(125, 7, utf8_decode($acc_centralizada->accion_centralizada), 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(180, 7, utf8_decode('3.2 Nombre de la Accion Específica:'), 'TRL', 0, 'L', '1');
$this->pdf->Ln(7);
$this->pdf->SetFont('Arial', '', 8);
foreach ($accion_especifica as $row) {
    $this->pdf->MultiCell(180, 5, utf8_decode($row->accion_especifica . "."), 'LR', 'J', 0);
}
$this->pdf->SetFont('Arial', 'B', 10);
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(139, 28, 28);
$this->pdf->Cell(180.2, 5, utf8_decode('4 ACTIVIDADES DE LA ACCIÓN ESPECÍFICA'), 'TBL', 1, 'C', '1');
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(127, 127, 127);
$this->pdf->Cell(180.2, 5, utf8_decode('4.1 Distribución de las Actividades'), 'TBLR', 1, 'C', '1');

$x = 1;
foreach ($actividades as $row) {

    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(191, 191, 191);
    $this->pdf->Cell(180, 5, utf8_decode('Actividad'), 'TBLR', 0, 'C', '1');
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(255, 255, 255);
    $this->pdf->SetFont('Arial', '', 7);
    $this->pdf->Ln('5');
    $this->pdf->MultiCell(180, 3.8, utf8_decode($row->actividad), 'TBLR', 'L', 1);
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(191, 191, 191);
    $this->pdf->Cell(20, 5, 'Unidad/Medida:', 'TBLR', 0, 'C', '1');
    $this->pdf->SetFont('Arial', '', 6.5);
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(255, 255, 255);
    $this->pdf->Cell(58, 5, utf8_decode($row->unidad_medida), 'TBLR', 0, 'L', '1');
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(191, 191, 191);
    $this->pdf->Cell(25, 5, utf8_decode('Medio/Verificación:'), 'TBLR', 0, 'C', '1');
    $this->pdf->SetFont('Arial', '', 6.5);
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(255, 255, 255);
    $this->pdf->Cell(77, 5, utf8_decode($row->medio_verificacion), 'TBLR', 1, 'L', '1');
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(191, 191, 191);
    $this->pdf->Cell(20, 5, 'Cantidad', 'TBLR', 0, 'C', '1');
    $this->pdf->SetFont('Arial', '', 6.5);
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(255, 255, 255);
    $this->pdf->Cell(58, 5, $row->cantidad, 'TBLR', 0, 'L', '1');
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(191, 191, 191);
    $this->pdf->Cell(25, 5, 'Indicador/Actividad', 'TBLR', 0, 'C', '1');
    $this->pdf->SetFont('Arial', '', 6.5);
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(255, 255, 255);
    $this->pdf->Cell(77, 5, utf8_decode($row->indicador_actividad), 'TBLR', 1, 'L', '1');

    // if ($x == 6) {
    //     $this->pdf->AddPage();
    //     $this->pdf->SetFont('Arial', 'B', 13);
    //     $this->pdf->Cell(30);
    //     $this->pdf->Cell(180, 7, utf8_decode('Dirección General de Planificación, Presupuesto'), '', 0, 'L', '0');
    //     $this->pdf->Ln('5');
    //     $this->pdf->Cell(50);
    //     $this->pdf->Cell(180, 7, utf8_decode(' y Optimización Organizacional'), '', 1, 'L', '0');
    //     $this->pdf->Ln('1');
    //     $this->pdf->SetFont('Arial', 'B', 12);
    //     $this->pdf->Cell(30);
    //     $this->pdf->Cell(120, 10, utf8_decode('Acción Centralizada'), 0, 0, 'C');
    //     $this->pdf->Ln('10');
    //     $this->pdf->SetFont('Arial', 'B', 10);
    //     $this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
    //     $this->pdf->SetFillColor(139, 28, 28);
    //     $this->pdf->Cell(180.2, 5, utf8_decode('4 ACTIVIDADES DE LA ACCIÓN ESPECÍFICA'), 'TBL', 1, 'C', '1');
    //     $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    //     $this->pdf->SetFillColor(127, 127, 127);
    //     $this->pdf->Cell(180.2, 5, utf8_decode('4.1 Distribución de las Actividades'), 'TBLR', 1, 'C', '1');
    //     $this->pdf->SetFont('Arial', '', 8);
    //     $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    //     $this->pdf->SetFillColor(191, 191, 191);
    //     $this->pdf->Cell(180, 5, utf8_decode('Actividad'), 'TBLR', 0, 'C', '1');
    //     $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    //     $this->pdf->SetFillColor(255, 255, 255);
    //     $this->pdf->SetFont('Arial', '', 7);
    //     $this->pdf->Ln('5');
    //     $this->pdf->MultiCell(180, 3.8, utf8_decode($row->actividad), 'TBLR', 'L', 1);
    //     $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    //     $this->pdf->SetFillColor(191, 191, 191);
    //     $this->pdf->Cell(20, 5, 'Unidad/Medida:', 'TBLR', 0, 'C', '1');
    //     $this->pdf->SetFont('Arial', '', 6.5);
    //     $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    //     $this->pdf->SetFillColor(255, 255, 255);
    //     $this->pdf->Cell(58, 5, utf8_decode($row->unidad_medida), 'TBLR', 0, 'L', '1');
    //     $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    //     $this->pdf->SetFillColor(191, 191, 191);
    //     $this->pdf->Cell(25, 5, utf8_decode('Medio/Verificación:'), 'TBLR', 0, 'C', '1');
    //     $this->pdf->SetFont('Arial', '', 6.5);
    //     $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    //     $this->pdf->SetFillColor(255, 255, 255);
    //     $this->pdf->Cell(77, 5, utf8_decode($row->medio_verificacion), 'TBLR', 1, 'L', '1');
    //     $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    //     $this->pdf->SetFillColor(191, 191, 191);
    //     $this->pdf->Cell(20, 5, 'Cantidad', 'TBLR', 0, 'C', '1');
    //     $this->pdf->SetFont('Arial', '', 6.5);
    //     $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    //     $this->pdf->SetFillColor(255, 255, 255);
    //     $this->pdf->Cell(58, 5, $row->cantidad, 'TBLR', 0, 'L', '1');
    //     $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    //     $this->pdf->SetFillColor(191, 191, 191);
    //     $this->pdf->Cell(25, 5, 'Indicador/Actividad', 'TBLR', 0, 'C', '1');
    //     $this->pdf->SetFont('Arial', '', 6.5);
    //     $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    //     $this->pdf->SetFillColor(255, 255, 255);
    //     $this->pdf->Cell(77, 5, utf8_decode($row->indicador_actividad), 'TBLR', 1, 'L', '1');
    // }

    $x++;
}
$this->pdf->AddPage();
$this->pdf->SetFont('Arial', 'B', 13);
$this->pdf->Cell(30);
$this->pdf->Cell(180, 7, utf8_decode('Dirección General de Planificación, Presupuesto'), '', 0, 'L', '0');
$this->pdf->Ln('5');
$this->pdf->Cell(50);
$this->pdf->Cell(180, 7, utf8_decode(' y Optimización Organizacional'), '', 1, 'L', '0');
$this->pdf->Ln('1');
$this->pdf->SetFont('Arial', 'B', 12);
$this->pdf->Cell(30);
$this->pdf->Cell(120, 10, utf8_decode('Acción Centralizada'), 0, 0, 'C');
$this->pdf->Ln('10');
$this->pdf->SetFont('Arial', 'B', 10);
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(139, 28, 28);
$this->pdf->Cell(180.2, 5, utf8_decode('4.2 Distribución Trimestral de las Actividades'), 'TBLR', 1, 'C', '1');
$this->pdf->SetFont('Arial', '', 8);

$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(139, 28, 28);
$y             = 1;
$trimestre_i   = 0;
$trimestre_ii  = 0;
$trimestre_iii = 0;
$trimestre_iv  = 0;
$total         = 0;
foreach ($distrib_tri_act as $row) {
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(139, 28, 28);
    $this->pdf->Cell(180, 5, 'Actividad', 'TBLR', 1, 'C', '1');
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(255, 255, 255);
    $this->pdf->MultiCell(180, 3.8, utf8_decode($row->actividad), 'TBLR', 'L', 1);
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(191, 191, 191);
    $this->pdf->Cell(36, 5, 'I Trimestre', 'TBLR', 0, 'C', '1');
    $this->pdf->Cell(36, 5, 'II Trimestre', 'TBLR', 0, 'C', '1');
    $this->pdf->Cell(36, 5, 'III Trimestre', 'TBLR', 0, 'C', '1');
    $this->pdf->Cell(36, 5, 'IV Trimestre', 'TBLR', 0, 'C', '1');
    $this->pdf->Cell(36, 5, 'Total', 'TBLR', 1, 'C', '1');
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(255, 255, 255);
    $this->pdf->Cell(36, 5, $this->pdf->Format_Miles($row->trimestre_i), 'TBLR', 0, 'C', '1');
    $this->pdf->Cell(36, 5, $this->pdf->Format_Miles($row->trimestre_ii), 'TBLR', 0, 'C', '1');
    $this->pdf->Cell(36, 5, $this->pdf->Format_Miles($row->trimestre_iii), 'TBLR', 0, 'C', '1');
    $this->pdf->Cell(36, 5, $this->pdf->Format_Miles($row->trimestre_iv), 'TBLR', 0, 'C', '1');
    $this->pdf->Cell(36, 5, $this->pdf->Format_Miles($row->total), 'TBLR', 1, 'C', '1');
	
	//if ($y == 9) {
    if ($y == 6) {
        $this->pdf->AddPage();
        $this->pdf->SetFont('Arial', 'B', 13);
        $this->pdf->Cell(30);
        $this->pdf->Cell(180, 7, utf8_decode('Dirección General de Planificación, Presupuesto'), '', 0, 'L', '0');
        $this->pdf->Ln('5');
        $this->pdf->Cell(50);
        $this->pdf->Cell(180, 7, utf8_decode(' y Optimización Organizacional'), '', 1, 'L', '0');
        $this->pdf->Ln('1');
        $this->pdf->SetFont('Arial', 'B', 12);
        $this->pdf->Cell(30);
        $this->pdf->Cell(120, 10, utf8_decode('Acción Centralizada'), 0, 0, 'C');
        $this->pdf->Ln('10');
        $this->pdf->SetFont('Arial', 'B', 10);
        $this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
        $this->pdf->SetFillColor(139, 28, 28);
        $this->pdf->Cell(180.2, 5, utf8_decode('4.2 Distribución Trimestral de las Actividades'), 'TBLR', 1, 'C', '1');
    }

    $y = $y + 1;
    $trimestre_i +=$row->trimestre_i;
    $trimestre_ii +=$row->trimestre_ii;
    $trimestre_iii +=$row->trimestre_iii;
    $trimestre_iv +=$row->trimestre_iv;
    $total +=$row->total;
}
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(209, 153, 153);
$this->pdf->Cell(36, 5, $this->pdf->Format_Miles($trimestre_i), 'TBLR', 0, 'C', '1');
$this->pdf->Cell(36, 5, $this->pdf->Format_Miles($trimestre_ii), 'TBLR', 0, 'C', '1');
$this->pdf->Cell(36, 5, $this->pdf->Format_Miles($trimestre_iii), 'TBLR', 0, 'C', '1');
$this->pdf->Cell(36, 5, $this->pdf->Format_Miles($trimestre_iv), 'TBLR', 0, 'C', '1');
$this->pdf->Cell(36, 5, $this->pdf->Format_Miles($total), 'TBLR', 0, 'C', '1');


// 5 METAS FINANCIERAS DE LAS ACCIÓN ESPECÍFICA
$this->pdf->AddPage();
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFont('Arial', 'B', 13);
$this->pdf->Cell(30);
$this->pdf->Cell(180, 7, utf8_decode('Dirección General de Planificación, Presupuesto'), '', 0, 'L', '0');
$this->pdf->Ln('5');
$this->pdf->Cell(50);
$this->pdf->Cell(180, 7, utf8_decode(' y Optimización Organizacional'), '', 1, 'L', '0');
$this->pdf->Ln('1');
$this->pdf->SetFont('Arial', 'B', 12);
$this->pdf->Cell(30);
$this->pdf->Cell(120, 10, utf8_decode('Acción Centralizada'), 0, 0, 'C');
$this->pdf->Ln('10');
$this->pdf->SetFont('Arial', 'B', 10);
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(139, 28, 28);
$this->pdf->Cell(180.2, 5, utf8_decode('5. METAS FINANCIERAS DE LA ACCIÓN ESPECÍFICA'), 'TBLR', 1, 'C', '1');
$this->pdf->Cell(180.2, 5, utf8_decode('5.1 Distribución Trimestral'), 'TBLR', 1, 'C', '1');
$this->pdf->SetFont('Arial', '', 8);

$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(139, 28, 28);
$z              = 1;
$trimestre_if   = 0;
$trimestre_iif  = 0;
$trimestre_iiif = 0;
$trimestre_ivf  = 0;
$totalf         = 0;
foreach ($distrib_tri_fin as $row) {

    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(139, 28, 28);
    #$this->pdf->Ln('4');
    $this->pdf->Cell(180, 5, 'Actividad', 'TBLR', 1, 'C', '1');
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(255, 255, 255);
    $this->pdf->MultiCell(180, 3.8, utf8_decode($row->actividad), 'TBLR', 'L', 1);
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(191, 191, 191);
    $this->pdf->Cell(36, 5, 'I Trimestre', 'TBLR', 0, 'C', '1');
    $this->pdf->Cell(36, 5, 'II Trimestre', 'TBLR', 0, 'C', '1');
    $this->pdf->Cell(36, 5, 'III Trimestre', 'TBLR', 0, 'C', '1');
    $this->pdf->Cell(36, 5, 'IV Trimestre', 'TBLR', 0, 'C', '1');
    $this->pdf->Cell(36, 5, 'Total', 'TBLR', 1, 'C', '1');
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(255, 255, 255);
    $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->trimestre_i), 'TBLR', 0, 'R', '1');
    $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->trimestre_ii), 'TBLR', 0, 'R', '1');
    $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->trimestre_iii), 'TBLR', 0, 'R', '1');
    $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->trimestre_iv), 'TBLR', 0, 'R', '1');
    $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->total), 'TBLR', 1, 'R', '1');

    if ($z == 9) {
        $this->pdf->AddPage();
        $this->pdf->SetFont('Arial', 'B', 13);
        $this->pdf->Cell(30);
        $this->pdf->Cell(180, 7, utf8_decode('Dirección General de Planificación, Presupuesto'), '', 0, 'L', '0');
        $this->pdf->Ln('5');
        $this->pdf->Cell(50);
        $this->pdf->Cell(180, 7, utf8_decode(' y Optimización Organizacional'), '', 1, 'L', '0');
        $this->pdf->Ln('1');
        $this->pdf->SetFont('Arial', 'B', 12);
        $this->pdf->Cell(30);
        $this->pdf->Cell(120, 10, utf8_decode('Acción Centralizada'), 0, 0, 'C');
        $this->pdf->Ln('10');
        $this->pdf->SetFont('Arial', 'B', 10);
        $this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
        $this->pdf->SetFillColor(139, 28, 28);
        $this->pdf->Cell(180.2, 5, utf8_decode('4.2 Distribución Trimestral de las Actividades'), 'TBLR', 1, 'C', '1');
    }

    $z = $z + 1;
    $trimestre_if += $row->trimestre_i;
    $trimestre_iif += $row->trimestre_ii;
    $trimestre_iiif += $row->trimestre_iii;
    $trimestre_ivf += $row->trimestre_iv;
    $totalf += $row->total;
}

$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(209, 153, 153);
$this->pdf->Cell(36, 5, $this->pdf->Format_number($trimestre_if), 'TBLR', 0, 'R', '1');
$this->pdf->Cell(36, 5, $this->pdf->Format_number($trimestre_iif), 'TBLR', 0, 'R', '1');
$this->pdf->Cell(36, 5, $this->pdf->Format_number($trimestre_iiif), 'TBLR', 0, 'R', '1');
$this->pdf->Cell(36, 5, $this->pdf->Format_number($trimestre_ivf), 'TBLR', 0, 'R', '1');
$this->pdf->Cell(36, 5, $this->pdf->Format_number($totalf), 'TBLR', 1, 'R', '1');

// 6. IMPUTACIÓN ACCIONES
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(139, 28, 28);
$this->pdf->Cell(180.2, 5, utf8_decode('6. IMPUTACIÓN ACCIONES'), 'TBLR', 1, 'C', '1');
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Cell(15, 7.5, utf8_decode('Código'), 'LR', 0, 'C', '0');
$this->pdf->Cell(47, 7.5, utf8_decode('Denominación'), 'LR', 0, 'C', '0');
$this->pdf->Cell(93, 5, utf8_decode('Distribución Trimestral'), 'TBLR', 0, 'C', '1');
$this->pdf->Cell(25, 5, utf8_decode('Total'), 'LR', 1, 'C', '1');

$this->pdf->Cell(15, 5, utf8_decode(''), 'LBR', 0, 'C', '1');
$this->pdf->Cell(47, 5, utf8_decode(''), 'BLR', 0, 'C', '1');
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(191, 191, 191);
$this->pdf->Cell(23.25, 5, utf8_decode('I'), 'TBLR', 0, 'C', '1');
$this->pdf->Cell(23.25, 5, utf8_decode('II'), 'TBLR', 0, 'C', '1');
$this->pdf->Cell(23.25, 5, utf8_decode('III'), 'TBLR', 0, 'C', '1');
$this->pdf->Cell(23.25, 5, utf8_decode('IV'), 'TBLR', 0, 'C', '1');
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Cell(25, 5, utf8_decode(''), 'BLR', 1, 'C', '1');

$trimestre_ip   = 0;
$trimestre_iip  = 0;
$trimestre_iiip = 0;
$trimestre_ivp  = 0;
$montop         = 0;
foreach ($imp_presupuestaria as $row) {
    $this->pdf->SetFont('Arial', '', 5.5);
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(255, 255, 255);
    $this->pdf->Cell(15, 5, utf8_decode($row->codigo), 'TBLR', 0, 'C', '1');
    $this->pdf->Cell(47, 5, utf8_decode($row->partida_presupuestaria), 'TBLR', 0, 'L', '1');
    $this->pdf->Cell(23.25, 5, $this->pdf->Format_number($row->trimestre_i), 'TBLR', 0, 'R', '1');
    $this->pdf->Cell(23.25, 5, $this->pdf->Format_number($row->trimestre_ii), 'TBLR', 0, 'R', '1');
    $this->pdf->Cell(23.25, 5, $this->pdf->Format_number($row->trimestre_iii), 'TBLR', 0, 'R', '1');
    $this->pdf->Cell(23.25, 5, $this->pdf->Format_number($row->trimestre_iv), 'TBLR', 0, 'R', '1');
    $this->pdf->Cell(25, 5, $this->pdf->Format_number($row->monto), 'TBLR', 1, 'R', '1');

    $trimestre_ip +=$row->trimestre_i;
    $trimestre_iip +=$row->trimestre_ii;
    $trimestre_iiip +=$row->trimestre_iii;
    $trimestre_ivp +=$row->trimestre_iv;
    $montop +=$row->monto;
}
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(209, 153, 153);
$this->pdf->Cell(62, 5, utf8_decode('TOTAL GENERAL'), 'TBLR', 0, 'C', '1');
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Cell(23.25, 5, $this->pdf->Format_number($trimestre_ip), 'TBLR', 0, 'R', '1');
$this->pdf->Cell(23.25, 5, $this->pdf->Format_number($trimestre_iip), 'TBLR', 0, 'R', '1');
$this->pdf->Cell(23.25, 5, $this->pdf->Format_number($trimestre_iiip), 'TBLR', 0, 'R', '1');
$this->pdf->Cell(23.25, 5, $this->pdf->Format_number($trimestre_ivp), 'TBLR', 0, 'R', '1');
$this->pdf->Cell(25, 5, $this->pdf->Format_number($montop), 'TBLR', 1, 'R', '1');

// Imputacion Especifica
$this->pdf->AddPage();
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(139, 28, 28);
$this->pdf->SetFont('Arial', 'B', 10);
$this->pdf->Ln(20);
$this->pdf->SetFont('Arial', 'B', 6);
$this->pdf->Cell(180, 5, utf8_decode('12. IMPUTACIÓN ESPECIFICA'), 'TBLR', 1, 'C', '1');
$this->pdf->Cell(20, 5, utf8_decode("Cod"), 'TBLR', 0, 'L', '1');
$this->pdf->Cell(125, 5, utf8_decode("Partida"), 'TBLR', 0, 'L', '1');
$this->pdf->Cell(35, 5, "Monto", 'TBLR', 0, 'R', '1');
$this->pdf->Ln(5);
$this->pdf->SetFont('Arial', '', 6);
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$sum_monto         = 0.00;
foreach ($obj_imp_especifica as $row) {
	$this->pdf->Cell(20, 5, utf8_decode("$row->estructura"), 'TBLR', 0, 'L', '1');
	$this->pdf->Cell(125, 5, utf8_decode("$row->partida"), 'TBLR', 0, 'L', '1');
	$this->pdf->Cell(35, 5, $this->pdf->Format_number($row->monto), 'TBLR', 1, 'R', '1');
	$sum_monto +=$row->monto;
}
$this->pdf->Cell(145, 5, "MONTO TOTAL", 'TBLR', 0, 'L', '1');
$this->pdf->Cell(35, 5, $this->pdf->Format_number($sum_monto), 'TBLR', 0, 'R', '1');

$this->pdf->Output("Accion Centralizada.pdf", 'I');
?>
