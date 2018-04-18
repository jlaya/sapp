<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MMedidas extends SI_Model {

    private $table = 'medidas_cautelares';

    public function __construct()
    {
        parent::__construct();
    }

    public function listar()
    {
        $query = $this->db->select("*")
        ->get($this->table);
        return $query->result();
    }

    public function buscar($id)
    {
        $query = $this->db->select("*")
        ->where('id', $id)
        ->get($this->table);
        return $query->row();
    }

    public function guardar($data)
    {
        $insert = $this->insert($this->table, $data);
        return $insert;
    }

    public function modificar($data)
    {
        $result = $this->update($this->table,$data);
        return $result;
    }
    public function eliminar($id)
    {
        $datos['estatus'] = 0;
        $this->db->where('id', $id);
        $result = $this->db->update($this->table,$datos);
        return $result;
    }

}
