<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllersSubModulo
 *
 * @author ING: Jesus Laya
 */
class ControllersSubModulo extends CI_Controller
{

    //put your code here

    public function __construct()
    {
        parent::__construct();
        $this->load->model('entes/ModelEntes'); # Llamado a el modelo de Entes
        $this->load->model('sub_modulo/ModelSubModulo'); # Llamado a el modelo de Entes
    }

    public function index()
    {   
        $datos['lista_modulos'] = $this->ModelEntes->listar('sub_modulo');
        $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base",$datos);
        $this->load->view("sub_modulo/ViewLista", $datos);
    }

    public function nuevo()
    {   $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base",$datos);
        $this->load->view("sub_modulo/ViewAdd",$datos);
    }


    public function guardar()
    {
        # Validacion para el campo activo
        if($this->input->post('activo') ==''){
            $activo = 'False';
        }else{
            $activo = 'True';
        }
        
        $array = array(
            'sub_modulo' => $this->input->post('sub_modulo'),
            'id_modulo' => $this->input->post('id_modulo'),
            'url' => $this->input->post('url'),
            'posicion' => $this->input->post('posicion'),
            'activo' => $activo,
        );
        
        if($this->input->post('id') == ""){
            $result = $this->ModelSubModulo->insertar($array);
            if ($result) {
                redirect('sub_modulo/ControllersSubModulo');
            }
        }else{
            $result = $this->ModelSubModulo->actualizar($array);
            if ($result) {
                redirect('sub_modulo/ControllersSubModulo');
            }
        }
    }

    public function procesar($id)
    {
        $datos['detalles_lista'] = $this->ModelSubModulo->detailList($id);
        $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base",$datos);
        $this->load->view('sub_modulo/ViewUpdate', $datos);
    }

    public function delete($id)
    {
        $result = $this->ModelSubModulo->eliminar($id);
        if ($result) {
            redirect('sub_modulo/ControllersSubModulo');
        }
    }

}
