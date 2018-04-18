<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllersComunidad
 *
 * @author ING: Jesus Laya
 */
class ControllersComunidad extends CI_Controller
{

    //put your code here

    public function __construct()
    {
        parent::__construct();
        $this->load->model('entes/ModelEntes'); # Llamado a el modelo de Entes
        $this->load->model('comunidad/ModelComunidad'); # Llamado a el modelo de Entes
    }

    public function index()
    {
        $datos['lista_comunidad'] = $this->ModelEntes->listar('comunidad');
        $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        
        $this->load->view("base/Base",$datos);
        $this->load->view("comunidad/ViewLista", $datos);
    }

    public function nuevo()
    {   
        $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base",$datos);
        $this->load->view("comunidad/ViewAdd");
    }


    public function guardar()
    {
        # Validacion para el campo activo
        if($this->input->post('activo') ==''){
            $activo = 'False';
        }else{
            $activo = 'True';
        }
        if($this->input->post('desplegable') ==''){
            $desplegable = 'False';
        }else{
            $desplegable = 'True';
        }
        
        $array = array(
            'comunidad' => $this->input->post('comunidad'),
            'url' => $this->input->post('url'),
            'posicion' => $this->input->post('posicion'),
            'activo' => $activo,
            'desplegable' => $desplegable
        );
        
        if($this->input->post('id') == ""){
            $result = $this->ModelModulo->insertar($array);
            if ($result) {
                redirect('comunidad/ControllersComunidad');
            }
        }else{
            $result = $this->ModelModulo->actualizar($array);
            if ($result) {
                redirect('comunidad/ControllersComunidad');
            }
        }
    }

    public function procesar($id)
    {
        $datos['detalles_lista'] = $this->ModelModulo->detailList($id);
        $datos['lista_comunidad'] = $this->ModelEntes->listar_table('comunidad');
        $datos['lista_sub_comunidad'] = $this->ModelEntes->listar_table('sub_comunidad');
        $this->load->view("base/Base",$datos);
        $this->load->view('comunidad/ViewUpdate', $datos);
    }

    public function delete($id)
    {
        $result = $this->ModelModulo->eliminar($id);
        if ($result) {
            redirect('comunidad/ControllersComunidad');
        }
    }

}
