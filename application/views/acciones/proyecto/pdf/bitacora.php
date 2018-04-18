<?php

$this->load->model('model_standard/ModelStandard'); # Llamado a el modelo Estandard

$this->pdf   = new Pdf($orientation = 'L', $unit        = 'mm', $format      = 'A4');
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

$nom = utf8_decode("AUDITORIA DE USUARIOS");

//$ano = date('Y', now());
$ano = 2016;

$this->pdf->SetTitle(utf8_decode("$nom"));

if ($tipo == 1):
    $where   = "b.id_usuario= $usuario";
endif;
if ($tipo == 3):
    $desde = mdate('%Y-%m-%d',strtotime($desde));
    $hasta = mdate('%Y-%m-%d',strtotime($hasta));
    
    if($desde!="00-00-0000" AND $hasta!="00-00-0000"){
        $where = "fecha_registro BETWEEN '$desde' AND '$hasta' OR fecha_actualizacion BETWEEN '$desde' AND '$hasta'";
    }else if($desde == $hasta){
        $where = "fecha_registro = '$desde' OR fecha_actualizacion =  '$hasta'";
    }
    
endif;
if ($tipo == 4):
    $where   = "b.id_usuario=$usuario AND b.accion= '$acc'";
endif;

///////////////////////////////////////////////////////////////////////////////////
//                            AUDITORIA DE USUARIOS
//////////////////////////////////////////////////////////////////////////////////////

$usuarios      = "SELECT u.id,u.username,u.first_name AS nombres,u.is_active FROM auth_user AS u INNER JOIN bitacora AS b ON(b.id_usuario=u.id) WHERE TO_CHAR(b.fecha_registro::DATE,'YYYY') = '$ano' AND u.id = $usuario GROUP BY u.id,u.username,u.first_name,u.is_active";
$usuarios_list = $this->ModelStandard->query_set($usuarios, 'result');

foreach ($usuarios_list AS $row):
    $id = $row->id;

    if ($row->is_active == 't'):
        $activo = "ACTIVO";
    else:
        $activo = "INACTIVO";
    endif;

    $is_active = $row->is_active;
    $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
    $this->pdf->SetFillColor(222, 222, 222);
    $this->pdf->SetFont('Helvetica', '', 8);
    $this->pdf->Cell(180, 5, strtoupper($row->username) . " - $row->nombres ( $activo )", 'RBLT', 1, 'C', '1');
    $this->pdf->SetFont('Helvetica', 'B', 5);
    $this->pdf->Cell(101, 5, utf8_decode("ACCIÓN"), 'RBLT', 0, 'C', '1');
    $this->pdf->Cell(19.8, 5, utf8_decode("REGISTRO"), 'RBLT', 0, 'C', '1');
    $this->pdf->Cell(19.8, 5, utf8_decode("ACTUALIZACIÓN"), 'RBLT', 0, 'C', '1');
    $this->pdf->Cell(19.8, 5, strtoupper("HORA/REGISTRO"), 'RBLT', 0, 'C', '1');
    $this->pdf->Cell(19.8, 5, strtoupper("HORA/ACTUALIZACION"), 'RBLT', 1, 'C', '1');

    // Proceso de los datos de la bitacora de los usuarios
    $list_u     = "SELECT b.accion,to_char(b.fecha_registro, 'DD-MM-YYYY') AS fecha_registro,to_char(b.fecha_actualizacion, 'DD-MM-YYYY') AS fecha_actualizacion,b.hora_registro,b.hora_actualizacion,b.ip FROM bitacora AS b WHERE $where";
    $usuarios_l = $this->ModelStandard->query_set($list_u, 'result');

    if(count($usuarios_l) != 0):
        $i          = 1;
        foreach ($usuarios_l AS $user):
            $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
            $this->pdf->SetFillColor(255, 255, 255);
            $this->pdf->SetFont('Helvetica', '', 6.5);
            $this->pdf->Cell(101, 5, utf8_decode("$user->accion"), 'RBLT', 0, 'L', '1');
            $this->pdf->Cell(19.8, 5, utf8_decode("$user->fecha_registro"), 'RBLT', 0, 'C', '1');
            $this->pdf->Cell(19.8, 5, utf8_decode("$user->fecha_actualizacion"), 'RBLT', 0, 'C', '1');
            $this->pdf->Cell(19.8, 5, strtoupper("$user->hora_registro"), 'RBLT', 0, 'C', '1');
            $this->pdf->Cell(19.8, 5, strtoupper("$user->hora_actualizacion"), 'RBLT', 1, 'C', '1');

            if ($i == 44):
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
                $this->pdf->Cell(180, 5, strtoupper($row->username) . " - $row->nombres ( $activo )", 'RBLT', 1, 'C', '1');
                $this->pdf->SetFont('Helvetica', 'B', 5);
                $this->pdf->Cell(101, 5, utf8_decode("ACCIÓN"), 'RBLT', 0, 'C', '1');
                $this->pdf->Cell(19.8, 5, utf8_decode("FECHA/REGISTRO"), 'RBLT', 0, 'C', '1');
                $this->pdf->Cell(19.8, 5, utf8_decode("FECHA/ACTUALIZACIÓN"), 'RBLT', 0, 'C', '1');
                $this->pdf->Cell(19.8, 5, strtoupper("HORA/REGISTRO"), 'RBLT', 0, 'C', '1');
                $this->pdf->Cell(19.8, 5, strtoupper("HORA/ACTUALIZACION"), 'RBLT', 1, 'C', '1');
            endif;

            $i++;
        endforeach;
    else:
        $this->pdf->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
        $this->pdf->SetFillColor(255, 255, 255);
        $this->pdf->SetFont('Helvetica', '', 11);
        $this->pdf->Cell(180, 5, utf8_decode("NO SE ENCUENTRAN REGISTROS ASOCIADOS"), 'RBLT', 0, 'C', '1');
    endif;
endforeach;

//////////////////////////////////////////////////////////////////////////////////////
// Salida del Formato PDF
$this->pdf->Output(utf8_decode("$nom AÑO ($ano).pdf"), 'D');

