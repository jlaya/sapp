<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllersPlanGobierno
 *
 * @author ING: Jesus Laya
 */
class ControllersPlanGobierno extends CI_Controller
{

    //put your code here

    public function __construct()
    {
        parent::__construct();
        $this->load->model('plan_gobierno/ModelPlanGobierno'); # Llamado a el modelo de Plan de gobierno
        $this->load->model('entes/ModelEntes'); # Llamado a el modelo de Entes
    }

    public function index()
    {
        $datos['lista_plan_gobierno'] = $this->ModelEntes->listar('plan_gobierno');
        $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base",$datos);
        $this->load->view("plan_gobierno/ViewLista", $datos);
    }

    public function nuevo()
    {   $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base",$datos);
        $this->load->view("plan_gobierno/ViewAdd");
    }

    public function guardar()
    {
        $result = $this->ModelPlanGobierno->insertar($this->input->post());
        // =========================================================================
		// Proceso de bitacora
		// =========================================================================
		$time   = "%h:%i %a"; // Se captura la hora actual
		$datos  = array(
			'modulo'   =>  'PLAN DE GOBIERNO (TABLA plan_gobierno)',
			'accion'  => 'NUEVO INGRESO DE PLAN DE GOBIERNO',
			'id_usuario' => $this->session->userdata['logged_in']['id'],
			'fecha_registro'  => date('Y-m-d',now()),
			'fecha_actualizacion' => NULL,
			'hora_registro' => mdate($time),
			'hora_actualizacion' => NULL,
			'ip' => $_SERVER['REMOTE_ADDR'],
		);
		$result = $this->ModelStandard->bitacora($datos);
		// =========================================================================
    }

    public function modificar()
    {
        $result = $this->ModelPlanGobierno->actualizar($this->input->post());
        // =========================================================================
		// Proceso de bitacora
		// =========================================================================
		$time   = "%h:%i %a"; // Se captura la hora actual
		$datos  = array(
			'modulo'   =>  'PLAN DE GOBIERNO (TABLA plan_gobierno)',
			'accion'  => 'NUEVA ACTUALIZACIÓN DE PLAN DE GOBIERNO',
			'id_usuario' => $this->session->userdata['logged_in']['id'],
			'fecha_registro'  => NULL,
			'fecha_actualizacion' => date('Y-m-d',now()),
			'hora_registro' => NULL,
			'hora_actualizacion' => mdate($time),
			'ip' => $_SERVER['REMOTE_ADDR'],
		);
		$result = $this->ModelStandard->bitacora($datos);
		// =========================================================================
    }

    public function procesar($id)
    {
        $datos['detalles_lista'] = $this->ModelPlanGobierno->detailList($id);
        $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base",$datos);
        $this->load->view('plan_gobierno/ViewUpdate', $datos);
    }

    public function delete($id)
    {
        $result = $this->ModelPlanGobierno->eliminar($id);
        if ($result) {
            redirect('plan_gobierno/ControllersPlanGobierno');
        }
    }

}
