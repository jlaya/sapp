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
$this->pdf->SetFont('Arial', 'B', 12);
$this->pdf->Cell(30);
$this->pdf->Cell(180, 7, utf8_decode('Secretaria Sectorial del Poder Popular para la Planificación'), '', 0, 'L', '0');
$this->pdf->Ln('5');
$this->pdf->Cell(50);
$this->pdf->Cell(180, 7, utf8_decode('Presupuesto y Control de Gestión'), '', 1, 'L', '0');
$this->pdf->Ln(15);

// Condicional para validar los distintos reportes para el Control de los procesos Presupuestarios
if($tipo == 1):
    $nom = "DISTRIBUCION PARTIDAS PRESUPUESTARIAS";
endif;
if($tipo == 2):
    $nom = "RESUMEN DE PARTIDAS PRESUPUESTARIA (ACCIONES Y PROYECTOS)";
endif;
if($tipo == 3):
    $nom = "ESTRUCTURA PRESUPUESTARIA";
endif;
if($tipo == 4):
    $nom = "FUENTE DE FINANCIAMIENTO";
endif;

if($tipo == 5):
    $nom = utf8_decode("AUDITORIA DE USUARIOS");
endif;

$this->pdf->SetTitle(utf8_decode("$nom"));

// Comienzo de la Estructura del Reporte

$this->pdf->SetFont('Helvetica', 'B', 8);
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(138, 28, 28);
$this->pdf->Cell(180, 5, utf8_decode("$nom AÑO $ano"), 'RBLT', 1, 'C', '1');

//////////////////////////////////////////////////////////////////////////////////////
//                  DISTRIBUCION PARTIDAS PRESUPUESTARIAS
//////////////////////////////////////////////////////////////////////////////////////
if($tipo == 1):
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(222, 222, 222);
    $this->pdf->Cell(35, 5, utf8_decode("Código Presupuestario"), 'RBLT', 0, 'C', '1');
    $this->pdf->Cell(100, 5, utf8_decode("Denominación"), 'RBLT', 0, 'C', '1');
    $this->pdf->Cell(45, 5, utf8_decode("Monto Bs"), 'RBLT', 1, 'C', '1');
    $this->pdf->SetFont('Helvetica', '', 8);
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(255, 255, 255);
    // Iteracion de los montos Presupuestarios (2)
    $distribucion_acciones  = " SELECT p.codigo,p.partida_presupuestaria,SUM(imp.m_asig) AS m_asig FROM partida_presupuestaria AS p";
    $distribucion_acciones .= " INNER JOIN imp_presupuestaria AS imp ON(p.id=imp.partida) ";
    $distribucion_acciones .= " INNER JOIN acciones_registro AS a ON(imp.id_acc_reg=a.id)";
    $distribucion_acciones .= " WHERE a.ano_fiscal = $ano AND a.estatus=4 AND imp.m_asig > 0.00";
    $distribucion_acciones .= " GROUP BY p.codigo,p.partida_presupuestaria ORDER BY p.codigo ASC";
    $dis_acciones = $this->ModelStandard->query_set($distribucion_acciones, 'result');
    
    $monto_acc  = 0;
    $total = 0;
    foreach ($dis_acciones as $row):
        $monto_acc = $row->m_asig; // Monto de las Acciones Centralizadas
        // Iteracion de los montos Presupuestarios (1)
        $distribucion_proy = "  SELECT p.codigo,p.partida_presupuestaria,SUM(d.m_asig) AS m_asig";
        $distribucion_proy .= " FROM partida_presupuestaria AS p";
        $distribucion_proy .= " INNER JOIN distribucion_trimestral_imp_pre AS d ON(p.id=d.denominacion)"; 
        $distribucion_proy .= " INNER JOIN proyecto_registro AS proy ON(d.pk=proy.id)";
        $distribucion_proy .= " WHERE proy.ano_fiscal = $ano AND proy.estatus=4 AND d.m_asig > 0.00";
        $distribucion_proy .= " GROUP BY p.codigo,p.partida_presupuestaria ORDER BY p.codigo ASC";
        $dis_proy = $this->ModelStandard->query_set($distribucion_proy, 'result');
        $monto_proy = 0; // Monto
        foreach ($dis_proy as $row_proy):
            if($row->codigo == $row_proy->codigo):
                $monto_proy = $row_proy->m_asig;
           endif;
        endforeach;
        
        $this->pdf->Cell(35, 5, utf8_decode("$row->codigo.00.00.00"), 'RBLT', 0, 'C', '1');
        $this->pdf->Cell(100, 5, utf8_decode("$row->partida_presupuestaria"), 'RBLT', 0, 'L', '1');
        $this->pdf->Cell(45, 5, $this->pdf->Format_number($monto_acc + $monto_proy), 'RBLT', 1, 'R', '1');
        $total += $monto_acc + $monto_proy;
    endforeach;
    // Encabezado Final
    $this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(159, 112, 112);
    $this->pdf->Cell(35, 5, "TOTAL", 'LB', 0, 'C', '1');
    $this->pdf->Cell(100, 5, "", 'B', 0, 'L', '1');
    $this->pdf->Cell(45, 5, $this->pdf->Format_number($total), 'RBLT', 1, 'R', '1');
