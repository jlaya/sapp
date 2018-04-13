<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllersMonitor
 *
 * @author ING: Jesus Laya
 */
class ControllersMonitor extends CI_Controller
{

    //put your code here

    public function __construct()
    {
        parent::__construct();
        $this->load->model('entes/ModelEntes'); # Llamado a el modelo de Entes
    }

    // Metodo predeterminado (Index)
    public function index()
    {   $datos['lista_modulo']  = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base", $datos);
        $datos['organo'] = $this->ModelEntes->listar('organos_entes');
        $this->load->view('monitoreo/ViewList', $datos);
    }

}
