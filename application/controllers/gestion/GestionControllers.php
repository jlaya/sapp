<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllersModulo
 *
 * @author ING: Jesus Laya
 */
class GestionControllers extends CI_Controller
{
    //put your code here

    public function __construct()
    {   
        parent::__construct();
        $this->load->model('entes/ModelEntes'); # Llamado a el modelo de Entes
        $this->load->model('gestion/GestionModel','gestion'); # Llamado a el modelo GestionModel
        $this->load->model('topologia/MunicipiosModel','municipios'); # Llamado a el modelo Municipios
        if (!$this->session->userdata['logged_in']) {
			$header = base_url() . "?error=1";
			header("location: " . $header);
		}
    }

    // Panel
    public function panel()
    {
        $acc = $this->input->get('accion');
        $ano_fiscal = $this->input->get('ano_fiscal');
        if($ano_fiscal == "" && $acc == ""){
            $acc = 1;
            $ano_fiscal = date('Y', now());
        }
        $get_config_sistem = $this->gestion->get_config_sistem();
        $accion   = $this->gestion->search_aprobado("acciones_registro", $ano_fiscal, $acc);
        $proyecto = $this->gestion->search_aprobado("proyecto_registro", $ano_fiscal, $acc);
        $this->load->view("gestion/panel", compact('accion','proyecto','ano_fiscal','acc','get_config_sistem'));
    }

    // Guardar cambios
    public function save_config()
    {
        $data = $this->input->post();
        $this->gestion->save_config($data);
        $response['success'] = 'ok';
        echo json_encode($response);
    }

    // Guardar cambios
    public function save_config_sistem()
    {
        $data = $this->input->post();
        $this->gestion->save_config_sistem($data);
        $response['success'] = 'ok';
        echo json_encode($response);
        //echo $this->db->last_query();
    }

    // Accion
    public function home($id_org)
    {
        $lista_modulos    = $this->ModelEntes->listar('modulo');
        $lista_modulo     = $this->ModelEntes->listar_table('modulo');
        $lista_sub_modulo = $this->ModelEntes->listar_table('sub_modulo');
        $organo           = $this->session->userdata['logged_in']['sigla'];
        $id               = $this->session->userdata['logged_in']['pk'];
        if($organo == "SSPPPPCG"){
            $id = 0;
        }
		$ano_fiscal = $this->input->get('ano_fiscal');
		if($ano_fiscal == ""){
			$ano_fiscal = date('Y', now());
		}
		
        $busqueda_acc     = $this->gestion->busqueda_aprobado("acciones_registro", $ano_fiscal);
        $busqueda_proy    = $this->gestion->busqueda_proy();
        $municipios       = $this->municipios->listar();
        $param['id']      = $id_org;
        $param['table']   = "acciones_registro";
        $obj_org          = $this->gestion->search($param);
        $act_acc          = $this->gestion->list_actividad_acc($id_org);
        $obj_acc          = $this->gestion->list_eje_fin_original($id_org, "pk_accion");
        $get_config_sistem = $this->gestion->get_config_sistem();
        
        $data             = compact(
            'id_org',
            'id',
            'lista_modulos',
            'lista_modulo',
            'lista_sub_modulo',
            'busqueda_acc',
            'estructura',
            'busqueda_proy',
            'municipios',
            'obj_org',
            'act_acc',
            'obj_acc',
            'get_config_sistem'
            );
        $this->load->view("base/Base", $data);
        $this->load->view("gestion/gestion_acc");
    }