endif;
//////////////////////////////////////////////////////////////////////////////////////
//          RESUMEN DE PARTIDAS PRESUPUESTARIA (ACCIONES Y PROYECTOS)
//////////////////////////////////////////////////////////////////////////////////////
if($tipo == 2):
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(222, 222, 222);
    $this->pdf->Cell(180, 5, utf8_decode("ACCIONES CENTRALIZADAS"), 'RBLT', 1, 'C', '1');
    $this->pdf->Cell(35, 5, utf8_decode("Código Presupuestario"), 'RBLT', 0, 'C', '1');
    $this->pdf->Cell(100, 5, utf8_decode("Denominación"), 'RBLT', 0, 'C', '1');
    $this->pdf->Cell(45, 5, utf8_decode("Monto Bs"), 'RBLT', 1, 'C', '1');
    $this->pdf->SetFont('Helvetica', '', 8);
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(255, 255, 255);
    
    // Iteracion de los Procesos de las Acciones Centralizas
    $distribucion_acciones  = " SELECT p.codigo,p.partida_presupuestaria,SUM(imp.m_asig) AS m_asig FROM partida_presupuestaria AS p";
    $distribucion_acciones .= " INNER JOIN imp_presupuestaria AS imp ON(p.id=imp.partida) ";
    $distribucion_acciones .= " INNER JOIN acciones_registro AS a ON(imp.id_acc_reg=a.id)";
    $distribucion_acciones .= " WHERE a.ano_fiscal = $ano AND a.estatus=4 AND imp.m_asig > 0.00";
    $distribucion_acciones .= " GROUP BY p.codigo,p.partida_presupuestaria ORDER BY p.codigo ASC";
    $dis_acciones = $this->ModelStandard->query_set($distribucion_acciones, 'result');
    //echo $this->db->last_query();
    $monto_acc  = 0.00;
    $total = 0.00; // Total monto General
    foreach ($dis_acciones as $row):
        $monto_acc = $row->m_asig; // Monto de las Acciones Centralizadas
        // Iteracion de los montos Presupuestarios (1)
        $distribucion_proy = "  SELECT p.codigo,p.partida_presupuestaria,SUM(d.m_asig) AS m_asig";
        $distribucion_proy .= " FROM partida_presupuestaria AS p";
        $distribucion_proy .= " INNER JOIN distribucion_trimestral_imp_pre AS d ON(p.id=d.denominacion)"; 
        $distribucion_proy .= " INNER JOIN proyecto_registro AS proy ON(d.pk=proy.id)";
        $distribucion_proy .= " WHERE proy.ano_fiscal = $ano AND proy.estatus=4 AND d.m_asig > 0.00";
        $distribucion_proy .= " GROUP BY p.codigo,p.partida_presupuestaria ORDER BY p.codigo ASC";
        $dis_proy = $this->ModelStandard->query_set($distribucion_proy, 'result');
        $monto_proy = 0; // Monto
        foreach ($dis_proy as $row_proy):
            if($row->codigo == $row_proy->codigo):
                $monto_proy = $row_proy->m_asig;
           endif;
        endforeach;
        
        $this->pdf->Cell(35, 5, utf8_decode("$row->codigo.00.00.00"), 'RBLT', 0, 'C', '1');
        $this->pdf->Cell(100, 5, utf8_decode("$row->partida_presupuestaria"), 'RBLT', 0, 'L', '1');
        $this->pdf->Cell(45, 5, $this->pdf->Format_number($monto_acc + $monto_proy), 'RBLT', 1, 'R', '1');
        $total += $monto_acc + $monto_proy;
    endforeach;
    // Encabezado Final
    $this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(159, 112, 112);
    $this->pdf->Cell(35, 5, "TOTAL", 'LB', 0, 'C', '1');
    $this->pdf->Cell(100, 5, "", 'B', 0, 'L', '1');
    $this->pdf->Cell(45, 5, $this->pdf->Format_number($total), 'RBLT', 1, 'R', '1');
    
    $this->pdf->Ln(0);
    // Iteracion de los Procesos de los Proyectos
    $distribucion_proy  = " SELECT p.codigo,p.partida_presupuestaria,SUM(d.m_asig) AS m_asig";
    $distribucion_proy .= " FROM partida_presupuestaria AS p";
    $distribucion_proy .= " INNER JOIN distribucion_trimestral_imp_pre AS d ON(p.id=d.denominacion)";
    $distribucion_proy .= " INNER JOIN proyecto_registro AS proy ON(d.pk=proy.id)";
    $distribucion_proy .= " WHERE proy.ano_fiscal = $ano AND proy.estatus=4 AND d.m_asig > 0.00";
    $distribucion_proy .= " GROUP BY p.codigo,p.partida_presupuestaria ORDER BY p.codigo ASC";
    $dis_proy = $this->ModelStandard->query_set($distribucion_proy, 'result');
    //echo $this->db->last_query();
    $monto_proy  = 0.00;
    $total_proy  = 0.00;
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(222, 222, 222);
    $this->pdf->SetFont('Helvetica', 'B', 8);
    $this->pdf->Cell(180, 5, utf8_decode("PROYECTOS"), 'RBLT', 1, 'C', '1');
    foreach ($dis_proy as $row):
    $this->pdf->SetFont('Helvetica', '', 8);
        $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
        $this->pdf->SetFillColor(255, 255, 255);
        $monto_proy = $row->m_asig; // Monto de las Acciones Centralizadas
        $this->pdf->Cell(35, 5, utf8_decode("$row->codigo.00.00.00"), 'RBLT', 0, 'C', '1');
        $this->pdf->Cell(100, 5, utf8_decode("$row->partida_presupuestaria"), 'RBLT', 0, 'L', '1');
        $this->pdf->Cell(45, 5, $this->pdf->Format_number($monto_proy), 'RBLT', 1, 'R', '1');
        $total_proy += $monto_proy;
    endforeach;
    // Encabezado Final
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(159, 112, 112);
    $this->pdf->SetFont('Helvetica', '', 8);
    $this->pdf->Cell(35, 5, "TOTAL", 'LB', 0, 'C', '1');
    $this->pdf->Cell(100, 5, "", 'B', 0, 'L', '1');
    $this->pdf->Cell(45, 5, $this->pdf->Format_number($total_proy), 'RBLT', 1, 'R', '1');
    
    // Monto General de los montos de las Acciones y de los Proyectos
    $this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(159, 112, 112);
    $this->pdf->Ln(2);
    $this->pdf->Cell(35, 5, "GASTO FISCAL", 'LB', 0, 'C', '1');
    $this->pdf->Cell(100, 5, "", '', 0, 'L', '1');
    $this->pdf->Cell(45, 5, $this->pdf->Format_number($total + $total_proy), 'RBLT', 1, 'R', '1');
