<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of Modulo
 *
 * @author josue
 */

class CModulo extends SI_Controller
{
    private $dir   = 'seguridad/';
    private $files = array('new'=>'modulo','list'=>'modulo');
    private $vista = '';
    private $table = 'se_modulo';
    public function __construct()
    {
        parent::__construct();
        $this->files = (object)$this->files;
        //echo strtolower(substr($this->router->fetch_class(),1));
    }
    public function index()
    {
        $this->vista        = $this->dir.$this->files->new;
        $datos['animation'] = 'zoomIn';
        $datos['id']        = $this->modulo->lastId($this->table);
        $datos['lista']     = $this->modulo->listar();
        $datos['modulos']   = $this->modulo->modulo();
        $datos['token']     = $this->libreria->token();

        $datos['directorio']= $this->modulo->listar_directorios_ruta("application/controllers/");

        // print_r($datos['directorio']);
        // exit;

        $this->template->write('title', 'Modulos');
        $this->template->write('module', 'Registro de Modulos');
        $this->template->write_view('content', $this->vista, $datos);
        $this->template->render();

    }
    public function guardar()
    {
        if ($this->input->post('token') && $this->input->post('token') == $this->session->userdata('token')) {
            $data = $this->input->post();
            unset($data['csrf_test_name']);
            unset($data['token']);
            $response_data['success']='error';
            $result = $this->modulo->agregar($data);
            if($result){
                $response_data['success']='ok';
                $response_data['msg']='<div>Registro exitoso, <span class="text-danger"> la p&aacute;gina se actualizara para realizar los cambios</span></div>';
            }
        } else {
            $response_data['success']='error';
        }
        echo json_encode($response_data);
    }

    public function buscar()
    {
        $id = $this->input->get('id');
        $resultado = $this->modulo->buscar($id);
        echo json_encode($resultado);
    }

    public function modificar()
    {
        if ($this->input->post('token') && $this->input->post('token') == $this->session->userdata('token')) {
            $data = $this->input->post();
            $id = $data['id'];
            unset($data['csrf_test_name']);
            unset($data['token']);
            unset($data['id']);

            $response_data['success']='error';
            $result = $this->modulo->modificar($id, $data);
            if($result){
                $response_data['success']='ok';
                $response_data['msg']='<div>Registro modificado con exito, <span class="text-danger"> la p&aacute;gina se actualizara para realizar los cambios</span></div>';
            }
        } else {
            $response_data['success']='error';
        }
        echo json_encode($response_data);
    }

    public function eliminar()
    {
        $response_data['success']='error';
        $id = $this->input->get('id');
        $resultado = $this->modulo->eliminar($id);
        if($resultado){
            $response_data['success']='ok';
            $response_data['msg']='<div>Registro eliminado con exito, <span class="text-danger"> la p&aacute;gina se actualizara para realizar los cambios</span></div>';
        }else{
            $response_data['success']='existe';
            $response_data['msg']='<div>Disculpe, no se puede eliminar porque se encuentra asociado a uno o más módulos</div>';
        }
        echo json_encode($response_data);
    }

}