    // Proyecto
    public function proy($id_org)
    {
        $lista_modulos    = $this->ModelEntes->listar('modulo');
        $lista_modulo     = $this->ModelEntes->listar_table('modulo');
        $lista_sub_modulo = $this->ModelEntes->listar_table('sub_modulo');
        $organo           = $this->session->userdata['logged_in']['sigla'];
        $id               = $this->session->userdata['logged_in']['pk'];
        $obj_acc          = $this->gestion->list_eje_fin_original($id_org, "pk_proyecto");
        
        if($organo == "SSPPPPCG"){
            $id = 0;
        }

        $ano_fiscal = $this->input->get('ano_fiscal');
		if($ano_fiscal == ""){
			$ano_fiscal = date('Y', now());
		}
        $busqueda_proy    = $this->gestion->busqueda_aprobado("proyecto_registro", $ano_fiscal);
        $municipios       = $this->municipios->listar();
        $param['id']      = $id_org;
        $param['table']   = "proyecto_registro";
        $obj_org          = $this->gestion->search($param);
        $act_proy         = $this->gestion->list_actividad_proy($id_org);
        //echo $this->db->last_query(); exit;
        $obj_proy_other   = $this->gestion->proy_other($id_org);
        $get_config_sistem = $this->gestion->get_config_sistem();

        // Foto avatar foto
        if(isset($obj_proy_other->avatar_foto_1)){
            $explode_avatar_foto_1 = "image/gestion/$obj_proy_other->avatar_foto_1";
        }else{
            $explode_avatar_foto_1 = "image/photo.png";
        }

        if(isset($obj_proy_other->avatar_foto_2)){
            $explode_avatar_foto_2 = "image/gestion/$obj_proy_other->avatar_foto_2";
        }else{
            $explode_avatar_foto_2 = "image/photo.png";
        }

        if(isset($obj_proy_other->avatar_foto_3)){
            $explode_avatar_foto_3 = "image/gestion/$obj_proy_other->avatar_foto_3";
        }else{
            $explode_avatar_foto_3 = "image/photo.png";
        }

        if(isset($obj_proy_other->avatar_foto_4)){
            $explode_avatar_foto_4 = "image/gestion/$obj_proy_other->avatar_foto_4";
        }else{
            $explode_avatar_foto_4 = "image/photo.png";
        }

        // Foto cuadros graficos
        if(isset($obj_proy_other->avatar_grafico_1)){
            $explode_avatar_grafico_1 = "image/gestion/$obj_proy_other->avatar_grafico_1";
        }else{
            $explode_avatar_grafico_1 = "image/document.png";
        }

        if(isset($obj_proy_other->avatar_grafico_2)){
            $explode_avatar_grafico_2 = "image/gestion/$obj_proy_other->avatar_grafico_2";
        }else{
            $explode_avatar_grafico_2 = "image/document.png";
        }

        if(isset($obj_proy_other->avatar_grafico_3)){
            $explode_avatar_grafico_3 = "image/gestion/$obj_proy_other->avatar_grafico_3";
        }else{
            $explode_avatar_grafico_3 = "image/document.png";
        }

        if(isset($obj_proy_other->avatar_grafico_4)){
            $explode_avatar_grafico_4 = "image/gestion/$obj_proy_other->avatar_grafico_4";
        }else{
            $explode_avatar_grafico_4 = "image/document.png";
        }

        $data             = compact(
            'id_org',
            'id',
            'lista_modulos',
            'lista_modulo',
            'lista_sub_modulo',
            'busqueda_proy',
            'municipios',
            'act_proy',
            'obj_org',
            'obj_proy_other',
            'explode_avatar_foto_1',
            'explode_avatar_foto_2',
            'explode_avatar_foto_3',
            'explode_avatar_foto_4',
            'explode_avatar_grafico_1',
            'explode_avatar_grafico_2',
            'explode_avatar_grafico_3',
            'explode_avatar_grafico_4',
            'obj_acc',
            'get_config_sistem'
            );
        $this->load->view("base/Base", $data);
        $this->load->view("gestion/gestion_proy");
    }

    // Guardar cambios
    public function save()
    {
        $data = $this->input->post();
        $this->gestion->save($data);
    }