endif;
//////////////////////////////////////////////////////////////////////////////////////
//                           ESTRUCTURA PRESUPUESTARIA
//////////////////////////////////////////////////////////////////////////////////////
if($tipo == 3):
foreach ($sectores as $sec) {
    $sec_id          = $sec->id;
    $this->pdf->SetFont('Helvetica', 'B', 8);
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(222, 222, 222);
    $this->pdf->Cell(180, 7, utf8_decode($sec->sector), '', 1, 'L', '1'); // Salida de los sectores
    // Proceso para reflejar los Organismos asociados al sector
    $monto_general   = 0; // Monto General por Organos
    $gastos_fiscales = 0; // Monto General de los gastos fiscales
    $monto_asig      = 0;
    // Acciones Centralizadas    
    $SQL  = "SELECT y.ente, y.sector,substring(y.estruc_presupuestaria from 1 for 8),y.nom_ins,SUM(y.monto_asig) AS monto_asig, y.codigo FROM ";
    $SQL .= "((SELECT acc.ente,oe.sector,acc.estruc_presupuestaria,oe.nom_ins,SUM(imp.m_asig) AS monto_asig, s.codigo ";
    $SQL .= "FROM acciones_registro AS acc ";
    $SQL .= "INNER JOIN accion_centralizada AS ac ON(acc.acc_centralizada = ac.id) ";
    $SQL .= "INNER JOIN imp_presupuestaria AS imp ON(imp.id_acc_reg = acc.id) ";
    $SQL .= "INNER JOIN organos_entes AS oe ON(acc.ente=oe.id) ";
    $SQL .= "INNER JOIN sectores AS s ON(s.id=oe.sector)";
    $SQL .= "WHERE acc.ano_fiscal= $ano AND imp.m_asig > 0.00 AND imp.id_acc_reg = acc.id AND acc.estatus= 4 AND acc.cierre = 1 ";
    $SQL .= "GROUP BY acc.ente,oe.sector,acc.estruc_presupuestaria,oe.nom_ins,s.codigo ";
    $SQL .= "ORDER BY acc.estruc_presupuestaria ASC) ";
    $SQL .= "UNION ALL";
    $SQL .= "(SELECT proy.ente,oe.sector,proy.estruc_presupuestaria,oe.nom_ins,SUM(dis.m_asig) AS monto_asig, s.codigo ";
    $SQL .= "FROM distribucion_trimestral_imp_pre AS dis ";
    $SQL .= "INNER JOIN proyecto_registro AS proy ON(dis.pk=proy.id) ";
    $SQL .= "INNER JOIN organos_entes AS oe ON(proy.ente=oe.id) ";
    $SQL .= "INNER JOIN sectores AS s ON(s.id=oe.sector)";
    $SQL .= "WHERE proy.ano_fiscal= $ano AND proy.estatus = 4 AND proy.cierre = 1 AND dis.pk = proy.id ";
    $SQL .= "GROUP BY proy.ente,oe.sector,proy.estruc_presupuestaria,oe.nom_ins, s.codigo))AS y ";
    $SQL .= "GROUP BY y.ente, y.sector,substring(y.estruc_presupuestaria from 1 for 8),y.nom_ins, y.codigo ";
    $SQL .= "ORDER BY y.sector,substring(y.estruc_presupuestaria from 1 for 8)";
    $organo          = $this->ModelStandard->query_set($SQL, 'result');
    // Codiciona
    foreach ($organo as $org) {
        $ente       = $org->ente;
        $sector     = $org->sector;
        $monto_asig = $org->monto_asig;
        // Seleccion de Organos
        $gastos_fiscales += $monto_asig; // Gasto Fiscal
        $monto_g    = $monto_asig; // Monto Especifico
        $tipo       = $tipo; // Elemento para la captura de los valores a filtar, ya sea por Tomo I o Tomo II
        $dato       = explode('-', $tipo);
        if ($sector === $sec_id) {
            $this->pdf->SetFont('Helvetica', '', 7);
            $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
            $this->pdf->SetFillColor(255, 255, 255);
            $this->pdf->Cell(160, 7, utf8_decode($org->nom_ins), '', 0, 'L', '1');
            $this->pdf->Cell(20, 7, $this->pdf->Format_number($monto_g), '', 1, 'R', '1');
            // Seleccion de Unidades de Apoyo
        }
    }
}
$this->pdf->SetFont('Helvetica', 'B', 8);
$this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
$this->pdf->SetFillColor(159, 112, 112);
$this->pdf->Cell(180, 7, $this->pdf->Format_number($gastos_fiscales), '', 1, 'R', '1');
endif;

