<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CDetalle extends SI_Controller {

    private $dir   = 'registro/';
    private $files = array('new'=>'detalle');
    private $vista = '';
    private $table = 'detalles';
    public function __construct()
    {
        parent::__construct();
        $this->files = (object)$this->files;
        $this->load->model('registro/MDetalle','detalle');
        $this->load->model('registro/MDelito','delito');
        $this->load->model('topologia/MEstado','estado');
        $this->load->model('registro/MResena','resena');
        //echo strtolower(substr($this->router->fetch_class(),1));
    }
    public function index()
    {
        $datos['id']     = $this->modulo->lastId($this->table);
        $datos['lista_resena'] = $this->resena->listar();
        $datos['token']  = $this->libreria->token();
        $datos['delito'] = $this->delito->listar();
        $datos['estado'] = $this->estado->listar();
        $this->vista = $this->dir.$this->files->new;
        $this->template->write_view('content', $this->vista,$datos);
        $this->template->render();

    }

    public function buscar()
    {
        $id = $this->input->get('id');
        $row = $this->detalle->buscar($id);
        echo json_encode($row);
    }

    public function buscar_falta()
    {
        $id = $this->input->get('ci');
        $row = $this->detalle->buscar_falta($id);
        echo json_encode($row);
    }
    
    public function buscar_ced()
    {
        $id = $this->input->get('ci');
        $row = $this->detalle->buscar_ced($id);
        echo json_encode($row);
    }

    public function eliminar()
    {
        $response_data['success']='error';
        $id = $this->input->get('id');
        $resultado = $this->detalle->eliminar($id);
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
            $result = $this->detalle->modificar($data);
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
            $result = $this->detalle->guardar($data);
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