    // Lista proceso de carga de partidas especificas
    public function lista($id, $acc)
    {   
        $param['id']        = $id;
        $param['acc']       = $acc;
        $param['obj']        = $this->gestion->list_financiero_acc($param);
        $param['estructura'] = $this->gestion->list_estructura();
        $this->load->view("gestion/list", $param);
    }

    public function search(){
        $param = $this->input->get();
        $result = $this->gestion->search($param);
        $data['accion']    = $result;
        $data['actividad'] = $this->gestion->list_actividad($param['id']);
        $data['financiero_acc'] = $this->gestion->list_financiero_acc($param['id']);
        if($result){
            echo json_encode($data);
        }
    }

    public function list_estructura(){
        $data['estructura'] = $this->gestion->list_estructura();
        echo json_encode($data);
    }

    public function updateAction()
    {   
        $data = $this->input->post();
        $response['success'] = 'ok';
        $this->gestion->updateAction($data);
        echo json_encode($response);
    }
    
    // Ejecucion financiera original de Accion, Proyecto
    public function ejecucion_fin_original()
    {   
        $data = $this->input->post();
        $response['success'] = 'ok';
        $this->gestion->ejecucion_fin_original($data);
        echo json_encode($response);
    }

    public function deleteActionFAcc()
    {
        $param = $this->input->get();
        $result = $this->gestion->deleteActionFAcc($param);
        $response['success'] = 'error';
        if($result){
            $response['success'] = 'ok';
        }
        echo json_encode($response);
    }

    public function updateActionFAcc()
    {   
        $data = $this->input->post();
        $response['success'] = 'ok';
        $this->gestion->updateActionFAcc($data);
        echo json_encode($response);
    }

    // Send Proyecto *
    public function send_proy()
    {   
        $data = $this->input->post();

        $ruta = getcwd();  // Obtiene el directorio actual en donde se esta trabajando
        
        // Archivo Foto
        if ($_FILES['avatar_foto_1']['name'] !=""){
            $archivo = $_FILES['avatar_foto_1']['name'];
            
            $ruta    = getcwd();  // Obtiene el directorio actual en donde se esta trabajando
            if($archivo){
                move_uploaded_file($_FILES['avatar_foto_1']['tmp_name'], $ruta . "/assets/image/gestion/" . $archivo);
                $datos['avatar_foto_1']         = ltrim($archivo);
            }
        }

        if ($_FILES['avatar_foto_2']['name'] !=""){
            $archivo = $_FILES['avatar_foto_2']['name'];
            $ruta    = getcwd();  // Obtiene el directorio actual en donde se esta trabajando
            if($archivo){
                move_uploaded_file($_FILES['avatar_foto_2']['tmp_name'], $ruta . "/assets/image/gestion/" . $archivo);
                $datos['avatar_foto_2']         = ltrim($archivo);
            }
        }

        if ($_FILES['avatar_foto_3']['name'] !=""){
            $archivo = $_FILES['avatar_foto_3']['name'];
            $ruta    = getcwd();  // Obtiene el directorio actual en donde se esta trabajando
            if($archivo){
                move_uploaded_file($_FILES['avatar_foto_3']['tmp_name'], $ruta . "/assets/image/gestion/" . $archivo);
                $datos['avatar_foto_3']         = ltrim($archivo);
            }
        }

        if ($_FILES['avatar_foto_4']['name'] !=""){
            $archivo = $_FILES['avatar_foto_4']['name'];
            $ruta    = getcwd();  // Obtiene el directorio actual en donde se esta trabajando
            if($archivo){
                move_uploaded_file($_FILES['avatar_foto_4']['tmp_name'], $ruta . "/assets/image/gestion/" . $archivo);
                $datos['avatar_foto_4']         = ltrim($archivo);
            }
        }

        // Archivo pdf
        if ($_FILES['avatar_grafico_1']['name'] !=""){
            $archivo = $_FILES['avatar_grafico_1']['name'];
            $ruta    = getcwd();  // Obtiene el directorio actual en donde se esta trabajando
            if($archivo){
                move_uploaded_file($_FILES['avatar_grafico_1']['tmp_name'], $ruta . "/assets/image/gestion/" . $archivo);
                $datos['avatar_grafico_1']         = ltrim($archivo);
            }
        }

        if ($_FILES['avatar_grafico_2']['name'] !=""){
            $archivo = $_FILES['avatar_grafico_2']['name'];
            $ruta    = getcwd();  // Obtiene el directorio actual en donde se esta trabajando
            if($archivo){
                move_uploaded_file($_FILES['avatar_grafico_2']['tmp_name'], $ruta . "/assets/image/gestion/" . $archivo);
                $datos['avatar_grafico_2']         = ltrim($archivo);
            }
        }

        if ($_FILES['avatar_grafico_3']['name'] !=""){
            $archivo = $_FILES['avatar_grafico_3']['name'];
            $ruta    = getcwd();  // Obtiene el directorio actual en donde se esta trabajando
            if($archivo){
                move_uploaded_file($_FILES['avatar_grafico_3']['tmp_name'], $ruta . "/assets/image/gestion/" . $archivo);
                $datos['avatar_grafico_3']         = ltrim($archivo);
            }
        }

        if ($_FILES['avatar_grafico_4']['name'] !=""){
            $archivo = $_FILES['avatar_grafico_4']['name'];
            $ruta    = getcwd();  // Obtiene el directorio actual en donde se esta trabajando
            if($archivo){
                move_uploaded_file($_FILES['avatar_grafico_4']['tmp_name'], $ruta . "/assets/image/gestion/" . $archivo);
                $datos['avatar_grafico_4']         = ltrim($archivo);
            }
        }

        $datos['id']              = $data['id'];
        $datos['proyecto_id']     = $data['proyecto_id'];
        $datos['beneficiario']    = $data['beneficiario'];
        $datos['avance_fisico']   = explode(",", $data['avance_fisico'])[1];

        if(isset($data['municipio_ids']) == ""){
            $municipio_ids = NULL;
        }else{
            $municipio_ids = $data['municipio_ids'];
        }

        $datos['municipio_ids']   = $municipio_ids;
        $datos['resumen']         = $data['resumen'];
        $datos['indicador']       = $data['indicador'];

        $response['success'] = 'ok';
        $this->gestion->send_proy($datos);
    }

