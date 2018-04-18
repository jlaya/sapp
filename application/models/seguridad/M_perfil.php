<?php

/**
*
*/
class M_perfil extends SI_Model
{
    private $table = 'se_perfil';
    function __construct()
    {
        parent::__construct();
    }

    public function listar()
    {
        $this->db->select("id, perfil, activo");
        $this->db->order_by("id",'asc');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function listUser()
    {
        $this->db->select("id, perfil, activo")
        ->where_not_in('id', array(1,3));
        $query = $this->db->get($this->table);

        return $query->result();
    }

    public function agregar($data)
    {
        date_default_timezone_set('America/Caracas');
        $data['user_create'] =  $this->session->userdata('user_id');
        $data['date_create'] =  date('Y-m-d H:i:s');
        $result = $this->db->where('perfil =', $data['perfil']);
        $result = $this->db->get($this->table);

        if ($result->num_rows() > 0) {
            #echo "CORRECTO";
            #echo '1';
        } else {
            $insert = $this->db->insert($this->table, $data);
    
            return $insert;
        }
        
        
    }

    public function buscar($id)
    {
        $this->db->select('id, perfil, activo');
        $this->db->where('id',$id);
        $query = $this->db->get($this->table);
        return $query->row();
    }
    public function modificar($id,$data)
    {
        $result = $this->db->where('id !=', $id);
        $result = $this->db->where('perfil =', $data['perfil']);
        $result = $this->db->get($this->table);

        if ($result->num_rows() > 0) {
            #echo "CORRECTO";
            #echo '1';
        } else {
            $this->db->where('id', $id);
            $result = $this->db->update($this->table,$data);
            return $result;
        }
        
        
    }
    public function eliminar($id)
    {
             
        $result = $this->db->where('perfil_id =', $id);
        $result = $this->db->get('se_users');

        if ($result->num_rows() > 0) {
            #echo "CORRECTO";
            #echo '1';
        } else {
            
            $datos['id'] = $id;
            return $this->db->delete($this->table, $datos);
        }
        
        
    }

    public function perfil_active()
    {
        $this->db->select("id, perfil");
        $this->db->where('activo',1);
        $query = $this->db->get($this->table);
        return $query->result();
    }
}