<?php

$this->load->model('model_standard/ModelStandard'); # Llamado a el modelo Estandard
$this->pdf   = new PdfLeyTomoI($orientation = 'L', $unit        = 'mm', $format      = 'A3');
// Agregamos una página
$this->pdf->AddPage();
// Define el alias para el número de página que se imprimirá en el pie
$this->pdf->AliasNbPages();
/* Se define el titulo, márgenes izquierdo, derecho y
 * el color de relleno predeterminado
 */
$this->pdf->SetLeftMargin(15);
$this->pdf->SetRightMargin(15);
$this->pdf->SetFillColor(139, 28, 28);
// Titulo del formato PDF
// Registro de Acciones Centralizadas
if ($dato[0] == 1 AND $dato[1] == 4) {
    $tomo   = "Tomo I $ano";
    $titulo = "Tomo I";
    $tipo_f = "Organos y Unidades de Apoyo";
    $title  = "Plan Operativo Anual Estadal Modificado";
} elseif ($dato[0] == 2 AND $dato[1] == 3) {
    $tomo   = "Tomo II $ano";
    $titulo = "Tomo II";
    $tipo_f = "Entes y Empresas";
    $title  = "Plan Operativo Anual Estadal Modificado";
}

//$this->pdf->SetTitle(utf8_decode($nom)); // Nombre del titulo
// =============================================================================
// PLAN OPERATIVO ANUAL (REGISTRO DE ACCIONES Y ANTE PROYECTOS)
// =============================================================================
$this->pdf->Ln(3);
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Ln(80);
$this->pdf->SetFont('Helvetica', 'B', 16);
$this->pdf->Cell(180, 7, utf8_decode("$title"), '', 0, 'C', '1');
$this->pdf->Ln(7);
$this->pdf->Cell(180, 7, $ano, '', 1, 'C', '1');
$this->pdf->Ln(95);
$this->pdf->Cell(180, 7, utf8_decode($titulo), '', 1, 'C', '1');
$this->pdf->Cell(180, 7, utf8_decode("Ejercicio Fiscal $ano"), '', 1, 'C', '1');

// =============================================================================
// Contra Portada Tomo I (Ley Presupuestaria)
// =============================================================================
$this->pdf->AddPage();
$this->pdf->Ln(10);
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->SetFont('Helvetica', 'B', 11);

if ($dato[0] == 1 AND $dato[1] == 4) {
    $this->pdf->Ln(6);
    $this->pdf->Cell(25, 7, utf8_decode('Artículo 32.'), '', 0, 'L', '1');
    $this->pdf->SetFont('Helvetica', '', 10);
    $this->pdf->Cell(155, 7, utf8_decode('Acuérdese el monto total de los créditos presupuestario para cada Órgano del estado y para las'), '', 1, 'L', '1');
    $this->pdf->Cell(155, 7, utf8_decode('rectificaciones al presupuesto de gasto, de acuerdo con la distribución siguiente:'), '', 1, 'L', '1');
    $query = "SELECT oe.id,oe.tipo_ins,oe.sector,oe.nom_ins,SUM(im.m_asig) AS monto_general FROM imp_presupuestaria AS im INNER JOIN acciones_registro AS acc ON(im.id_acc_reg=acc.id) INNER JOIN organos_entes AS oe ON(acc.ente=oe.id) WHERE oe.tipo_ins = $dato[0] OR oe.tipo_ins = $dato[1] AND acc.estatus=4 GROUP BY oe.nom_ins,oe.sector,oe.tipo_ins,oe.id";
} elseif ($dato[0] == 2 AND $dato[1] == 3) {
    $this->pdf->Ln(6);
    $this->pdf->Cell(25, 7, utf8_decode('Artículo 33.'), '', 0, 'L', '1');
    $this->pdf->SetFont('Helvetica', '', 10);
    $this->pdf->Cell(155, 7, utf8_decode('Acuérdese el monto total de los créditos presupuestario para cada Ente Descentralizado'), '', 1, 'L', '1');
    $this->pdf->Cell(155, 7, utf8_decode('Funcionalmente con y sin Fines Empresariales de acuerdo con la distribución siguiente:'), '', 1, 'L', '1');
    $query = "SELECT oe.id,oe.tipo_ins,oe.sector,oe.nom_ins,SUM(im.m_asig) AS monto_general FROM imp_presupuestaria AS im INNER JOIN acciones_registro AS acc ON(im.id_acc_reg=acc.id) INNER JOIN organos_entes AS oe ON(acc.ente=oe.id) WHERE oe.tipo_ins = $dato[0] OR oe.tipo_ins = $dato[1] AND acc.estatus=4 GROUP BY oe.nom_ins,oe.sector,oe.tipo_ins,oe.id";


// Registro de Proyectos
} elseif ($dato[0] == 2 AND $dato[0] == 1 AND $dato[1] == 4) {
    $this->pdf->Ln(6);
    $this->pdf->Cell(25, 7, utf8_decode('Artículo 32.'), '', 0, 'L', '1');
    $this->pdf->SetFont('Helvetica', '', 10);
    $this->pdf->Cell(155, 7, utf8_decode('Acuérdese el monto total de los créditos presupuestario para cada Órgano del estado y para las'), '', 1, 'L', '1');
    $this->pdf->Cell(155, 7, utf8_decode('rectificaciones al presupuesto de gasto, de acuerdo con la distribución siguiente:'), '', 1, 'L', '1');
    $query = "SELECT oe.id,oe.tipo_ins,oe.sector,oe.nom_ins,SUM(dis.m_asig) AS monto_general FROM distribucion_trimestral_imp_pre AS dis INNER JOIN proyecto_registro AS proy ON(dis.pk=proy.id) INNER JOIN organos_entes AS oe ON(proy.ente=oe.id) INNER JOIN observaciones_acciones_proy AS obs ON(proy.ente=obs.organo) WHERE oe.tipo_ins = $dato[0] OR oe.tipo_ins = $dato[1] AND proy.estatus = 4 GROUP BY oe.nom_ins,oe.id,proy.id";
    //echo $query;
} elseif ($dato[0] == 2 AND $dato[0] == 2 AND $dato[1] == 3) {
    $this->pdf->Ln(6);
    $this->pdf->Cell(25, 7, utf8_decode('Artículo 33.'), '', 0, 'L', '1');
    $this->pdf->SetFont('Helvetica', '', 10);
    $this->pdf->Cell(155, 7, utf8_decode('Se aprueba la estimación de los ingresos y fuentes de financiamiento y se acuerdan los presupuestos'), '', 1, 'L', '1');
    $this->pdf->Cell(155, 7, utf8_decode('de gastos y aplicaciones financieras de los Entes Descentralizados Funcionalmente con y sin Fines Empresariales,'), '', 1, 'L', '1');
    $this->pdf->Cell(155, 7, utf8_decode('que a continuación se señalan:'), '', 1, 'L', '1');
    $query = "SELECT oe.id,oe.tipo_ins,oe.sector,oe.nom_ins,SUM(dis.m_asig) AS monto_general FROM distribucion_trimestral_imp_pre AS dis INNER JOIN proyecto_registro AS proy ON(dis.pk=proy.id) INNER JOIN organos_entes AS oe ON(proy.ente=oe.id) INNER JOIN observaciones_acciones_proy AS obs ON(proy.ente=obs.organo) WHERE oe.tipo_ins = $dato[0] OR oe.tipo_ins = $dato[1] AND proy.estatus = 4 GROUP BY oe.nom_ins,oe.id,proy.id";
}

