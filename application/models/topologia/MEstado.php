
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MEstado extends SI_Model {

    private $table = 'estados';

    public function __construct()
    {
        parent::__construct();

    }

    public function listar()
    {
        $this->db->select('*');
        $this->db->order_by("id", "asc");
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function buscar($id)
    {

        $this->db->select('*');
        $this->db->where('id',$id);
        $query = $this->db->get($this->table);
        return $query->row();
    }

}