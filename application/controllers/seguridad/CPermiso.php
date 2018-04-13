<?php
/**
 *
 */
class CPermiso extends SI_Controller
{

    private $dir   = 'seguridad/';
    private $files = array('new'=>'permiso');
    private $vista = '';
    private $table = 'se_permissions';
    public function __construct()
    {
        parent::__construct();
        $this->files = (object)$this->files;
        $this->load->model('seguridad/MUsers','users');
        $this->load->model('seguridad/m_perfil','perfil');
        $this->load->model('seguridad/MPermiso','permiso');
        $this->load->model('seguridad/MModulo','modulo');
    }

    public function index()
    {
        $this->vista       = $this->dir.$this->files->new;
        $datos['id']       = $this->users->lastId($this->table);
        $datos['token']    = $this->libreria->token();
        $datos['perfiles'] = $this->perfil->perfil_active();
        $datos['usuarios'] = $this->users->userActive();
        $this->template->write('title', 'Permiso de Usuarios');
        $this->template->write('module', 'Permisos de Usuario');
        $this->template->write_view('content', $this->vista, $datos);
        $this->template->render();
    }

    public function guardar()
    {
        $data = $this->input->post();
        $bandera = FALSE;
        foreach ($data['modulo_id'] as $value) {
            $datos['id']        = $this->users->lastId($this->table);
            $datos['perfil_id'] = $data['perfil_id'];
            $datos['user_id']   = $data['user_id'];
            $datos['modulo_id'] = $value;
            $result = $this->permiso->agregar($datos);
        }
        $response_data['success']='ok';
                $response_data['msg']='<div>Registro exitoso</div>';
        echo json_encode($response_data);
    }


}