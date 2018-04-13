<?php

$this->load->model('model_standard/ModelStandard'); # Llamado a el modelo Estandard
$this->pdf   = new PdfLeyTomoI($orientation = 'L', $unit        = 'mm', $format      = 'A4');
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

if ($dato[0] == 1 AND $dato[1] == 4) {
    $tomo   = "Tomo I $ano";
    $titulo = "Tomo I";
    $tipo_f = "Organos y Unidades de Apoyo";
} elseif ($dato[0] == 2 AND $dato[1] == 3) {
    $tomo   = "Tomo II $ano";
    $titulo = "Tomo II";
    $tipo_f = "Entes y Empresas";
}
// =============================================================================
// Portada Tomo (Ley Presupuestaria)
// =============================================================================
$this->pdf->Ln(3);
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Ln(80);
$this->pdf->SetFont('Helvetica', 'B', 16);
$this->pdf->Cell(180, 7, utf8_decode('Ley de Presupuesto de Ingresos y Egresos'), '', 0, 'C', '1');
$this->pdf->Ln(7);
$this->pdf->Cell(180, 7, utf8_decode('del Estado Aragua'), '', 1, 'C', '1');
$this->pdf->Ln(95);
$this->pdf->Cell(180, 7, utf8_decode($titulo), '', 1, 'C', '1');
$this->pdf->Cell(180, 7, utf8_decode("Ejercicio Fiscal $ano"), '', 1, 'C', '1');
// =============================================================================
// Contra Portada Tomo I (Ley Presupuestaria)
// =============================================================================
$this->pdf->AddPage();
$this->pdf->Ln(10);
$this->pdf->SetFont('Helvetica', 'B', 11);

if ($dato[0] == 1 AND $dato[1] == 4) {
    //$this->pdf->MultiCell(180, 5, utf8_decode("Presupuestos de Ingresos, Gastos y Operaciones de Financiamiento de los Órganos y Unidades de Apoyo del Estado Bolivariano de Aragua"), 0, 'J', 0);
    //$this->pdf->Ln(6);
    $this->pdf->Cell(25, 7, utf8_decode('Artículo 32.'), '', 0, 'L', '1');
    $this->pdf->SetFont('Helvetica', '', 10);
    $this->pdf->Cell(155, 7, utf8_decode('Acuérdese el monto total de los créditos presupuestario para cada Órgano del estado y para las'), '', 1, 'L', '1');
    $this->pdf->Cell(155, 7, utf8_decode('rectificaciones al presupuesto de gasto, de acuerdo con la distribución siguiente:'), '', 1, 'L', '1');
} elseif ($dato[0] == 2 AND $dato[1] == 3) {
    //$this->pdf->MultiCell(180, 5, utf8_decode("Presupuesto de Ingresos, Gastos y Operaciones de Financiamiento de los Entes Descentralizados, Desconcentrados sin Fines Empresariales y Empresas del Estado Funcionalmente del Estado Bolivariano de Aragua"), 0, 'J', 0);
    //$this->pdf->Ln(6);
    $this->pdf->Cell(25, 7, utf8_decode('Artículo 33.'), '', 0, 'L', '1');
    $this->pdf->SetFont('Helvetica', '', 10);
    $this->pdf->Cell(155, 7, utf8_decode('Acuérdese el monto total de los créditos presupuestario para cada Ente Descentralizado'), '', 1, 'L', '1');
    $this->pdf->Cell(155, 7, utf8_decode('Funcionalmente con y sin Fines Empresariales de acuerdo con la distribución siguiente:'), '', 1, 'L', '1');
}

