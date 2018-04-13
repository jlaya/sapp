<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class CReporte extends CI_Controller {

    private $dir = 'reportes/';
    private $files = array('solicitudes' => 'solicitudes', 'gsolicitudes' => 'gsolicitudes');
    private $vista = '';

    public function __construct() {
        parent::__construct();
        $this->files = (object) $this->files;
        $this->load->model('registro/MResena', 'ficha'); # Llamado a el modelo de Reseña Ficha
        $this->load->model('registro/MDelito', 'delito'); #delito
        $this->load->model('registro/MEstacion', 'estacion'); #estacion
        $this->load->model('registro/MBoca', 'boca'); # boca
        $this->load->model('registro/MCabello', 'cabello'); #cabello
        $this->load->model('registro/MCabeza', 'cabeza'); #cabeza
        $this->load->model('registro/MCejas', 'cejas'); #cejas
        $this->load->model('registro/MColorCabello', 'color_cabello'); #color_cabello
        $this->load->model('registro/MColorOjos', 'color_ojos'); #color_ojos
        $this->load->model('registro/MColorPiel', 'color_piel'); #color_piel
        $this->load->model('registro/MContextura', 'contextura'); #contextura
        $this->load->model('registro/MFrente', 'frente'); #frente
        $this->load->model('registro/MLabios', 'labios'); #labios
        $this->load->model('registro/MMenton', 'menton'); #menton
        $this->load->model('registro/MNariz', 'nariz'); #nariz
        $this->load->model('registro/MOjos', 'ojos'); #ojos
        $this->load->model('registro/MOrejas', 'orejas'); #orejas
        $this->load->model('registro/MPiel', 'piel'); #piel
        $this->load->model('registro/MCabeza', 'cabeza');
        $this->load->model('registro/MCabello', 'cabellos');
        $this->load->model('registro/MColorCabello', 'color_cabellos');
        $this->load->model('registro/MDetalle', 'detalle');
        $this->load->model('topologia/MEstado', 'estado');
        //echo strtolower(substr($this->router->fetch_class(),1));
    }

    public function resena() {
        $cedula = $this->input->get('ci');
        $delito = 'no';
        $ficha = $this->ficha->search_ficha($cedula);
        $delitos = $this->ficha->search_delito($cedula);
        $rasgo_f = $this->ficha->search_rasgos_fisicos($cedula);
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Ing Jesus Laya');
        $pdf->SetTitle("Reseña $cedula");
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        $pdf->SetHeaderMargin(30);
        $pdf->SetTopMargin(20);
        $pdf->setFooterMargin(20);
        $pdf->SetAutoPageBreak(true);
        $pdf->SetDisplayMode('real', 'default');
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 005', PDF_HEADER_STRING);

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        if (@file_exists(dirname(__FILE__) . '/lang/es.php')) {
            require_once(dirname(__FILE__) . '/lang/es.php');
            $pdf->setLanguageArray($l);
        }
        $pdf->SetFont('times', 'B', 14);
        $pdf->Ln(5);
        $pdf->SetFont('times', '', 10);
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->setCellMargins(1, 1, 1, 1);
        $pdf->SetFillColor(255, 255, 127);
        $pdf->SetAuthor('Marcel Arcuri');
        $pdf->AddPage(); # AÑADE UNA NUEVA PAGINACION
        #$pdf->set_font('Times','',10) # TAMANO DE LA FUENTE
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->SetFillColor(157, 188, 201); # COLOR DE BOLDE DE LA CELDA
        $pdf->SetTextColor(24, 29, 31); # COLOR DEL TEXTO
        $pdf->SetMargins(19, 10, 10); # MARGENE DEL DOCUMENTO
        $pdf->SetLineWidth(0.25);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetY(4);
        $pdf->SetX(70);
        $pdf->Write(30, "REPÚBLICA BOLIVARIANA DE VENEZUELA");
        $pdf->SetY(8);
        $pdf->SetX(80);
        $pdf->Write(30, "MARACAY ESTADO ARAGUA");
        $pdf->SetY(12);
        $pdf->SetX(90);
        $pdf->SetY(4);
        $pdf->SetX(170);
        $pdf->Write(30, "");
        ############################### FICHA PERSONAL #############################################
        $pdf->ln(32.5);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(180, 7, "FICHA PERSONAL", 'LTBR', 1, 'C', 1);
        $pdf->SetFillColor(42, 63, 84);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(180, 5, "DATOS PERSONALES", 'LTBR', 1, 'C', 1);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(24, 29, 31);
        $pdf->SetFont('Arial', 'B', 8);                   #ID SI D
        if (isset($ficha->ruta_file)) {
            $pdf->Image(base_url() . "assets/$ficha->ruta_file", 25, 63, 25);
        } else {
            $pdf->Image(base_url() . "assets/images/default_avatar_male.jpg", 25, 63, 25);
        }
        $pdf->Cell(35, 45, "", 'LTBR', 0, 'C', 0);
        $pdf->SetY(93.5);
        $pdf->SetX(19);
        if (isset($ficha->ruta_file)) {
            $pdf->Cell(35, 5, "$ficha->ci", 0, 0, 'C', 0);
        } else {
            $pdf->Cell(35, 5, "", 0, 0, 'C', 0);
        }
        $pdf->Cell(35, 5, "$ficha->ci", 0, 0, 'C', 0);
        $pdf->SetY(55);
        $pdf->SetX(55);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40, 5, "CÉDULA", 'LTBR', 0, 'L', 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetX(55);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40, 5, "NOMBRE Y APELLIDO", 'LTBR', 0, 'L', 1);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(102, 5, "$ficha->nombres $ficha->apellidos", 'LTBR', 1, 'L', 1);
        $pdf->SetX(55);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40, 5, "NACIONALIDAD", 'LTBR', 0, 'L', 1);
        $pdf->SetFont('Arial', '', 9);
        if ($ficha->nacionalidad == 0) {
            $nacionalidad = "S/F";
        } else if ($ficha->nacionalidad == 1) {
            $nacionalidad = "VENEZOLANO(A)";
        } else {
            $nacionalidad = "EXTRANJERO(A)";
        }

        if ($ficha->estado_civil == 0) {
            $estado_civil = "S/F";
        } else if ($ficha->estado_civil == 1) {
            $estado_civil = "SOLTERO(A)";
        } else if ($ficha->estado_civil == 2) {
            $estado_civil = "CASADO(A)";
        } else if ($ficha->estado_civil == 3) {
            $estado_civil = "DIVORCIADO(A)";
        } else if ($ficha->estado_civil == 4) {
            $estado_civil = "VIUDO(A)";
        } else if ($ficha->estado_civil == 5) {
            $estado_civil = "CONCUBINO(A)";
        }

        if ($ficha->sexo == 0) {
            $sexo = "S/F";
        } else if ($ficha->sexo == 1) {
            $sexo = "MASCULINO";
        } else {
            $sexo = "FEMENINO";
        }
        $fecha_nac = "N/D";
        $edad = "N/D";
        if ($ficha->fecha_de_nacimiento != "") {
            $fecha_nac = date("d/m/Y", strtotime($ficha->fecha_de_nacimiento));
            $edad = $ficha->fecha_de_nacimiento;
            $edad = $this->libreria->edad($edad);
        }
        $pdf->Cell(102, 5, "$nacionalidad", 'LTBR', 1, 'L', 1);
        $pdf->SetX(55);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40, 5, "EDAD", 'LTBR', 0, 'L', 1);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(102, 5, "$edad", 'LTBR', 1, 'L', 1);
        $pdf->SetX(55);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40, 5, "FECHA DE NACIMIENTO", 'LTBR', 0, 'L', 1);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(102, 5, "$fecha_nac", 'LTBR', 1, 'L', 1);
        $pdf->SetX(55);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40, 5, "GÉNERO", 'LTBR', 0, 'L', 1);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(102, 5, "$sexo", 'LTBR', 1, 'L', 1);
        $pdf->SetX(55);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40, 5, "ESTADO CIVIL", 'LTBR', 0, 'L', 1);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(102, 5, "$estado_civil", 'LTBR', 1, 'L', 1);
        $pdf->SetX(55);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(42, 63, 84);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Ln(1);
        $pdf->Cell(180, 5, "OTROS DATOS", 'LTBR', 1, 'C', 1);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetTextColor(24, 29, 31);
        if ($ficha->funcionario == 0) {
            $funcionario = "S/F";
        } else if ($ficha->funcionario == 1) {
            $funcionario = "POLICIA NACIONAL";
        } else if ($ficha->funcionario == 2) {
            $funcionario = "GUARDIA";
        } else if ($ficha->funcionario == 3) {
            $funcionario = "POLICIA MUNICIPAL";
        }

        if ($ficha->estado_funcionario == 0) {
            $estado_funcionario = "S/F";
        } else if ($ficha->estado_funcionario == 1) {
            $estado_funcionario = "ACTIVO";
        } else {
            $estado_funcionario = "DE BAJA";
        }
        $pdf->Cell(35, 5, "FUNCIONARIO", 'LTBR', 0, 'L', 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(143, 5, "$funcionario", 'LTBR', 1, 'L', 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(35, 5, "ESTADO", 'LTBR', 0, 'L', 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(143, 5, "$estado_funcionario", 'LTBR', 1, 'L', 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(35, 5, "OCUPACIÓN", 'LTBR', 0, 'L', 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(143, 5, "$ficha->ocupacion", 'LTBR', 1, 'L', 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(35, 5, "APODO", 'LTBR', 0, 'L', 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(143, 5, "$ficha->apodo", 'LTBR', 1, 'L', 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(35, 5, "FALLECIDO", 'LTBR', 0, 'L', 0);
        $pdf->SetFont('Arial', '', 9);
        if ($ficha->fallecido == 'f') {
            $fallecido = "NO";
        } else {
            $fallecido = "SI";
        }
        if ($ficha->evadido == 'f') {
            $evadido = "NO";
        } else {
            $evadido = "SI";
        }
        $pdf->Cell(143, 5, "$fallecido", 'LTBR', 1, 'L', 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(35, 5, "EVADIDO", 'LTBR', 0, 'L', 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(143, 5, "$evadido", 'LTBR', 1, 'L', 0);
        $pdf->SetFillColor(42, 63, 84);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(180, 5, "DIRECCIÓN", 'LTBR', 1, 'C', 1);
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell(180, 7, "$ficha->direccion", 1, 'L', 1, 0, '', '', true);

        if (isset($rasgo_f)) {
            // Segmento de rasgos físicos de la persona
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 15);
            $pdf->SetFillColor(157, 188, 201); # COLOR DE BOLDE DE LA CELDA
            $pdf->SetTextColor(24, 29, 31); # COLOR DEL TEXTO
            $pdf->SetMargins(19, 10, 10); # MARGENE DEL DOCUMENTO
            $pdf->SetLineWidth(0.25);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetFont('Arial', '', 10);
            $pdf->SetY(4);
            $pdf->SetX(70);
            $pdf->Write(30, "REPÚBLICA BOLIVARIANA DE VENEZUELA");
            $pdf->SetY(8);
            $pdf->SetX(80);
            $pdf->Write(30, "MARACAY ESTADO ARAGUA");
            $pdf->SetY(12);
            $pdf->SetX(90);
            $pdf->SetY(4);
            $pdf->SetX(170);
            $pdf->Write(30, "");
            $pdf->Ln(35);
            $pdf->SetFillColor(42, 63, 84);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFont('Arial', 'B', 10);

            $pdf->Cell(180, 7, "RASGOS FÍSICOS", 'LTBR', 1, 'L', 1);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(35, 5, "CABEZA", 'LTBR', 0, 'L', 1);
            $pdf->SetFont('Arial', '', 9);

            $pdf->Cell(47.7, 5, "$rasgo_f->cabeza", 'LTBR', 0, 'L', 1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(35, 5, "PIEL", 'LTBR', 0, 'L', 0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(56.5, 5, "$rasgo_f->piel", 'LTBR', 1, 'L', 0);

            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(35, 5, "COLOR", 'LTBR', 0, 'L', 1);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(47.7, 5, "$rasgo_f->color_piel", 'LTBR', 0, 'L', 1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(35, 5, "FRENTE", 'LTBR', 0, 'L', 0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(56.5, 5, "$rasgo_f->frente", 'LTBR', 1, 'L', 0);

            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(35, 5, "OJOS", 'LTBR', 0, 'L', 1);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(47.7, 5, "$rasgo_f->ojos", 'LTBR', 0, 'L', 1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(35, 5, "COLOR", 'LTBR', 0, 'L', 0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(56.5, 5, "$rasgo_f->color_ojos", 'LTBR', 1, 'L', 0);

            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(35, 5, "CABELLO", 'LTBR', 0, 'L', 1);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(47.7, 5, "$rasgo_f->cabello", 'LTBR', 0, 'L', 1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(35, 5, "COLOR", 'LTBR', 0, 'L', 0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(56.5, 5, "$rasgo_f->color_cabello", 'LTBR', 1, 'L', 0);

            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(35, 5, "CEJAS", 'LTBR', 0, 'L', 1);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(47.7, 5, "$rasgo_f->cejas", 'LTBR', 0, 'L', 1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(35, 5, "NARIZ", 'LTBR', 0, 'L', 0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(56.5, 5, "$rasgo_f->nariz", 'LTBR', 1, 'L', 0);

            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(35, 5, "BOCA", 'LTBR', 0, 'L', 1);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(47.7, 5, "$rasgo_f->boca", 'LTBR', 0, 'L', 1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(35, 5, "LABIOS", 'LTBR', 0, 'L', 0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(56.5, 5, "$rasgo_f->labios", 'LTBR', 1, 'L', 0);

            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(35, 5, "ESTATURA", 'LTBR', 0, 'L', 1);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(47.7, 5, "$rasgo_f->estatura", 'LTBR', 0, 'L', 1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(35, 5, "PESO", 'LTBR', 0, 'L', 0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(56.5, 5, "$rasgo_f->peso", 'LTBR', 1, 'L', 0);

            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(35, 5, "LUNARES", 'LTBR', 0, 'L', 1);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(47.7, 5, "$rasgo_f->lunares", 'LTBR', 0, 'L', 1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(35, 5, "AMPUTACIONES", 'LTBR', 0, 'L', 0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(56.5, 5, "$rasgo_f->amputaciones", 'LTBR', 1, 'L', 0);

            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(35, 5, "QUEMADURAS", 'LTBR', 0, 'L', 1);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(47.7, 5, "$rasgo_f->quemaduras", 'LTBR', 0, 'L', 1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(35, 5, "TATUAJES", 'LTBR', 0, 'L', 0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(56.5, 5, "$rasgo_f->tatuaje", 'LTBR', 1, 'L', 0);

            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(35, 5, "PROTESIS", 'LTBR', 0, 'L', 1);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(47.7, 5, "$rasgo_f->protesis", 'LTBR', 0, 'L', 1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(35, 5, "CICATRICES", 'LTBR', 0, 'L', 0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(56.5, 5, "$rasgo_f->cicatrices", 'LTBR', 1, 'L', 0);

            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(35, 5, "CONTEXTURA", 'LTBR', 0, 'L', 1);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(47.7, 5, "$rasgo_f->contextura", 'LTBR', 0, 'L', 1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(35, 5, "MENTÓN", 'LTBR', 0, 'L', 0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(56.5, 5, "$rasgo_f->menton", 'LTBR', 1, 'L', 0);

            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(35, 5, "OREJAS", 'LTBR', 0, 'L', 1);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(143, 5, "$rasgo_f->orejas", 'LTBR', 0, 'L', 1);
        }
        // Fin de Segmento de rasgos físicos de la persona

        foreach ($delitos as $row) {
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 15);
            $pdf->SetFillColor(157, 188, 201); # COLOR DE BOLDE DE LA CELDA
            $pdf->SetTextColor(24, 29, 31); # COLOR DEL TEXTO
            $pdf->SetMargins(19, 10, 10); # MARGENE DEL DOCUMENTO
            $pdf->SetLineWidth(0.25);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetFont('Arial', '', 10);
            $pdf->SetY(4);
            $pdf->SetX(70);
            $pdf->Write(30, "REPÚBLICA BOLIVARIANA DE VENEZUELA");
            $pdf->SetY(8);
            $pdf->SetX(80);
            $pdf->Write(30, "MARACAY ESTADO ARAGUA");
            $pdf->SetY(12);
            $pdf->SetX(90);
            $pdf->SetY(4);
            $pdf->SetX(170);
            $pdf->Write(30, "");
            $pdf->Ln(35);
            $i = 1;
            
            if (isset($row->fecha_de_presentacion) !="") {
                $fecha_de_presentacion = (date("d/m/Y", strtotime($row->fecha_de_presentacion)));
            } else {
                $fecha_de_presentacion = "S/F";
            }


            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(60, 5, "  FECHA / PRESENTACIÓN:  $fecha_de_presentacion", '', 0, 'C', 1);
            $pdf->SetFont('Arial', '', 9);
            #$pdf->Cell(20, 5, "$delitos", '', 1, 'C', 1);
            $pdf->SetFillColor(42, 63, 84);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->Ln(5);
            $pdf->Cell(180, 5, "DELITO COMETIDO(S)", 'LTBR', 0, 'C', 1);
            $pdf->Ln(8);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(35, 5, "Decisión / Tribunal", 'LTBR', 0, 'L', 0);
            $pdf->SetFont('Arial', '', 9);
            if ($row->decision_tribunal == 1) {
                $decision_tribunal = "PRIVADO DE LIBERTAD";
            } else if ($row->decision_tribunal == 2) {
                $decision_tribunal = "LIBERTA PLENA";
            } else if ($row->decision_tribunal == 3) {
                $decision_tribunal = "MEDIDA CAUTELAR SUSTITUTIVA DE LIBERTAD";
            }
            $pdf->Cell(143, 5, "$decision_tribunal", 'LTBR', 1, 'L', 0);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(35, 5, "Delito", 'LTBR', 0, 'L', 0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(143, 5, "$row->delito", 'LTBR', 1, 'L', 0);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(35, 5, "Estado", 'LTBR', 0, 'L', 0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(47.7, 5, "$row->estado", 'LTBR', 0, 'L', 0);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(35, 5, "Abogado", 'LTBR', 0, 'L', 0);
            $pdf->SetFont('Arial', '', 9);
            if ($row->abogado_defensor == 1) {
                $abogado_defensor = "PÚBLICO";
            } else if ($row->abogado_defensor == 2) {
                $abogado_defensor = "PRIVADO";
            }
            $pdf->Cell(56.5, 5, "$abogado_defensor", 'LTBR', 1, 'L', 0);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(35, 5, "Causa", 'LTBR', 0, 'L', 0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(143, 5, "$row->causa", 'LTBR', 1, 'L', 0);
            $pdf->SetFillColor(42, 63, 84);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->Cell(180, 5, "DETALLE DE LA FALTA", 'LTBR', 1, 'C', 1);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->MultiCell(180, 7, "$row->detalle_falta", 1, 'L', 1, 0, '', '', true);

            /* if ($i == 4) {
              $pdf->AddPage();
              $pdf->SetFont('Arial', 'B', 15);
              $pdf->SetFillColor(157, 188, 201); # COLOR DE BOLDE DE LA CELDA
              $pdf->SetTextColor(24, 29, 31); # COLOR DEL TEXTO
              $pdf->SetMargins(19, 10, 10); # MARGENE DEL DOCUMENTO
              $pdf->SetLineWidth(0.25);
              $pdf->SetFillColor(255, 255, 255);
              $pdf->SetFont('Arial', '', 10);
              $pdf->SetY(4);
              $pdf->SetX(70);
              $pdf->Write(30, "REPÚBLICA BOLIVARIANA DE VENEZUELA");
              $pdf->SetY(8);
              $pdf->SetX(80);
              $pdf->Write(30, "MARACAY ESTADO ARAGUA");
              $pdf->SetY(12);
              $pdf->SetX(90);
              $pdf->SetY(4);
              $pdf->SetX(170);
              $pdf->Write(30, "");
              $pdf->Ln(35);
              $pdf->SetFillColor(42, 63, 84);
              $pdf->SetTextColor(255, 255, 255);
              $pdf->Cell(180, 5, "DELITO COMETIDO(S)", 'LTBR', 0, 'C', 1);
              $pdf->Ln(8);
              $pdf->SetTextColor(0, 0, 0);
              $pdf->SetFont('Arial', 'B', 9);
              $pdf->Cell(35, 5, "Desición / Tribunal", 'LTBR', 0, 'L', 0);
              $pdf->SetFont('Arial', '', 9);
              $pdf->Cell(143, 5, "", 'LTBR', 1, 'L', 0);
              $pdf->SetFont('Arial', 'B', 9);
              $pdf->Cell(35, 5, "Delito", 'LTBR', 0, 'L', 0);
              $pdf->SetFont('Arial', '', 9);
              $pdf->Cell(143, 5, "", 'LTBR', 1, 'L', 0);
              $pdf->SetFont('Arial', 'B', 9);
              $pdf->Cell(35, 5, "Estado", 'LTBR', 0, 'L', 0);
              $pdf->SetFont('Arial', '', 9);
              $pdf->Cell(47.7, 5, "", 'LTBR', 0, 'L', 0);
              $pdf->SetFont('Arial', 'B', 9);
              $pdf->Cell(35, 5, "Abogado", 'LTBR', 0, 'L', 0);
              $pdf->SetFont('Arial', '', 9);
              $pdf->Cell(56.5, 5, "", 'LTBR', 1, 'L', 0);
              $pdf->SetFont('Arial', 'B', 9);
              $pdf->Cell(35, 5, "Causa", 'LTBR', 0, 'L', 0);
              $pdf->SetFont('Arial', '', 9);
              $pdf->Cell(143, 5, "", 'LTBR', 1, 'L', 0);
              $pdf->SetFillColor(42, 63, 84);
              $pdf->SetTextColor(255, 255, 255);
              $pdf->Cell(180, 5, "DETALLE DE LA FALTA", 'LTBR', 1, 'C', 1);
              $pdf->SetFillColor(255, 255, 255);
              $pdf->SetTextColor(0, 0, 0);
              $pdf->MultiCell(180, 7, "$ficha->direccion", 1, 'L', 1, 0, '', '', true);
              //$pdf->Ln(25);
              } */
            $pdf->Ln(23);
            $i = $i + 1;
        }


        $pdf->lastPage();
        $pdf->Output("Reseña General.pdf", 'FI');
        unlink(base_url() . "Reseña General.pdf");
    }

    public function estacion() {


        $lista = $this->estacion->listar();

        /*         * ********** */
        $pdf = new Pdf('P', 'mm', 'Letter', true, 'UTF-8', false);

        $pdf->AddPage();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Ing Jesus Laya');
        $pdf->SetTitle("ESTACION DE POLICIA");
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        $pdf->SetHeaderMargin(30);
        $pdf->SetTopMargin(20);
        $pdf->setFooterMargin(20);
        $pdf->SetAutoPageBreak(true);
        $pdf->SetDisplayMode('real', 'default');
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 005', PDF_HEADER_STRING);

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        if (@file_exists(dirname(__FILE__) . '/lang/es.php')) {
            require_once(dirname(__FILE__) . '/lang/es.php');
            $pdf->setLanguageArray($l);
        }
        $nom = "ESTACIONES DE POLICIA";
        $pdf->SetTitle(utf8_decode("$nom"));

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(60);
        $pdf->Cell(180, 7, utf8_decode('LISTADO DE ESTACIONES DE POLICIA'), '', 0, 'L', '0');
        $pdf->Ln(15);

        $pdf->SetFont('Helvetica', 'B', 8);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFillColor(42, 63, 84);
        $pdf->Cell(7, 5, "#", 'RBLT', 0, 'C', '1');
        $pdf->Cell(173, 5, "ESTACIÓN", 'RBLT', 1, 'C', '1');

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(149, 184, 219);
        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetTextColor(0, 0, 0);

        $pdf->SetFillColor(242, 242, 242);
        $i = 0;
        $j = 1;
        $l = 1;
        foreach ($lista as $lista) {

            if ($l == 47) {
                $pdf->SetFont('Helvetica', 'B', 8);
                $pdf->SetTextColor(255, 255, 255);
                $pdf->SetFillColor(42, 63, 84);
                $pdf->Cell(7, 5, "#", 'RBLT', 0, 'C', '1');
                $pdf->Cell(173, 5, "ESTACIÓN", 'RBLT', 1, 'C', '1');
                $l = 1;
            }

            $relleno = '0';
            if ($i % 2 == 0) {
                $relleno = '1';
            }
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFillColor(149, 184, 219);
            $pdf->SetFont('Helvetica', '', 8);
            $pdf->SetTextColor(0, 0, 0);

            $pdf->SetFillColor(242, 242, 242);
            $pdf->Cell(7, 5, $j, 'RBLT', 0, 'C', $relleno);
            $pdf->Cell(173, 5, $lista->estacion, 'RBLT', 1, 'L', $relleno);
            $i++;
            $j++;
            $l++;
        }

        // $pdf->lastPage();
        $pdf->Output("Configuracion_mantenimiento.pdf", 'FI');
        unlink(base_url() . "Configuracion_mantenimiento.pdf");
    }

    // Reportes dinamincos
    public function config() {
        $id = $this->input->get('id');

        if ($id == 1) {
            $nom = "Delito";
            $lista = $this->delito->listar();
            $campo = "DELITO";
            $title = "LISTADO DE DELITO";
        }if ($id == 2) {
            $nom = "Boca";
            $lista = $this->boca->listar();
            $campo = "BOCA";
            $title = "LISTADO DE RASGO DE BOCA";
        }
        if ($id == 3) {
            $nom = "Cabello";
            $lista = $this->cabello->listar();
            $campo = "CABELLO";
            $title = "LISTADO DE RASGO DE CABELLO";
        }if ($id == 4) {
            $nom = "Cabeza";
            $lista = $this->cabeza->listar();
            $campo = "CABEZA";
            $title = "LISTADO DE RASGO DE CABEZA";
        }if ($id == 5) {
            $nom = "Cejas";
            $lista = $this->cejas->listar();
            $campo = "CEJAS";
            $title = "LISTADO DE RASGO DE CEJA";
        }if ($id == 6) {
            $nom = "Color Cabello";
            $lista = $this->color_cabello->listar();
            $campo = "Color Cabello";
            $title = "LISTADO DE COLOR DE CABELLO";
        }if ($id == 7) {
            $nom = "Color Ojos";
            $lista = $this->color_ojos->listar();
            $campo = "Color Ojos";
            $title = "LISTADO DE COLOR DE OJO";
        }if ($id == 8) {
            $nom = "Color Piel";
            $lista = $this->color_piel->listar();
            $campo = "Color Piel";
            $title = "LISTADO DE COLOR DE PIEL";
        }if ($id == 9) {
            $nom = "Contextura";
            $lista = $this->contextura->listar();
            $campo = "Contextura";
            $title = "LISTADO DE CONTEXTURA";
        }if ($id == 10) {
            $nom = "Frente";
            $lista = $this->frente->listar();
            $campo = "Frente";
            $title = "LISTADO DE RASGO DE FRENTE";
        }if ($id == 11) {
            $nom = "Labios";
            $lista = $this->labios->listar();
            $campo = "Labios";
            $title = "LISTADO DE RASGO DE LABIO";
        }if ($id == 12) {
            $nom = "Mentón";
            $lista = $this->menton->listar();
            $campo = "Mentón";
            $title = "LISTADO DE RASGO DE MENTÓN";
        }if ($id == 13) {
            $nom = "Nariz";
            $lista = $this->nariz->listar();
            $campo = "Nariz";
            $title = "LISTADO DE RASGO DE NARIZ";
        }if ($id == 14) {
            $nom = "Ojos";
            $lista = $this->ojos->listar();
            $campo = "Ojos";
            $title = "LISTADO DE RASGO DE OJO";
        }if ($id == 15) {
            $nom = "Orejas";
            $lista = $this->orejas->listar();
            $campo = "Orejas";
            $title = "LISTADO DE RASGO DE OREJA";
        }if ($id == 16) {
            $nom = "Piel";
            $lista = $this->piel->listar();
            $campo = "Piel";
            $title = "LISTADO DE RASGO DE PIEL";
        }



        /*         * ********** */

        $pdf = new Pdf('P', 'mm', 'Letter', true, 'UTF-8', false);

        $pdf->AddPage();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Ing Jesus Laya');
        $pdf->SetTitle("$campo");
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        $pdf->SetHeaderMargin(30);
        $pdf->SetTopMargin(20);
        $pdf->setFooterMargin(20);
        $pdf->SetAutoPageBreak(true);
        $pdf->SetDisplayMode('real', 'default');
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 005', PDF_HEADER_STRING);

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        if (@file_exists(dirname(__FILE__) . '/lang/es.php')) {
            require_once(dirname(__FILE__) . '/lang/es.php');
            $pdf->setLanguageArray($l);
        }

        $pdf->SetTitle(utf8_decode("$nom"));

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(65);
        $pdf->Cell(180, 7, utf8_decode("$title"), '', 0, 'L', '0');
        $pdf->Ln(15);

        $pdf->SetFont('Helvetica', 'B', 8);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFillColor(42, 63, 84);
        $pdf->Cell(7, 5, "#", 'RBLT', 0, 'C', '1');
        $pdf->Cell(173, 5, "$campo", 'RBLT', 1, 'C', '1');

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(149, 184, 219);
        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetTextColor(0, 0, 0);

        $pdf->SetFillColor(242, 242, 242);
        $i = 0;
        $j = 1;
        $l = 1;
        foreach ($lista as $lista) {

            if ($id == 1) {
                $row = strtoupper($lista->delito);
            }if ($id == 2 or $id == 3 or $id == 4 or $id == 5 or $id == 6 or $id == 7 or $id == 8 or $id == 9 or $id == 10 or $id == 11 or $id == 12 or $id == 13 or $id == 14 or $id == 15 or $id == 16) {
                $row = strtoupper($lista->descripcion);
            }

            if ($l == 47) {
                $pdf->SetFont('Helvetica', 'B', 8);
                $pdf->SetTextColor(255, 255, 255);
                $pdf->SetFillColor(42, 63, 84);
                $pdf->Cell(7, 5, "#", 'RBLT', 0, 'C', '1');
                $pdf->Cell(173, 5, "$row", 'RBLT', 1, 'C', '1');
                $l = 1;
            }

            $relleno = '0';
            if ($i % 2 == 0) {
                $relleno = '1';
            }
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFillColor(149, 184, 219);
            $pdf->SetFont('Helvetica', '', 8);
            $pdf->SetTextColor(0, 0, 0);

            $pdf->SetFillColor(242, 242, 242);
            $pdf->Cell(7, 5, $j, 'RBLT', 0, 'C', $relleno);
            $pdf->Cell(173, 5, $row, 'RBLT', 1, 'L', $relleno);
            $i++;
            $j++;
            $l++;
        }

        $pdf->Output("Configuracion_mantenimiento.pdf", 'FI');
        unlink(base_url() . "Configuracion_mantenimiento.pdf");
    }

    public function delito() {

        $datos['lista_cabeza'] = $this->cabeza->listar();
        $datos['lista_piel'] = $this->piel->listar();
        $datos['lista_color_piel'] = $this->color_piel->listar();
        $datos['lista_frente'] = $this->frente->listar();
        $datos['lista_ojos'] = $this->ojos->listar();
        $datos['lista_color_ojos'] = $this->color_ojos->listar();
        $datos['lista_cabellos'] = $this->cabellos->listar();
        $datos['lista_color_cabellos'] = $this->color_cabellos->listar();
        $datos['lista_cejas'] = $this->cejas->listar();
        $datos['lista_nariz'] = $this->nariz->listar();
        $datos['lista_boca'] = $this->boca->listar();
        $datos['lista_labios'] = $this->labios->listar();
        $datos['lista_contextura'] = $this->contextura->listar();
        $datos['lista_menton'] = $this->menton->listar();
        $datos['lista_orejas'] = $this->orejas->listar();


        $datos['lista'] = $this->detalle->listar();
        $datos['delito'] = $this->delito->listar();
        $datos['estado'] = $this->estado->listar();

        $this->vista = "reportes/resena";
        $this->template->write_view('content', $this->vista, $datos);
        $this->template->render();
//        $this->load->view('reportes/resena', $datos);
    }

    public function deli() {

        $delito = $this->input->get('delito');
        $delitos = $this->ficha->search_delitos($delito);

        /*         * ********** */
        $pdf = new Pdf('P', 'mm', 'Letter', true, 'UTF-8', false);

        $pdf->AddPage();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Ing Jesus Laya');
        $pdf->SetTitle("DELITOS");
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        $pdf->SetHeaderMargin(30);
        $pdf->SetTopMargin(20);
        $pdf->setFooterMargin(20);
        $pdf->SetAutoPageBreak(true);
        $pdf->SetDisplayMode('real', 'default');
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 005', PDF_HEADER_STRING);

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        if (@file_exists(dirname(__FILE__) . '/lang/es.php')) {
            require_once(dirname(__FILE__) . '/lang/es.php');
            $pdf->setLanguageArray($l);
        }
        $nom = "DELITOS";
        $pdf->SetTitle(utf8_decode("$nom"));

        $pdf->SetFont('Arial', 'B', 12);

        $pdf->Cell(200, 7, utf8_decode('LISTADO DE DELITOS'), '', 0, 'C', '0');
        $pdf->Ln(15);

        $pdf->SetFont('Helvetica', 'B', 8);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFillColor(42, 63, 84);
        $pdf->Cell(7, 5, "#", 'RBLT', 0, 'C', '1');
//        $pdf->Cell(173, 5, "DELITOS", 'RBLT', 1, 'C', '1');
        $pdf->Cell(20, 5, "CI", 'RBLT', 0, 'C', '1');
        $pdf->Cell(40, 5, "FECHA PRESENTACION", 'RBLT', 0, 'C', '1');
        $pdf->Cell(30, 5, "CAUSA", 'RBLT', 0, 'C', '1');
        $pdf->Cell(43, 5, "DELITO", 'RBLT', 0, 'C', '1');
        $pdf->Cell(20, 5, "ABOGADO", 'RBLT', 0, 'C', '1');
        $pdf->Cell(20, 5, "ESTADO", 'RBLT', 1, 'C', '1');

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(149, 184, 219);
        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetTextColor(0, 0, 0);

        $pdf->SetFillColor(242, 242, 242);
        $i = 0;
        $j = 1;
        $l = 1;
        foreach ($delitos as $deli) {

            if ($l == 47) {
                $pdf->SetFont('Helvetica', 'B', 8);
                $pdf->SetTextColor(255, 255, 255);
                $pdf->SetFillColor(42, 63, 84);
                $pdf->Cell(7, 5, "#", 'RBLT', 0, 'C', '1');
                $pdf->Cell(20, 5, "CI", 'RBLT', 0, 'C', '1');
                $pdf->Cell(40, 5, "FECHA PRESENTACION", 'RBLT', 0, 'C', '1');
                $pdf->Cell(30, 5, "CAUSA", 'RBLT', 0, 'C', '1');
                $pdf->Cell(43, 5, "DELITO", 'RBLT', 0, 'C', '1');
                $pdf->Cell(20, 5, "ABOGADO", 'RBLT', 0, 'C', '1');
                 $pdf->Cell(20, 5, "ESTADO", 'RBLT', 1, 'C', '1');
                $l = 1;
            }

            $relleno = '0';
            if ($i % 2 == 0) {
                $relleno = '1';
            }
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFillColor(149, 184, 219);
            $pdf->SetFont('Helvetica', '', 8);
            $pdf->SetTextColor(0, 0, 0);

            $pdf->SetFillColor(242, 242, 242);
            $pdf->Cell(7, 5, $j, 'RBLT', 0, 'C', $relleno);
            $pdf->Cell(20, 5, $deli->ci, 'RBLT', 0, 'L', $relleno);
            $pdf->Cell(40, 5, date("d/m/Y", strtotime($deli->fecha_de_presentacion)), 'RBLT', 0, 'L', $relleno);
            $pdf->Cell(30, 5, $deli->causa, 'RBLT', 0, 'L', $relleno);
            $pdf->Cell(43, 5, $deli->delito, 'RBLT', 0, 'L', $relleno);
            if ($deli->abogado_defensor == 1) {
                $abogado_defensor = "PÚBLICO";
            } else if ($deli->abogado_defensor == 2) {
                $abogado_defensor = "PRIVADO";
            }
            $pdf->Cell(20, 5, $abogado_defensor, 'RBLT', 0, 'L', $relleno);
            $pdf->Cell(20, 5, $deli->estado, 'RBLT', 1, 'L', $relleno);
            $i++;
            $j++;
            $l++;
        }

        // $pdf->lastPage();
        $pdf->Output("Configuracion_mantenimiento.pdf", 'FI');
        unlink(base_url() . "Configuracion_mantenimiento.pdf");
    }

}
