<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ModelUser
 *
 * @author jesus
 */
class ModelUser extends CI_Model
{

    //put your code here
    public $variable;

    public function __construct()
    {
        parent::__construct();
        #$this->load->database();
        $this->load->library('session');
    }

    
    // Metodo publico, forma de insertar los datos
    public function insertar($datos)
    {

        $result = $this->db->where('username =', $datos['username']);
        $result = $this->db->get('auth_user');

        if ($result->num_rows() > 0) {
            #echo "CORRECTO";
            echo 'existe';
        } else {

            $result = $this->db->insert("auth_user", $datos);
            return $result;
        }
    }

    public function detailList_avatar()
    {
        $this->db->where('status', 1);
        $this->db->select('avatar.avatar, avatar.status, avatar.titulo, avatar.panel_p, avatar.panel_s, avatar.panel_d, avatar.avatar_login');
        $query = $this->db->get('avatar');
        return $query->row();
    }

    public function detailList_avatar_result($id=0)
    {
        if($id > 0){
            $this->db->where('id', $id);
        }else{
            $this->db->where('status', 1);
        }
        $this->db->select('avatar.id, avatar.avatar, avatar.status, avatar.titulo, avatar.panel_p, avatar.panel_s, avatar.panel_d, avatar.avatar_login');
        $query = $this->db->get('avatar');
        return $query->result();
    }

    public function detailList_avatar_all()
    {
        $this->db->select('avatar.id, avatar.avatar, avatar.status, avatar.titulo');
        $query = $this->db->get('avatar');
        return $query->result();
    }

    // Metodo publico, forma de insertar Avatar
    public function insert_image($datos)
    {
        if($datos['id'] !=""){
            $datos['status'] = 0;
            $id = $datos['id'];
            unset($datos['id']);
            $data['status'] = 0;
            $result = $this->db->update('avatar', $data);
            if($result){
                $this->db->where('id', $id);
                $datos['status'] = 1;
                $result = $this->db->update('avatar', $datos);
            }
        }else{
            unset($datos['id']);
            $result = $this->db->insert("avatar", $datos);
        }
        return $result;
    }


    public function insertar_acceso($datos)
    {

        $result = $this->db->where('id_user =', $datos['user_ids'],'id_org =', $datos['id_org'],'id_modulo =', $datos['modulo_ids'],'id_sub_modulo =', $datos['sub_modulo_ids']);
        $result = $this->db->get('auth_acceso');

        if ($result->num_rows() > 0) {
            #echo "CORRECTO";
            echo 'existe';
        } else {

            $result = $this->db->insert("auth_acceso", $datos);
            return $result;
        }
    }
    
    public function actualizar_acceso($id,$datos)
    {   
        $result = $this->db->where('id', $id);
        $result = $this->db->update('auth_acceso', $datos);
        return $result;
    }

    

    
    // Metodo publico, forma de actualizar los datos
    public function actualizar($id,$datos)
    {   #echo print_r($datos['id']);
        #return true;
    $result = $this->db->where('id', $id);
    $result = $this->db->update('auth_user', $datos);
    return $result;
	}

	public function detailList($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('auth_user');
		return $query->row();
	}

	public function detailList_access($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('auth_acceso');
		return $query->row();
	}

	public function picture($username)
	{
		$this->db->where('username', $username);
		$query = $this->db->get('auth_user');
		return $query->row();
	}

		// Metodo publico, proceso para el logeo
	public function login($username,$password)
	{   
		$array = array('username' => $username, 'password' => $password, 'is_active' => True);

		$this->db->where($array);

		$result = $this->db->get('auth_user');

		if ($result->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function cambio_password($datos)
	{
		$result = $this->db->where('password =', 'pbkdf2_sha256$12000$' . hash("sha256", $datos['password_f']));
		$result = $this->db->get('auth_user');
		if ($result->num_rows() > 0) {
			$this->db->where('id', $datos['id']);
				//$datos['change_id'] = TRUE;
				//$datos['password'] = 'pbkdf2_sha256$12000$' . hash("sha256", $datos['password']);


			$datos  = array(
				'change_id' => TRUE,
				'password'  => 'pbkdf2_sha256$12000$' . hash("sha256", $datos['password']),
				);

			$this->db->update('auth_user', $datos);
			echo 1;
		} else {
			echo 2;
		}
	}

	public function remember_password($username)
	{
		$datos  = array(
			'change_id' => FALSE,
			'password'  => 'pbkdf2_sha256$12000$' . hash("sha256", 123456),
			);

		$this->db->where('username =', $username);
		$this->db->update('auth_user', $datos);
		echo 1;

	}

	public function logout()
	{
		$logout_session = $this->session->sess_destroy();

		if($logout_session){
			return true;
		}
	}


	public function information($username) {

		$array = array('username' => $username);
		$this->db->where($array);
		$this->db->limit(1);
		$query = $this->db->get('auth_user');

		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}


		// Metodo publico para reflejar un dato en especifico
	public function information_auth_group($campo, $id, $table) {

		$array = array($campo => $id);
		$this->db->where($array);
		$this->db->limit(1);
		$query = $this->db->get($table);

		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function ajax()
    {
		$this->db->select("o.correo, CONCAT('(', o.siglas,') ' || trim(o.nom_ins)) AS nom_organo, a.is_superuser, a.username, a.first_name, a.cedula, a.is_staff, a.is_active, a.id, a.ente, a.foto");
        $this->db->from('auth_user a');
        $this->db->join('organos_entes o', 'a.ente = o.id');
        $this->db->order_by('o.id', "DESC");
        $query = $this->db->get();
        return $query->result();
    }
    
    public function notifications()
    {
		$this->db->select("o.correo, u.id, CONCAT('(', o.siglas,') ' || trim(o.nom_ins)) AS nom_organo, u.is_superuser, u.username, u.first_name, u.cedula, u.is_staff, u.is_active, u.id, u.ente, u.foto,  TRIM(s.comentario) as comentario, s.is_active");
        $this->db->from('send_notifications s');
        $this->db->join('auth_user u', 's.pk_user = u.id');
        $this->db->join('organos_entes o', 'u.ente = o.id');
        $this->db->where('s.is_active', FALSE);
        $this->db->order_by('s.id', "DESC");
        $this->db->order_by('o.nom_ins', "DESC");
        $query = $this->db->get();
        return $query->result();
    }
    
    public function send_notifications($data)
    {
		$this->db->select('fecha_hora');
		$this->db->from('send_notifications');
		$this->db->where('pk_user', $data['pk_user']);
		$get = $this->db->get()->row();
		
		if(isset($get->fecha_hora) == date('Y-m-d', now())){
			return 1;
		}else{
			$this->db->insert("send_notifications", $data);
			return 2;
		}
	}
	
	public function change_status($param)
    {
		$this->db->where('id', $param['id']);
		$result= $this->db->update('auth_user', array('is_active' => $param['is_active']) );
		
		if($result){
			$this->db->where('is_active', FALSE);
			$this->db->where('pk_user', $param['id']);
			$this->db->update('send_notifications', array('is_active' => $param['is_active']));
		}
	}


}
