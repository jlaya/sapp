<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MOjos extends SI_Model {

    private $table = 'rasgos_ojos';

    public function __construct()
    {
        parent::__construct();
    }

    public function listar()
    {
        $this->db->select("*");
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function guardar($data)
    {
        $insert = $this->insert($this->table, $data);
        return $insert;
    }
}

