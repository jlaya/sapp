<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CDelito extends SI_Controller {

    private $dir   = 'registro/';
    private $files = array('new'=>'delito');
    private $vista = '';
    private $table = 'delito';
    public function __construct()
    {
        parent::__construct();
        $this->files = (object)$this->files;
        $this->load->model('registro/MDelito','delito');
        //echo strtolower(substr($this->router->fetch_class(),1));
    }
    public function index()
    {
        $datos['id']        = $this->modulo->lastId($this->table);
        $datos['lista']     = $this->delito->listar();
        $datos['token']     = $this->libreria->token();
        $this->vista = $this->dir.$this->files->new;
        $this->template->write_view('content', $this->vista,$datos);
        $this->template->render();

    }

    public function buscar()
    {
        $id = $this->input->get('id');
        $row = $this->delito->buscar($id);
        echo json_encode($row);
    }

    public function eliminar()
    {
        $response_data['success']='error';
        $id = $this->input->get('id');
        $resultado = $this->delito->eliminar($id);
        if($resultado){
            $response_data['success']='ok';
            $response_data['msg']='<div>El registro fue eliminado exitosamente</div>';
        }
        echo json_encode($response_data);
    }

    public function modificar()
    {
        if ($this->input->post('token') && $this->input->post('token') == $this->session->userdata('token')) {
            $data = $this->input->post();
            $result = $this->delito->modificar($data);
            if($result){
                $response_data['success']='ok';
                $response_data['msg']='<div>Registro modifcado con exito</div>';
            }
        }else{
            $response_data['success']='error';
        }
        echo json_encode($response_data);
    }
    public function guardar()
    {
        if ($this->input->post('token') && $this->input->post('token') == $this->session->userdata('token')) {
            $data = $this->input->post();
            $response_data['success']='error';
            $result = $this->delito->guardar($data);
            if($result){
                $response_data['success']='ok';
                $response_data['msg']='<div>Registro guardado con exito</div>';
            }
        }else{
            $response_data['success']='error';
        }
        echo json_encode($response_data);
    }
}