    public function send_email()
    {
        $param  = $this->input->get();
        $id     = $param['id'];
        $codigo = $param['codigo'];
        $config['protocol']  = "smtp";
        $config['smtp_host'] = "ssl://smtp.gmail.com";
        $config['smtp_port'] = "465";
        $config['smtp_user'] = "sisadmidesarrollo@gmail.com";
        $config['smtp_pass'] = "administradordesarrollo";
        $config['charset']   = "utf-8";
        $config['mailtype']  = "html";
        $config['newline']   = "\r\n";

        $path_email    = base_url("assets/image/email.png");
        $type_email    = pathinfo($path_email, PATHINFO_EXTENSION);
        $data_email    = file_get_contents($path_email);
        $this->load->library('email', $config);
        $email                 = strtolower($this->session->userdata['logged_in']['correo']);
        $accion                = $this->gestion->list_actividad($id);
        $financiero            = $this->gestion->list_financiero_acc($id);
        $count_cumplido_acc    = $this->gestion->count_cumplido_acc($id);
        $count_no_cumplido_acc = $this->gestion->count_no_cumplido_acc($id);

        $email_html = $this->load->view('gestion/email/send_email', compact('accion', 'financiero','count_cumplido_acc','count_no_cumplido_acc','codigo'), true);

        $this->email->initialize($config);
        $this->email->from("sppppcg@gmail.com", 'Gestión de Control / Notificación');
        $list = array($email);
        $this->email->to($list);
        $this->email->cc("sppppcg@gmail.com");
        $this->email->subject($this->session->userdata['logged_in']['nom_ins']);
        $this->email->message($email_html);
        $result = $this->email->send();

        $response['success'] = 'error';
        if($result){
            $response['success'] = 'ok';
        }
        echo json_encode($response);
    }

