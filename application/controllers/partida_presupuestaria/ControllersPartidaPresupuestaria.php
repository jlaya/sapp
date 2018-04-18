<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllersPartidaPresupuestaria
 *
 * @author ING: Jesus Laya
 */
class ControllersPartidaPresupuestaria extends CI_Controller
{

    //put your code here

    public function __construct()
    {
        parent::__construct();
        $this->load->model('partida_presupuestaria/ModelPartidaPresupuestaria'); # Llamado a el modelo de Accion Centralizada
        $this->load->model('entes/ModelEntes'); # Llamado a el modelo de Entes
    }

    public function index()
    {
        $datos['lista_partida_presupuestaria'] = $this->ModelEntes->listar('partida_presupuestaria');
        $datos['partida_padre'] = $this->ModelEntes->listar('partida_presupuestaria');
        $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base",$datos);
        $this->load->view("partida_presupuestaria/ViewLista", $datos);
    }

    public function procesar($id)
    {
        $datos['detalles_lista'] = $this->ModelPartidaPresupuestaria->detailList($id);
        $datos['lista_partida_padre'] = $this->ModelEntes->listar('partida_presupuestaria');
        $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base",$datos);
        $this->load->view('partida_presupuestaria/ViewUpdate', $datos);
    }

    public function guardar()
    {
        $result = $this->ModelPartidaPresupuestaria->insertar($this->input->post());
        // =========================================================================
        // Proceso de bitacora
        // =========================================================================
        $time   = "%h:%i %a"; // Se captura la hora actual
        $datos  = array(
            'modulo'   =>  'PARTIDAS PRESUPUESTARIA (TABLA partida_presupuestaria)',
            'accion'  => 'NUEVO INGRESO DE PARTIDA PRESUPUESTARIA',
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
        $result = $this->ModelPartidaPresupuestaria->actualizar($this->input->post());
        // =========================================================================
        // Proceso de bitacora
        // =========================================================================
        $time   = "%h:%i %a"; // Se captura la hora actual
        $datos  = array(
            'modulo'   =>  'PARTIDAS PRESUPUESTARIA (TABLA partida_presupuestaria)',
            'accion'  => 'NUEVA ACTUALIZACIÓN DE PARTIDA PRESUPUESTARIA',
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
    {   $datos['lista_partida_padre'] = $this->ModelEntes->listar('partida_presupuestaria');
        $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base",$datos);
        $this->load->view("partida_presupuestaria/ViewAdd",$datos);
    }

    public function delete($id)
    {
        $result = $this->ModelPartidaPresupuestaria->eliminar($id);
        if ($result) {
            redirect('partida_presupuestaria/ControllersPartidaPresupuestaria');
        }
    }

}
