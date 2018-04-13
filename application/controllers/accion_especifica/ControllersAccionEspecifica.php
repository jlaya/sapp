<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllersAccionEspecifica
 *
 * @author ING: Jesus Laya
 */
class ControllersAccionEspecifica extends CI_Controller
{

    //put your code here

    public function __construct()
    {
        parent::__construct();
        $this->load->model('accion_especifica/ModelAccionEspecifica'); # Llamado a el modelo de Accion Especifica
        $this->load->model('entes/ModelEntes'); # Llamado a el modelo de Entes
    }

    public function index()
    {
        $datos['lista_accion_especifica'] = $this->ModelEntes->listar('accion_especifica');
        $datos['lista_accion_centralizada'] = $this->ModelEntes->listar('accion_centralizada');
        $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base",$datos);
        $this->load->view("accion_especifica/ViewLista", $datos);
    }

    public function procesar($id)
    {
        $datos['detalles_lista'] = $this->ModelAccionEspecifica->detailList($id);
        $datos['lista_accion_centralizada'] = $this->ModelEntes->listar('accion_centralizada');
        $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base",$datos);
        $this->load->view('accion_especifica/ViewUpdate', $datos);
    }

    public function guardar()
    {
        $result = $this->ModelAccionEspecifica->insertar($this->input->post());
        // =========================================================================
		// Proceso de bitacora
		// =========================================================================
		$time   = "%h:%i %a"; // Se captura la hora actual
		$datos  = array(
			'modulo'   => 'ACCIÓN ESPECÍFICA (TABLA accion_especifica)',
			'accion'  => 'NUEVO INGRESO DE ACCIÓN ESPECÍFICA',
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
        $result = $this->ModelAccionEspecifica->actualizar($this->input->post());
        // =========================================================================
		// Proceso de bitacora
		// =========================================================================
		$time   = "%h:%i %a"; // Se captura la hora actual
		$datos  = array(
			'modulo'   => 'ACCIÓN ESPECÍFICA (TABLA accion_especifica)',
			'accion'  => 'NUEVA ACTUALIZACIÓN DE ACCIÓN ESPECÍFICA',
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
    {   $datos['lista_accion_centralizada'] = $this->ModelEntes->listar('accion_centralizada');
        $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base",$datos);
        $this->load->view("accion_especifica/ViewAdd",$datos);
    }

    public function delete($id)
    {
        $result = $this->ModelAccionEspecifica->eliminar($id);
        if ($result) {
            redirect('accion_especifica/ControllersAccionEspecifica');
        }
    }

}
