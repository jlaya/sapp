<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllersUser
 *
 * @author ING: Jesus Laya
 */
class ControllersUser extends CI_Controller
{

    //put your code here

    public function __construct()
    {
        parent::__construct();
        
    }

    public function index()
    {
        
        if (isset($_POST['password'])){
            
            $this->load->model('user/ModelUser'); # Llamado a el modelo de Usuario
            if ($this->ModelUser->login($_POST['username'],md5($_POST['password']))){
                redirect('sectores/ControllersSectores');
            }else{
                redirect('ControllersUser');
            }
        }
        
        
        $this->load->view("user/ViewUser");
        #$this->load->view("sectores/ViewLista", $datos);
    }

}