//////////////////////////////////////////////////////////////////////////////////////
//                  FUENTE DE FINANCIAMIENTO (ACCIONES Y PROYECTOS)
//////////////////////////////////////////////////////////////////////////////////////
if($tipo == 4):
    // Acciones Centralizadas
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(222, 222, 222);
    $this->pdf->Cell(180, 5, utf8_decode("DISTRIBUCACIÓN FINANCIERA"), 'RBLT', 1, 'C', '1');
    $this->pdf->SetFont('Helvetica', '', 6);
    $this->pdf->Cell(32, 5, utf8_decode("SITUADO CONSTITUCIONAL"), 'RBLT', 0, 'C', '1');
    $this->pdf->Cell(28, 5, utf8_decode("GESTIÓN FISCAL"), 'RBLT', 0, 'C', '1');
    $this->pdf->Cell(52, 5, utf8_decode("FONDO DE COMPENSACIÓN INTERTERRITORIAL"), 'RBLT', 0, 'C', '1');
    $this->pdf->Cell(68, 5, utf8_decode("TRANSFERENCIAS CORRIENTES INTERNAS DE LA REPÚBLICA"), 'RBLT', 1, 'C', '1');
    
    // Recorrido de los datos de las Fuentes de Financiamiento Por Acciones Centralizadas Y Proyectos
    $SQL = "SELECT SUM(y.s_cons) AS s_cons, SUM(y.g_fiscal) AS g_fiscal, SUM(y.fci) AS fci, SUM(y.ticr) AS ticr FROM ((SELECT SUM(i.s_cons) AS s_cons, SUM(i.g_fiscal) AS g_fiscal, SUM(i.fci) AS fci, SUM(i.ticr) AS ticr";
    $SQL .= " FROM imp_presupuestaria AS i";
    $SQL .= " INNER JOIN acciones_registro AS a ON(i.id_acc_reg=a.id)";
    $SQL .= " WHERE a.estatus = 4) ";
    $SQL .= "UNION ALL";
    $SQL .= "(SELECT SUM(i.s_cons) AS s_cons, SUM(i.g_fiscal) AS g_fiscal, SUM(i.fci) AS fci, SUM(i.ticr) AS ticr";
    $SQL .= " FROM distribucion_trimestral_imp_pre AS i";
    $SQL .= " INNER JOIN proyecto_registro AS p ON(i.pk=p.id)";
    $SQL .= " WHERE p.estatus = 4)) ";
    $SQL .= "AS y ";
    $distribucion = $this->ModelStandard->query_set($SQL, 'result');
    $s_cons = 0.00;
    $g_fiscal = 0.00;
    $fci = 0.00;
    $ticr = 0.00;
    $gasto_fiscal = 0.00;
    foreach ($distribucion as $row):
        $s_cons   = $row->s_cons;
        $g_fiscal = $row->g_fiscal;
        $fci      = $row->fci;
        $ticr     = $row->ticr;
        $gasto_fiscal = $s_cons + $g_fiscal + $fci + $ticr;
        $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
        $this->pdf->SetFillColor(255, 255, 255);        
        $this->pdf->SetFont('Helvetica', '', 8);
        $this->pdf->Cell(32, 5, $this->pdf->Format_number($s_cons), 'RBLT', 0, 'R', '1');
        $this->pdf->Cell(28, 5, $this->pdf->Format_number($g_fiscal), 'RBLT', 0, 'R', '1');
        $this->pdf->Cell(52, 5, $this->pdf->Format_number($fci), 'RBLT', 0, 'R', '1');
        $this->pdf->Cell(68, 5, $this->pdf->Format_number($ticr), 'RBLT', 1, 'R', '1');
    endforeach;
    $this->pdf->SetFont('Helvetica', 'B', 8);
    $this->pdf->SetTextColor(255, 255, 255);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(159, 112, 112);
    $this->pdf->Cell(180, 7, "GASTO FISCAL:  ".$this->pdf->Format_number($gasto_fiscal), 'RBLT', 1, 'L', '1');
