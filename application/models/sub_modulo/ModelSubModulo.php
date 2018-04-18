<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ModelPrueba
 *
 * @author jesus
 */
class ModelSubModulo extends CI_Model
{

    //put your code here

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Metodo publico, forma de insertar los datos
    public function insertar($datos)
    {
        #$result = $this->db->where('sub_modulo =', $datos['sub_modulo']);
        $result = $this->db->where('url =', $datos['url']);
        $result = $this->db->get('sub_modulo');

        if ($result->num_rows() > 0) {
            #echo "CORRECTO";
            echo '1';
        } else {
            $result = $this->db->insert("sub_modulo", $datos);
            return $result;
        }
    }

    // Metodo publico, forma de actualizar los datos
    public function actualizar($datos)
    {
        $result = $this->db->where('id', $this->input->post('id'));
        $result = $this->db->update('sub_modulo', $datos);
        return $result;
    }

    // Metodo publico, forma de eliminar los datos
    public function eliminar($id)
    {
        $result = $this->db->where('id', $id);
        $result = $this->db->delete('sub_modulo');
        return $result;
        
    }

    public function detailList($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('sub_modulo');
        return $query->row();
    }

}
