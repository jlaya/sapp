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
class ModelEstructura extends CI_Model
{

    //put your code here

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Metodo publico, forma de listar los datos
    public function listar()
    {   $query = $this->db->order_by("id", "desc");
        $query = $this->db->get('estructura');

        return $query->result();
    }

    // Metodo publico, forma de insertar los datos
    public function insertar($datos)
    {
        $result = $this->db->where('estructura =', $datos['estructura']);
        $result = $this->db->or_where('codigo = ', $datos['codigo']);
        $result = $this->db->get('estructura');

        if ($result->num_rows() > 0) {
            #echo "CORRECTO";
            echo '1';
        } else {
            $result = $this->db->insert("estructura", $datos);
            return $result;
        }
    }

    // Metodo publico, forma de actualizar los datos
    public function actualizar($datos)
    {
        $result = $this->db->where('id', $datos['id']);
        $result = $this->db->update('estructura', $datos);
        return $result;
    }

    // Metodo publico, forma de eliminar los datos
    public function eliminar($id)
    {
        $result = $this->db->where('id', $id);
        $result = $this->db->delete('estructura');
        return $result;
       
    }

    public function detailList($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('estructura');
        return $query->row();
    }

}
