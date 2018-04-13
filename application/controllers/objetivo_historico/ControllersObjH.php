<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllersObjH
 *
 * @author ING: Jesus Laya
 */
class ControllersObjH extends CI_Controller
{

    //put your code here

    public function __construct()
    {
        parent::__construct();
        $this->load->model('objetivo_historico/ModelLObjH'); # Llamado a el modelo de Lineas Estrategicas
        $this->load->model('entes/ModelEntes'); # Llamado a el modelo de Entes
    }

    public function index()
    {
        $datos['lista_objetivo_historico']   = $this->ModelEntes->listar('objetivo_historico');
        $datos['lista_plan_patria'] = $this->ModelEntes->listar('plan_patria');
        $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base",$datos);
        $this->load->view("objetivo_historico/ViewLista", $datos);
    }

    public function procesar($id)
    {
        $datos['detalles_lista']            = $this->ModelLObjH->detailList($id);
        $datos['lista_plan_patria'] = $this->ModelEntes->listar('plan_patria');
        $datos['lista_modulo']      = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base",$datos);
        $this->load->view('objetivo_historico/ViewUpdate', $datos);
    }

    public function guardar()
    {
        $result = $this->ModelLObjH->insertar($this->input->post());
        // =========================================================================
		// Proceso de bitacora
		// =========================================================================
		$time   = "%h:%i %a"; // Se captura la hora actual
		$datos  = array(
			'modulo'              => 'OBJETIVO HISTÓRICO (TABLA objetivo_historico)',
			'accion'              => 'NUEVO INGRESO DE OBJETIVO HISTÓRICO',
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
        $result = $this->ModelLObjH->actualizar($this->input->post());
        // =========================================================================
		// Proceso de bitacora
		// =========================================================================
		$time   = "%h:%i %a"; // Se captura la hora actual
		$datos  = array(
			'modulo'              => 'OBJETIVO HISTÓRICO (TABLA objetivo_historico)',
			'accion'              => 'NUEVA ACTUALIZACIÓN DE OBJETIVO HISTÓRICO',
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
        $this->load->view("objetivo_historico/ViewAdd", $datos);
    }

    public function delete($id)
    {
        $result = $this->ModelLObjH->eliminar($id);
        if ($result) {
            redirect('objetivo_historico/ControllersObjH');
        }
    }

}
