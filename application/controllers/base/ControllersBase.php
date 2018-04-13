<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllersBase
 *
 * @author ING: Jesus Laya
 */
class ControllersBase extends CI_Controller
{

    //put your code here

    public function __construct()
    {
        parent::__construct();
        $this->load->model('entes/ModelEntes'); # Llamado a el modelo de Entes
        
    }

    public function index()
    {
        $datos['lista_modulo'] = $this->ModelEntes->listar('modulo');
        $this->load->view("base/Base", $datos);
    }

}
