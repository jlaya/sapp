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
$this->pdf->SetFillColor(56, 119, 119);
// Se define el formato de fuente: Arial, negritas, tamaño 9
$this->pdf->SetFont('Arial', 'B', 9);
/*
 * TITULOS DE COLUMNAS
 *
 * $this->pdf->Cell(Ancho, Alto,texto,borde,posición,alineación,relleno);
 */
// El encabezado del PDF
$this->pdf->SetFont('Arial', 'B', 13);
$this->pdf->Cell(30);
$this->pdf->Cell(120, 10, utf8_decode('Dirección de Planificación, Presupuesto y Control de Gestión'), 0, 0, 'C');
$this->pdf->Ln('5');
$this->pdf->SetFont('Arial', 'B', 12);
$this->pdf->Cell(30);
$this->pdf->Cell(120, 10, utf8_decode('Acción Centralizada'), 0, 0, 'C');
$this->pdf->Ln(10);

# Primera Pagina Todo lo referente a los datos principales de proyecto
$this->pdf->SetFont('Arial', 'B', 10);
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->Cell(180.2, 5, utf8_decode('1. IDENTIFICACIÓN DEL PROPONENTE'), 'TBL', 1, 'C', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Cell(45, 7, utf8_decode('1.1 Organismo/Ente/Empresa:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(135, 7, utf8_decode($row->nom_ins), 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(15, 7, utf8_decode('1.2 Fecha:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(18, 7, '12/02/2015', 'TBR', 0, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(25, 7, utf8_decode('1.4. Responsable:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(82, 7, 'Luisa Perez', 'TBR', 0, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(20, 7, utf8_decode('1.6. Teléfono:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(20, 7, utf8_decode($row->tlf), 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(180, 7, utf8_decode('1.3 Domicilio:'), 'TRL', 0, 'L', '1');
$this->pdf->Ln(7);
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->MultiCell(180, 5, "Av. Las Delicias", 'LR', 'J', 0);
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(18, 7, '1.5 Cargo:', 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(50, 7, 'Presidente', 'TBR', 0, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(35, 7, utf8_decode('1.7. Correo Electrónico:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(77, 7, utf8_decode("jesus@gmail.com"), 'TBR', 1, 'L', '1');

$this->pdf->SetFont('Arial', 'B', 10);
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(56, 119, 119);
$this->pdf->Cell(180.2, 6.5, utf8_decode('2. DATOS DEL PROYECTO'), 'TBL', 0, 'C', '1');
$this->pdf->Ln(7);
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Cell(180, 7, utf8_decode('2.1 Nombre del Proyecto:'), 'TRL', 0, 'L', '1');
$this->pdf->Ln(7);
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->MultiCell(180, 4, utf8_decode('Dotación de medicamentos'), 'LR', 'J', 0);
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(180, 7, utf8_decode('2.2 Ubicación:'), 'TRL', 0, 'L', '1');
$this->pdf->Ln(7);
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->MultiCell(180, 4, utf8_decode('Dotación de medicamentos'), 'LR', 'J', 0);
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(18, 7, utf8_decode('2.3 Duración:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(10, 7, utf8_decode('1 Año'), 'TBR', 0, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(45, 7, utf8_decode('Fecha de Inicio y Culminación:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(44.5, 7, utf8_decode('01 de Enero / 31 de Diciembre'), 'TBR', 0, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(16, 7, utf8_decode('Año Fiscal:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(9, 7, utf8_decode('2016'), 'TBR', 0, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(15, 7, utf8_decode('2.4 Etapa:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(22.5, 7, utf8_decode('Nueva'), 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(32, 7, '2.5 Costo del Proyecto:', 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(16, 7, '0.00', 'TBR', 0, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(42, 7, utf8_decode('2.6 Fuente de Financiamiento:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(90, 7, utf8_decode('Transferencias Corrientes Internas de la República:'), 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(32, 7, '2.7. Indicador General', 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(148, 7, utf8_decode('Transferencias Corrientes Internas de la República:'), 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(50, 7, utf8_decode('2.8. Fórmula del Indicador General'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(130, 7, utf8_decode('Transferencias Corrientes Internas de la República:'), 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(38, 7, utf8_decode('2.9. Medio de Verificación'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(142, 7, utf8_decode('Transferencias Corrientes Internas de la República:'), 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 10);
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(56, 119, 119);
$this->pdf->Cell(180.2, 5, utf8_decode('3. LOCALIZACIÓN POLÍTICO ADMINISTRATIVA'), 'TBLR', 1, 'C', '1');
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(18, 7, utf8_decode('3.1. Ámbito'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(162, 7, utf8_decode('Estadal'), 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(180, 7, utf8_decode('3.2 Especifique:'), 'TRL', 0, 'L', '1');
$this->pdf->Ln(7);
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->MultiCell(180, 4, utf8_decode('Se predente beneficiar a toda la poblacion'), 'LR', 'J', 0);

$this->pdf->SetFont('Arial', 'B', 10);
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(56, 119, 119);
$this->pdf->Cell(180, 5, utf8_decode('4. ÁREA ESTRATÉGICA'), 'TBLR', 1, 'C', '1');
$this->pdf->Cell(180, 7, utf8_decode('4.1. Segundo Plan Socialista de Desarrollo Económico y Social de la Nación 2013-2019'), 'TBLR', 1, 'L', '1');
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(180, 7, utf8_decode('4.1.1. Objetivo Histórico:'), 'TRL', 0, 'L', '1');
$this->pdf->Ln(7);
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->MultiCell(180, 4, utf8_decode('Se predente beneficiar a toda la poblacion'), 'LR', 'J', 0);
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(180, 7, utf8_decode('4.1.2. Objetivo Nacional:'), 'TRL', 0, 'L', '1');
$this->pdf->Ln(7);
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->MultiCell(180, 4, utf8_decode('Se predente beneficiar a toda la poblacion'), 'LR', 'J', 0);
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(180, 7, utf8_decode('4.1.3. Objetivo Estratégico:'), 'TRL', 0, 'L', '1');
$this->pdf->Ln(7);
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->MultiCell(180, 4, utf8_decode('Se predente beneficiar a toda la poblacion'), 'LR', 'J', 0);
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(180, 7, utf8_decode('4.1.4. Objetivo General:'), 'TRL', 0, 'L', '1');
$this->pdf->Ln(7);
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->MultiCell(180, 4, utf8_decode('Se predente beneficiar a toda la poblacion'), 'LR', 'J', 0);
$this->pdf->SetFont('Arial', 'B', 10);
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(56, 119, 119);
$this->pdf->Cell(180, 5, utf8_decode('4.2. Plan de Gobierno para el período: 2013-2017'), 'TBLR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Cell(65, 7, utf8_decode('4.2.1. Lineas Estratégicas del plan de Gobierno:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(115, 7, utf8_decode('Aragua Potencia'), 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Cell(35, 7, utf8_decode('4.2.2. Area de Inversión:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(145, 7, utf8_decode('Salud'), 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Cell(20, 7, utf8_decode('4.2.3. Sector:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(160, 7, utf8_decode('Salud'), 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Cell(20, 7, utf8_decode('4.2.4. Tipo:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(160, 7, utf8_decode('Fortalecimiento Institucional'), 'TBR', 1, 'L', '1');

# Segunda Pagina de datos del proyecto
$this->pdf->AddPage();
$this->pdf->SetFont('Arial', 'B', 13);
$this->pdf->Cell(30);
$this->pdf->Cell(120, 10, utf8_decode('Dirección de Planificación, Presupuesto y Control de Gestión'), 0, 0, 'C');
$this->pdf->Ln('5');
$this->pdf->SetFont('Arial', 'B', 12);
$this->pdf->Cell(30);
$this->pdf->Cell(120, 10, utf8_decode('Acción Centralizada'), 0, 0, 'C');
$this->pdf->Ln(10);
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(56, 119, 119);
$this->pdf->SetFont('Arial', 'B', 10);
$this->pdf->Cell(180.2, 5, utf8_decode('5. IDENTIFICACIÓN DEL PROBLEMA Y JUSTIFICACIÓN'), 'TBLR', 1, 'C', '1');
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(180, 7, utf8_decode('5.1. Descripción del problema:'), 'TRL', 0, 'L', '1');
$this->pdf->Ln(7);
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->MultiCell(180, 4, utf8_decode('Se predente beneficiar a toda la poblacion'), 'LR', 'J', 0);
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(180, 7, utf8_decode('5.2. Objetivo general:'), 'TRL', 0, 'L', '1');
$this->pdf->Ln(7);
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->MultiCell(180, 4, utf8_decode('Se predente beneficiar a toda la poblacion'), 'LR', 'J', 0);
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(180, 7, utf8_decode('5.3. Importancia e Impacto:'), 'TRL', 0, 'L', '1');
$this->pdf->Ln(7);
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->MultiCell(180, 4, utf8_decode('Se predente beneficiar a toda la poblacion'), 'LR', 'J', 0);
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(56, 119, 119);
$this->pdf->SetFont('Arial', 'B', 10);
$this->pdf->Cell(180.2, 5, utf8_decode('6. POBLACIÓN BENEFICIADA POR LA EJECUCIÓN DEL PROYECTO'), 'TBLR', 1, 'C', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Cell(39, 7, '6.1.  Beneficios Femeninos:', 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(23, 7, '450237', 'TBR', 0, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(39, 7, utf8_decode('6.2. Beneficios Masculinos:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(23, 7, utf8_decode("450237"), 'TBR', 0, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(33, 7, utf8_decode('6.3. Total Beneficiarios:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(23, 7, utf8_decode("450237"), 'TBR', 1, 'L', '1');
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(56, 119, 119);
$this->pdf->SetFont('Arial', 'B', 10);
$this->pdf->Cell(180.2, 5, utf8_decode('7. CONEXIONES INTER-INSTITUCIONALES'), 'TBLR', 1, 'C', '1');
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(80, 7, utf8_decode('7.1. Requiere acciones (no financieras) de otra Institución:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(100, 7, 'NO', 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(25, 7, utf8_decode('7.1.1. Institución:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(155, 7, 'NO', 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(25, 7, utf8_decode('7.1.2. Explique:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(155, 7, 'NO', 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(87, 7, utf8_decode('7.2. Contribuye o complementa acciones de otras Instituciones:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(93, 7, 'NO', 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(25, 7, utf8_decode('7.2.1. Institución:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(155, 7, 'NO', 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(25, 7, utf8_decode('7.2.2. Explique:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(155, 7, 'NO', 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(60, 7, utf8_decode('7.3 Entra en conflicto con otra Institución:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(120, 7, 'NO', 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(25, 7, utf8_decode('7.3.1. Institución:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(155, 7, 'NO', 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(25, 7, utf8_decode('7.3.2. Explique:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(155, 7, 'NO', 'TBR', 1, 'L', '1');
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(56, 119, 119);
$this->pdf->SetFont('Arial', 'B', 10);

$this->pdf->Cell(180.2, 5, utf8_decode('8. EMPLEADOS ESTIMADOS POR LA EJECUCIÓN DEL PROYECTO'), 'TBLR', 1, 'C', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Cell(70, 7, utf8_decode('8.1. N° Estimado de empleos directos femeninos:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(20, 7, '90', 'TBR', 0, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(70, 7, utf8_decode('8.2. N° Estimado de empleos directos masculinos:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(20, 7, '45', 'TBR', 1, 'L', '1');

$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Cell(70, 7, utf8_decode('8.3. N° Estimado total de empleos directos:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(20, 7, '135', 'TBR', 0, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(70, 7, utf8_decode('8.4. N° Estimado de empleos indirectos:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(20, 7, '450', 'TBR', 1, 'L', '1');

// Acciones Especificas
$this->pdf->AddPage();
$this->pdf->SetFont('Arial', 'B', 13);
$this->pdf->Cell(30);
$this->pdf->Cell(120, 10, utf8_decode('Dirección de Planificación, Presupuesto y Control de Gestión'), 0, 0, 'C');
$this->pdf->Ln('5');
$this->pdf->SetFont('Arial', 'B', 12);
$this->pdf->Cell(30);
$this->pdf->Cell(120, 10, utf8_decode('Acción Centralizada'), 0, 0, 'C');
$this->pdf->Ln(10);
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(56, 119, 119);
$this->pdf->SetFont('Arial', 'B', 10);
$this->pdf->Cell(180.2, 5, utf8_decode('9. ACCIONES ESPECIFICAS'), 'TBLR', 1, 'C', '1');

$y             = 1;
$trimestre_i   = 0;
$trimestre_ii  = 0;
$trimestre_iii = 0;
$trimestre_iv  = 0;
$total         = 0;
foreach (range(1, 2) as $row) {
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(56, 119, 119);
    $this->pdf->Cell(180, 5, utf8_decode('Nombre de la Acción Específica'), 'TBLR', 1, 'C', '1');
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(255, 255, 255);
    $this->pdf->MultiCell(180, 3.8, utf8_decode("Dotación de medicamentos de las farmacias socialistas"), 'TBLR', 'L', 1);
    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->Cell(26, 7, 'Unidad de Medida:', 'TBL', 0, 'L', '1');
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->Cell(40, 7, 'FARMACIAS', 'TBR', 0, 'L', '1');
    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->Cell(27, 7, utf8_decode('Medio/Verificación:'), 'TBL', 0, 'L', '1');
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->Cell(87, 7, utf8_decode("Estado de Resultado"), 'TBR', 1, 'L', '1');
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(191, 191, 191);
    $this->pdf->Cell(36, 5, 'I Trimestre', 'TBLR', 0, 'C', '1');
    $this->pdf->Cell(36, 5, 'II Trimestre', 'TBLR', 0, 'C', '1');
    $this->pdf->Cell(36, 5, 'III Trimestre', 'TBLR', 0, 'C', '1');
    $this->pdf->Cell(36, 5, 'IV Trimestre', 'TBLR', 0, 'C', '1');
    $this->pdf->Cell(36, 5, 'Total', 'TBLR', 1, 'C', '1');
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(255, 255, 255);
    $this->pdf->Cell(36, 5, '0.00', 'TBLR', 0, 'C', '1');
    $this->pdf->Cell(36, 5, '0.00', 'TBLR', 0, 'C', '1');
    $this->pdf->Cell(36, 5, '0.00', 'TBLR', 0, 'C', '1');
    $this->pdf->Cell(36, 5, '0.00', 'TBLR', 0, 'C', '1');
    $this->pdf->Cell(36, 5, '0.00', 'TBLR', 1, 'C', '1');
    $y = $y + 1;
    /* $trimestre_i +=$row->trimestre_i;
      $trimestre_ii +=$row->trimestre_ii;
      $trimestre_iii +=$row->trimestre_iii;
      $trimestre_iv +=$row->trimestre_iv;
      $total +=$row->total; */
}
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(209, 153, 153);
$this->pdf->Cell(36, 5, '0.00', 'TBLR', 0, 'C', '1');
$this->pdf->Cell(36, 5, '0.00', 'TBLR', 0, 'C', '1');
$this->pdf->Cell(36, 5, '0.00', 'TBLR', 0, 'C', '1');
$this->pdf->Cell(36, 5, '0.00', 'TBLR', 0, 'C', '1');
$this->pdf->Cell(36, 5, '0.00', 'TBLR', 1, 'C', '1');

// Metas Financieras
$trimestre_ip   = 0;
$trimestre_iip  = 0;
$trimestre_iiip = 0;
$trimestre_ivp  = 0;
$montop         = 0;
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(56, 119, 119);
$this->pdf->SetFont('Arial', 'B', 10);
$this->pdf->Cell(180, 5, utf8_decode('10. METAS FINANCIERAS'), 'TBLR', 1, 'C', '1');
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Cell(15, 10, utf8_decode(''), 'L', 0, 'C', '0');
$this->pdf->Cell(78, 5, utf8_decode('Nombre de la Acción Específica'), '', 0, 'L', '0');
$this->pdf->Cell(70, 5, utf8_decode('Distribución Trimestral'), 'TBLR', 0, 'C', '1');
$this->pdf->Cell(17, 5, utf8_decode('Total'), 'LR', 1, 'C', '1');

$this->pdf->Cell(15, 5, utf8_decode(''), 'LB', 0, 'C', '1');
$this->pdf->Cell(78, 5, utf8_decode(''), '', 0, 'C', '1');
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(191, 191, 191);
$this->pdf->Cell(17.5, 5, utf8_decode('I'), 'TBLR', 0, 'C', '1');
$this->pdf->Cell(17.5, 5, utf8_decode('II'), 'TBLR', 0, 'C', '1');
$this->pdf->Cell(17.5, 5, utf8_decode('III'), 'TBLR', 0, 'C', '1');
$this->pdf->Cell(17.5, 5, utf8_decode('IV'), 'TBLR', 0, 'C', '1');
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Cell(17, 5, utf8_decode(''), 'BLR', 1, 'C', '1');
foreach (range(1, 2) as $row) {

    $this->pdf->SetFont('Arial', '', 5);
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(255, 255, 255);
    $this->pdf->Cell(5, 5, '', 'TL', 0, 'C', '1');
    $this->pdf->Cell(88, 5, utf8_decode("DOTACIÓN DE MEDICAMENTOS DE LAS FARMACIAS SOCIALISTAS"), 'TBR', 0, 'L', '1');
    $this->pdf->Cell(17.5, 5, '0.00', 'TBLR', 0, 'C', '1');
    $this->pdf->Cell(17.5, 5, '0.00', 'TBLR', 0, 'C', '1');
    $this->pdf->Cell(17.5, 5, '0.00', 'TBLR', 0, 'C', '1');
    $this->pdf->Cell(17.5, 5, '0.00', 'TBLR', 0, 'C', '1');
    $this->pdf->Cell(17, 5, '0.00', 'TBLR', 1, 'C', '1');

    /*$trimestre_ip +=$row->trimestre_i;
    $trimestre_iip +=$row->trimestre_ii;
    $trimestre_iiip +=$row->trimestre_iii;
    $trimestre_ivp +=$row->trimestre_iv;
    $montop +=$row->monto;*/
}
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(209, 153, 153);
$this->pdf->Cell(93, 5, utf8_decode('TOTALES'), 'TBLR', 0, 'C', '1');
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Cell(17.5, 5, '0.00', 'TBLR', 0, 'C', '1');
$this->pdf->Cell(17.5, 5, '0.00', 'TBLR', 0, 'C', '1');
$this->pdf->Cell(17.5, 5, '0.00', 'TBLR', 0, 'C', '1');
$this->pdf->Cell(17.5, 5, '0.00', 'TBLR', 0, 'C', '1');
$this->pdf->Cell(17, 5, '0.00', 'TBLR', 1, 'C', '1');


// IMPUTACION PRESUPUESTARIA

$trimestre_iimp   = 0;
$trimestre_iipimp  = 0;
$trimestre_iiipimp = 0;
$trimestre_ivpimp  = 0;
$montopimp         = 0;
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(56, 119, 119);
$this->pdf->SetFont('Arial', 'B', 10);
$this->pdf->Cell(180, 5, utf8_decode('11. IMPUTACIÓN PRESUPUESTARIA'), 'TBLR', 1, 'C', '1');
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Cell(15, 7.5, utf8_decode('Código'), 'LR', 0, 'C', '0');
$this->pdf->Cell(78, 7.5, utf8_decode('Denominación'), 'LR', 0, 'C', '0');
$this->pdf->Cell(70, 5, utf8_decode('Distribución Trimestral'), 'TBLR', 0, 'C', '1');
$this->pdf->Cell(17, 5, utf8_decode('Total'), 'LR', 1, 'C', '1');

$this->pdf->Cell(15, 5, utf8_decode(''), 'LBR', 0, 'C', '1');
$this->pdf->Cell(78, 5, utf8_decode(''), 'LBR', 0, 'C', '1');
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(191, 191, 191);
$this->pdf->Cell(17.5, 5, utf8_decode('I'), 'TBLR', 0, 'C', '1');
$this->pdf->Cell(17.5, 5, utf8_decode('II'), 'TBLR', 0, 'C', '1');
$this->pdf->Cell(17.5, 5, utf8_decode('III'), 'TBLR', 0, 'C', '1');
$this->pdf->Cell(17.5, 5, utf8_decode('IV'), 'TBLR', 0, 'C', '1');
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Cell(17, 5, utf8_decode(''), 'BLR', 1, 'C', '1');
foreach (range(1, 2) as $row) {

    $this->pdf->SetFont('Arial', '', 5);
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(255, 255, 255);
    $this->pdf->Cell(5, 5, '', 'TL', 0, 'C', '1');
    $this->pdf->Cell(88, 5, utf8_decode("TRANSFERENCIAS Y DONACIONES"), 'TBR', 0, 'L', '1');
    $this->pdf->Cell(17.5, 5, '0.00', 'TBLR', 0, 'C', '1');
    $this->pdf->Cell(17.5, 5, '0.00', 'TBLR', 0, 'C', '1');
    $this->pdf->Cell(17.5, 5, '0.00', 'TBLR', 0, 'C', '1');
    $this->pdf->Cell(17.5, 5, '0.00', 'TBLR', 0, 'C', '1');
    $this->pdf->Cell(17, 5, '0.00', 'TBLR', 1, 'C', '1');

    /*$trimestre_ipimp +=$row->trimestre_i;
    $trimestre_iipimp +=$row->trimestre_ii;
    $trimestre_iiipimp +=$row->trimestre_iii;
    $trimestre_ivpimp +=$row->trimestre_iv;
    $montopimp +=$row->monto;*/
}
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(209, 153, 153);
$this->pdf->Cell(93, 5, utf8_decode('TOTALES'), 'TBLR', 0, 'C', '1');
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Cell(17.5, 5, '0.00', 'TBLR', 0, 'C', '1');
$this->pdf->Cell(17.5, 5, '0.00', 'TBLR', 0, 'C', '1');
$this->pdf->Cell(17.5, 5, '0.00', 'TBLR', 0, 'C', '1');
$this->pdf->Cell(17.5, 5, '0.00', 'TBLR', 0, 'C', '1');
$this->pdf->Cell(17, 5, '0.00', 'TBLR', 1, 'C', '1');

// Salida del Formato PDF
$this->pdf->Output("Accion Centralizada.pdf", 'I');

