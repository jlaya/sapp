<?php
/**
*
*/
class MUsers extends SI_Model
{
    private $table = 'se_users';
    function __construct()
    {
        parent::__construct();
    }
    public function listar()
    {
        $this->db->select("u.id, u.si_user, u.first_name, u.last_name, u.correo, u.active, p.perfil");
        $this->db->from($this->table.' AS u');
        $this->db->join('se_perfil AS p', 'u.perfil_id = p.id');
        $query = $this->db->get();
        return $query->result();
    }
    public function agregar($data)
    {

        $result = $this->db->where('si_user =', $data['si_user']);
        $result = $this->db->get($this->table);

        if ($result->num_rows() > 0) {
            #echo "CORRECTO";
            #echo '1';
        } else {
            $insert = $this->db->insert($this->table, $data);
    
            return $insert;
        }
        
        
    }

    public function modificar($id,$data)
    {
        $this->db->where('id', $id);
        $result = $this->db->update($this->table,$data);
        return $result;
    }

    public function login($user,$pass)
    {
        $checkpass = $this->libreria->checkPassword($user, $pass);
        return $checkpass;
    }

    public function changePassword($id,$data)
    {
        $data['change_password'] = TRUE;
        $result = $this->db->update($this->table, $data, "id = $id");
        return $result;
    }

    public function userActive()
    {
        $this->db->select("id, si_user");
        $this->db->where('active',TRUE);
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function buscar($id)
    {
        $this->db->select('id, si_user, first_name, last_name, correo, show_panel, active, perfil_id, change_password');
        $this->db->where('id',$id);
        $query = $this->db->get($this->table);
        return $query->row();
    }


}