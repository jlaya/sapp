<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
// Incluimos el archivo fpdf
require_once APPPATH . "/third_party/fpdf/fpdf.php";

//Extendemos la clase Pdf de la clase fpdf para que herede todas sus variables y funciones
class Pdf extends FPDF
{

    public function __construct()
    {
        parent::__construct();
    }
    
    public function Header()
    {   /*Y = Eje izquierdo
        # Z = Arriba / Abajo
        # D = Dimencion de la imagen */
                                                      # Y  Z D
        $this->Image(base_url().'assets/image/logo.jpg',15,7,25);
    }
    
    // El pie del pdf
    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'R');
    }

    function Format_number($decimal)
    {
        $result = str_replace('', '', number_format($decimal, 2, ",", "."));
        return $result;
    }

    function string_pad($string, $log, $ext)
    {
        return str_pad($string,  $log, $ext);
    }
    
    function Format_Miles($decimal)
    {
        $result = str_replace('', '', number_format($decimal, 0, ",", "."));
        return $result;
    }

}

// Ley Presupuestaria
class PdfLeyTomoI extends FPDF
{

    public function __construct()
    {
        parent::__construct();
    }
    
    public function Header()
    {   
        // El encabezado del PDF
        $this->SetFont('Arial', 'B', 13);
        $this->Cell(30);

        $this->SetY(18);
        $this->SetX(92);
        $this->SetFont('Arial','',6);
        $this->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
        $this->SetFillColor(255, 255, 255);
        $this->Cell(20,3,utf8_decode("REPÚBLICA BOLIVARIANA"),'',0,'C',1);
        $this->Ln(7);
        $this->SetY(21);
        $this->SetX(91);
        $this->SetFont('Arial','',6);
        $this->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
        $this->SetFillColor(255, 255, 255);
        $this->Cell(20,3,utf8_decode("DE VENEZUELA"),'',0,'C',1);

        $this->Image(base_url().'assets/image/aragua_escudo.jpg',90,25,25);

        $this->SetY(54);
        $this->SetX(92);
        $this->SetFont('Arial','',6);
        $this->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
        $this->SetFillColor(255, 255, 255);
        $this->Cell(20,3,utf8_decode("CONSEJO LEGISLATIVO"),'',0,'C',1);
        $this->SetY(57);
        $this->SetX(92);
        $this->SetFont('Arial','',6);
        $this->SetTextColor(0, 0, 0);  # COLOR DEL TEXTO
        $this->SetFillColor(255, 255, 255);
        $this->Cell(20,3,utf8_decode("DEL ESTADO ARAGUA"),'',0,'C',1);
    }
    
    // El pie del pdf
    public function Footer()
    {
        $this->SetY(273);
        $this->Ln(7);
        $this->SetFillColor(139, 28, 28);
        #$this->SetFillColor(56, 119, 119);
        $this->Cell(180, 1.5, utf8_decode(''), '', 1, 'C', '1');
        
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        //$this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'R');
    }

    function Format_number($decimal)
    {
        $result = str_replace('', '', number_format($decimal, 2, ",", "."));
        return $result;
    }

    function string_pad($string, $log, $ext)
    {
        return str_pad($string,  $log, $ext);
    }
    
    function Format_Miles($decimal)
    {
        $result = str_replace('', '', number_format($decimal, 0, ",", "."));
        return $result;
    }

}

?>
