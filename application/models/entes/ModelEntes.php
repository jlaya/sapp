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
class ModelEntes extends CI_Model
{

    //put your code here

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Metodo publico, forma de listar los datos
    public function listar($table)
    {
        $query = $this->db->order_by("id", "desc");
        $query = $this->db->get($table);
        return $query->result();
    }

    public function listar_table($table)
    {
        $query = $this->db->order_by("posicion", "asc");
        $query = $this->db->get($table);
        return $query->result();
    }

    public function listar_join()
    {
        $query = $this->db->select('*');
        $query = $this->db->from('modulo');
        $query = $this->db->join('sub_modulo', 'modulo.id = sub_modulo.id_modulo');
        $query = $this->db->get();
        #print_r($query);
        return $query->result();
    }

    // Metodo publico, forma de insertar los datos
    public function insertar($datos)
    {

        $result = $this->db->where('nom_ins =', $datos['nom_ins']);
        $result = $this->db->or_where('siglas =', $datos['siglas']);
        $result = $this->db->get('organos_entes');

        if ($result->num_rows() > 0) {
            #echo "CORRECTO";
            echo '1';
        } else {

            $result = $this->db->insert("organos_entes", $datos);
            return $result;
        }
    }

    // Metodo publico, forma de actualizar los datos
    public function actualizar($datos)
    {   
        $this->db->where('id', $datos['id']);
        $result = $this->db->update('organos_entes', $datos);
        if($result){
            /* ========================================== */
            $this->db->where('ente', $datos['id']);
            $data['cargo']       = $datos['cargo'];
            $data['m_autoridad'] = $datos['nom_resp'];
            $data['tlf']         = $datos['tlf'];
            $data['correo']      = $datos['correo'];
            $this->db->update('acciones_registro', $data);
            /* ========================================== */
            $this->db->where('ente', $datos['id']);
            $datas['cargo']       = $datos['cargo'];
            $datas['responsable'] = $datos['nom_resp'];
            $datas['tlf']         = $datos['tlf'];
            $datas['correo']      = $datos['correo'];
            $this->db->update('proyecto_registro', $datas);
            /* ========================================== */
        }
        return $result;
    }

    // Metodo publico, forma de eliminar los datos
    public function eliminar($id)
    {
        $result = $this->db->where('id', $id);
        $result = $this->db->delete('organos_entes');
        return $result;
    }

    public function detailList($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('organos_entes');
        return $query->row();
    }

}
