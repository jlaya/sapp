<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllersCierre
 *
 * @author ING: Jesus Laya
 */
class ControllersCierre extends CI_Controller
{

    //put your code here

    public function __construct()
    {
        parent::__construct();
        $this->load->model('cierre/ModelCierre'); # Llamado a el modelo de Cierre de Año Fiscal
    }

    public function close_ano()
    {
        $this->ModelCierre->cierre();
        // =========================================================================
        // Proceso de bitacora
        // =========================================================================
        $time = "%h:%i %a"; // Se captura la hora actual
        $datos  = array(
            'modulo'              =>  'CIERRE DE AÑO FISCAL '.date('Y',now()),
            'accion'              => 'NUEVO CIERRE DE AÑO FISCAL',
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

}
