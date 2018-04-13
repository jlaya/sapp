<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllersEstructura
 *
 * @author ING: Jesus Laya
 */
class ControllersEstructura extends CI_Controller
{

    //put your code here

    public function __construct()
    {
        parent::__construct();
        $this->load->model('entes/ModelEntes'); # Llamado a el modelo de Entes
        $this->load->model('estructura/ModelEstructura'); # Llamado a el modelo de Tipo de Estructura
    }

    public function index()
    {
        $datos['lista_estructura'] = $this->ModelEntes->listar('estructura');
        $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base",$datos);
        $this->load->view("estructura/ViewLista", $datos);
    }
    
    
    public function procesar($id)
    {
        $datos['detalles_lista'] = $this->ModelEstructura->detailList($id);
        $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base",$datos);
        $this->load->view('estructura/ViewUpdate', $datos);
    }
    
    public function guardar()
    {
        $result = $this->ModelEstructura->insertar($this->input->post());
        // =========================================================================
        // Proceso de bitacora
        // =========================================================================
        $time   = "%h:%i %a"; // Se captura la hora actual
        $datos  = array(
            'modulo'   =>  'TIPO DE ESTRUCTURA (TABLA estructura)',
            'accion'  => 'NUEVO INGRESO DE ESTRUCTURA',
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
        $result = $this->ModelEstructura->actualizar($this->input->post());
        // =========================================================================
        // Proceso de bitacora
        // =========================================================================
        $time   = "%h:%i %a"; // Se captura la hora actual
        $datos  = array(
            'modulo'   =>  'TIPO DE ESTRUCTURA (TABLA estructura)',
            'accion'  => 'NUEVA ACTUALIZACIÓN DE ESTRUCTURA',
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
    {   $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base",$datos);
        $this->load->view("estructura/ViewAdd");
    }

    public function delete($id)
    {
        $result = $this->ModelEstructura->eliminar($id);
        if ($result) {
            redirect('estructura/ControllersEstructura');
        }
    }

}