    // Reportes
    public function pdf_accion($id)
    {
        $this->load->library('rpdf');
        require_once APPPATH . "libraries/mpdf/jpgraph/jpgraph.php";
        require_once APPPATH . "libraries/mpdf/jpgraph/jpgraph_pie.php";
        require_once APPPATH . "libraries/mpdf/jpgraph/jpgraph_pie3d.php";
        $this->load->library('twig');
        date_default_timezone_set("America/Caracas");
        $mpdf = $this->rpdf->load('utf-8', 'A4-L');
        $accion = $this->gestion->list_actividad($id);
        $financiero = $this->gestion->list_financiero_acc($id);
        $count_cumplido_acc = $this->gestion->count_cumplido_acc($id);
        $count_no_cumplido_acc = $this->gestion->count_no_cumplido_acc($id);
        $mpdf->SetHTMLHeader($html_header);
        $mpdf->SetHTMLFooter($html_footer);
        $mpdf->AddPage('L');
        // $this->twig->display("gestion/pdf/accion", compact('accion','count_cumplido_acc','count_no_cumplido_acc','id'));
        $html = $this->twig->render('gestion/pdf/accion', compact('accion','count_cumplido_acc','count_no_cumplido_acc','id', 'financiero'), true);
        // Some data
        $cumplido    = (int)$count_cumplido_acc->cumplido;
        $no_cumplido = (int)$count_no_cumplido_acc->no_cumplido;
        $arr_value = array($cumplido,$no_cumplido);
        $this->graph($arr_value, "assets/image/accion_".$id.".jpg", "Indicador de Actividades");
        $mpdf->WriteHTML($html);
        $mpdf->Output('prueba.pdf', 'I');
        unlink("assets/image/accion_".$id.".jpg");
    }

    public function graph($arr_value, $image, $title)
    {
        // Create the Pie Graph. 
        $graph = new PieGraph(1024,900);

        $theme_class= new VividTheme;
        $graph->SetTheme(new $theme_class());

        // Set A title for the plot
        $graph->title->Set($title);
        $graph->title->SetFont(FF_ARIAL,FS_NORMAL,21);
        // $graph->SetBox(true);

        // Create
        $p1 = new PiePlot3D($arr_value);
        $graph->Add($p1);

        $p1->ShowBorder();
        $p1->SetColor('black');
        $p1->ExplodeSlice(1);
        $graph->Stroke($image);
    }
    
    public function grafico()
    {
		$param  = $this->input->get();
		$object = $this->gestion->grafico($param);
		echo json_encode($object, JSON_NUMERIC_CHECK);
    }
    
    public function organos_entes()
    {
		$param  = $this->input->get();
		$object = $this->gestion->organos_entes($param);
		echo json_encode($object, JSON_NUMERIC_CHECK);
    }

