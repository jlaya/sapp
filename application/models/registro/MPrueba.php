<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'entities/Prueba.php';
class MPrueba extends CI_Model {

    public $variable;

    public function __construct()
    {
        parent::__construct();

    }

    public function listar()
    {
        $query = $this->db->get('prueba');
        return $query->result('Prueba');

    }
    public function insertar()
    {

        $this->load->helper('date');
        $bad_date = '1980-09-16';
        $prueba = new Prueba();
        $prueba->setCedula('15649505');
        $prueba->setNombre('Johanlit');
        $prueba->setFechaNaci($bad_date);
        //$this->db->insert('prueba', $prueba);
        $data['cedula']     = 15649505;
        $data['nombre']     = 'Josue';
        $data['fecha_naci'] = '1980-09-16';
        $data['peso']       = '';
        $this->db->set($data)->insert('prueba');
    }
}