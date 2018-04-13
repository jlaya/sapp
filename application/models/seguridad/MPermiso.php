<?php

/**
*
*/
class MPermiso extends SI_Model
{

    private $table = 'se_permissions';
    public function __construct()
    {
        parent::__construct();

    }

    public function listar()
    {

    }

    public function agregar($data)
    {
        $this->insert($this->table, $data);
    }

    public function getModuleExits($id)
    {
        $this->db->select('modulo_id');
        $this->db->where('id',$id);
        $query = $this->db->get($this->table);
        return $query->row()->modulo_id;
    }
}