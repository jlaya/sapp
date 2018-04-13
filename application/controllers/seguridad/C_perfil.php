<?php

/**
 * *
 */
class C_perfil extends SI_Controller {

    private $dir = 'seguridad/';
    private $files = array('new' => 'perfil');
    private $vista = '';
    private $_table = 'se_perfil';
    protected $_not_check = ['user_create', 'date_create', 'user_update', 'date_update'];
    public $_unique = ['perfil'];

    function __construct() {
        parent::__construct();
        $this->_tab = $this->_table;
        $this->files = (object) $this->files;
        $this->load->model('seguridad/M_perfil', 'perfil');
    }

    public function index() {
        // /print_r($this->router->routes);
        $this->vista = $this->dir . $this->files->new;
        $datos['id'] = $this->perfil->lastId($this->_table);
        $datos['listar'] = $this->perfil->listar();
        $datos['token'] = $this->libreria->token();

        $this->template->write('title', 'Perfil');
        $this->template->write('module', 'Registro de Perfiles');
        $this->template->write_view('content', $this->vista, $datos);
        $this->template->render();
    }

    public function guardar() {

        $data = $this->input->post();
        $response_data['success'] = 'error';
        $result = $this->perfil->agregar($data);
        if ($result) {
            $response_data['success'] = 'ok';
            $response_data['msg'] = '<div>Registro exitoso</div>';
        } else {
            $response_data['success'] = 'existe';
            $response_data['msg'] = '<div>Ya existe un perfil con ese nombre</div>';
        }
        $resul_activity = $this->libreria->generateActivity('Registro de Perfil');

        echo json_encode($response_data);
    }

    public function buscar() {
        $id = $this->input->get('id');
        $resultado = $this->perfil->buscar($id);
        echo json_encode($resultado);
    }

    public function modificar() {

        $data = $this->input->post();
        $id = $data['id'];
        unset($data['csrf_test_name']);
        unset($data['token']);
        unset($data['id']);


        $result = $this->perfil->modificar($id, $data);
        if ($result) {
            $response_data['success'] = 'ok';
            $response_data['msg'] = '<div>Registro modificado con exito</div>';
            $response_data['action'] = 'update';
        } else {
            $response_data['success'] = 'existe';
            $response_data['msg'] = '<div>Ya existe un perfil con ese nombre</div>';
        }

        echo json_encode($response_data);
    }

    public function eliminar() {
        $response_data['success'] = 'error';
        $id = $this->input->get('id');
        $resultado = $this->perfil->eliminar($id);
        if ($resultado) {
            $response_data['success'] = 'ok';
            $response_data['msg'] = '<div>Registro eliminado con exito</div>';
        }else{
            $response_data['success'] = 'error';
            $response_data['msg'] = '<div>Disculpe, el registro no se puede eliminar se encuentra asociado a uno o más elementos</div>';
        }
        echo json_encode($response_data);
    }

}

?>