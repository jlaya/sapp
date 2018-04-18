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
class ModelObjN extends CI_Model
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
        $result = $this->db->where('objetivo_nacional =',$datos['objetivo_nacional']);
        $result = $this->db->get('objetivo_nacional');

        if ($result->num_rows() > 0) {
            #echo "CORRECTO";
            echo '1';
        } else {
            $result = $this->db->insert("objetivo_nacional", $datos);
            return $result;
        }
    }

    // Metodo publico, forma de actualizar los datos
    public function actualizar($datos)
    {
        $result = $this->db->where('id', $datos['id']);
        $result = $this->db->update('objetivo_nacional', $datos);
        return $result;
    }

    // Metodo publico, forma de eliminar los datos
    public function eliminar($id)
    {
        /* $result = $this->db->where('sector =', $id);
          $result = $this->db->get('accion_centralizada');

          if ($result->num_rows() > 0) {
          #echo "CORRECTO";
          echo 'existe';
          } else { */

        $result = $this->db->where('id', $id);
        $result = $this->db->delete('objetivo_nacional');
        return $result;
        /* } */
    }    
    
    public function detailList($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('objetivo_nacional');
        return $query->row();
    }

}
