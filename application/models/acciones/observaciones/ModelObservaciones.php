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
class ModelObservaciones extends CI_Model
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
//        $result = $this->db->where('estructura =', $datos['estructura']);
//        $result = $this->db->get('observaciones_acciones');
//
//        if ($result->num_rows() > 0) {
//            #echo "CORRECTO";
//            echo 'existe';
//        } else {
            // Se procesa la informacion para el registro de la observacion de la Accion Especifica
        $result = $this->db->insert("observaciones_acciones", $datos);
            // Se procesa la informacion para el registro de Acciones de Registro
        $array  = array(
            'reg_res'               => $this->input->post('revisado'),
            'estruc_presupuestaria' => $this->input->post('estructura'),
            'observaciones'         => $this->input->post('observaciones'),
            'estatus'               => $this->input->post('estatus'),
            'fecha_revision'        => $this->input->post('fecha_elaboracion'),
            );
        $this->db->where('id', $datos['id_accion']);
        $this->db->update('acciones_registro', $array);
//        }
    }

    // Metodo publico, forma de actualizar los datos
    public function modificar($param)
    {   // Se procesa la informacion para la Actualizacion de la observacion de la Accion Especifica

        $data = array(
            'estructura'        => $param['estructura'],
            'observaciones'     => $param['observaciones'],
            'estatus'           => $param['estatus'],
            'fecha_elaboracion' => date('Y-m-d',now()),
            );
        
        $this->db->where('id', $param['id']);
        $this->db->update('observaciones_acciones', $data);

        // Se procesa la informacion para la Actualizacion de Acciones de Registro
        $array  = array(
            'estruc_presupuestaria' => $param['estructura'],
            'observaciones'         => $param['observaciones'],
            'estatus'               => $param['estatus'],
            'fecha_revision'        => date('Y-m-d',now()),
            );
        $this->db->where('id', $param['id_accion']);
        $this->db->update('acciones_registro', $array);
    }

    // Metodo publico, forma de eliminar los datos
    public function eliminar($id)
    {   
        $dato = explode('-', $id);
        $array_ids = array(4);
        
        $this->db->where_in('estatus', $array_ids);
        $this->db->where('id', $dato[0]);
        $this->db->where('ano_fiscal', $dato[1]);
        $result = $this->db->get('observaciones_acciones');

        if ($result->num_rows() > 0) {
          #echo "CORRECTO";
          echo 'existe';
      } else {

        $result = $this->db->where('id', $dato[0]);
        $result = $this->db->delete('observaciones_acciones');
        return $result;

    }
}

public function detailList($table)
{
    return $this->db->count_all($table);
}

public function datos($id)
{
    $this->db->where('id_accion', $id);
    $query = $this->db->get('observaciones_acciones');
    return $query->row();
}

public function ajax_table($id)
{
    $result = $this->db->from('acciones_registro a');
    $result = $this->db->join('imp_presupuestaria i', 'a.id = i.id_acc_reg');
    $result = $this->db->where('i.id_acc_reg', $id);
    $result = $this->db->get();
    return $result->result();
}

public function procesar($id, $datos)
{   
    $result = $this->db->where('pk', $id);
    $result = $this->db->update('imp_presupuestaria', $datos);
    return $result;
}

public function monto_modificado($id, $data)
{   
    if($id){
        $this->db->where('id', $id);
        $result = $this->db->update('imp_presupuestaria_modificado', $data);
    }else{
        $result = $this->db->insert("imp_presupuestaria_modificado", $data);
    }
    return $result;
}

}