// =============================================================================
// Proceso para el listado de sectores
// =============================================================================
$this->pdf->SetTitle(utf8_decode($tomo));
$this->pdf->Ln(5);
$s = 1;
foreach ($sectores as $sec) {
    $sec_id          = $sec->id;
    $this->pdf->SetFont('Helvetica', 'B', 8);
    //$this->pdf->Ln(7);
    
    if($s == 5){
        $this->pdf->AddPage();
        $this->pdf->Ln(12);
    }
    
    $this->pdf->Cell(25, 7, utf8_decode($sec->sector), '', 1, 'L', '1'); // Salida de los sectores
    // Proceso para reflejar los Organismos asociados al sector
    $monto_general   = 0; // Monto General por Organos
    $gastos_fiscales = 0; // Monto General de los gastos fiscales
    $monto_asig      = 0;
    $s = $s + 1;
    // Acciones Centralizadas Y Proyectos   

    $SQL = "SELECT y.ente, y.sector,substring(y.estruc_presupuestaria from 1 for 8),y.nom_ins,SUM(y.monto_asig) AS monto_asig FROM ";
    $SQL .= "((SELECT acc.ente,oe.sector,acc.estruc_presupuestaria,oe.nom_ins,SUM(imp.m_asig) AS monto_asig ";
    $SQL .= "FROM acciones_registro AS acc ";
    $SQL .= "INNER JOIN accion_centralizada AS ac ON(acc.acc_centralizada = ac.id) ";
    $SQL .= "INNER JOIN imp_presupuestaria AS imp ON(imp.id_acc_reg = acc.id) ";
    $SQL .= "INNER JOIN organos_entes AS oe ON(acc.ente=oe.id) ";
    $SQL .= "WHERE acc.ano_fiscal= $ano AND imp.m_asig > 0.00 AND oe.tipo_ins IN($dato[0],$dato[1]) AND imp.id_acc_reg = acc.id AND acc.estatus= 4 AND acc.cierre = 1 ";
    $SQL .= "GROUP BY acc.ente,oe.sector,acc.estruc_presupuestaria,oe.nom_ins ";
    $SQL .= "ORDER BY acc.estruc_presupuestaria ASC) ";
    $SQL .= "UNION ALL";
    $SQL .= "(SELECT proy.ente,oe.sector,proy.estruc_presupuestaria,oe.nom_ins,SUM(dis.m_asig) AS monto_asig ";
    $SQL .= "FROM distribucion_trimestral_imp_pre AS dis ";
    $SQL .= "INNER JOIN proyecto_registro AS proy ON(dis.pk=proy.id) ";
    $SQL .= "INNER JOIN organos_entes AS oe ON(proy.ente=oe.id) ";
    $SQL .= "WHERE proy.ano_fiscal= $ano AND proy.estatus = 4 AND oe.tipo_ins IN($dato[0],$dato[1]) AND proy.cierre = 1 AND dis.pk = proy.id ";
    $SQL .= "GROUP BY proy.ente,oe.sector,proy.estruc_presupuestaria,oe.nom_ins))AS y ";
    $SQL .= "GROUP BY y.ente, y.sector,substring(y.estruc_presupuestaria from 1 for 8),y.nom_ins ";
    $SQL .= "ORDER BY y.sector,substring(y.estruc_presupuestaria from 1 for 8)";
    
    $organo = $this->ModelStandard->query_set($SQL, 'result');
    //echo $this->db->last_query(); exit;

    // Condicional
    $orgj = 1;
    foreach ($organo as $org) {
        $ente       = $org->ente;
        $sector     = $org->sector;
        $monto_asig = $org->monto_asig;
        // Seleccion de Organos
        $gastos_fiscales += $monto_asig; // Gasto Fiscal
        $monto_g    = $monto_asig; // Monto Especifico
        $tipo       = $tipo; // Elemento para la captura de los valores a filtar, ya sea por Tomo I o Tomo II
        $dato       = explode('-', $tipo);
        if ((int)$sector === (int)$sec_id) {
            if ($monto_asig > 0.00) {
                $this->pdf->Cell(3);
                $this->pdf->SetFont('Helvetica', '', 6.3);
                $this->pdf->Cell(160, 5, utf8_decode($org->nom_ins), 0, 0, 'L', '1');
                $this->pdf->SetFont('Helvetica', '', 7);
                $this->pdf->Cell(20, 5, $this->pdf->Format_number($monto_g), '', 1, 'R', '1');
            }
        }
        $orgj = $orgj + 1;
    }
}
// =============================================================================
$this->pdf->Ln(25);
$this->pdf->SetFont('Arial', 'B', 8);
$this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(255, 255, 255);
$this->pdf->Cell(160, 7, "TOTAL", '', 0, 'L', '1');
$this->pdf->SetFont('Arial', '', 8);
$this->pdf->Cell(20, 7, $this->pdf->Format_number($gastos_fiscales), '', 1, 'L', '1');
// =============================================================================
// Inicio de los procesos por sectores asociados a los organismos
// =============================================================================
$this->pdf->AddPage();
$this->pdf->Ln(82);
foreach ($titulo_org_pro as $row) {

    if ($row->nom_ins == NULL or $row->nom_ins == "") {
        $nom_institucion = "";
    } else {
        $nom_institucion = $row->nom_ins;
    }

//    if($row->monto_asig != 0 or $row->monto_asig != "" or $row->monto_asig != NULL){
    $ente              = $row->ente; // ID del Ente asociado
    $this->pdf->SetFont('Helvetica', 'B', 10);
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(255, 255, 255);
    $nom_sector        = $this->ModelStandard->search_in_row('id', 'sectores', $row->sector);
    $this->pdf->Cell(180, 7, utf8_decode("SECTOR : $row->codigo $nom_sector->sector"), '', 0, 'C', '1'); // Salida de los sectores
    $this->pdf->Ln(5);
    $this->pdf->SetFont('Helvetica', 'B', 9);
    $this->pdf->MultiCell(180, 5, utf8_decode("$row->nom_ins"), 0, 'C', 0);
//    }
    //$this->pdf->AddPage(); // Siguiente pagina para reflejar de forma detallada la informacion de las Acciones Y Proyectos vinculados a los Sectores y Organos
    // =============================================================================
    // Siguiente pagina para reflejar de forma detallada la informacion de las Acciones Y Proyectos vinculados a los Sectores y Organos
    // =============================================================================
    /////////////////////////////////// RESUMEN DE PROYECTO //////////////////////////////////////////
    $resumen_proyecto1 = "select proy.estruc_presupuestaria, proy.nom_proyecto, SUM(dis.s_cons) AS s_cons, SUM(dis.g_fiscal) AS g_fiscal, SUM(dis.fci) AS fci, SUM(dis.ticr) AS ticr, SUM(dis.m_asig) AS m_asig from distribucion_trimestral_imp_pre AS dis INNER JOIN proyecto_registro AS proy ON(proy.id = dis.pk) WHERE proy.ente = $ente AND proy.estatus = 4 AND proy.cierre = 1 AND proy.ano_fiscal = $ano GROUP BY proy.estruc_presupuestaria, proy.nom_proyecto";
    $obj_rp            = $this->ModelStandard->query_set($resumen_proyecto1, 'result');

    if (count($obj_rp) > 0) {
        foreach ($obj_rp as $row) {
            $monto_general += $row->m_asig;
        }
    }
    //////////////////////////////////////////////////////////////////////////////////////////////////
    $query4           = "SELECT acc.ente,acc.estruc_presupuestaria,ac.id AS id_accion,ac.accion_centralizada,SUM(imp.s_cons) AS s_cons, SUM(imp.g_fiscal) AS g_fiscal, SUM(imp.fci) AS fci,SUM(imp.ticr) AS ticr,SUM(imp.m_asig) AS m_asig FROM acciones_registro AS acc INNER JOIN accion_centralizada AS ac ON(acc.acc_centralizada = ac.id) INNER JOIN imp_presupuestaria AS imp ON(imp.id_acc_reg = acc.id) WHERE acc.acc_centralizada = ac.id AND acc.ente = $ente AND acc.estatus=4 AND acc.cierre = 1 AND ano_fiscal=$ano GROUP BY ac.id,imp.id_acc_reg,acc.estruc_presupuestaria,ac.accion_centralizada,acc.ente,ac.id ORDER BY ac.accion_centralizada ASC";
    $resumen_acciones = $this->ModelStandard->query_set($query4, 'result');
    // echo $this->db->last_query(); exit;

//echo $this->db->last_query();

    if (count($resumen_acciones) > 0) { // Validacion si existe resumenes existentes por Sectores y Organos
        $this->pdf->AddPage();
        $this->pdf->Ln(7);
        $this->pdf->SetLineWidth(-50); // Grozor de la linea
        $this->pdf->SetFont('Helvetica', 'B', 8);
        $this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
        $this->pdf->SetFillColor(139, 28, 28);
        $this->pdf->MultiCell(180, 5, utf8_decode("$nom_institucion"), 'RBLT', 'L', 1); // Salida de los sectores


        $this->pdf->Cell(180, 6, "RESUMEN DE LAS ACCIONES CENTRALIZADAS (EN BOLIVARES)", 'RBLT', 1, 'L', '1');
        $m_asig = 0;
        foreach ($resumen_acciones as $row) {
            $m_asig +=$row->m_asig;
            $ente_id = $row->ente;
            $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
            $this->pdf->SetFillColor(222, 222, 222);
            $this->pdf->SetFont('Helvetica', 'B', 5);
            if ($row->m_asig > 0.00) {
                $this->pdf->Cell(36, 6, "ESTRUCTURA PRESUPUESTARIA", 'RBLT', 0, 'C', '1');
                $this->pdf->Cell(144, 6, utf8_decode("DENOMINACIÓN"), 'RBLT', 1, 'C', '1');
                $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
                $this->pdf->SetFillColor(255, 255, 255);
                $this->pdf->SetFont('Helvetica', '', 7);
                $this->pdf->Cell(36, 6, "$row->estruc_presupuestaria", 'RBLT', 0, 'C', '1');
                $this->pdf->MultiCell(144, 5, utf8_decode("$row->accion_centralizada"), 'RBLT', 'C', 0);

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
                $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->s_cons), 'RBLT', 0, 'R', '1');
                $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->g_fiscal), 'RBLT', 0, 'R', '1');
                $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->fci), 'RBLT', 0, 'R', '1');
                $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->ticr), 'RBLT', 0, 'R', '1');
                $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->m_asig), 'RBLT', 1, 'R', '1');
            }
        }
        $this->pdf->SetFont('Helvetica', 'B', 6.2);
        $this->pdf->Cell(36, 5, utf8_decode("TOTAL"), 'RBLT', 0, 'C', '1');
        $this->pdf->Cell(108, 5, "", 'RBLT', 0, 'C', '1');
        $this->pdf->Cell(36, 5, $this->pdf->Format_number($m_asig), 'RBLT', 1, 'R', '1');

        /////////////////////////////////// RESUMEN DE PROYECTO //////////////////////////////////////////

        $resumen_proyecto = "select proy.estruc_presupuestaria, proy.nom_proyecto, SUM(dis.s_cons) AS s_cons, SUM(dis.g_fiscal) AS g_fiscal, SUM(dis.fci) AS fci, SUM(dis.ticr) AS ticr, SUM(dis.m_asig) AS m_asig from distribucion_trimestral_imp_pre AS dis INNER JOIN proyecto_registro AS proy ON(proy.id = dis.pk) WHERE proy.ente = $ente AND proy.estatus = 4 AND proy.cierre = 1 AND proy.ano_fiscal = $ano GROUP BY proy.estruc_presupuestaria, proy.nom_proyecto";
        $obj_rp           = $this->ModelStandard->query_set($resumen_proyecto, 'result');

        if (count($obj_rp) > 0) {
            $sum_total = 0.00;
            foreach ($obj_rp as $row) {
                $sum_total += $row->m_asig;
                
                if((int)strlen($row->nom_proyecto) >= 100){
                    $x = 10;
                }else{
                    $x = 4;
                }
                
                $this->pdf->SetFont('Helvetica', 'B', 8);
                $this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
                $this->pdf->SetFillColor(139, 28, 28);
                $this->pdf->Cell(180, 6, "PROYECTO", 'RBLT', 1, 'L', '1');
                $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
                $this->pdf->SetFillColor(222, 222, 222);
                $this->pdf->SetFont('Helvetica', 'B', 5.1);
                $this->pdf->Cell(36, 6, "ESTRUCTURA PRESUPUESTARIA", 'RBLT', 0, 'C', '1');
                $this->pdf->Cell(144, 6, utf8_decode("NOMBRE DEL PROYECTO"), 'RBLT', 1, 'C', '1');
                $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
                $this->pdf->SetFillColor(255, 255, 255);
                $this->pdf->SetFont('Helvetica', '', 5.1);
                $this->pdf->Cell(36, 6, "$row->estruc_presupuestaria", 'RBLT', 0, 'C', '1');
                $this->pdf->MultiCell(144, 5, utf8_decode("$row->nom_proyecto"), 'RBLT', 'L', 0);

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
                $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->s_cons), 'RBLT', 0, 'R', '1');
                $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->g_fiscal), 'RBLT', 0, 'R', '1');
                $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->fci), 'RBLT', 0, 'R', '1');
                $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->ticr), 'RBLT', 0, 'R', '1');
                $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->m_asig), 'RBLT', 1, 'R', '1');
            }
            // TOTAL GENERAL DEL PROYECTO
            $this->pdf->Cell(36, 5, "TOTAL", 'RBLT', 0, 'C', '1');
            $this->pdf->Cell(108, 5, "", 'RBLT', 0, 'C', '1');
            $this->pdf->Cell(36, 5, $this->pdf->Format_number($sum_total), 'RBLT', 1, 'R', '1');
        }
        //////////////////////////////////////////////////////////////////////////////////////////////////
        // Bloque de validacion para reflejar de forma detallada por Accion Centralida (Sectores / Organos)
        $this->pdf->SetLineWidth(-50); // Grozor de la linea
        $this->pdf->SetFont('Helvetica', 'B', 8);
        $this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
        $this->pdf->SetFillColor(139, 28, 28);
        // Bloque donde se refleja el Resumen de los Creditos Presupuestarios (Bolivares) por Organos Entes
        $this->pdf->AddPage();
        $this->pdf->Ln(20);
        $this->pdf->Cell(180, 5, utf8_decode("RESUMEN DE CRÉDITOS PRESUPUESTARIOS (EN BOLIVARES)"), 'RBLT', 1, 'L', '1');
        foreach ($resumen_acciones as $row) {
            $id_accion = $row->id_accion; // ID de la Accion Centralizada

            if ($row->m_asig > 0.00) {

                $this->pdf->SetFont('Helvetica', 'B', 8);
                $this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
                $this->pdf->SetFillColor(139, 28, 28);
                // Accion centralizada (Ciclo foreach)
                $this->pdf->Cell(180, 5, utf8_decode("ACCIÓN CENTRALIZADA : $row->accion_centralizada"), 'RBLT', 1, 'L', '1');

                // Proceso de llamado de los datos de forma detallada (Resumen de Creditos Presupuestarios)
                $query_resumen = "SELECT acc.acc_centralizada,p.codigo,p.partida_presupuestaria,imp.s_cons,imp.g_fiscal,imp.fci,imp.ticr,imp.m_asig FROM acciones_registro acc INNER JOIN imp_presupuestaria AS imp ON(imp.id_acc_reg=acc.id) INNER JOIN partida_presupuestaria AS p ON(imp.partida=p.id) WHERE acc.acc_centralizada= $id_accion AND acc.ente = $ente AND acc.cierre = 1 AND ano_fiscal=$ano ORDER BY acc.acc_centralizada,p.codigo,p.partida_presupuestaria ASC";
                $resumen_c_p   = $this->ModelStandard->query_set($query_resumen, 'result');

                /* echo $this->db->last_query();
                  exit; */

                foreach ($resumen_c_p as $row) {
                    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
                    $this->pdf->SetFillColor(222, 222, 222);
                    $this->pdf->SetFont('Helvetica', 'B', 5);

                    if ($row->m_asig > 0.00) { // Bloque de validacion para determinar la existencia de los montos por partidas
                        $this->pdf->Cell(36, 6, "PARTIDA DE EGRESO", 'RBLT', 0, 'C', '1');
                        $this->pdf->Cell(144, 6, utf8_decode("DENOMINACIÓN"), 'RBLT', 1, 'C', '1');
                        $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
                        $this->pdf->SetFillColor(255, 255, 255);
                        $this->pdf->SetFont('Helvetica', '', 7);
                        $this->pdf->Cell(36, 6, "$row->codigo.00.00.00", 'RBLT', 0, 'C', '1');
                        $this->pdf->MultiCell(144, 5, utf8_decode("$row->partida_presupuestaria"), 'RBLT', 'C', 0);
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
                        $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->s_cons), 'RBLT', 0, 'R', '1');
                        $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->g_fiscal), 'RBLT', 0, 'R', '1');
                        $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->fci), 'RBLT', 0, 'R', '1');
                        $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->ticr), 'RBLT', 0, 'R', '1');
                        $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->m_asig), 'RBLT', 1, 'R', '1');
                    }
                }
                // Bloque para reflejar los proyectos asociados por el organo
            }
        }
    } // Fin del ciclo

    if ($monto_general > 0) { // Se deternina si posee un existente por organo monto del proyecto
        $query6         = "SELECT proy.objetivo_institucional,proy.id,proy.estruc_presupuestaria,proy.descripcion_proy,proy.obj_general AS obj_proyecto,obj_h.objetivo_historico,obj_n.objetivo_nacional,obj_e.objetivo_estrategico,obj_g.objetivo_general,li_es.linea_estrategica,proy.nom_proyecto,SUM(dis.s_cons) AS s_cons,SUM(dis.g_fiscal) AS g_fiscal, SUM(dis.fci) AS fci,SUM(dis.ticr) AS ticr,SUM(dis.m_asig) AS m_asig FROM proyecto_registro AS proy INNER JOIN distribucion_trimestral_imp_pre AS dis ON(dis.pk = proy.id) INNER JOIN objetivo_historico AS obj_h ON(proy.objetivo_historico=obj_h.id) INNER JOIN objetivo_nacional AS obj_n ON(proy.objetivo_nacional=obj_n.id) INNER JOIN objetivo_estrategico AS obj_e ON(proy.objetivo_estrategico=obj_e.id) INNER JOIN objetivo_general AS obj_g ON(proy.objetivo_general=obj_g.id) INNER JOIN linea_estrategica AS li_es ON(proy.linea_estrategica=li_es.id) WHERE proy.ente = $ente AND proy.estatus = 4 AND proy.cierre = 1 AND proy.ano_fiscal = $ano GROUP BY dis.pk,proy.estruc_presupuestaria,proy.ente,proy.id,obj_h.objetivo_historico,obj_n.objetivo_nacional,obj_e.objetivo_estrategico,obj_g.objetivo_general,li_es.linea_estrategica,proy.descripcion_proy ORDER BY proy.id DESC";
        $resumen_proy_p = $this->ModelStandard->query_set($query6, 'result');
        
       /* echo $this->db->last_query();
        exit; */

        $s      = 5;
        $m_asig = 0; // Variable en donde se toman la sumatoria de los montos asignados por cada proyecto (Sectores / Organos)
        $i      = 1; // Variable que se encarga de contar la cantidad de registros por proyectos
        $resumen_proyecto = "select proy.estruc_presupuestaria, proy.nom_proyecto, SUM(dis.s_cons) AS s_cons, SUM(dis.g_fiscal) AS g_fiscal, SUM(dis.fci) AS fci, SUM(dis.ticr) AS ticr, SUM(dis.m_asig) AS m_asig from distribucion_trimestral_imp_pre AS dis INNER JOIN proyecto_registro AS proy ON(proy.id = dis.pk) WHERE proy.ente = $ente AND proy.estatus = 4 AND proy.cierre = 1 AND proy.ano_fiscal = $ano GROUP BY proy.estruc_presupuestaria, proy.nom_proyecto ORDER BY proy.estruc_presupuestaria ASC";
        $obj_rp           = $this->ModelStandard->query_set($resumen_proyecto, 'result');
        
        //echo $this->db->last_query(); exit;
        
        if (count($resumen_acciones) == 0 and count($obj_rp) > 0) {

            $sum_total_rp = 0.00;
            foreach ($obj_rp as $row) {
                $sum_total_rp += $row->m_asig; 
                $x = 4;
                if((int)strlen($row->nom_proyecto) > 2){
                    $x = 20;
                }
                if((int)strlen($row->nom_proyecto) >= 101){
                    $x = 10;
                }else{
                    $x = 4;
                }
                $this->pdf->AddPage(); // Salto de pagina
                $this->pdf->Ln(7);
                $this->pdf->SetFont('Helvetica', 'B', 8);
                $this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
                $this->pdf->SetFillColor(139, 28, 28);
                $this->pdf->Cell(180, 6, "PROYECTO", 'RBLT', 1, 'L', '1');
                $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
                $this->pdf->SetFillColor(222, 222, 222);
                $this->pdf->SetFont('Helvetica', 'B', 5.1);
                $this->pdf->Cell(36, 6, "ESTRUCTURA PRESUPUESTARIA", 'RBLT', 0, 'C', '1');
                $this->pdf->Cell(144, 6, utf8_decode("NOMBRE DEL PROYECTO"), 'RBLT', 1, 'C', '1');
                $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
                $this->pdf->SetFillColor(255, 255, 255);
                $this->pdf->SetFont('Helvetica', '', 5.1);
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
                $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->s_cons), 'RBLT', 0, 'R', '1');
                $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->g_fiscal), 'RBLT', 0, 'R', '1');
                $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->fci), 'RBLT', 0, 'R', '1');
                $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->ticr), 'RBLT', 0, 'R', '1');
                $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->m_asig), 'RBLT', 1, 'R', '1');
                // TOTAL GENERAL DEL PROYECTO
                $this->pdf->Cell(36, 5, "TOTAL", 'RBLT', 0, 'C', '1');
                $this->pdf->Cell(108, 5, "", 'RBLT', 0, 'C', '1');
                $this->pdf->Cell(36, 5, $this->pdf->Format_number($sum_total_rp), 'RBLT', 1, 'R', '1');
            }
        }
        
        foreach ($resumen_proy_p as $row) { // Recorrido de los proyectos
            $m_asig  = $row->m_asig; // Monto general de los proyectos (Organos/Entes)
            $id      = $row->id; // ID del Proyecto
            $acc_esp = $this->ModelStandard->search('pk', 'distribucion_acc_especifica', $id);
            $this->pdf->AddPage(); // Salto de pagina
            $this->pdf->Ln(7);
            $this->pdf->SetLineWidth(-50); // Grozor de la linea
            $this->pdf->SetFont('Helvetica', 'B', 8);
            $this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
            $this->pdf->SetFillColor(139, 28, 28);
            $this->pdf->Cell(180, 5, "PROYECTO", 'RBLT', 1, 'L', '1');
            $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
            $this->pdf->SetFillColor(222, 222, 222);
            $this->pdf->SetFont('Helvetica', 'B', 5.1);
            $this->pdf->Cell(40, 6, utf8_decode("ESTRUCTURA PRESUPUESTARIA: "), 'RBLT', 0, 'L', '1');
            $this->pdf->SetFont('Helvetica', 'B', 6);
            $this->pdf->Cell(140, 6, utf8_decode("$row->estruc_presupuestaria"), 'RBLT', 1, 'L', '1');
            $this->pdf->SetFont('Helvetica', 'B', 5);
            $this->pdf->Cell(180, 6, utf8_decode("NOMBRE DEL PROYECTO"), 'RBLT', 1, 'C', '1');
            $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
            $this->pdf->SetFillColor(255, 255, 255);
            $this->pdf->SetFont('Helvetica', '', 5);
            $this->pdf->MultiCell(180, 4, utf8_decode("$row->nom_proyecto"), 'LR', 'L', 0);
            $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
            $this->pdf->SetFillColor(222, 222, 222);
            $this->pdf->Cell(36, 5, utf8_decode("SITUADO CONSTITUCIONAL"), 'RBLT', 0, 'C', '1');
            $this->pdf->Cell(36, 5, utf8_decode("GESTIÓN FISCAL"), 'RBLT', 0, 'C', '1');
            $this->pdf->Cell(36, 5, utf8_decode("FONDO COMP INTERTERRITORIAL"), 'RBLT', 0, 'C', '1');
            $this->pdf->Cell(36, 5, utf8_decode("TRANSF CORRIENTES INTERNAS REP"), 'RBLT', 0, 'C', '1');
            $this->pdf->Cell(36, 5, utf8_decode("TOTAL"), 'RBLT', 1, 'C', '1');
            $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
            $this->pdf->SetFillColor(255, 255, 255);
            $this->pdf->SetFont('Helvetica', '', 7);
            // Bloque de montos por Fuente de Financiamiento
            $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->s_cons), 'RBLT', 0, 'R', '1');
            $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->g_fiscal), 'RBLT', 0, 'R', '1');
            $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->fci), 'RBLT', 0, 'R', '1');
            $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->ticr), 'RBLT', 0, 'R', '1');
            $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->m_asig), 'RBLT', 1, 'R', '1');

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
            $this->pdf->MultiCell(180, 3, utf8_decode(trim($row->objetivo_general)), 'LR', 'J', 0);
            $this->pdf->SetFont('Arial', 'B', 7);
            $this->pdf->Cell(180, 5, utf8_decode('OBJETIVO ESTRATEGICO INSTITUCIONAL'), 'RL', 0, 'L', '1');
            $this->pdf->Ln(5);
            $this->pdf->SetFont('Arial', '', 6);
            $this->pdf->MultiCell(180, 3, utf8_decode("$row->objetivo_institucional"), 'LR', 'J', 0);
            $this->pdf->SetFont('Arial', 'B', 7);
            $this->pdf->Cell(180, 5, utf8_decode('LÍNEA ESTRÁTEGICA DEL PLAN DE GOBIERNO BOLIVARIANO DE ARAGUA 2017-2021'), 'RL', 0, 'L', '1');
            $this->pdf->Ln(5);
            $this->pdf->SetFont('Arial', '', 6);
            $this->pdf->MultiCell(180, 3, utf8_decode("$row->linea_estrategica"), 'RBL', 'J', 0);
            
            /* =====================================================================================
             * RESUMEN DE CRÉDITOS PRESUPUESTARIOS (EN BOLIVARES) - PROYECTOS
              ===================================================================================== */
            $this->pdf->SetFont('Helvetica', 'B', 8);
            $this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
            $this->pdf->SetFillColor(139, 28, 28);
            $this->pdf->AddPage(); // Salto de pagina
            $this->pdf->Ln(12);
            $this->pdf->Cell(180, 5, utf8_decode("RESUMEN DE CRÉDITOS PRESUPUESTARIOS (EN BOLIVARES)"), 'RBLT', 1, 'L', '1');

            $query_creditos   = "SELECT p.partida_presupuestaria,p.codigo,dis.s_cons,dis.g_fiscal,dis.fci,dis.ticr,dis.m_asig FROM proyecto_registro AS proy INNER JOIN distribucion_trimestral_imp_pre AS dis ON(proy.id=dis.pk) INNER JOIN partida_presupuestaria AS p ON(dis.denominacion=p.id) WHERE proy.cierre = 1 AND proy.ente  = $ente AND proy.id = $id AND dis.m_asig > 0.00 ORDER BY p.codigo ASC";
            $resumen_creditos = $this->ModelStandard->query_set($query_creditos, 'result');
            
            /* echo $this->db->last_query();
            exit; */
            
            $resumen          = 1;
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
                    $this->pdf->MultiCell(144, 5, utf8_decode("$row->partida_presupuestaria"), 'RBLT', 'C', 0);

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
                    $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->s_cons), 'RBLT', 0, 'R', '1');
                    $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->g_fiscal), 'RBLT', 0, 'R', '1');
                    $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->fci), 'RBLT', 0, 'R', '1');
                    $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->ticr), 'RBLT', 0, 'R', '1');
                    $this->pdf->Cell(36, 5, $this->pdf->Format_number($row->m_asig), 'RBLT', 1, 'R', '1');
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
            $this->pdf->Cell(36, 5, $this->pdf->Format_number($m_asig), 'RBLT', 1, 'R', '1');
        }
    }
//    }
    $this->pdf->AddPage();
    $this->pdf->Ln(82);
}
// =============================================================================
// Salida del Formato PDF
$this->pdf->Output("Ley Presupuestaria $tipo_f $ano.pdf", 'I');