// =============================================================================
// Proceso para el listado de sectores
// =============================================================================
$this->pdf->SetTitle(utf8_decode($tomo));
$this->pdf->Ln(5);
$s = 1;
foreach ($sectores as $sec) {
    $sec_id = $sec->id;
    $this->pdf->SetFont('Helvetica', 'B', 8);
    //$this->pdf->Ln(7);

    if ($s == 5) {
        $this->pdf->AddPage();
        $this->pdf->Ln(12);
    }

    $this->pdf->Cell(25, 7, utf8_decode($sec->sector), '', 1, 'L', '1'); // Salida de los sectores
    // Proceso para reflejar los Organismos asociados al sector
    $monto_general   = 0; // Monto General por Organos
    $gastos_fiscales = 0; // Monto General de los gastos fiscales
    $monto_asig      = 0;
    $s               = $s + 1;
    // Acciones y Proyectos    
    $SQL    = "SELECT y.ente, y.sector,substring(y.estruc_presupuestaria from 1 for 8),y.nom_ins,SUM(y.monto_asig) AS monto_asig, y.codigo FROM ";
    $SQL   .= "((SELECT acc.ente,oe.sector,acc.estruc_presupuestaria,oe.nom_ins,SUM(imp.m_asig) AS monto_asig, s.codigo ";
    $SQL   .= "FROM acciones_registro AS acc ";
    $SQL   .= "INNER JOIN accion_centralizada AS ac ON(acc.acc_centralizada = ac.id) ";
    $SQL   .= "INNER JOIN imp_presupuestaria AS imp ON(imp.id_acc_reg = acc.id) ";
    $SQL   .= "INNER JOIN organos_entes AS oe ON(acc.ente=oe.id) ";
    $SQL   .= "INNER JOIN sectores AS s ON(s.id=oe.sector)";
    $SQL   .= "WHERE acc.ano_fiscal= $ano AND imp.m_asig > 0.00 AND oe.tipo_ins IN($dato[0],$dato[1]) AND imp.id_acc_reg = acc.id AND acc.estatus= 4 AND acc.cierre = 1 ";
    $SQL   .= "GROUP BY acc.ente,oe.sector,acc.estruc_presupuestaria,oe.nom_ins,s.codigo ";
    $SQL   .= "ORDER BY acc.estruc_presupuestaria ASC) ";
    $SQL   .= "UNION ALL";
    $SQL   .= "(SELECT proy.ente,oe.sector,proy.estruc_presupuestaria,oe.nom_ins,SUM(dis.m_asig) AS monto_asig, s.codigo ";
    $SQL   .= "FROM distribucion_trimestral_imp_pre AS dis ";
    $SQL   .= "INNER JOIN proyecto_registro AS proy ON(dis.pk=proy.id) ";
    $SQL   .= "INNER JOIN organos_entes AS oe ON(proy.ente=oe.id) ";
    $SQL   .= "INNER JOIN sectores AS s ON(s.id=oe.sector)";
    $SQL   .= "WHERE proy.ano_fiscal= $ano AND proy.estatus = 4 AND oe.tipo_ins IN($dato[0],$dato[1]) AND proy.cierre = 1 AND dis.pk = proy.id ";
    $SQL   .= "GROUP BY proy.ente,oe.sector,proy.estruc_presupuestaria,oe.nom_ins, s.codigo))AS y ";
    $SQL   .= "GROUP BY y.ente, y.sector,substring(y.estruc_presupuestaria from 1 for 8),y.nom_ins, y.codigo ";
    $SQL   .= "ORDER BY y.sector,substring(y.estruc_presupuestaria from 1 for 8)";
    $organo = $this->ModelStandard->query_set($SQL, 'result');
    // echo $this->db->last_query(); exit;

    // Condicional
    $gastos_fiscales = '0.00';
    foreach ($organo as $org) {
        $ente       = $org->ente;
        $sector     = $org->sector;
        $monto_asig = $org->monto_asig;
        $mod_acc    = $dato[2];
        // Seleccion de Organos
        $gastos_fiscales += $monto_asig; // Gasto Fiscal


        $monto_g    = $monto_asig; // Monto Especifico
        $tipo       = $tipo; // Elemento para la captura de los valores a filtar, ya sea por Tomo I o Tomo II
        $dato       = explode('-', $tipo);

        $query_org  = "select y.ente,y.sector, SUM(y.m_asig) as m_asig from";
        $query_org .= "((select acc.ente,oe.sector,SUM(imp.m_asig) as m_asig from acciones_registro as acc ";
        $query_org .= "INNER JOIN imp_presupuestaria_modificado AS imp ON(imp.id_acc_reg = acc.id) ";
        $query_org .= "INNER JOIN accion_centralizada AS ac ON(acc.acc_centralizada = ac.id) ";
        $query_org .= "INNER JOIN organos_entes AS oe ON(acc.ente=oe.id) ";
        $query_org .= "INNER JOIN sectores AS s ON(s.id=oe.sector)";
        $query_org .= "WHERE acc.ano_fiscal= $ano AND imp.m_asig > 0.00 AND oe.tipo_ins IN($dato[0],$dato[1]) AND ";
        $query_org .= "acc.acc_centralizada = ac.id AND acc.estatus= 4 AND acc.cierre = 1 and imp.accion = 1";
        $query_org .= "and acc.ente = $ente and oe.sector = $sector";
        $query_org .= " group by acc.ente,oe.sector)";
        $query_org .= "union all";
        $query_org .= "(select proy.ente,oe.sector,SUM(imp.m_asig) as m_asig from proyecto_registro as proy ";
        $query_org .= "INNER JOIN imp_presupuestaria_modificado AS imp ON(imp.id_acc_reg = proy.id)"; 
        $query_org .= "INNER JOIN organos_entes AS oe ON(proy.ente=oe.id) ";
        $query_org .= "INNER JOIN sectores AS s ON(s.id=oe.sector)";
        $query_org .= "WHERE proy.ano_fiscal= $ano AND imp.m_asig > 0.00 AND oe.tipo_ins IN($dato[0],$dato[1])";
        $query_org .= "AND proy.estatus= 4 AND proy.cierre = 1 and imp.accion = 2";
        $query_org .= "and proy.ente = $ente and oe.sector = $sector";
        $query_org .= " group by proy.ente,oe.sector)) as y ";
        $query_org .= "group by y.ente,y.sector";
        $result_mod = $this->ModelStandard->query_set($query_org, 'result');

        
        if ($sector === $sec_id) {
            if ($monto_asig > 0.00) {
                $this->pdf->Cell(3);
                $this->pdf->SetFont('Helvetica', '', 6.3);
                $this->pdf->Cell(160, 5, utf8_decode($org->nom_ins), 0, 0, 'L', '1');
                $this->pdf->SetFont('Helvetica', '', 7);

                $sum_total = 0.00;
                foreach ($result_mod as $row) {
                    if ($sector === $row->sector and $dato[2] == 5) {
                        $sum_total += (float)$row->m_asig;
                    }
                }
                $this->pdf->Cell(20, 5, $this->pdf->Format_number((float)$monto_g + $sum_total), '', 1, 'R', '1');

            }
        }
    }
}
// =============================================================================
// Validacion de monto de gastos fiscales
if(isset($gastos_fiscales)){
    $gasto_f = $gastos_fiscales;
}else{
    $gasto_f = 0.00;
}
$this->pdf->Ln(25);
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Cell(160, 7, "TOTAL", '', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(20, 7, $this->pdf->Format_number($gasto_f), '', 1, 'L', '1');
/* =========================================================================== */
// ORDER BY oe.sector ASC
$this->pdf->AddPage(); // Salto de pagina para la contra portada, reflejando los detallado de sectores y organos

foreach ($titulo_org_sectores as $row) { // Apertura de ciclo for (iteracion en cuanto a los Sectores y Organos)
    $this->pdf->Ln(82);
    $ente = $row->ente; // ID del Ente asociado a las Acciones Centralizadas
    $this->pdf->SetFont('Helvetica', 'B', 10);
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(255, 255, 255);

    $nom_sector = $this->ModelStandard->search_in_row('id', 'sectores', $row->sector);
    $this->pdf->Cell(180, 7, utf8_decode("SECTOR: $row->codigo $nom_sector->sector"), '', 0, 'C', '1'); // Salida de los sectores
    $this->pdf->Ln(5);
    $this->pdf->SetFont('Helvetica', 'B', 9);
    $this->pdf->MultiCell(180, 5, utf8_decode("$row->nom_ins"), 0, 'C', 0);
    /* ==============================================================================
      # Inicio del formato del Plan Operativo Anual
    ============================================================================== */
    // Identificación del Proponente
    //$this->pdf->AddPage();
    $this->pdf->AliasNbPages(); // Define el alias para el número de página que se imprimirá en el pie
    /* Se define el titulo, márgenes izquierdo, derecho y el color de relleno predeterminado */
    //$this->pdf->SetTitle(utf8_decode("$nom"));
    $this->pdf->SetLeftMargin(15);
    $this->pdf->SetRightMargin(15);
    $this->pdf->SetFillColor(139, 28, 28);
    $this->pdf->SetFont('Arial', 'B', 9); // Se define el formato de fuente: Arial, negritas, tamaño 9

    if (($dato[0] == 1 AND $dato[1] == 4) OR ( $dato[0] == 2 AND $dato[1] == 3)) { // Bloque de validación para generar el reporte de Acción Centralizada (POA)
        // El encabezado del PDF
        $query_iden     = "SELECT acc.id AS id_acc,ac.id AS accion,acc.ente,oe.nom_ins,ac.accion_centralizada FROM acciones_registro AS acc INNER JOIN organos_entes AS oe ON(acc.ente=oe.id) INNER JOIN accion_centralizada AS ac ON(acc.acc_centralizada=ac.id) WHERE acc.estatus=4 AND acc.ente= $ente AND acc.cierre = 1 AND acc.ano_fiscal= $ano ORDER BY ac.accion_centralizada ASC";
        $identificacion = $this->ModelStandard->query_set($query_iden, 'result');
        //echo $this->db->last_query(); exit;
        // Inicio
        foreach ($identificacion as $row) {
            $id_accion     = $row->accion;
            $id_acc        = $row->id_acc;
            
            $query_imp         = "SELECT p.codigo,p.partida_presupuestaria,imp.m_asig AS monto FROM acciones_registro AS acc INNER JOIN imp_presupuestaria AS imp ON(acc.id=imp.id_acc_reg) INNER JOIN partida_presupuestaria AS p ON(imp.partida=p.id) WHERE imp.id_acc_reg = $id_acc AND imp.m_asig > 0.00 ORDER BY p.codigo ASC";
			$dis_actividad_imp = $this->ModelStandard->query_set($query_imp, 'result');
			
			if(count($dis_actividad_imp) > 0.00){
            
            $this->pdf->AddPage();
            $this->pdf->Ln(7);
            $this->pdf->SetFont('Arial', 'B', 10);
            $this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
            $this->pdf->SetFillColor(139, 28, 28);
            $this->pdf->Cell(180.2, 5, utf8_decode('IDENTIFICACIÓN DEL PROPONENTE'), 'TBL', 1, 'C', '1');
            $this->pdf->SetFont('Arial', 'B', 8);
            $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
            $this->pdf->SetFillColor(255, 255, 255);
            //$this->pdf->Cell(45, 7, utf8_decode('1.1 Organismo/Ente/Empresa:'), 'TBL', 0, 'L', '1');
            $this->pdf->SetFont('Arial', '', 8);
            $this->pdf->MultiCell(180, 5, utf8_decode($row->nom_ins), 'LR', 'J', 1);
            $this->pdf->SetFont('Arial', 'B', 10);
            $this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
            $this->pdf->SetFillColor(139, 28, 28);
            $this->pdf->Cell(180.2, 5, utf8_decode('DATOS BÁSICOS DE LA ACCIÓN CENTRALIZADA'), 'TBL', 1, 'C', '1');
            $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
            $this->pdf->SetFillColor(191, 191, 191);
            $this->pdf->Cell(180.2, 5, utf8_decode('ACCIÓN CENTRALIZADA'), 'TBLR', 1, 'C', '1');
            $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
            $this->pdf->SetFillColor(255, 255, 255);
            $this->pdf->SetFont('Arial', 'B', 8);
            $this->pdf->Cell(55, 7, utf8_decode('3.1 Nombre de la Accion Centralizada:'), 'TBL', 0, 'L', '1');
            $this->pdf->SetFont('Arial', '', 8);
            $this->pdf->Cell(125, 7, utf8_decode($row->accion_centralizada), 'TBR', 1, 'L', '1');
            $this->pdf->SetFont('Arial', 'B', 8);
            $this->pdf->Cell(180, 7, utf8_decode('3.2 Nombre de la Accion Específica:'), 'TRL', 0, 'L', '1');
            $this->pdf->Ln(7);
            $this->pdf->SetFont('Arial', '', 8);
            $query_acc_esp = "SELECT ace.accion_especifica FROM acciones_registro AS acc INNER JOIN organos_entes AS oe ON(acc.ente=oe.id) INNER JOIN accion_especifica AS ace ON(acc.acc_centralizada=ace.accion_centralizada) WHERE ace.accion_centralizada= $id_accion AND acc.cierre = 1 GROUP BY ace.accion_especifica";
            $acc_esp       = $this->ModelStandard->query_set($query_acc_esp, 'result');
            foreach ($acc_esp as $row) {
			//echo $this->db->last_query(); exit;
                $this->pdf->MultiCell(180, 5, utf8_decode($row->accion_especifica), 'LR', 'J', 0);
            }
            $this->pdf->SetFont('Arial', 'B', 10);
            $this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
            $this->pdf->SetFillColor(139, 28, 28);
            $this->pdf->Cell(180.2, 5, utf8_decode('ACTIVIDADES DE LA ACCIÓN ESPECÍFICA'), 'TBL', 1, 'C', '1');
            $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
            $this->pdf->SetFillColor(127, 127, 127);
//            $this->pdf->Cell(180.2, 5, utf8_decode('ACTIVIDADES DE LA ACCIÓN ESPECÍFICA'), 'TBLR', 1, 'C', '1');

            $xx               = 1;
            $query_actividad = "SELECT dis.actividad,dis.unidad_medida,dis.medio_verificacion,dis.cantidad,dis.indicador_actividad FROM acciones_registro AS acc INNER JOIN distribucion_actividad AS dis ON(acc.id=dis.id_acc_reg) WHERE dis.id_acc_reg = $id_acc AND acc.cierre = 1 AND dis.programado = TRUE ORDER BY dis.id ASC";
            $actividad       = $this->ModelStandard->query_set($query_actividad, 'result');
            //echo $this->db->last_query(); exit;
            foreach ($actividad as $row) {

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

                if ($xx == 8) {
                    $this->pdf->AddPage();
                    $this->pdf->Ln('10');
                    
                }

                $xx++;
            }
            $this->pdf->AddPage();
            $this->pdf->Ln(5);
            $this->pdf->SetFont('Arial', 'B', 10);
            $this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
            $this->pdf->SetFillColor(139, 28, 28);
            $this->pdf->Cell(180.2, 5, utf8_decode('Distribución Trimestral de las Actividades'), 'TBLR', 1, 'C', '1');
            $this->pdf->SetFont('Arial', '', 8);

            $this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
            $this->pdf->SetFillColor(139, 28, 28);
            $y             = 1;
            $trimestre_i   = 0;
            $trimestre_ii  = 0;
            $trimestre_iii = 0;
            $trimestre_iv  = 0;
            $total         = 0;
            $query_dis_act = "SELECT disac.actividad,dis.trimestre_i,dis.trimestre_ii,dis.trimestre_iii,dis.trimestre_iv,dis.total FROM acciones_registro AS acc INNER JOIN distribucion_trimestral_actividad AS dis ON(acc.id=dis.id_acc_reg) INNER JOIN distribucion_actividad AS disac ON(dis.id_actividad=disac.id) WHERE dis.id_acc_reg = $id_acc AND acc.cierre = 1 ORDER BY dis.id ASC";
            $dis_actividad = $this->ModelStandard->query_set($query_dis_act, 'result');
            //echo $this->db->last_query(); exit;
            foreach ($dis_actividad as $row) {
                if ($row->total > 0.00) {
                    $this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
                    $this->pdf->SetFillColor(143, 141, 141);
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Cell(180, 5, 'Actividad', 'TBLR', 0, 'C', '1');
                    $this->pdf->SetFont('Arial', '', 8);
                    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
                    $this->pdf->SetFillColor(255, 255, 255);
                    $this->pdf->Ln(5);
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
                    $this->pdf->Cell(36, 5, $this->pdf->Format_Miles($row->trimestre_i), 'TBLR', 0, 'R', '1');
                    $this->pdf->Cell(36, 5, $this->pdf->Format_Miles($row->trimestre_ii), 'TBLR', 0, 'R', '1');
                    $this->pdf->Cell(36, 5, $this->pdf->Format_Miles($row->trimestre_iii), 'TBLR', 0, 'R', '1');
                    $this->pdf->Cell(36, 5, $this->pdf->Format_Miles($row->trimestre_iv), 'TBLR', 0, 'R', '1');
                    $this->pdf->Cell(36, 5, $this->pdf->Format_Miles($row->total), 'TBLR', 1, 'R', '1');
                }

                if ((int) $y == 6) {
                    $this->pdf->AddPage();
                    $this->pdf->Ln(5);
                    if ($row->total > 0.00) {
                        $this->pdf->SetFont('Arial', 'B', 10);
                        $this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
                        $this->pdf->SetFillColor(139, 28, 28);
                        $this->pdf->Cell(180.2, 5, utf8_decode('Distribución Trimestral de las Actividades'), 'TBLR', 1, 'C', '1');
                        $this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
                        $this->pdf->SetFillColor(143, 141, 141);
                        $this->pdf->SetFont('Arial', '', 10);
                        $this->pdf->Cell(180, 5, 'Actividad', 'TBLR', 0, 'C', '1');
                        $this->pdf->SetFont('Arial', '', 8);
                        $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
                        $this->pdf->SetFillColor(255, 255, 255);
                        $this->pdf->Ln(5);
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
                        $this->pdf->Cell(36, 5, $this->pdf->Format_Miles($row->trimestre_i), 'TBLR', 0, 'R', '1');
                        $this->pdf->Cell(36, 5, $this->pdf->Format_Miles($row->trimestre_ii), 'TBLR', 0, 'R', '1');
                        $this->pdf->Cell(36, 5, $this->pdf->Format_Miles($row->trimestre_iii), 'TBLR', 0, 'R', '1');
                        $this->pdf->Cell(36, 5, $this->pdf->Format_Miles($row->trimestre_iv), 'TBLR', 0, 'R', '1');
                        $this->pdf->Cell(36, 5, $this->pdf->Format_Miles($row->total), 'TBLR', 1, 'R', '1');
                    }
                }

                $y++;
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

            // IMPUTACIÓN ACCIONES
            $this->pdf->Ln(4);
            $this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
            $this->pdf->SetFillColor(139, 28, 28);
            $this->pdf->Cell(180.2, 5, utf8_decode('IMPUTACIÓN ACCIONES'), 'TBLR', 1, 'C', '1');
            $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
            $this->pdf->SetFillColor(255, 255, 255);
            $this->pdf->Cell(15, 7.5, utf8_decode('Código'), 'LR', 0, 'C', '0');
            $this->pdf->Cell(165, 7.5, utf8_decode('Denominación'), 'LRTB', 1, 'C', '0');

            $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
            $this->pdf->SetFillColor(191, 191, 191);
            $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
            $this->pdf->SetFillColor(255, 255, 255);

            $trimestre_ip   = 0;
            $trimestre_iip  = 0;
            $trimestre_iiip = 0;
            $trimestre_ivp  = 0;
            $montop         = 0;
            
            $query_imp         = "select y.codigo, y.partida_presupuestaria, SUM(y.m_asig) AS monto FROM";
			$query_imp         .= "((select p.codigo, p.partida_presupuestaria, SUM(a.m_asig) AS m_asig from imp_presupuestaria AS a";
			$query_imp         .= " INNER JOIN partida_presupuestaria AS p ON(a.partida=p.id)";
			 $query_imp         .= "where id_acc_reg = $id_acc and a.m_asig > 0.00 GROUP BY p.codigo, p.partida_presupuestaria";
			$query_imp         .= ")";
			$query_imp         .= "UNION ALL";
			$query_imp         .= "(select p.codigo, p.partida_presupuestaria, SUM(a.m_asig) AS m_asig from imp_presupuestaria_modificado AS a ";
			$query_imp         .= " INNER JOIN partida_presupuestaria AS p ON(a.partida_id=p.id)";
			$query_imp         .= "where a.id_acc_reg = $id_acc and a.m_asig > 0.00 AND a.accion=1 GROUP BY p.codigo, p.partida_presupuestaria";
			$query_imp         .= ")) AS y";
			$query_imp         .= " GROUP BY y.codigo, y.partida_presupuestaria ORDER BY y.codigo ASC";
            
            $dis_actividad_imp = $this->ModelStandard->query_set($query_imp, 'result');
            //echo $this->db->last_query(); exit;
            $monto_sub_total = 0.00;
            foreach ($dis_actividad_imp as $row) {
				$this->pdf->SetFont('Arial', '', 6);
				$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
				$this->pdf->SetFillColor(255, 255, 255);
				$this->pdf->Cell(15, 5, utf8_decode($this->pdf->string_pad($row->codigo, 13, ".00")), 'TBLR', 0, 'C', '1');
				$this->pdf->Cell(130, 5, utf8_decode($row->partida_presupuestaria), 'TBLR', 0, 'L', '1');
				$this->pdf->Cell(35, 5, $this->pdf->Format_number($row->monto), 'TBLR', 1, 'R', '1');
				$montop +=$row->monto; // Sumatoria total de los montos por partidas presupuestarias (Distribucion presupuestaria)
            }
            
            $this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
            $this->pdf->SetFillColor(159, 112, 112);
            $this->pdf->Cell(15, 5, utf8_decode("TOTAL"), 'TBLR', 0, 'C', '1');
            $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
            $this->pdf->SetFillColor(255, 255, 255);
            $this->pdf->Cell(130, 5, '', 'TBLR', 0, 'L', '1');
            $this->pdf->Cell(35, 5, $this->pdf->Format_number($montop), 'TBLR', 1, 'R', '1');
		}
    }
    
    // Fin


        // Bloque para reflejar los proyectos asociados del organo
        // PROYECTOS
    $resumen_proyecto = "select dis.pk AS pk_proyecto,proy.estruc_presupuestaria, proy.nom_proyecto, SUM(dis.s_cons) AS s_cons, SUM(dis.g_fiscal) AS g_fiscal, SUM(dis.fci) AS fci, SUM(dis.ticr) AS ticr, SUM(dis.m_asig) AS m_asig from distribucion_trimestral_imp_pre AS dis INNER JOIN proyecto_registro AS proy ON(proy.id = dis.pk) WHERE proy.ente = $ente AND proy.estatus = 4 AND proy.cierre = 1 AND proy.ano_fiscal = $ano GROUP BY proy.estruc_presupuestaria, proy.nom_proyecto,dis.pk ORDER BY proy.estruc_presupuestaria ASC";
    $obj_rp           = $this->ModelStandard->query_set($resumen_proyecto, 'result');
	//echo $this->db->last_query(); exit;
    if (count($obj_rp) > 0) {
        $sum_total_rp = 0.00;
        
        foreach ($obj_rp as $row) {
			$pk_proyecto = $row->pk_proyecto;
			
			// Imputacion modificado por Proyecto
			$sql        = "select im.id, im.m_asig from imp_presupuestaria_modificado AS im where id_acc_reg = $pk_proyecto AND im.accion=2";
			$obj_improy = $this->ModelStandard->query_set($sql, 'result');
			$sum_total_mod = 0.00;
			foreach ($obj_improy as $value) {
				$sum_total_mod += $value->m_asig;
			}
			
			//echo $sum_total_mod; exit;
			
            $sum_total_rp += $row->m_asig;
            $x = 6;
            if ((int) strlen($row->nom_proyecto) >= 216) {
                $x = 18;
            }
            if ((int) strlen($row->nom_proyecto) >= 101) {
                $x = 12;
            }
            $this->pdf->AddPage(); // Salto de pagina
            $this->pdf->Ln(7);
            $this->pdf->SetFont('Helvetica', 'B', 8);
                $this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
                $this->pdf->SetFillColor(139, 28, 28);
                $this->pdf->Cell(180, 6, "PROYECTOS", 'RBLT', 1, 'L', '1');
                $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
                $this->pdf->SetFillColor(222, 222, 222);
                $this->pdf->SetFont('Helvetica', 'B', 5);
                $this->pdf->Cell(36, 6, "ESTRUCTURA PRESUPUESTARIA", 'RBLT', 0, 'C', '1');
                $this->pdf->Cell(144, 6, utf8_decode("NOMBRE DEL PROYECTO"), 'RBLT', 1, 'C', '1');
                $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
                $this->pdf->SetFillColor(255, 255, 255);
                $this->pdf->SetFont('Helvetica', '', 7);
                $this->pdf->Cell(36, $x, "$row->estruc_presupuestaria", 'RBLT', 0, 'C', '1');
                $this->pdf->MultiCell(144, 4, utf8_decode("$row->nom_proyecto"), 'RBLT', 'L', 0);

                $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
                $this->pdf->SetFillColor(222, 222, 222);
                $this->pdf->SetFont('Helvetica', 'B', 5);
                $this->pdf->Cell(36, 5, utf8_decode("SITUADO CONSTITUCIONAL"), 'RBLT', 0, 'C', '1');
                $this->pdf->Cell(36, 5, utf8_decode("GESTIÓN FISCAL"), 'RBLT', 0, 'C', '1');
                $this->pdf->Cell(36, 5, utf8_decode("FONDO COMP INTERTERRITORIAL"), 'RBLT', 0, 'C', '1');
                $this->pdf->Cell(36, 5, utf8_decode("TRANSF CORRIENTES INTERNAS REP"), 'RBLT', 0, 'C', '1');
                $this->pdf->Cell(36, 5, utf8_decode("TOTAL"), 'RBLT', 1, 'C', '1');
                $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
                $this->pdf->SetFillColor(255, 255, 255);
                $this->pdf->SetFont('Helvetica', '', 6.2);
                $this->pdf->Cell(36, 5, $this->pdf->Format_number(($row->s_cons > $sum_total_mod)? $row->s_cons + $sum_total_mod: $row->s_cons), 'RBLT', 0, 'R', '1');
                $this->pdf->Cell(36, 5, $this->pdf->Format_number(($row->g_fiscal > $sum_total_mod)? $row->g_fiscal + $sum_total_mod: $row->g_fiscal), 'RBLT', 0, 'R', '1');
                $this->pdf->Cell(36, 5, $this->pdf->Format_number(($row->fci > $sum_total_mod)? $row->fci + $sum_total_mod: $row->fci), 'RBLT', 0, 'R', '1');
                $this->pdf->Cell(36, 5, $this->pdf->Format_number(($row->ticr > $sum_total_mod)? $row->ticr + $sum_total_mod: $row->ticr), 'RBLT', 0, 'R', '1');
                $this->pdf->Cell(36, 5, $this->pdf->Format_number(($row->m_asig > $sum_total_mod)? $row->m_asig + $sum_total_mod: $row->m_asig), 'RBLT', 1, 'R', '1');
            }
            // TOTAL GENERAL DEL PROYECTO
            $this->pdf->Cell(36, 5, "TOTAL", 'RBLT', 0, 'C', '1');
            $this->pdf->Cell(108, 5, "", 'RBLT', 0, 'C', '1');
            $this->pdf->Cell(36, 5, $this->pdf->Format_number($sum_total_rp + $sum_total_mod), 'RBLT', 1, 'R', '1');
        }

        $query5           = "SELECT proy.id AS id_proyecto,oe.id,SUM(dis.m_asig) AS monto_asig FROM distribucion_trimestral_imp_pre AS dis INNER JOIN proyecto_registro AS proy ON(dis.pk=proy.id) INNER JOIN organos_entes AS oe ON(proy.ente=oe.id) INNER JOIN observaciones_acciones_proy AS obs ON(proy.ente=obs.organo) WHERE proy.estatus=4 AND proy.ente = $ente AND proy.cierre = 1 AND proy.ano_fiscal=$ano GROUP BY oe.nom_ins,oe.id,proy.id ORDER BY proy.estruc_presupuestaria ASC";
        $proyectos_montos = $this->ModelStandard->query_set($query5, 'result');
        //echo $this->db->last_query(); exit;
        foreach ($proyectos_montos as $proy) {
            $id_proyecto   = $proy->id_proyecto; // ID del Proyecto
            $id_ente       = $proy->id; // ID del Ente
            $monto_general = $proy->monto_asig; // Monto General por Proyectos (Sectores / Organos)
            if ($monto_general > 0) { // Se deternina si posee un existente por organo monto del proyecto
                $query6       = "SELECT proy.objetivo_institucional,proy.id,proy.estruc_presupuestaria,proy.descripcion_proy,proy.obj_general AS obj_proyecto,obj_h.objetivo_historico,obj_n.objetivo_nacional,obj_e.objetivo_estrategico,obj_g.objetivo_general,li_es.linea_estrategica,proy.nom_proyecto,SUM(dis.s_cons) AS s_cons,SUM(dis.g_fiscal) AS g_fiscal, SUM(dis.fci) AS fci,SUM(dis.ticr) AS ticr,SUM(dis.m_asig) AS m_asig FROM proyecto_registro AS proy INNER JOIN distribucion_trimestral_imp_pre AS dis ON(dis.pk = proy.id) INNER JOIN objetivo_historico AS obj_h ON(proy.objetivo_historico=obj_h.id) INNER JOIN objetivo_nacional AS obj_n ON(proy.objetivo_nacional=obj_n.id) INNER JOIN objetivo_estrategico AS obj_e ON(proy.objetivo_estrategico=obj_e.id) INNER JOIN objetivo_general AS obj_g ON(proy.objetivo_general=obj_g.id) INNER JOIN linea_estrategica AS li_es ON(proy.linea_estrategica=li_es.id) WHERE proy.ente = $id_ente AND proy.id = $id_proyecto AND proy.estatus=4 AND proy.ano_fiscal=$ano GROUP BY dis.pk,proy.estruc_presupuestaria,proy.ente,proy.id,obj_h.objetivo_historico,obj_n.objetivo_nacional,obj_e.objetivo_estrategico,obj_g.objetivo_general,li_es.linea_estrategica,proy.descripcion_proy";
                $resumen_proy = $this->ModelStandard->query_set($query6, 'result');
                //echo $this->db->last_query(); exit;
                $this->pdf->AddPage(); // Salto de pagina
                $this->pdf->Ln(7);
                $this->pdf->SetLineWidth(-50); // Grozor de la linea
                $this->pdf->SetFont('Helvetica', 'B', 8);
                $this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
                $this->pdf->SetFillColor(139, 28, 28);
                $this->pdf->Cell(180, 5, "PROYECTOS", 'RBLT', 1, 'L', '1');
                $s            = 5;
                $m_asig       = 0; // Variable en donde se toman la sumatoria de los montos asignados por cada proyecto (Sectores / Organos)
                $i            = 1; // Variable que se encarga de contar la cantidad de registros por proyectos
                foreach ($resumen_proy as $row) { // Recorrido de los proyectos
                    $m_asig  = $row->m_asig; // Monto general de los proyectos (Organos/Entes)
                    $id      = $row->id; // ID del Proyecto
                    $x = 6;
                    if ((int) strlen($row->nom_proyecto) >= 216) {
                        $x = 18;
                    }
                    if ((int) strlen($row->nom_proyecto) >= 101) {
                        $x = 12;
                    }
                    $acc_esp = $this->ModelStandard->search('pk', 'distribucion_acc_especifica', $id);
                    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
                    $this->pdf->SetFillColor(222, 222, 222);
                    $this->pdf->SetFont('Helvetica', 'B', 5);
                    $this->pdf->Cell(36, 6, "ESTRUCTURA PRESUPUESTARIA", 'RBLT', 0, 'C', '1');
                    $this->pdf->Cell(144, 6, utf8_decode("NOMBRE DEL PROYECTO"), 'RBLT', 1, 'C', '1');
                    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
                    $this->pdf->SetFillColor(255, 255, 255);
                    $this->pdf->SetFont('Helvetica', '', 7);
                    $this->pdf->Cell(36, $x, "$row->estruc_presupuestaria", 'RBLT', 0, 'C', '1');
                    $this->pdf->MultiCell(144, 4, trim(utf8_decode("$row->nom_proyecto")), 'RBLT', 'L', 0);

                    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
                    $this->pdf->SetFillColor(222, 222, 222);
                    $this->pdf->SetFont('Helvetica', 'B', 5);
                    $this->pdf->Cell(36, 5, utf8_decode("SITUADO CONSTITUCIONAL"), 'RBLT', 0, 'C', '1');
                    $this->pdf->Cell(36, 5, utf8_decode("GESTIÓN FISCAL"), 'RBLT', 0, 'C', '1');
                    $this->pdf->Cell(36, 5, utf8_decode("FONDO COMP INTERTERRITORIAL"), 'RBLT', 0, 'C', '1');
                    $this->pdf->Cell(36, 5, utf8_decode("TRANSF CORRIENTES INTERNAS REP"), 'RBLT', 0, 'C', '1');
                    $this->pdf->Cell(36, 5, utf8_decode("TOTAL"), 'RBLT', 1, 'C', '1');
                    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
                    $this->pdf->SetFillColor(255, 255, 255);
                    $this->pdf->SetFont('Helvetica', '', 6.2);
                    $this->pdf->Cell(36, 5, $this->pdf->Format_number(($row->s_cons > $sum_total_mod)? $row->s_cons + $sum_total_mod: $row->s_cons), 'RBLT', 0, 'R', '1');
					$this->pdf->Cell(36, 5, $this->pdf->Format_number(($row->g_fiscal > $sum_total_mod)? $row->g_fiscal + $sum_total_mod: $row->g_fiscal), 'RBLT', 0, 'R', '1');
					$this->pdf->Cell(36, 5, $this->pdf->Format_number(($row->fci > $sum_total_mod)? $row->fci + $sum_total_mod: $row->fci), 'RBLT', 0, 'R', '1');
					$this->pdf->Cell(36, 5, $this->pdf->Format_number(($row->ticr > $sum_total_mod)? $row->ticr + $sum_total_mod: $row->ticr), 'RBLT', 0, 'R', '1');
					$this->pdf->Cell(36, 5, $this->pdf->Format_number(($row->m_asig > $sum_total_mod)? $row->m_asig + $sum_total_mod: $row->m_asig), 'RBLT', 1, 'R', '1');
                    /* =========================================================================================
                      Detallado especifico del proyecto
                      ========================================================================================= */
                      $this->pdf->SetFont('Arial', 'B', 7);
                      $this->pdf->Cell(180, 5, utf8_decode('DESCRIPCIÓN DEL PROYECTO'), 'TRL', 0, 'L', '1');
                      $this->pdf->Ln(5);
                      $this->pdf->SetFont('Arial', '', 6);
                      $this->pdf->MultiCell(180, 3, utf8_decode("$row->descripcion_proy"), 'LR', 'J', 0);
                      $this->pdf->SetFont('Arial', 'B', 7);
                      $this->pdf->Cell(180, 5, utf8_decode('OBJETIVO GENERAL DEL PROYECTO'), 'RL', 0, 'L', '1');
                      $this->pdf->Ln(5);
                      $this->pdf->SetFont('Arial', '', 6);
                      $this->pdf->MultiCell(180, 5, utf8_decode("$row->obj_proyecto"), 'LR', 'J', 0);
                      $this->pdf->SetFont('Arial', 'B', 7);
                      $this->pdf->Ln(0);
                      $this->pdf->Cell(180, 5, utf8_decode('VINCULACIÓN PLAN DE DESARROLLO ECONÓMICO Y SOCIAL DE LA NACIÓN 2013-2019'), 'RL', 0, 'L', '1');
                      $this->pdf->Ln(5);
                      $this->pdf->Cell(180, 5, utf8_decode('OBJETIVO HISTÓRICO'), 'RL', 0, 'L', '1');
                      $this->pdf->Ln(5);
                      $this->pdf->SetFont('Arial', '', 6);
                      $this->pdf->MultiCell(180, 3, utf8_decode("$row->objetivo_historico"), 'LR', 'J', 0);
                      $this->pdf->SetFont('Arial', 'B', 7);
                      $this->pdf->Cell(180, 5, utf8_decode('OBJETIVO NACIONAL'), 'RL', 0, 'L', '1');
                      $this->pdf->Ln(5);
                      $this->pdf->SetFont('Arial', '', 6);
                      $this->pdf->MultiCell(180, 3, utf8_decode("$row->objetivo_nacional"), 'LR', 'J', 0);
                      $this->pdf->SetFont('Arial', 'B', 7);
                      $this->pdf->Cell(180, 5, utf8_decode('OBJETIVO ESTRATÉGICO'), 'RL', 0, 'L', '1');
                      $this->pdf->Ln(5);
                      $this->pdf->SetFont('Arial', '', 6);
                      $this->pdf->MultiCell(180, 3, utf8_decode("$row->objetivo_estrategico"), 'LR', 'J', 0);
                      $this->pdf->SetFont('Arial', 'B', 7);
                      $this->pdf->Cell(180, 5, utf8_decode('OBJETIVO GENERAL'), 'RL', 0, 'L', '1');
                      $this->pdf->Ln(5);
                      $this->pdf->SetFont('Arial', '', 6);
                      $this->pdf->MultiCell(180, 3, utf8_decode("$row->objetivo_general"), 'LR', 'J', 0);
                      $this->pdf->SetFont('Arial', 'B', 7);
                      $this->pdf->Cell(180, 5, utf8_decode('OBJETIVO GENERAL INSTITUCIONAL'), 'RL', 0, 'L', '1');
                      $this->pdf->Ln(5);
                      $this->pdf->SetFont('Arial', '', 6);
                      $this->pdf->MultiCell(180, 3, utf8_decode("$row->objetivo_institucional"), 'LR', 'J', 0);
                      $this->pdf->SetFont('Arial', 'B', 7);
                      $this->pdf->Cell(180, 5, utf8_decode('LÍNEA ESTRÁTEGICA DEL PLAN DE GOBIERNO BOLIVARIANO DE ARAGUA 2017-2021'), 'RL', 0, 'L', '1');
                      $this->pdf->Ln(5);
                      $this->pdf->SetFont('Arial', '', 6);
                      $this->pdf->MultiCell(180, 3, utf8_decode("$row->linea_estrategica"), 'LR', 'J', 0);



                    /* =====================================================================================
                     * RESUMEN DE CRÉDITOS PRESUPUESTARIOS (EN BOLIVARES) - PROYECTOS
                    ===================================================================================== */
                    $this->pdf->SetFont('Helvetica', 'B', 8);
                    $this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
                    $this->pdf->SetFillColor(139, 28, 28);
                    // ING JESUS LAYA
                    $this->pdf->Cell(180, 5, utf8_decode("RESUMEN DE CRÉDITOS PRESUPUESTARIOS (EN BOLIVARES)"), 'RBLT', 1, 'L', '1');

                    $query_creditos   = "SELECT p.partida_presupuestaria,p.codigo,dis.s_cons,dis.g_fiscal,dis.fci,dis.ticr,dis.m_asig FROM proyecto_registro AS proy INNER JOIN distribucion_trimestral_imp_pre AS dis ON(proy.id=dis.pk) INNER JOIN partida_presupuestaria AS p ON(dis.denominacion=p.id) WHERE proy.cierre = 1 AND proy.ente  = $ente AND proy.id = $id AND dis.m_asig > 0.00 AND proy.ano_fiscal=$ano ORDER BY p.codigo ASC";
                    $resumen_creditos = $this->ModelStandard->query_set($query_creditos, 'result');
					
                    //echo $this->db->last_query(); exit;

                    $resumen = 1;
                    foreach ($resumen_creditos as $row) {
                        $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
                        $this->pdf->SetFillColor(222, 222, 222);
                        $this->pdf->SetFont('Helvetica', 'B', 5);

                        if ($row->m_asig > 0.00) {
                            $this->pdf->Cell(36, 6, "PARTIDA PRESUPUESTARIA", 'RBLT', 0, 'C', '1');
                            $this->pdf->Cell(144, 6, utf8_decode("DENOMINACIÓN"), 'RBLT', 1, 'C', '1');
                            $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
                            $this->pdf->SetFillColor(255, 255, 255);
                            $this->pdf->SetFont('Helvetica', '', 7);
                            $this->pdf->Cell(36, 6, "$row->codigo.00.00.00", 'RBLT', 0, 'C', '1');
                            $this->pdf->MultiCell(144, 5, utf8_decode("$row->partida_presupuestaria"), 'RBLT', 'L', 0);

                            $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
                            $this->pdf->SetFillColor(222, 222, 222);
                            $this->pdf->SetFont('Helvetica', 'B', 5);
                            $this->pdf->Cell(36, 5, utf8_decode("SITUADO CONSTITUCIONAL"), 'RBLT', 0, 'C', '1');
                            $this->pdf->Cell(36, 5, utf8_decode("GESTIÓN FISCAL"), 'RBLT', 0, 'C', '1');
                            $this->pdf->Cell(36, 5, utf8_decode("FONDO COMP INTERTERRITORIAL"), 'RBLT', 0, 'C', '1');
                            $this->pdf->Cell(36, 5, utf8_decode("TRANSF CORRIENTES INTERNAS REP"), 'RBLT', 0, 'C', '1');
                            $this->pdf->Cell(36, 5, utf8_decode("TOTAL"), 'RBLT', 1, 'C', '1');
                            $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
                            $this->pdf->SetFillColor(255, 255, 255);
                            $this->pdf->SetFont('Helvetica', '', 6.2);
                            $this->pdf->Cell(36, 5, $this->pdf->Format_number(($row->s_cons > $sum_total_mod)? $row->s_cons + $sum_total_mod: $row->s_cons), 'RBLT', 0, 'R', '1');
							$this->pdf->Cell(36, 5, $this->pdf->Format_number(($row->g_fiscal > $sum_total_mod)? $row->g_fiscal + $sum_total_mod: $row->g_fiscal), 'RBLT', 0, 'R', '1');
							$this->pdf->Cell(36, 5, $this->pdf->Format_number(($row->fci > $sum_total_mod)? $row->fci + $sum_total_mod: $row->fci), 'RBLT', 0, 'R', '1');
							$this->pdf->Cell(36, 5, $this->pdf->Format_number(($row->ticr > $sum_total_mod)? $row->ticr + $sum_total_mod: $row->ticr), 'RBLT', 0, 'R', '1');
							$this->pdf->Cell(36, 5, $this->pdf->Format_number(($row->m_asig > $sum_total_mod)? $row->m_asig + $sum_total_mod: $row->m_asig), 'RBLT', 1, 'R', '1');
                        }

                        if ($resumen == 3) {
                            $this->pdf->AddPage(); // Salto de pagina
                            $this->pdf->Ln(12);
                            $this->pdf->SetFont('Helvetica', 'B', 8);
                            $this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
                            $this->pdf->SetFillColor(139, 28, 28);
                            $this->pdf->Cell(180, 5, utf8_decode("RESUMEN DE CRÉDITOS PRESUPUESTARIOS (EN BOLIVARES)"), 'RBLT', 1, 'L', '1');
                        }
                        /* ===================================================================================== */

                        $resumen = $resumen + 1;
                    }
                    $s = $s + 5; // Acumulador de dimension de las celdas
                    $i = $i + 1; // Acumulador de cantidad de registros por proyecto (Sectores/ Organos)
                    /* ========================================================================================= */
                    $this->pdf->SetFont('Helvetica', 'B', 6);
                    $this->pdf->Cell(36, 5, utf8_decode("MONTO TOTAL"), 'RBLT', 0, 'C', '1');
                    $this->pdf->Cell(108, 5, "", 'RBLT', 0, 'C', '1');
                    // Bloque de monto General asignado por proyecto
                    $this->pdf->Cell(36, 5, $this->pdf->Format_number($sum_total_rp + $sum_total_mod), 'RBLT', 1, 'R', '1');

                    $s             = $s + 5; // Acumulador de dimension de las celdas
                    $i             = $i + 1; // Acumulador de cantidad de registros por proyecto (Sectores/ Organos)
                    // ACCIONES ESPECIFICAS DEL PROYECTO
                    $this->pdf->AddPage();
                    $this->pdf->Ln(10);
                    $this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
                    $this->pdf->SetFillColor(139, 28, 28);
                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->Cell(180.2, 5, utf8_decode('ACCIONES ESPECIFICAS'), 'TBLR', 1, 'C', '1');
                    $y             = 1;
                    $trimestre_i   = 0;
                    $trimestre_ii  = 0;
                    $trimestre_iii = 0;
                    $trimestre_iv  = 0;
                    $total         = 0;
                    foreach ($acc_esp as $row) {

                        //if((int)$y == 2){
                        //    $this->pdf->AddPage();
                        //    $this->pdf->Ln(5);
                        //}

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
                        $this->pdf->Cell(154, 7, utf8_decode($row->unidad_medida), 'TBR', 1, 'L', '1');
                        $this->pdf->SetFont('Arial', 'B', 8);
                        $this->pdf->Cell(26, 7, utf8_decode('Medio/Verificación:'), 'TBL', 0, 'L', '1');
                        $this->pdf->SetFont('Arial', '', 8);
                        $this->pdf->Cell(154, 7, utf8_decode($row->medio_verificacion), 'TBR', 1, 'L', '1');
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
                        $y = $y + 1;
                        $trimestre_i +=$row->trimestre_i;
                        $trimestre_ii +=$row->trimestre_ii;
                        $trimestre_iii +=$row->trimestre_iii;
                        $trimestre_iv +=$row->trimestre_iv;
                        $total +=$row->total;
                    }
                    $this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
                    $this->pdf->SetFillColor(159, 112, 112);
                    $this->pdf->Cell(36, 5, $this->pdf->Format_Miles($trimestre_i), 'TBLR', 0, 'C', '1');
                    $this->pdf->Cell(36, 5, $this->pdf->Format_Miles($trimestre_ii), 'TBLR', 0, 'C', '1');
                    $this->pdf->Cell(36, 5, $this->pdf->Format_Miles($trimestre_iii), 'TBLR', 0, 'C', '1');
                    $this->pdf->Cell(36, 5, $this->pdf->Format_Miles($trimestre_iv), 'TBLR', 0, 'C', '1');
                    $this->pdf->Cell(36, 5, $this->pdf->Format_Miles($total), 'TBLR', 1, 'C', '1');
                }
            }
        }
        $this->pdf->AddPage();
    } /* Cierre de Bloque de Accion Centralizada (POA) */
} // Cierre de ciclo for (iteracion en cuanto a los Sectores y Organos)
// =============================================================================
// Salida del Formato PDF

$fecha_hora = date ("d/m/Y h:i:s A");
$this->pdf->Output("Plan Operativo Anual Estadal Modificado ($ano) $fecha_hora.pdf", 'I');
