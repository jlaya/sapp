<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ModelStandard
 *
 * @author jesus
 */
class ModelStandard extends CI_Model
{

    //put your code here}
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Método General para la busqueda de registros
    public function search($campo, $table, $id)
    {
        // $result = $this->db->where($campo . '=', $id);
        $this->db->order_by("id","ASC");
        $this->db->where($campo . '=', $id);
        $result = $this->db->get($table);
        return $result->result();
    }
    
     // Metodo global para capturar los grupos de ids
    public function search_in($campo, $table, $id)
    {   $result = $this->db->order_by('id ASC'); // Ordenar por id
    $result = $this->db->where($campo . " IN($id)");
    $result = $this->db->get($table);
    return $result->result();
}

    // Metodo global para capturar un dato en especifico
public function search_in_row($campo, $table, $id)
{
    $result = $this->db->where($campo . " IN($id)");
    $result = $this->db->get($table);
    return $result->row();
}

    // Método General para ejecutar sql personalizados
public function query_set($query,$param)
{
    $result = $this->db->query($query);
    if ($param == "row") {
        $return = $result->row();
    } else if ($param == "result") {
        $return = $result->result();
    }
        return $return; // Salida de la informacion
        
    }
    
    public function busqueda_esp($table,$group_by)
    {   
        $result = $this->db->order_by('id ASC'); // Ordenar por id
        $result = $this->db->group_by($group_by);
        $result = $this->db->get($table);
        return $result->result();
    }
    
    // Método General para la busqueda de registros en especifico row o result
    public function search_element($campo, $table,$param, $id)
    {
        $result = $this->db->where($campo . '=', $id);
        $result = $this->db->get($table);
        
        if ($param == "row") {
            $return = $result->row();
        } else if ($param == "result") {
            $return = $result->result();
        }
        return $return; // Salida de la informacion
    }

    // Método General para la busqueda de 1 campo
    public function join_table_one($tableA, $tableB, $campoA, $campoB)
    {
        $result = $this->db->from($tableA);
        $result = $this->db->join($tableB, $campoA . '=' . $campoB);
        $result = $this->db->get();
        return $result->result();
    }

    // Método General para la busqueda de 2 campos
    public function search_multiple_two($campoA, $campoB, $table, $idA, $idB)
    {
        $result = $this->db->where($campoA . '=', $idA, $campoB . '=', $idB);
        $result = $this->db->get($table);
        return $result->result();
    }

    // Método General para la busqueda de 3 campos
    public function search_multiple_three($campoA, $campoB, $campoC, $table, $idA, $idB, $idC)
    {
        $result = $this->db->where($campoA . '=', $idA, $campoB . '=', $idB, $campoC . '=', $idC);
        $result = $this->db->get($table);
        return $result->result();
    }

    // Método General para la busqueda de 4 campos
    public function search_multiple_four($campoA, $campoB, $campoC, $campoD, $table, $idA, $idB, $idC, $idD)
    {
        $result = $this->db->where($campoA . '=', $idA, $campoB . '=', $idB, $campoC . '=', $idC, $campoD . '=', $idD);
        $result = $this->db->get($table);
        return $result->result();
    }

    // Método General para buscar el ultimo id del registro
    public function count_all_table($table)
    {
        $query = $this->db->order_by("id", "asc");
        $query = $this->db->get($table);
        return $query->result();
    }
    
    public function count_all_table_all($table)
    {
        $query = $this->db->order_by("id", "desc");
        $query = $this->db->get($table);
        return $query->row();
    }

    // JOIN, Metodo General para la busqueda de 2 tablas
    public function join_table($tableA, $tableB, $campoA, $campoB, $campoC, $id_accion)
    {   
        $result = $this->db->from($tableA);
        $result = $this->db->join($tableB, $campoA . '=' . $campoB);
        $result = $this->db->where($campoC, $id_accion);
        $result = $this->db->order_by($campoB, "ASC");
        $result = $this->db->get();
        return $result->result();
    }

    // JOIN, Metodo General para la busqueda de 2 tablas (registro en especifico)
    public function join_table_row($tableA, $tableB, $campoA, $campoB, $campoC, $id, $valores)
    {
        $result = $this->db->from($tableA);
        $result = $this->db->join($tableB, $campoA . '=' . $campoB);
        $result = $this->db->select($valores);
        $result = $this->db->where($campoC, $id);
        $result = $this->db->get();
        return $result->row();
    }

