<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllersObjE
 *
 * @author ING: Jesus Laya
 */
class ControllersObjE extends CI_Controller
{

    //put your code here

    public function __construct()
    {
        parent::__construct();
        $this->load->model('objetivo_estrategico/ModelObjE'); # Llamado a el modelo objetivos Estrategico
        $this->load->model('entes/ModelEntes'); # Llamado a el modelo de Entes
        $this->load->model('model_standard/ModelStandard'); # Llamado a el modelo general
    }

    public function index()
    {
        $datos['lista_objetivo_estrategico'] = $this->ModelEntes->listar('objetivo_estrategico');
        $datos['lista_plan_patria']          = $this->ModelEntes->listar('plan_patria');
        $datos['lista_obj_historico']        = $this->ModelEntes->listar('objetivo_historico');
        $datos['lista_obj_nacional']         = $this->ModelEntes->listar('objetivo_nacional');
        $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base",$datos);
        $this->load->view("objetivo_estrategico/ViewLista", $datos);
    }

    public function procesar($id)
    {
        $datos['detalles_lista']    = $this->ModelObjE->detailList($id);
        $datos['lista_plan_patria'] = $this->ModelEntes->listar('plan_patria');
        $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base",$datos);
        $this->load->view('objetivo_estrategico/ViewUpdate', $datos);
    }

    public function guardar()
    {
        $result = $this->ModelObjE->insertar($this->input->post());
        // =========================================================================
		// Proceso de bitacora
		// =========================================================================
		$time   = "%h:%i %a"; // Se captura la hora actual
		$datos  = array(
			'modulo'              => 'OBJETIVO ESTRATÉGICO (TABLA objetivo_estrategico)',
			'accion'              => 'NUEVO INGRESO DE OBJETIVO ESTRATÉGICO',
			'id_usuario'          => $this->session->userdata['logged_in']['id'],
			'fecha_registro'      => date('Y-m-d',now()),
			'fecha_actualizacion' => NULL,
			'hora_registro'       => mdate($time),
			'hora_actualizacion'  => NULL,
			'ip'                  => $_SERVER['REMOTE_ADDR'],
		);
		$result = $this->ModelStandard->bitacora($datos);
		// =========================================================================
    }

    public function modificar()
    {
        $result = $this->ModelObjE->actualizar($this->input->post());
        // =========================================================================
		// Proceso de bitacora
		// =========================================================================
		$time   = "%h:%i %a"; // Se captura la hora actual
		$datos  = array(
			'modulo'              => 'OBJETIVO ESTRATÉGICO (TABLA objetivo_estrategico)',
			'accion'              => 'NUEVA ACTUALIZACIÓN DE OBJETIVO ESTRATÉGICO',
			'id_usuario'          => $this->session->userdata['logged_in']['id'],
			'fecha_registro'      => NULL,
			'fecha_actualizacion' => date('Y-m-d',now()),
			'hora_registro'       => NULL,
			'hora_actualizacion'  => mdate($time),
			'ip'                  => $_SERVER['REMOTE_ADDR'],
		);
		$result = $this->ModelStandard->bitacora($datos);
		// =========================================================================
    }

    public function nuevo()
    {
        $datos['lista_plan_patria'] = $this->ModelEntes->listar('plan_patria');
        $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base",$datos);
        $this->load->view("objetivo_estrategico/ViewAdd", $datos);
    }

    public function delete($id)
    {
        $result = $this->ModelObjE->eliminar($id);
        if ($result) {
            redirect('objetivo_estrategico/ControllersObjE');
        }
    }

    // Método publico para traer las lineas estrategicas segun la asociacion con el plan de la nacion
    public function ajax_search($id)
    {                                          #Campo         #Tabla                #ID
        $result = $this->ModelStandard->search('plan_patria', 'objetivo_historico', $id);
        echo json_encode($result);
    }
    
    // Método publico para traer el objetivo nacional segun la asociacion con el plan de la patria y el objetivo Historico
    public function ajax_search_multiple_two($idA,$idB)
    {                                                       #CampoA        #CampoB              $Tabla               #IDA $IDB
        $result = $this->ModelStandard->search_multiple_two('plan_patria','objetivo_historico', 'objetivo_nacional', $idA,$idB);
        echo json_encode($result);
    }
    
    # three

}
