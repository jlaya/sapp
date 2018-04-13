<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


// Include the main TCPDF library (search for installation path).
require_once APPPATH . 'third_party/tcpdf/examples/tcpdf_include.php';
//require_once APPPATH . 'third_party/tcpdf/examples/tcpdf_header.php';
// create new PDF document
$pdf = new TPDF($orientation='P', $unit='mm', $format='A4', $unicode=true, $encoding='UTF-8', $diskcache=false, $pdfa=false);
$pdf->SetTitle('EJEMPLO TCPDF');
$pdf->AddPage();
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'XYZ',$pdf->writeHTML($html));

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
// set some text for example
$txt  = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';
$txt2 = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. sdfsdffsfksfsfsdfsdfsddfsadffafaf';

//echo (int)strlen($txt2) - (int)strlen($txt);
$x = (int) strlen($txt2) - (int) strlen($txt);
// Multicell test
$pdf->MultiCell(55, $x - 5, '[LEFT] ' . $txt, 1, 'L', 1, 0, '', '', true);
$pdf->MultiCell(55, $x - 5, '[RIGHT] ' . $txt2, 1, 'R', 0, 1, '', '', true);
$pdf->MultiCell(55, 5, '[CENTER] ' . $txt, 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(55, 5, '[JUSTIFY] ' . $txt . "\n", 1, 'J', 1, 2, '', '', true);
$pdf->MultiCell(55, 5, '[DEFAULT] ' . $txt, 1, '', 0, 1, '', '', true);
$pdf->SetFillColor(222, 222, 222);
/* $pdf->Cell(15, 5, "ITEM", 'RBLT', 0, 'C', 1);
  $pdf->Cell(20, 5, "NOMBRE", 'RBLT', 1, 'C', 1); */

// EJEMPLO DE CONSTRUCCION DE PDF CON TCPDF


$html = '<table border="0" cellspacing="2" cellpadding="2">
            <tr style="background-color:#487287;color:#FFFFFF;">
                <th style="width:7%;">#</th>
                <th style="text-align:center;width:12%">Cédula</th>
                <th style="text-align:center;width:68%">Nombres y Apellidos</th>
                <th style="text-align:center;width:10%">Teléfono</th>
            </tr>';
$html .='</table>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');



$pdf->lastPage();

//Close and output PDF document
$pdf->Output('TCPDF.pdf', 'I');

