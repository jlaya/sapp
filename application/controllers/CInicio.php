<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CInicio extends SI_Controller
{

    private $dir   = array('sistema'=>'seguridad','registro'=>'registro','consulta'=>'seguridad');
    private $files = array('inicio'=>'inicio', 'sistema'=>'sistema','lista'=>'lista','new'=>'tickeks','consulta'=>'consulta');
    private $vista = '';
    private $table = 'ticket';
    public function __construct()
    {
        parent::__construct();
        $this->dir = (object)$this->dir;
        $this->files = (object)$this->files;
        $this->load->model('registro/MResena','resena');
    }

    public function index()
    {   
        $datos['lista_resena'] = $this->resena->listar();
        $this->vista = $this->dir->sistema.'/'.$this->files->sistema;
        $this->template->write_view('content', $this->vista, $datos);
        $this->template->render();
    }
    
    public function consulta()
    {   
        

		$datos['lista_resena'] = $this->resena->listarf();
		
        $this->vista = $this->dir->consulta.'/'.$this->files->consulta;
        $this->template->write_view('content', $this->vista, $datos);
        $this->template->render();
    }
}