    // JOIN, Metodo General para la busqueda de 2 tablas (Seleccion de campos)
    public function join_table_select($tableA, $tableB, $campoA, $campoB, $campoC, $id, $valores)
    {
        $result = $this->db->from($tableA);
        $result = $this->db->join($tableB, $campoA . '=' . $campoB);
        $result = $this->db->select($valores);
        $result = $this->db->where($campoC, $id);
        $result = $this->db->get();
        return $result->result();
    }

    // JOIN, Metodo General para la busqueda de 2 tablas
    public function join_table_two($tableA, $tableB, $tableC, $campoA, $campoB, $campoC, $campoD)
    {
        $result = $this->db->from($tableA);
        $result = $this->db->join($tableB, $campoA . '=' . $campoB);
        $result = $this->db->join($tableC, $campoC . '=' . $campoD);
        $result = $this->db->get();
        return $result->result();
    }

    public function join_table_element($tableA, $tableB, $tableC, $campoA, $campoB, $campoC, $campoD,$campo,$valor)
    {
        $result = $this->db->from($tableA);
        $result = $this->db->join($tableB, $campoA . '=' . $campoB);
        $result = $this->db->join($tableC, $campoC . '=' . $campoD);
        $result = $this->db->where($campo, $valor);
        $result = $this->db->get();
        return $result->result();
    }

    // JOIN, Metodo General para la busqueda de 2 tablas (clausula Where)
    public function join_table_select1($tableA, $tableB, $campoA, $campoB, $select)
    {
        $result = $this->db->from($tableA);
        $result = $this->db->join($tableB, $campoA . '=' . $campoB);
        $result = $this->db->select($select);
        $result = $this->db->get();
        return $result->result();
    }

    // JOIN, Metodo General para la busqueda de 2 tablas (Clausula Where)
    public function join_table_where($tableA, $tableB, $campos, $select, $where, $param)
    {
        $result = $this->db->from($tableA);
        $result = $this->db->join($tableB, $campos);
        $result = $this->db->select($select);
        $result = $this->db->where($where);
        $result = $this->db->get();

        if ($param == "row") {
            $return = $result->row();
        } else if ($param == "result") {
            $return = $result->result();
        }
        return $return; // Salida de la informacion
    }
    
    
    public function join_table_two_where($tableA, $tableB, $tableC, $camposA, $camposB,$select,$group_by)
    {   
        $result = $this->db->group_by($group_by);
        $result = $this->db->from($tableA);
        $result = $this->db->join($tableB, $camposA);
        $result = $this->db->join($tableC, $camposB);
        $result = $this->db->select($select);
        $result = $this->db->get();
        return $result->result();
    }

    // Metodo General para formatear fechas
    public function format_fecha($old, $date)
    {
        $result = explode($old, $date);
        $result = $result[2] . "/" . $result[1] . "/" . $result[0];
        return $result;
    }
    
    // Metodo General para almacenar la bitacora de los procesos del usuario
    public function bitacora($datos)
    {
        $result = $this->db->insert("bitacora", $datos);
        return $result;
    }
    
    public function replace_string($a,$b,$id)
    {
        $result = str_replace($a,$b, $id);
        return $result;
    }

    public function listar($table)
    {
        $result = $this->db->get($table);
        return $result->result();
    }

    public function set_userdata_refresh($param)
    {   
        $userdata_refresh = array(
            'username'     => $this->session->userdata['logged_in']['username'],
            'id'           => $this->session->userdata['logged_in']['id'],
            'first_name'   => $this->session->userdata['logged_in']['first_name'],
            'org_id'       => $this->session->userdata['logged_in']['org_id'],
            'pk'           => $this->session->userdata['logged_in']['pk'],
            'is_superuser' => $this->session->userdata['logged_in']['is_superuser'],
            'modulo'       => $this->session->userdata['logged_in']['modulo'],
            'sub_modulo'   => $this->session->userdata['logged_in']['sub_modulo'],
            'agregar'      => $this->session->userdata['logged_in']['agregar'],
            'modificar'    => $this->session->userdata['logged_in']['modificar'],
            'eliminar'     => $this->session->userdata['logged_in']['eliminar'],
            'ver'          => $this->session->userdata['logged_in']['ver'],
            'change_id'    => $this->session->userdata['logged_in']['change_id'],
            'avatar'       => $param['avatar'],
            'titulo'       => $param['titulo'],
            'panel_p'      => $param['panel_p'],
            'panel_s'      => $param['panel_s'],
            'panel_d'      => $param['panel_d']
            );
        return $this->session->set_userdata('logged_in', $userdata_refresh);
    }
    
}
