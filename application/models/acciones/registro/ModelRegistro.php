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
class ModelRegistro extends CI_Model
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
//        $result = $this->db->where('plan_patria =', $datos['plan_patria']);
//        $result = $this->db->or_where('codigo = ', $datos['codigo']);
//        $result = $this->db->get('plan_patria');
//
//        if ($result->num_rows() > 0) {
//            #echo "CORRECTO";
//            echo '1';
//        } else {
        $result = $this->db->insert("acciones_registro", $datos);
        return $result;
//        }
    }

    // Metodo publico, forma de actualizar los datos
    public function actualizar($datos)
    {
        $result = $this->db->where('codigo', $datos['codigo']);
        $result = $this->db->update('acciones_registro', $datos);
        return $result;
    }

    // Metodo publico, forma de eliminar los datos
    public function eliminar($id)
    {
        $result = $this->db->where('estatus', 4);
        $result = $this->db->where('id', $id);
        $result = $this->db->get('acciones_registro');
        #echo $this->db->last_query();

        if ($result->num_rows() > 0) {
            echo 'existe';
        } else {
            $this->db->where('a.id', $id);
            $this->db->delete('acciones_registro a');
            
            $this->db->where('d1.id_acc_reg', $id);
            $this->db->delete('distribucion_actividad d1');
            
            $this->db->where('d2.id_acc_reg', $id);
            $this->db->delete('distribucion_trimestral_actividad d2');
            
            $this->db->where('d3.id_acc_reg', $id);
            $this->db->delete('distribucion_trimestral_financiera d3');
            
            $this->db->where('d4.id_acc_reg', $id);
            $this->db->delete('imp_presupuestaria d4');
            echo 'ok';
        }
    }

    public function detailList($table)
    {
        return $this->db->count_all($table);
    }

    public function datos($codigo)
    {
        $this->db->where('codigo', $codigo);
        $query = $this->db->get('acciones_registro');
        return $query->row();
    }

    // Metodo publico, forma de insertar las actividades para la asociacion de la accion
    public function procesar($P, $id, $datos)
    {
        if ($P == "1") {
            $result = $this->db->where('actividad =', $datos['actividad']);
            $result = $this->db->get('distribucion_actividad');

            if ($result->num_rows() > 0) {
                #echo "CORRECTO";
                echo '1';
            } else {
                $result = $this->db->insert('distribucion_actividad', $datos);
                return $result;
            }
        } else if ($P == "2") {
            $result = $this->db->where('id', $id);
            $result = $this->db->update('distribucion_actividad', $datos);
            return $result;
        } else if ($P == "3") {
            $result = $this->db->where('id', $id);
            $result = $this->db->delete('distribucion_actividad');
            $result = $this->db->where('id_actividad', $id);
            $result = $this->db->delete('distribucion_trimestral_actividad');
            $result = $this->db->where('id_actividad', $id);
            $result = $this->db->delete('distribucion_trimestral_financiera');
            return $result;
        } else if ($P == "4") { // Carga dinamica de las cifras trimestrales de las actividades
            #print_r($datos);
            $result = $this->db->where('id_actividad', $id);
            $result = $this->db->update('distribucion_trimestral_actividad', $datos);
        } else if ($P == "5") { // Carga dinamica de las cifras de las distribucación trimestral financiera
            #print_r($datos);
            $result = $this->db->where('id_actividad', $id);
            $result = $this->db->update('distribucion_trimestral_financiera', $datos);
        } else if ($P == "6") {

            $dato = explode('-', $id);

            $result = $this->db->from('partida_presupuestaria_centralizada');
            $result = $this->db->join('partida_presupuestaria', 'partida_presupuestaria.id = partida_presupuestaria_centralizada.partida_presupuestaria');
            $result = $this->db->where('partida_presupuestaria_centralizada.accion_centralizada', $dato[1]);
            $result = $this->db->get();

            foreach ($result->result() as $value) {
                /* echo $value->id."\n";
                  echo $value->partida_presupuestaria."\n";
                  echo $value->codigo."\n"; */
                $where  = "id_acc_reg=$dato[0] AND partida=$value->id";
                $result = $this->db->where($where);
                $result = $this->db->get('imp_presupuestaria');

                if ($result->num_rows() > 0) {
                    echo "existe";
                } else if ($result->num_rows() == "") {
                    $array = array(
                        'id_acc_reg' => $dato[0],
                        'partida'    => $value->id,
                    );
                    $this->db->insert("imp_presupuestaria", $array);
                }
//                $array = array(
//                    'id_acc_reg' => $dato[0],
//                    'partida'  => $value->id,
//                );
//                $this->db->insert("imp_presupuestaria", $array);
            }
        } else if ($P == "7") { // Carga dinamica de las cifras de las distribucación trimestral financiera
            #print_r($datos);
            $result = $this->db->where('pk', $id);
            $result = $this->db->update('imp_presupuestaria', $datos);
        }
    }

    # Proceso para el registro de la Distribución Trimestral de las actividades segun el id principal

    public function insert_act_trimestral($datos)
    {
        foreach ($datos as $value) {

            $resultA = $this->db->where('id_actividad =', $value->id);
            $resultA = $this->db->get('distribucion_trimestral_actividad');
            $resultB = $this->db->where('id_actividad =', $value->id);
            $resultB = $this->db->get('distribucion_trimestral_financiera');
            if ($resultA->num_rows() > 0 or $resultB->num_rows() > 0) {
                echo 'existe';
                #return true;
            } else if ($resultA->num_rows() == "" or $resultB->num_rows() == "") {
                $array = array(
                    'id_acc_reg'   => $value->id_acc_reg,
                    #'actividad'  => $value->actividad,
                    'id_actividad' => $value->id,
                );
                $this->db->insert("distribucion_trimestral_actividad", $array);
                $this->db->insert("distribucion_trimestral_financiera", $array);
            }
        }
    }

    public function save($data)
    {
        $id                  = $data['id'];
        $datos['accion_id']  = $data['accion_id'];
        $compromiso          = str_replace(".","",$this->input->post('compromiso'));
        $datos['compromiso'] = str_replace(",",".",$compromiso);
        $datos['causado']    = 0.00;
        $datos['pagado']     = 0.00;
        $datos['partida_id'] = $data['partida_id'];
        $datos['acc']        = 2;

        if($id == 0){
            unset($id);
            $query = $this->db->insert("ejecucion_financiera_acc", $datos);
        }else if($id > 0){
            $this->db->where('id', $id);
            $query = $this->db->update('ejecucion_financiera_acc',$datos);
        }

        return $query;
    }

    public function search($param)
    {
        if ($param['acc'] == 1):
            $this->db->select('acc.id, acc.accion_centralizada, ae.accion_especifica');
        $this->db->from('acciones_registro r');
        $this->db->where('r.id', $param['id']);
        $this->db->join('accion_centralizada acc', 'r.acc_centralizada = acc.id');
        $this->db->join('accion_especifica ae', 'acc.id = ae.accion_centralizada');
        $query = $this->db->get();
        endif;
        return $query->row();
    }

    public function deleteActionFAcc($param)
    {
        $this->db->where('id', $param['id']);
        $result = $this->db->delete('ejecucion_financiera_acc');
        return $result;
    }

    public function list_financiero_acc($id)
    {
        $this->db->select("r.id, r.partida_id,CONCAT(trim(to_char(padre,'00')),'.',trim(to_char(partida,'00')) ,'.',trim(to_char(generica,'00')) ,'.',trim(to_char(especifica,'00')) ,'.',trim(to_char(sub_especifica,'00'))) AS estructura, e.descripcion AS partida, r.compromiso, r.causado, r.pagado");
        $this->db->from('ejecucion_financiera_acc r');
        $this->db->join('estructura_presupuestaria AS e', 'r.partida_id = e.id', 'inner');
        $this->db->where('r.accion_id', $id);
        $this->db->where('r.acc', 2);
        $this->db->order_by("e.id", "ASC");
        $query = $this->db->get();
        return $query->result();
    }

    public function pdf($id)
    {
        $this->db->order_by("r.id", "ASC");
        $this->db->select("r.id, CONCAT(trim(to_char(padre,'00')),'.',trim(to_char(partida,'00')) ,'.',trim(to_char(generica,'00')) ,'.',trim(to_char(especifica,'00')) ,'.',trim(to_char(sub_especifica,'00'))) AS estructura, r.partida_id, e.descripcion AS partida, r.compromiso");
        $this->db->from('ejecucion_financiera_acc r');
        $this->db->join('estructura_presupuestaria AS e', 'r.partida_id = e.id', 'inner');
        $this->db->where('r.accion_id', $id);
        $this->db->where('r.acc', 2);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function pdf_acc($id)
    {
        $this->db->order_by("r.id", "ASC");
        $this->db->select("r.id, CONCAT(trim(to_char(padre,'00')),'.',trim(to_char(partida,'00')) ,'.',trim(to_char(generica,'00')) ,'.',trim(to_char(especifica,'00')) ,'.',trim(to_char(sub_especifica,'00'))) AS estructura, r.partida_id, e.descripcion AS partida, r.compromiso AS monto");
        $this->db->from('ejecucion_financiera_acc r');
        $this->db->join('estructura_presupuestaria AS e', 'r.partida_id = e.id', 'inner');
        $this->db->where('r.accion_id', $id);
        $this->db->where('r.acc', 2);
        $query = $this->db->get();
        return $query->result();
    }

}
