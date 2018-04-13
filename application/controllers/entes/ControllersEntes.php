<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllersEntes
 *
 * @author ING: Jesus Laya
 */
class ControllersEntes extends CI_Controller
{

    //put your code here

    public function __construct()
    {
        parent::__construct();
        $this->load->model('entes/ModelEntes'); # Llamado a el modelo de Entes
    }

    public function index()
    {
        $datos['lista_organos'] = $this->ModelEntes->listar('organos_entes');
        $datos['lista_modulo']  = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base", $datos);
        $this->load->view("entes/ViewLista", $datos);
    }

    public function nuevo()
    {   
        $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base",$datos);
        $datos['list_sector'] = $this->ModelEntes->listar('sectores');
        $datos['estructura'] = $this->ModelEntes->listar('estructura');
        $this->load->view("entes/ViewAdd", $datos);
    }

    public function guardar()
    {
        $result = $this->ModelEntes->insertar($this->input->post());
        // =========================================================================
        // Proceso de bitacora
        // =========================================================================
        $time   = "%h:%i %a"; // Se captura la hora actual
        $datos  = array(
            'modulo'   =>  'ORGANOS ENTES (TABLA organos_entes)',
            'accion'  => 'NUEVO INGRESO DE ORGANO ENTE',
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

    public function procesar($id)
    {
        $datos['data']        = $this->ModelEntes->detailList($id);
        $datos['list_sector'] = $this->ModelEntes->listar('sectores');
        $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $datos['estructura'] = $this->ModelEntes->listar('estructura');
        $this->load->view("base/Base",$datos);
        $this->load->view('entes/ViewUpdate', $datos);
    }

    public function update()
    {   
        $data = $this->input->post();
        $result = $this->ModelEntes->actualizar($data);
        if($result){
        // =========================================================================
        // Proceso de bitacora
        // =========================================================================
            $time   = "%h:%i %a";
            $datos  = array(
                'modulo'   =>  'ORGANOS ENTES (TABLA organos_entes)',
                'accion'  => 'NUEVA ACTUALIZACIÓN DE ORGANO ENTE',
                'id_usuario' => $this->session->userdata['logged_in']['id'],
                'fecha_registro'  => NULL,
                'fecha_actualizacion' => date('Y-m-d',now()),
                'hora_registro' => NULL,
                'hora_actualizacion' => mdate($time),
                'ip' => $_SERVER['REMOTE_ADDR'],
                );
            $result = $this->ModelStandard->bitacora($datos);
        }
        // =========================================================================
    }

    public function delete($id)
    {
        $result = $this->ModelEntes->eliminar($id);
        if ($result) {
            redirect('entes/ControllersEntes');
        }
    }

}
