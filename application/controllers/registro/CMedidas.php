<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CMedidas extends SI_Controller {

    private $dir   = 'registro/';
    private $files = array('new'=>'medidas');
    private $vista = '';
    private $table = 'medidas_cautelares';
    public function __construct()
    {
        parent::__construct();
        $this->files = (object)$this->files;
        $this->load->model('registro/MMedidas','medidas');
        $this->load->model('registro/MDelito','delito');
        //echo strtolower(substr($this->router->fetch_class(),1));
    }
    public function index()
    {
        $datos['id']     = $this->modulo->lastId($this->table);
        $datos['delito'] = $this->delito->listar();
        $datos['lista']  = $this->medidas->listar();
        $datos['token']  = $this->libreria->token();

        $this->vista = $this->dir.$this->files->new;
        $this->template->write_view('content', $this->vista,$datos);
        $this->template->render();

    }

    public function buscar()
    {
        $id = $this->input->get('id');
        $row = $this->medidas->buscar($id);
        echo json_encode($row);
    }

    public function eliminar()
    {
        $response_data['success']='error';
        $id = $this->input->get('id');
        $resultado = $this->medidas->eliminar($id);
        if($resultado){
            $response_data['success']='ok';
            $response_data['msg']='<div>El registro fue eliminado exitosamente</div>';
        }
        echo json_encode($response_data);
    }

    public function guardar()
    {
        if ($this->input->post('token') && $this->input->post('token') == $this->session->userdata('token')) {
            $data = $this->input->post();
            $response_data['success']='error';
            $result = $this->medidas->guardar($data);
            if($result){
                $response_data['success']='ok';
                $response_data['msg']='<div>Registro guardado con exito</div>';
            }
        }else{
            $response_data['success']='error';
        }
        echo json_encode($response_data);
    }

    public function modificar()
    {
        if ($this->input->post('token') && $this->input->post('token') == $this->session->userdata('token')) {
            $data = $this->input->post();
            $result = $this->medidas->modificar($data);
            if($result){
                $response_data['success']='ok';
                $response_data['msg']='<div>Registro modifcado con exito</div>';
            }
        }else{
            $response_data['success']='error';
        }
        echo json_encode($response_data);
    }
}
