<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllersLineaE
 *
 * @author ING: Jesus Laya
 */
class ControllersLineaE extends CI_Controller
{

    //put your code here

    public function __construct()
    {
        parent::__construct();
        $this->load->model('linea_estrategica/ModelLineaE'); # Llamado a el modelo de Lineas Estrategicas
        $this->load->model('entes/ModelEntes'); # Llamado a el modelo de Entes
    }

    public function index()
    {
        $datos['lista_linea_estrategica']   = $this->ModelEntes->listar('linea_estrategica');
        $datos['lista_plan_gobierno'] = $this->ModelEntes->listar('plan_gobierno');
        $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base",$datos);
        $this->load->view("linea_estrategica/ViewLista", $datos);
    }

    public function procesar($id)
    {
        $datos['detalles_lista']            = $this->ModelLineaE->detailList($id);
        $datos['lista_accion_centralizada'] = $this->ModelEntes->listar('accion_centralizada');
        $datos['lista_plan_gobierno'] = $this->ModelEntes->listar('plan_gobierno');
        $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base",$datos);
        $this->load->view('linea_estrategica/ViewUpdate', $datos);
    }

    public function guardar()
    {
        $result = $this->ModelLineaE->insertar($this->input->post());
        // =========================================================================
		// Proceso de bitacora
		// =========================================================================
		$time   = "%h:%i %a"; // Se captura la hora actual
		$datos  = array(
			'modulo'   =>  'LINEA ESTRATÉGICA (TABLA linea_estrategica)',
			'accion'  => 'NUEVO INGRESO DE LINEA ESTRATÉGICA',
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
        $result = $this->ModelLineaE->actualizar($this->input->post());
        // =========================================================================
		// Proceso de bitacora
		// =========================================================================
		$time   = "%h:%i %a"; // Se captura la hora actual
		$datos  = array(
			'modulo'   =>  'LINEA ESTRATÉGICA (TABLA linea_estrategica)',
			'accion'  => 'NUEVA ACTUALIZACIÓN DE LINEA ESTRATÉGICA',
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

    public function nuevo()
    {
        $datos['lista_plan_gobierno'] = $this->ModelEntes->listar('plan_gobierno');
        $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base",$datos);
        $this->load->view("linea_estrategica/ViewAdd", $datos);
    }

    public function delete($id)
    {
        $result = $this->ModelLineaE->eliminar($id);
        if ($result) {
            redirect('linea_estrategica/ControllersLineaE');
        }
    }

}
