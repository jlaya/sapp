<?php

$this->load->model('model_standard/ModelStandard'); # Llamado a el modelo Estandard

$this->pdf   = new Pdf($orientation = 'L', $unit        = 'mm', $format      = 'A3');
// Agregamos una página
$this->pdf->AddPage();
// Define el alias para el número de página que se imprimirá en el pie
$this->pdf->AliasNbPages();

/* Se define el titulo, márgenes izquierdo, derecho y
 * el color de relleno predeterminado
 */
$this->pdf->SetTitle(utf8_decode("Proyecto"));
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
$this->pdf->SetFont('Arial', 'B', 13);
$this->pdf->Cell(30);
$this->pdf->Cell(180, 7, utf8_decode('Dirección General de Planificación, Presupuesto'), '', 0, 'L', '0');
$this->pdf->Ln('5');
$this->pdf->Cell(50);
$this->pdf->Cell(180, 7, utf8_decode(' y Optimización Organizacional'), '', 1, 'L', '0');
$this->pdf->Ln('1');
$this->pdf->SetFont('Arial', 'B', 12);
$this->pdf->Cell(30);
$this->pdf->Cell(120, 10, utf8_decode('Proyecto'), 0, 0, 'C');
$this->pdf->Ln(20);

# Primera Pagina Todo lo referente a los datos principales de proyecto
$this->pdf->SetFont('Arial', 'B', 10);
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->Cell(180.2, 5, utf8_decode('1. IDENTIFICACIÓN DEL PROPONENTE'), 'TBL', 1, 'C', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->MultiCell(180, 5, utf8_decode("$row->nom_ins"), 'LR', 'J', 0);
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(15, 7, utf8_decode('1.2 Fecha:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(18, 7, $this->ModelStandard->format_fecha('-', $row->fecha_elaboracion), 'TBR', 0, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(25, 7, utf8_decode('1.4. Responsable:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(78, 7, utf8_decode($row->responsable), 'TBR', 0, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(20, 7, utf8_decode('1.6. Teléfono:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(24, 7, $row->tlf, 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(180, 7, utf8_decode('1.3 Domicilio:'), 'TRL', 0, 'L', '1');
$this->pdf->Ln(7);
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->MultiCell(180, 5, utf8_decode($row->domicilio), 'LR', 'J', 0);
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(18, 7, '1.5 Cargo:', 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(50, 7, utf8_decode($row->cargo), 'TBR', 0, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(35, 7, utf8_decode('1.7. Correo Electrónico:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(77, 7, utf8_decode($row->correo), 'TBR', 1, 'L', '1');
$this->pdf->Ln(5);
$this->pdf->SetFont('Arial', 'B', 10);
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(139, 28, 28);
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
$this->pdf->MultiCell(180, 4, utf8_decode($row->nom_proyecto), 'LR', 'J', 0);

$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(180, 7, utf8_decode('Descripción del proyecto:'), 'TRL', 0, 'L', '1');
$this->pdf->Ln(7);
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->MultiCell(180, 4, utf8_decode($row->descripcion_proy), 'LR', 'J', 0);

$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(180, 7, utf8_decode('2.2 Ubicación:'), 'TRL', 0, 'L', '1');
$this->pdf->Ln(7);
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->MultiCell(180, 4, utf8_decode($row->ubicacion), 'LR', 'J', 0);
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(18, 7, utf8_decode('2.3 Duración:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);

if ((int) $row->duracion > (int) 2):
    $duracion = $row->duracion . " Años";
else:
    $duracion = $row->duracion . " Año";
endif;
//validacion de Etapa
if ($row->etapa == 1):
    $etapa = "NUEVA";
else:
    $etapa = "CONTINUACIÓN";
endif;

if ($row->f_financiamiento == 1):
    $f_financiamiento = "SITUADO CONSTITUCIONAL";
elseif ($row->f_financiamiento == 2):
    $f_financiamiento = "F.C.I";
elseif ($row->f_financiamiento == 3):
    $f_financiamiento = "INGRESOS PROPIOS";
elseif ($row->f_financiamiento == 4):
    $f_financiamiento = "TRANSFERENCIAS CORRIENTES INTERNAS DE LA REPÚBLICA";
endif;

// Validación para los distintos Ambitos
if ($row->ambito == 1):
    $ambito = "ESTADAL";
elseif ($row->ambito == 2):
    $ambito = "NACIONAL";
elseif ($row->ambito == 3):
    $ambito = "INTERNACIONAL";
elseif ($row->ambito == 4):
    $ambito = "MUNICIPAL";
elseif ($row->ambito == 5):
    $ambito = "PARROQUIAL";
elseif ($row->ambito == 6):
    $ambito = "SIN EXTENSIÓN TERRITORIAL";
elseif ($row->ambito == 7):
    $ambito = "COMUNAL";
endif;

// Validacion de tipo de Inversión
if ($row->tipo_inversion == 1):
    $tipo = "INVERSIÓN PRODUCTIVA";
elseif ($row->tipo_inversion == 2):
    $tipo = "FORTALECIMIENTO INSTITUCIONAL";
elseif ($row->tipo_inversion == 3):
    $tipo = "INFRAESTRUCTURA";
elseif ($row->tipo_inversion == 4):
    $tipo = "SERVICIOS";
endif;

$this->pdf->Cell(10, 7, utf8_decode($duracion), 'TBR', 0, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(45, 7, utf8_decode('Fecha de Inicio y Culminación:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(33, 7, $this->ModelStandard->format_fecha('-', $row->inicio) . " / " . $this->ModelStandard->format_fecha('-', $row->fin), 'TBR', 0, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(16, 7, utf8_decode('Año Fiscal:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$ano       = $row->ano_fiscal;
$organismo = $row->nom_ins;
$codigo    = $row->codigo;
$this->pdf->Cell(9, 7, $row->ano_fiscal, 'TBR', 0, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(15, 7, utf8_decode('2.4 Etapa:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(34, 7, utf8_decode($etapa), 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
/*$this->pdf->Cell(23, 7, 'Costo Solicitud:', 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(29, 7, $this->pdf->Format_number($monto_soli), 'TBR', 0, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(25, 7, utf8_decode('Costo Asignación:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(103, 7, $this->pdf->Format_number($monto_asig->monto_asig), 'TBR', 1, 'L', '1');*/
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Cell(42, 7, utf8_decode('2.6 Fuente de Financiamiento:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(138, 7, utf8_decode($f_financiamiento), 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(180, 7, utf8_decode('2.7. Indicador General:'), 'TRL', 0, 'L', '1');
$this->pdf->Ln(7);
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->MultiCell(180, 4, utf8_decode(strtoupper($row->indicador_g)), 'LRB', 'J', 0);



$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(50, 7, utf8_decode('2.8. Fórmula del Indicador General:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(130, 7, utf8_decode($row->identificador), 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(38, 7, utf8_decode('2.9. Medio de Verificación'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(142, 7, utf8_decode($row->m_verificacion), 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 10);
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(139, 28, 28);
$this->pdf->Ln(5);
$this->pdf->Cell(180.2, 5, utf8_decode('3. LOCALIZACIÓN POLÍTICO ADMINISTRATIVA'), 'TBLR', 1, 'C', '1');
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(18, 7, utf8_decode('3.1. Ámbito'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(162, 7, utf8_decode($ambito), 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(180, 7, utf8_decode('3.2 Especifique:'), 'TRL', 0, 'L', '1');
$this->pdf->Ln(7);
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->MultiCell(180, 4, utf8_decode($row->especifique_amb), 'LRB', 'J', 0);

$this->pdf->SetFont('Arial', 'B', 9);
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(139, 28, 28);

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
$this->pdf->Cell(120, 10, utf8_decode('Proyecto'), 0, 0, 'C');
$this->pdf->Ln(20);
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(139, 28, 28);
$this->pdf->SetFont('Arial', 'B', 10);

$this->pdf->Cell(180, 5, utf8_decode('4. ÁREA ESTRATÉGICA'), 'TBLR', 1, 'C', '1');
$this->pdf->Cell(180, 7, utf8_decode("4.1. $plan_patria->plan_patria"), 'TBLR', 1, 'L', '1');
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(180, 7, utf8_decode('4.1.1. Objetivo Histórico:'), 'TRL', 0, 'L', '1');
$this->pdf->Ln(7);
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->MultiCell(180, 4, utf8_decode($objetivo_historico->objetivo_historico), 'LR', 'J', 0);
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(180, 7, utf8_decode('4.1.2. Objetivo Nacional:'), 'TRL', 0, 'L', '1');
$this->pdf->Ln(7);
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->MultiCell(180, 4, utf8_decode($objetivo_nacional->objetivo_nacional), 'LR', 'J', 0);
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(180, 7, utf8_decode('4.1.3. Objetivo Estratégico:'), 'TRL', 0, 'L', '1');
$this->pdf->Ln(7);
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->MultiCell(180, 4, utf8_decode($objetivo_estrategico->objetivo_estrategico), 'LR', 'J', 0);
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(180, 7, utf8_decode('Objetivo Estratégico Institucional:'), 'TRL', 0, 'L', '1');
$this->pdf->Ln(7);
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->MultiCell(180, 4, utf8_decode($row->objetivo_institucional), 'LR', 'J', 0);
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(180, 7, utf8_decode('4.1.4. Objetivo General:'), 'TRL', 0, 'L', '1');
$this->pdf->Ln(7);
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->MultiCell(180, 4, utf8_decode($objetivo_general->objetivo_general), 'LRB', 'J', 0);
$this->pdf->SetFont('Arial', 'B', 9);
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(139, 28, 28);
$this->pdf->Ln(5);
$this->pdf->Cell(180, 5, utf8_decode("4.2. $plan_gobierno->plan_gobierno"), 'TBLR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Cell(65, 7, utf8_decode('4.2.1. Lineas Estratégicas del plan de Gobierno:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(115, 7, utf8_decode($linea_estrategica->linea_estrategica), 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Cell(35, 7, utf8_decode('4.2.2. Area de Inversión:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(145, 7, utf8_decode($row->area_inversion), 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Cell(20, 7, utf8_decode('4.2.3. Sector:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(160, 7, utf8_decode($sector->sector), 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Cell(20, 7, utf8_decode('4.2.4. Tipo:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(160, 7, utf8_decode($tipo), 'TBR', 1, 'L', '1');

# Segunda Pagina de datos del proyecto
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
$this->pdf->Cell(120, 10, utf8_decode('Proyecto'), 0, 0, 'C');
$this->pdf->Ln(20);
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(139, 28, 28);
$this->pdf->SetFont('Arial', 'B', 10);
$this->pdf->Cell(180.2, 5, utf8_decode('5. IDENTIFICACIÓN DEL PROBLEMA Y JUSTIFICACIÓN'), 'TBLR', 1, 'C', '1');
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(180, 7, utf8_decode('5.1. Descripción del problema:'), 'TRL', 0, 'L', '1');
$this->pdf->Ln(7);
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->MultiCell(180, 4, utf8_decode($row->desc_problema), 'LR', 'J', 0);
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(180, 7, utf8_decode('5.2. Objetivo general:'), 'TRL', 0, 'L', '1');
$this->pdf->Ln(7);
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->MultiCell(180, 4, utf8_decode($row->obj_general), 'LR', 'J', 0);
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(180, 7, utf8_decode('5.3. Importancia e Impacto:'), 'TRL', 0, 'L', '1');
$this->pdf->Ln(7);
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->MultiCell(180, 4, utf8_decode($row->imp_impacto), 'LRB', 'J', 0);
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(139, 28, 28);
$this->pdf->SetFont('Arial', 'B', 10);
$this->pdf->Ln(5);
$this->pdf->Cell(180.2, 5, utf8_decode('6. POBLACIÓN BENEFICIADA POR LA EJECUCIÓN DEL PROYECTO'), 'TBLR', 1, 'C', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Cell(39, 7, '6.1.  Beneficios Femeninos:', 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(23, 7, $this->pdf->Format_Miles($row->ben_femeninos), 'TBR', 0, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(39, 7, utf8_decode('6.2. Beneficios Masculinos:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(23, 7, $this->pdf->Format_Miles($row->ben_masculinos), 'TBR', 0, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(33, 7, utf8_decode('6.3. Total Beneficiarios:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(23, 7, $this->pdf->Format_Miles($row->total_ben), 'TBR', 1, 'L', '1');
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(139, 28, 28);
$this->pdf->SetFont('Arial', 'B', 10);
$this->pdf->Cell(180.2, 5, utf8_decode('7. CONEXIONES INTER-INSTITUCIONALES'), 'TBLR', 1, 'C', '1');
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(80, 7, utf8_decode('7.1. Requiere acciones (no financieras) de otra Institución:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);

if ($row->req_acciones == 1):
    $req_acciones = "SI";
else:
    $req_acciones = "NO";
endif;

$this->pdf->Cell(100, 7, utf8_decode($req_acciones), 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(25, 7, utf8_decode('7.1.1. Institución:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(155, 7, utf8_decode($acc_instituciones), 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(25, 7, utf8_decode('7.1.2. Explique:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(155, 7, $row->acc_especifique, 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(87, 7, utf8_decode('7.2. Contribuye o complementa acciones de otras Instituciones:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);

if ($row->con_acciones == 1):
    $con_acciones = "SI";
else:
    $con_acciones = "NO";
endif;

$this->pdf->Cell(93, 7, utf8_decode($con_acciones), 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(25, 7, utf8_decode('7.2.1. Institución:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(155, 7, utf8_decode($con_instituciones), 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(25, 7, utf8_decode('7.2.2. Explique:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(155, 7, utf8_decode($row->con_especifique), 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(60, 7, utf8_decode('7.3 Entra en conflicto con otra Institución:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
if ($row->en_acciones == 1):
    $en_acciones = "SI";
else:
    $en_acciones = "NO";
endif;
$this->pdf->Cell(120, 7, $en_acciones, 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(25, 7, utf8_decode('7.3.1. Institución:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(155, 7, $en_instituciones, 'TBR', 1, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(25, 7, utf8_decode('7.3.2. Explique:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(155, 7, $row->en_especifique, 'TBR', 1, 'L', '1');
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(139, 28, 28);
$this->pdf->SetFont('Arial', 'B', 10);
$this->pdf->Ln(5);
$this->pdf->Cell(180.2, 5, utf8_decode('8. EMPLEADOS ESTIMADOS POR LA EJECUCIÓN DEL PROYECTO'), 'TBLR', 1, 'C', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Cell(70, 7, utf8_decode('8.1. N° Estimado de empleos directos femeninos:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(20, 7, $row->estimado_fem, 'TBR', 0, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(70, 7, utf8_decode('8.2. N° Estimado de empleos directos masculinos:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(20, 7, $row->estimado_mas, 'TBR', 1, 'L', '1');

$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Cell(70, 7, utf8_decode('8.3. N° Estimado total de empleos directos:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(20, 7, $row->estimado_t_direc, 'TBR', 0, 'L', '1');
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->Cell(70, 7, utf8_decode('8.4. N° Estimado de empleos indirectos:'), 'TBL', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(20, 7, $row->estimado_t_indirec, 'TBR', 1, 'L', '1');

// Acciones Especificas
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
$this->pdf->Cell(120, 10, utf8_decode('Proyecto'), 0, 0, 'C');
$this->pdf->Ln(10);
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(139, 28, 28);
$this->pdf->SetFont('Arial', 'B', 10);
$this->pdf->Cell(180.2, 5, utf8_decode('9. ACCIONES ESPECIFICAS'), 'TBLR', 1, 'C', '1');

$y             = 1;
$trimestre_i   = 0;
$trimestre_ii  = 0;
$trimestre_iii = 0;
$trimestre_iv  = 0;
$total         = 0;
foreach ($acc_esp_te as $row) {
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(139, 28, 28);
    $this->pdf->Cell(180, 5, utf8_decode('Nombre de la Acción Específica'), 'TBLR', 1, 'C', '1');
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(255, 255, 255);
    $this->pdf->MultiCell(180, 3.8, utf8_decode($row->acc_esp), 'TBLR', 'L', 1);
    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->Cell(26, 7, 'Unidad de Medida:', 'TBL', 0, 'L', '1');
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->Cell(63.5, 7, utf8_decode($row->unidad_medida), 'TBR', 0, 'L', '1');
    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->Cell(27, 7, utf8_decode('Medio/Verificación:'), 'TBL', 0, 'L', '1');
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->Cell(63.5, 7, utf8_decode($row->medio_verificacion), 'TBR', 1, 'L', '1');
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(191, 191, 191);
    $this->pdf->Cell(36, 5, 'I Trimestre', 'TBLR', 0, 'C', '1');
    $this->pdf->Cell(36, 5, 'II Trimestre', 'TBLR', 0, 'C', '1');
    $this->pdf->Cell(36, 5, 'III Trimestre', 'TBLR', 0, 'C', '1');
    $this->pdf->Cell(36, 5, 'IV Trimestre', 'TBLR', 0, 'C', '1');
    $this->pdf->Cell(36, 5, 'Total', 'TBLR', 1, 'C', '1');
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(255, 255, 255);
    $this->pdf->Cell(36, 5, $this->pdf->Format_Miles($row->trimestre_i), 'TBLR', 0, 'R', '1');
    $this->pdf->Cell(36, 5, $this->pdf->Format_Miles($row->trimestre_ii), 'TBLR', 0, 'R', '1');
    $this->pdf->Cell(36, 5, $this->pdf->Format_Miles($row->trimestre_iii), 'TBLR', 0, 'R', '1');
    $this->pdf->Cell(36, 5, $this->pdf->Format_Miles($row->trimestre_iv), 'TBLR', 0, 'R', '1');
    $this->pdf->Cell(36, 5, $this->pdf->Format_Miles($row->total), 'TBLR', 1, 'R', '1');
    $y = $y + 1;
    $trimestre_i +=$row->trimestre_i;
    $trimestre_ii +=$row->trimestre_ii;
    $trimestre_iii +=$row->trimestre_iii;
    $trimestre_iv +=$row->trimestre_iv;
    $total +=$row->total;
}
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(159, 112, 112);
$this->pdf->Cell(36, 5, $this->pdf->Format_Miles($trimestre_i), 'TBLR', 0, 'R', '1');
$this->pdf->Cell(36, 5, $this->pdf->Format_Miles($trimestre_ii), 'TBLR', 0, 'R', '1');
$this->pdf->Cell(36, 5, $this->pdf->Format_Miles($trimestre_iii), 'TBLR', 0, 'R', '1');
$this->pdf->Cell(36, 5, $this->pdf->Format_Miles($trimestre_iv), 'TBLR', 0, 'R', '1');
$this->pdf->Cell(36, 5, $this->pdf->Format_Miles($total), 'TBLR', 1, 'R', '1');

// Metas Financieras
$trimestre_ip   = 0;
$trimestre_iip  = 0;
$trimestre_iiip = 0;
$trimestre_ivp  = 0;
$montop         = 0;
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(139, 28, 28);
$this->pdf->SetFont('Arial', 'B', 10);
$this->pdf->AddPage();
$this->pdf->Ln(20);
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
$i = 1;

$query_acc_esp_fin = "SELECT a.acc_esp, b.trimestre_i, b.trimestre_ii, b.trimestre_iii, b.trimestre_iv, b.total FROM distribucion_acc_especifica a  JOIN distribucion_trimestral_acc_especifica b ON a.id = b.id_acc WHERE b.pk = $id AND b.total > 0 ORDER BY a.id ASC";
$acc_esp_fin = $this->ModelStandard->query_set($query_acc_esp_fin, 'result');

foreach ($acc_esp_fin as $row) {
    $this->pdf->SetFont('Arial', '', 5);
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(255, 255, 255);
    $this->pdf->Cell(5, 5, '', 'TL', 0, 'L', '1');
    $this->pdf->Cell(88, 5, utf8_decode($row->acc_esp), 'TBR', 0, 'L', '1');
    $this->pdf->Cell(17.5, 5, $this->pdf->Format_number($row->trimestre_i), 'TBLR', 0, 'R', '1');
    $this->pdf->Cell(17.5, 5, $this->pdf->Format_number($row->trimestre_ii), 'TBLR', 0, 'R', '1');
    $this->pdf->Cell(17.5, 5, $this->pdf->Format_number($row->trimestre_iii), 'TBLR', 0, 'R', '1');
    $this->pdf->Cell(17.5, 5, $this->pdf->Format_number($row->trimestre_iv), 'TBLR', 0, 'R', '1');
    $this->pdf->Cell(17, 5, $this->pdf->Format_number($row->total), 'TBLR', 1, 'R', '1');

    $trimestre_ip +=$row->trimestre_i;
    $trimestre_iip +=$row->trimestre_ii;
    $trimestre_iiip +=$row->trimestre_iii;
    $trimestre_ivp +=$row->trimestre_iv;
    $montop +=$row->total;
    $i++;
}

$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(209, 153, 153);
$this->pdf->Cell(93, 5, utf8_decode('TOTAL GENERAL'), 'TBLR', 0, 'C', '1');
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Cell(17.5, 5, $this->pdf->Format_number($trimestre_ip), 'TBLR', 0, 'R', '1');
$this->pdf->Cell(17.5, 5, $this->pdf->Format_number($trimestre_iip), 'TBLR', 0, 'R', '1');
$this->pdf->Cell(17.5, 5, $this->pdf->Format_number($trimestre_iiip), 'TBLR', 0, 'R', '1');
$this->pdf->Cell(17.5, 5, $this->pdf->Format_number($trimestre_ivp), 'TBLR', 0, 'R', '1');
$this->pdf->Cell(17, 5, $this->pdf->Format_number($montop), 'TBLR', 1, 'R', '1');

if($i > 6){
    $this->pdf->AddPage();
    $this->pdf->Ln(15);
}

// IMPUTACION PRESUPUESTARIA

$trimestre_iimp    = 0;
$trimestre_iipimp  = 0;
$trimestre_iiipimp = 0;
$trimestre_ivpimp  = 0;
$montopimp         = 0;
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(139, 28, 28);
$this->pdf->SetFont('Arial', 'B', 10);
$this->pdf->Ln(5);
$this->pdf->Cell(180, 5, utf8_decode('11. IMPUTACIÓN PRESUPUESTARIA'), 'TBLR', 1, 'C', '1');
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Cell(15, 7.5, utf8_decode('Código'), 'LR', 0, 'C', '0');
$this->pdf->Cell(47, 7.5, utf8_decode('Denominación'), 'LR', 0, 'C', '0');
$this->pdf->Cell(94, 5, utf8_decode('Distribución Trimestral'), 'TBLR', 0, 'C', '1');
$this->pdf->Cell(23.7, 5, utf8_decode('Total'), 'LR', 1, 'C', '1');

$this->pdf->Cell(15, 5, utf8_decode(''), 'LBR', 0, 'C', 0);
$this->pdf->Cell(47, 5, utf8_decode(''), 'LBR', 0, 'C', 1);
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(191, 191, 191);
$this->pdf->Cell(23.5, 5, utf8_decode('I'), 'TBLR', 0, 'C', '1');
$this->pdf->Cell(23.5, 5, utf8_decode('II'), 'TBLR', 0, 'C', '1');
$this->pdf->Cell(23.5, 5, utf8_decode('III'), 'TBLR', 0, 'C', '1');
$this->pdf->Cell(23.5, 5, utf8_decode('IV'), 'TBLR', 0, 'C', '1');
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Cell(23.7, 5, utf8_decode(''), 'BLR', 1, 'C', '1');
foreach ($partida_presupuestaria as $row) {

    $this->pdf->SetFont('Arial', '', 5);
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(255, 255, 255);
    if($row->cantidad > 0.00){
		$this->pdf->Cell(15, 5, $row->codigo, 'TL', 0, 'C', '1');
		$this->pdf->Cell(47, 5, utf8_decode($row->partida_presupuestaria), 'TBR', 0, 'L', '1');
		$this->pdf->Cell(23.5, 5, $this->pdf->Format_number($row->trimestre_i), 'TBLR', 0, 'R', '1');
		$this->pdf->Cell(23.5, 5, $this->pdf->Format_number($row->trimestre_ii), 'TBLR', 0, 'R', '1');
		$this->pdf->Cell(23.5, 5, $this->pdf->Format_number($row->trimestre_iii), 'TBLR', 0, 'R', '1');
		$this->pdf->Cell(23.5, 5, $this->pdf->Format_number($row->trimestre_iv), 'TBLR', 0, 'R', '1');
		$this->pdf->Cell(23.7, 5, $this->pdf->Format_number($row->cantidad), 'TBLR', 1, 'R', '1');
	}
    $trimestre_iimp +=$row->trimestre_i;
    $trimestre_iipimp +=$row->trimestre_ii;
    $trimestre_iiipimp +=$row->trimestre_iii;
    $trimestre_ivpimp +=$row->trimestre_iv;
    $montopimp +=$row->cantidad;
}
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(209, 153, 153);
$this->pdf->Cell(62, 5, utf8_decode('TOTAL GENERAL'), 'TBLR', 0, 'C', '1');
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Cell(23.5, 5, $this->pdf->Format_number($trimestre_iimp), 'TBLR', 0, 'R', '1');
$this->pdf->Cell(23.5, 5, $this->pdf->Format_number($trimestre_iipimp), 'TBLR', 0, 'R', '1');
$this->pdf->Cell(23.5, 5, $this->pdf->Format_number($trimestre_iiipimp), 'TBLR', 0, 'R', '1');
$this->pdf->Cell(23.5, 5, $this->pdf->Format_number($trimestre_ivpimp), 'TBLR', 0, 'R', '1');
$this->pdf->Cell(23.7, 5, $this->pdf->Format_number($montopimp), 'TBLR', 1, 'R', '1');

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

// Salida del Formato PDF

$this->pdf->Output("Proyecto-$codigo utf8_decode($organismo) ($ano).pdf", 'I');
