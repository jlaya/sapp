<?php

/**
 * Created by PhpStorm.
 * User: josue
 * Date: 09/06/17
 * Time: 09:15 AM
 */
class MunicipiosModel extends CI_Model
{
    private $table = 'municipios';

    public function __construct()
    {
        parent::__construct();

    }

    public function listar()
    {
        $this->db->select('*');
        $this->db->order_by("id", "asc");
        $this->db->where('estado_id', 4);
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function buscar($id)
    {

        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        return $query->row();
    }
}