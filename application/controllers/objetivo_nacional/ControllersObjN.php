<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllersObjN
 *
 * @author ING: Jesus Laya
 */
class ControllersObjN extends CI_Controller
{

    //put your code here

    public function __construct()
    {
        parent::__construct();
        $this->load->model('objetivo_nacional/ModelObjN'); # Llamado a el modelo objetivos Especificos
        $this->load->model('entes/ModelEntes'); # Llamado a el modelo de Entes
        $this->load->model('model_standard/ModelStandard'); # Llamado a el modelo general
    }

    public function index()
    {
        $datos['lista_objetivo_nacional'] = $this->ModelEntes->listar('objetivo_nacional');
        $datos['lista_plan_patria']       = $this->ModelEntes->listar('plan_patria');
        $datos['lista_obj_historico']     = $this->ModelEntes->listar('objetivo_historico');
        $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base",$datos);
        $this->load->view("objetivo_nacional/ViewLista", $datos);
    }

    public function procesar($id)
    {
        $datos['detalles_lista']      = $this->ModelObjN->detailList($id);
        $datos['lista_plan_patria'] = $this->ModelEntes->listar('plan_patria');
        $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base",$datos);
        $this->load->view('objetivo_nacional/ViewUpdate', $datos);
    }

    public function guardar()
    {
        $result = $this->ModelObjN->insertar($this->input->post());
        // =========================================================================
		// Proceso de bitacora
		// =========================================================================
		$time   = "%h:%i %a"; // Se captura la hora actual
		$datos  = array(
			'modulo'              => 'OBJETIVO NACIONAL (TABLA objetivo_nacional)',
			'accion'              => 'NUEVO INGRESO DE OBJETIVO NACIONAL',
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
        $result = $this->ModelObjN->actualizar($this->input->post());
        // =========================================================================
		// Proceso de bitacora
		// =========================================================================
		$time   = "%h:%i %a"; // Se captura la hora actual
		$datos  = array(
			'modulo'              => 'OBJETIVO NACIONAL (TABLA objetivo_nacional)',
			'accion'              => 'NUEVA ACTUALIZACIÓN DE OBJETIVO NACIONAL',
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
        $this->load->view("objetivo_nacional/ViewAdd", $datos);
    }

    public function delete($id)
    {
        $result = $this->ModelObjN->eliminar($id);
        if ($result) {
            redirect('objetivo_nacional/ControllersObjN');
        }
    }

    // Método publico para traer las lineas estrategicas segun la asociacion con el plan de la nacion
    public function ajax_search($id)
    {                                      #Campo            #Tabla              ID
        $result = $this->ModelStandard->search('plan_patria', 'objetivo_historico', $id);
        echo json_encode($result);
    }

}
