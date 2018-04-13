<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_personal extends SI_Model {

    public $table = 'personal_bva';

    public function __construct()
    {
        parent::__construct();

    }

    public function buscar_persona($cedula)
    {
        $query = $this->db->select('p_nombre, s_nombre, p_apellido, s_apellido')
        ->where('cedula',$cedula)
        ->get($this->table);
        $row = $query->row();
        return $row;

    }



}

