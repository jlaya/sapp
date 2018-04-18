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
class ModelPartidaPresupuestariaCentralizada extends CI_Model
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
        /*$result = $this->db->where($datos['codigo']);
        $result = $this->db->get('partida_presupuestaria_centralizada');

        if ($result->num_rows() > 0) {
            #echo "CORRECTO";
            echo '1';
        } else {*/
            $result = $this->db->insert("partida_presupuestaria_centralizada", $datos);
            return $result;
        /*}*/
    }

    // Metodo publico, forma de actualizar los datos
    public function actualizar($datos)
    {
        $result = $this->db->where('id', $datos['id']);
        $result = $this->db->update('partida_presupuestaria_centralizada', $datos);
        return $result;
    }

    // Metodo publico, forma de eliminar los datos
    public function eliminar($id)
    {
        /*$result = $this->db->where('sector =', $id);
        $result = $this->db->get('accion_centralizada');

        if ($result->num_rows() > 0) {
            #echo "CORRECTO";
            echo 'existe';
        } else {*/

            $result = $this->db->where('id', $id);
            $result = $this->db->delete('partida_presupuestaria_centralizada');
            return $result;
        /*}*/
    }

    // Metodo publico, forma de listar los datos de forma dinámica
    public function listar_datos($tabla)
    {
        $query = $this->db->get($tabla);
        return $query->result();
    }

    public function detailList($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('partida_presupuestaria_centralizada');
        return $query->row();
    }

}