endif;
//////////////////////////////////////////////////////////////////////////////////////
//                            AUDITORIA DE USUARIOS
//////////////////////////////////////////////////////////////////////////////////////
if($tipo == 5):
    $usuarios = "SELECT u.id,u.username,u.first_name AS nombres,u.is_active FROM auth_user AS u INNER JOIN bitacora AS b ON(b.id_usuario=u.id) WHERE TO_CHAR(b.fecha_registro::DATE,'YYYY') = '$ano' OR TO_CHAR(b.fecha_actualizacion::DATE,'YYYY') = '$ano' GROUP BY u.id,u.username,u.first_name,u.is_active";
    $usuarios_list = $this->ModelStandard->query_set($usuarios, 'result');
    foreach($usuarios_list AS $row):
        $id = $row->id;
        
        if($row->is_active == 't'):
            $activo = "ACTIVO";
        else:
            $activo = "INACTIVO";
        endif;
        
        $is_active = $row->is_active;
        $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
        $this->pdf->SetFillColor(222, 222, 222);
        $this->pdf->SetFont('Helvetica', '', 8);
        $this->pdf->Cell(180, 5, strtoupper($row->username)." - $row->nombres ( $activo )", 'RBLT', 1, 'C', '1');
        $this->pdf->SetFont('Helvetica', 'B', 5);
        $this->pdf->Cell(101, 5, utf8_decode("ACCIÓN"), 'RBLT', 0, 'C', '1');
        $this->pdf->Cell(19.8, 5, utf8_decode("FECHA/REGISTRO"), 'RBLT', 0, 'C', '1');
        $this->pdf->Cell(19.8, 5, utf8_decode("FECHA/ACTUALIZACIÓN"), 'RBLT', 0, 'C', '1');
        $this->pdf->Cell(19.8, 5, strtoupper("HORA/REGISTRO"), 'RBLT', 0, 'C', '1');
        $this->pdf->Cell(19.8, 5, strtoupper("HORA/ACTUALIZACION"), 'RBLT', 1, 'C', '1');
        
        // Proceso de los datos de la bitacora de los usuarios
        $list_u = "SELECT b.accion,to_char(b.fecha_registro, 'DD-MM-YYYY') AS fecha_registro,to_char(b.fecha_actualizacion, 'DD-MM-YYYY') AS fecha_actualizacion,b.hora_registro,b.hora_actualizacion,b.ip FROM bitacora AS b WHERE b.id_usuario=$id";
        $usuarios_l = $this->ModelStandard->query_set($list_u, 'result');
        $i = 1;
        foreach($usuarios_l AS $user):
        $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
        $this->pdf->SetFillColor(255, 255, 255);
        $this->pdf->SetFont('Helvetica', '', 6.5);
            $this->pdf->Cell(101, 5, utf8_decode("$user->accion"), 'RBLT', 0, 'L', '1');
            $this->pdf->Cell(19.8, 5, utf8_decode("$user->fecha_registro"), 'RBLT', 0, 'C', '1');
            $this->pdf->Cell(19.8, 5, utf8_decode("$user->fecha_actualizacion"), 'RBLT', 0, 'C', '1');
            $this->pdf->Cell(19.8, 5, strtoupper("$user->hora_registro"), 'RBLT', 0, 'C', '1');
            $this->pdf->Cell(19.8, 5, strtoupper("$user->hora_actualizacion"), 'RBLT', 1, 'C', '1');
            
            if($i == 44):
                $this->pdf->AddPage();
                $this->pdf->SetFont('Arial', 'B', 12);
                $this->pdf->Cell(30);
                $this->pdf->Cell(180, 7, utf8_decode('Secretaria Sectorial del Poder Popular para la Planificación'), '', 0, 'L', '0');
                $this->pdf->Ln('5');
                $this->pdf->Cell(50);
                $this->pdf->Cell(180, 7, utf8_decode('Presupuesto y Control de Gestión'), '', 1, 'L', '0');
                $this->pdf->Ln(15);
                $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
                $this->pdf->SetFillColor(222, 222, 222);
                $this->pdf->SetFont('Helvetica', '', 8);
                $this->pdf->Cell(180, 5, strtoupper($row->username)." - $row->nombres ( $activo )", 'RBLT', 1, 'C', '1');
                $this->pdf->SetFont('Helvetica', 'B', 5);
                $this->pdf->Cell(101, 5, utf8_decode("ACCIÓN"), 'RBLT', 0, 'C', '1');
                $this->pdf->Cell(19.8, 5, utf8_decode("FECHA/REGISTRO"), 'RBLT', 0, 'C', '1');
                $this->pdf->Cell(19.8, 5, utf8_decode("FECHA/ACTUALIZACIÓN"), 'RBLT', 0, 'C', '1');
                $this->pdf->Cell(19.8, 5, strtoupper("HORA/REGISTRO"), 'RBLT', 0, 'C', '1');
                $this->pdf->Cell(19.8, 5, strtoupper("HORA/ACTUALIZACION"), 'RBLT', 1, 'C', '1');
            endif;
            
            $i = $i + 1;
        endforeach;
    endforeach;
endif;
//////////////////////////////////////////////////////////////////////////////////////

// Salida del Formato PDF
$this->pdf->Output(utf8_decode("$nom AÑO ($ano).pdf"), 'I');
