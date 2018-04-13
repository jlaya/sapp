<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllersSectores
 *
 * @author ING: Jesus Laya
 */
class ControllersSectores extends CI_Controller
{

    //put your code here

    public function __construct()
    {
        parent::__construct();
        $this->load->model('sectores/ModelSectores'); # Llamado a el modelo de Entes
        $this->load->model('entes/ModelEntes'); # Llamado a el modelo de Entes
    }

    public function index()
    {
        $datos['lista_sectores'] = $this->ModelSectores->listar();
        $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base",$datos);
        $this->load->view("sectores/ViewLista", $datos);
    }

    public function nuevo()
    {   $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base",$datos);
        $this->load->view("sectores/ViewAdd");
    }


    public function procesar_data($v)
    {

        if ($v == "1") {
            $result = $this->ModelSectores->insertar($this->input->post());
            // =========================================================================
            // Proceso de bitacora
            // =========================================================================
            $time   = "%h:%i %a"; // Se captura la hora actual
            $datos  = array(
                'modulo'   =>  'SECTORES (TABLA sectores)',
                'accion'  => 'NUEVO INGRESO DE SECTOR',
                'id_usuario' => $this->session->userdata['logged_in']['id'],
                'fecha_registro'  => date('Y-m-d',now()),
                'fecha_actualizacion' => NULL,
                'hora_registro' => mdate($time),
                'hora_actualizacion' => NULL,
                'ip' => $_SERVER['REMOTE_ADDR'],
            );
            $result = $this->ModelStandard->bitacora($datos);
            // =========================================================================
        } else if ($v == "2") {
            $result = $this->ModelSectores->actualizar($this->input->post());
            // =========================================================================
            // Proceso de bitacora
            // =========================================================================
            $time   = "%h:%i %a"; // Se captura la hora actual
            $datos  = array(
                'modulo'   =>  'SECTORES (TABLA sectores)',
                'accion'  => 'NUEVA ACTUALIZACIÓN DE SECTOR',
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
    }

    public function procesar($id)
    {
        $datos['detalles_lista'] = $this->ModelSectores->detailList($id);
        $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base",$datos);
        $this->load->view('sectores/ViewUpdate', $datos);
    }

    /* Proceso para listar los datos */

    public function listar($tabla)
    {
        $datos['datos'] = $this->ModelSectores->listar_datos($tabla);
        $this->load->view("sectores/ViewLista", $datos);
    }

    public function delete($id)
    {
        $result = $this->ModelSectores->eliminar($id);
        if ($result) {
            redirect('sectores/ControllersSectores');
        }
    }

}