    // Reporte Informe
    public function accion_pdf($id,$ano_fiscal, $trimestre)
    {   
        $this->load->library('rpdf');
        $this->load->library('twig');
        date_default_timezone_set("America/Caracas");
        $mpdf = $this->rpdf->load('utf-8', 'A4-V');
        //$accion = $this->ModelRegistro->pdf($id);
        $mpdf->SetHTMLHeader($html_header);
        $mpdf->SetHTMLFooter($html_footer);
        $mpdf->AddPage('L');
        // $this->twig->display("gestion/pdf/accion", compact('accion','count_cumplido_acc','count_no_cumplido_acc','id'));
        //echo $this->db->last_query(); exit;
        
        $row_obj = $this->gestion->get_detaill($id);
        $m_asig = $this->gestion->get_detaill_mount($id);
        $meta_financiera = $this->gestion->get_meta_financiera($id,1);
        $codigo = $row_obj->estruc_presupuestaria;
        $nom_ins = $row_obj->nom_ins;
        $accion_centralizada = $row_obj->accion_centralizada;
        $accion_especifica = $row_obj->accion_especifica;
        $monto = $m_asig->m_asig;

        if($trimestre == 1){
            $act_acc = $this->gestion->list_actividad_acc_trimestre_i($id);
            $nom_arch = "gestion/pdf/accion_centralizada/I";
        }else if($trimestre == 2){
            $act_acc = $this->gestion->list_actividad_acc_trimestre_ii($id);
            $nom_arch = "gestion/pdf/accion_centralizada/II";
        }else if($trimestre == 3){
            $act_acc = $this->gestion->list_actividad_acc_trimestre_iii($id);
            $nom_arch = "gestion/pdf/accion_centralizada/III";
        }else if($trimestre == 4){
            $act_acc = $this->gestion->list_actividad_acc_trimestre_iv($id);
            $nom_arch = "gestion/pdf/accion_centralizada/IV";
        }

        
        //$this->twig->display('gestion/pdf/gestion_pdf', compact('param','act_acc','codigo','nom_ins','monto','accion_centralizada','accion_especifica','meta_financiera'));
        $html = $this->twig->render($nom_arch, compact('param','act_acc','codigo','nom_ins','monto','accion_centralizada','accion_especifica','meta_financiera','ano_fiscal'), true);
        $mpdf->WriteHTML($html);
        $mpdf->Output("Informe Gestion Accion $nom_ins.pdf", 'I');
    }

    public function proyecto_pdf($id,$ano_fiscal, $trimestre)
    {   
        $this->load->library('rpdf');
        $this->load->library('twig');
        date_default_timezone_set("America/Caracas");
        $mpdf = $this->rpdf->load('utf-8', 'A4-V');
        //$accion = $this->ModelRegistro->pdf($id);
        $mpdf->SetHTMLHeader($html_header);
        $mpdf->SetHTMLFooter($html_footer);
        $mpdf->AddPage('L');
        // $this->twig->display("gestion/pdf/accion", compact('accion','count_cumplido_acc','count_no_cumplido_acc','id'));
        $act_acc = $this->gestion->list_actividad_proy($id);
        
        $row_obj = $this->gestion->get_detaill_proy($id);
        $m_asig = $this->gestion->get_detaill_mount_proy($id);
        $meta_financiera = $this->gestion->get_meta_financiera($id,2);
        //echo $this->db->last_query(); exit;
        $codigo = $row_obj->estruc_presupuestaria;
        $nom_ins = $row_obj->nom_ins;
        $accion_centralizada = $row_obj->accion_centralizada;
        $accion_especifica = $row_obj->accion_especifica;
        $monto = $m_asig->m_asig;

        if($trimestre == 1){
            $act_acc = $this->gestion->list_actividad_proy_i($id);
            $nom_arch = "gestion/pdf/proyecto/I";
        }else if($trimestre == 2){
            $act_acc = $this->gestion->list_actividad_proy_ii($id);
            $nom_arch = "gestion/pdf/proyecto/II";
        }else if($trimestre == 3){
            $act_acc = $this->gestion->list_actividad_proy_iii($id);
            $nom_arch = "gestion/pdf/proyecto/III";
        }else if($trimestre == 4){
            $act_acc = $this->gestion->list_actividad_proy_iv($id);
            $nom_arch = "gestion/pdf/proyecto/IV";
        }

        //echo $this->db->last_query(); exit;
        //$this->twig->display('gestion/pdf/gestion_pdf', compact('param','act_acc','codigo','nom_ins','monto','accion_centralizada','accion_especifica','meta_financiera'));
        $html = $this->twig->render($nom_arch, compact('param','act_acc','codigo','nom_ins','monto','accion_centralizada','accion_especifica','meta_financiera','ano_fiscal'), true);
        $mpdf->WriteHTML($html);
        $mpdf->Output("Informe Gestion Proyecto $nom_ins.pdf", 'I');
    }

}
