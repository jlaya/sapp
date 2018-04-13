<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllersPartidaPresupuestariaCentralizada
 *
 * @author ING: Jesus Laya
 */
class ControllersPartidaPresupuestariaCentralizada extends CI_Controller
{

    //put your code here

    public function __construct()
    {
        parent::__construct();
        $this->load->model('partida_presupuestaria_centralizada/ModelPartidaPresupuestariaCentralizada'); # Llamado a el modelo de Partida Centralizada
        $this->load->model('entes/ModelEntes'); # Llamado a el modelo de Entes
    }

    public function index()
    {
        $datos['lista_partida_presupuestaria_centralizada'] = $this->ModelEntes->listar('partida_presupuestaria_centralizada');
        $datos['lista_acc_centralizada'] = $this->ModelEntes->listar('accion_centralizada');
        $datos['lista_partida_presupuestaria'] = $this->ModelEntes->listar('partida_presupuestaria');
        $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base",$datos);
        $this->load->view("partida_presupuestaria_centralizada/ViewLista", $datos);
    }

    public function procesar($id)
    {
        $datos['detalles_lista'] = $this->ModelPartidaPresupuestariaCentralizada->detailList($id);
        $datos['lista_acc_centralizada'] = $this->ModelEntes->listar('accion_centralizada');
        $datos['lista_partida_presupuestaria'] = $this->ModelEntes->listar('partida_presupuestaria');
        $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base",$datos);
        $this->load->view('partida_presupuestaria_centralizada/ViewUpdate', $datos);
    }

    public function guardar()
    {
        $result = $this->ModelPartidaPresupuestariaCentralizada->insertar($this->input->post());
        // =========================================================================
		// Proceso de bitacora
		// =========================================================================
		$time   = "%h:%i %a"; // Se captura la hora actual
		$datos  = array(
			'modulo'   =>  'PARTIDAS PRESUPUESTARIA CENTRALIZADA (TABLA partida_presupuestaria_centralizada)',
			'accion'  => 'NUEVO INGRESO DE PARTIDA PRESUPUESTARIA CENTRALIZADA',
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
        $result = $this->ModelPartidaPresupuestariaCentralizada->actualizar($this->input->post());
        // =========================================================================
		// Proceso de bitacora
		// =========================================================================
		$time   = "%h:%i %a"; // Se captura la hora actual
		$datos  = array(
			'modulo'   =>  'PARTIDAS PRESUPUESTARIA CENTRALIZADA (TABLA partida_presupuestaria_centralizada)',
			'accion'  => 'NUEVA ACTUALIZACIÓN DE PARTIDA PRESUPUESTARIA CENTRALIZADA',
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
    {   $datos['lista_acc_centralizada'] = $this->ModelEntes->listar('accion_centralizada');
        $datos['lista_partida_presupuestaria'] = $this->ModelEntes->listar('partida_presupuestaria');
        $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base",$datos);
        $this->load->view("partida_presupuestaria_centralizada/ViewAdd",$datos);
    }

    public function delete($id)
    {
        $result = $this->ModelPartidaPresupuestariaCentralizada->eliminar($id);
        if ($result) {
            redirect('partida_presupuestaria_centralizada/ControllersPartidaPresupuestariaCentralizada');
        }
    }

}
