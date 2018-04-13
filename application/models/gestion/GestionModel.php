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
class GestionModel extends CI_Model
{

    //put your code here
    private $table_acc = 'acciones_registro';
    private $table_proy = 'proyecto_registro';
    private $table_sis_configuracion = 'sis_configuracion';
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_detaill($id)
    {
        $this->db->select('b.estruc_presupuestaria, a.nom_ins, c.accion_centralizada, d.accion_especifica');
        $this->db->from("organos_entes a");
        $this->db->join('acciones_registro AS b', 'a.id = b.ente', 'inner');
        $this->db->join('accion_centralizada AS c', 'c.id = b.acc_centralizada', 'inner');
        $this->db->join('accion_especifica AS d', 'd.accion_centralizada = b.acc_centralizada', 'inner');
        $this->db->where('b.id', $id);
        $this->db->order_by('a.id', "ASC");
        $query = $this->db->get();
        return $query->row();
    }

    public function get_detaill_proy($id)
    {
        $this->db->select('b.estruc_presupuestaria, a.nom_ins, c.accion_centralizada, d.accion_especifica');
        $this->db->from("organos_entes a");
        $this->db->join('proyecto_registro AS b', 'a.id = b.ente', 'inner');
        $this->db->join('accion_centralizada AS c', 'c.id = b.accion', 'inner');
        $this->db->join('accion_especifica AS d', 'd.accion_centralizada = b.accion', 'inner');
        $this->db->where('b.id', $id);
        $this->db->order_by('a.id', "ASC");
        $query = $this->db->get();
        return $query->row();
    }

    public function get_detaill_mount($id)
    {   
        $this->db->select('SUM(i.m_asig) AS m_asig');
        $this->db->from('acciones_registro a');
        $this->db->join('imp_presupuestaria i', 'a.id = i.id_acc_reg');
        $this->db->where('i.id_acc_reg', $id);
        $result = $this->db->get();
        return $result->row();
    }

    public function get_detaill_mount_proy($id)
    {   
        $this->db->select('SUM(i.m_asig) AS m_asig');
        $this->db->from('acciones_registro a');
        $this->db->join('distribucion_trimestral_imp_pre i', 'a.id = i.pk');
        $this->db->where('i.pk', $id);
        $result = $this->db->get();
        return $result->row();
    }

    public function get_meta_financiera($id, $acc)
    {
        $this->db->select("r.id, r.partida_id,CONCAT(trim(to_char(padre,'00')),'.',trim(to_char(partida,'00')) ,'.',trim(to_char(generica,'00')) ,'.',trim(to_char(especifica,'00')) ,'.',trim(to_char(sub_especifica,'00'))) AS estructura, e.descripcion AS partida, r.compromiso, r.causado, r.pagado");
        $this->db->from('ejecucion_financiera_acc r');
        $this->db->join('estructura_presupuestaria AS e', 'r.partida_id = e.id', 'inner');
        $this->db->where('r.accion_id', $id);
        $this->db->where('r.acc', $acc);
        $this->db->order_by("r.id", "ASC");
        $query = $this->db->get();
        return $query->result();
    }

    // Accion centralizada con estatus aprobado
    public function busqueda_aprobado($table, $ano_fiscal)
    {
        $pk_organo = $this->session->userdata['logged_in']['pk'];
        $this->db->select('r.id,r.codigo,o.siglas,o.nom_ins');
        $this->db->from("$table r");
        $this->db->join('organos_entes AS o', 'r.ente = o.id', 'inner');
        $this->db->where('r.estatus', 4);
        $this->db->where('r.ano_fiscal', $ano_fiscal);
        if ($this->session->userdata['logged_in']['is_superuser'] == 'f'){
            $this->db->where('r.ente', $pk_organo);
        }
        $this->db->order_by('r.id', "ASC");
        $query = $this->db->get();
        return $query->result();
    }

    public function busqueda_proy()
    {
        $this->db->where('estatus', 4);
        $this->db->where('ano_fiscal', date('Y', now()));
        $this->db->order_by('codigo', 'ASC');
        $query = $this->db->get('proyecto_registro');
        return $query->result();
    }

    public function search($param)
    {
        $this->db->select('org.nom_ins');
        $this->db->from($param['table']." AS r");
        $this->db->where('r.id', $param['id']);
        $this->db->join('organos_entes org', 'r.ente = org.id');
        $query = $this->db->get();
        
        return $query->row();
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
        $datos['acc']        = $data['acc'];
        
        if($id == 0){
            unset($id);
            $query = $this->db->insert("ejecucion_financiera_acc", $datos);
        }else if($id > 0){
            $this->db->where('id', $id);
            $this->db->where('acc', $data['acc']);
            $query = $this->db->update('ejecucion_financiera_acc',$datos);
        }

        return $query;
    }

    public function list_financiero_acc($param)
    {
        $this->db->select("r.id, r.partida_id,CONCAT(trim(to_char(padre,'00')),'.',trim(to_char(partida,'00')) ,'.',trim(to_char(generica,'00')) ,'.',trim(to_char(especifica,'00')) ,'.',trim(to_char(sub_especifica,'00'))) AS estructura, e.descripcion AS partida, r.compromiso, r.causado, r.pagado");
        $this->db->from('ejecucion_financiera_acc r');
        $this->db->join('estructura_presupuestaria AS e', 'r.partida_id = e.id', 'inner');
        $this->db->where('r.accion_id', $param['id']);
        $this->db->where('r.acc', $param['acc']);
        $this->db->order_by("r.id", "ASC");
        $query = $this->db->get();
        return $query->result();
    }

    // Listado de Acciones Ejecucion Financiera
    public function list_actividad_acc($id)
    {
        $this->db->select("a.id, a.actividad,a.medio_verificacion, a.unidad_medida, b.trimestre_i, b.trimestre_ii, b.trimestre_iii, b.trimestre_iv, a.cantidad,((a.i)+(a.ii)+(a.iii)+(a.iv)) AS ejecutado, a.i, a.ii, a.iii, a.iv,to_char(float8 (a.i)/NULLIF(b.trimestre_i, 0) *100, 'FM999999999.00') AS porcentaje");
        $this->db->from('distribucion_actividad  AS a');
        $this->db->join('distribucion_trimestral_actividad AS b', 'a.id=b.id_actividad', 'inner');
        $this->db->where('a.id_acc_reg', $id);
        $this->db->order_by("a.id", "ASC");
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    // Trimestre I
    public function list_actividad_acc_trimestre_i($id)
    {
        $this->db->select("a.id, a.actividad,a.medio_verificacion, a.unidad_medida, b.trimestre_i, b.trimestre_ii, b.trimestre_iii, b.trimestre_iv, a.cantidad,((a.i)+(a.ii)+(a.iii)+(a.iv)) AS ejecutado, a.i, a.ii, a.iii, a.iv,to_char(float8 (a.i)/NULLIF(b.trimestre_i, 0) *100, 'FM999999999.00') AS porcentaje");
        $this->db->from('distribucion_actividad  AS a');
        $this->db->join('distribucion_trimestral_actividad AS b', 'a.id=b.id_actividad', 'inner');
        $this->db->where('a.id_acc_reg', $id);
        $this->db->order_by("a.id", "ASC");
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    // Trimestre II
    public function list_actividad_acc_trimestre_ii($id)
    {
        $this->db->select("a.id, a.actividad,a.medio_verificacion, a.unidad_medida, b.trimestre_i, b.trimestre_ii, b.trimestre_iii, b.trimestre_iv, a.cantidad,((a.i)+(a.ii)+(a.iii)+(a.iv)) AS ejecutado, a.i, a.ii, a.iii, a.iv,to_char(float8 (a.ii)/NULLIF(b.trimestre_ii, 0) *100, 'FM999999999.00') AS porcentaje");
        $this->db->from('distribucion_actividad  AS a');
        $this->db->join('distribucion_trimestral_actividad AS b', 'a.id=b.id_actividad', 'inner');
        $this->db->where('a.id_acc_reg', $id);
        $this->db->order_by("a.id", "ASC");
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    // Trimestre III
    public function list_actividad_acc_trimestre_iii($id)
    {
        $this->db->select("a.id, a.actividad,a.medio_verificacion, a.unidad_medida, b.trimestre_i, b.trimestre_ii, b.trimestre_iii, b.trimestre_iv, a.cantidad,((a.i)+(a.ii)+(a.iii)+(a.iv)) AS ejecutado, a.i, a.ii, a.iii, a.iv,to_char(float8 (a.iii)/NULLIF(b.trimestre_iii, 0) *100, 'FM999999999.00') AS porcentaje");
        $this->db->from('distribucion_actividad  AS a');
        $this->db->join('distribucion_trimestral_actividad AS b', 'a.id=b.id_actividad', 'inner');
        $this->db->where('a.id_acc_reg', $id);
        $this->db->order_by("a.id", "ASC");
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    // Trimestre IV
    public function list_actividad_acc_trimestre_iv($id)
    {
        $this->db->select("a.id, a.actividad,a.medio_verificacion, a.unidad_medida, b.trimestre_i, b.trimestre_ii, b.trimestre_iii, b.trimestre_iv, a.cantidad,((a.i)+(a.ii)+(a.iii)+(a.iv)) AS ejecutado, a.i, a.ii, a.iii, a.iv,to_char(float8 (a.iv)/NULLIF(b.trimestre_iv, 0) *100, 'FM999999999.00') AS porcentaje");
        $this->db->from('distribucion_actividad  AS a');
        $this->db->join('distribucion_trimestral_actividad AS b', 'a.id=b.id_actividad', 'inner');
        $this->db->where('a.id_acc_reg', $id);
        $this->db->order_by("a.id", "ASC");
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    // Listado de Proyecto Ejecucion Financiera
    public function list_actividad_proy($id)
    {
        $this->db->select("a.id, a.acc_esp, a.unidad_medida,a.medio_verificacion, a.trimestre_i, a.trimestre_ii, a.trimestre_iii, a.trimestre_iv, a.total, a.i, a.ii, a.iii, a.iv,((a.i)+(a.ii)+(a.iii)+(a.iv)) AS ejecutado,to_char(float8 (a.i)/NULLIF(a.trimestre_i, 0) *100, 'FM999999999.00') AS porcentaje");
        $this->db->from('distribucion_acc_especifica  AS a');
        $this->db->where('a.pk', $id);
        $query = $this->db->get();
        return $query->result();
    }

    // I
    public function list_actividad_proy_i($id)
    {
        $this->db->select("a.id, a.acc_esp, a.unidad_medida,a.medio_verificacion, a.trimestre_i, a.trimestre_ii, a.trimestre_iii, a.trimestre_iv, a.total, a.i, a.ii, a.iii, a.iv,((a.i)+(a.ii)+(a.iii)+(a.iv)) AS ejecutado,to_char(float8 (a.i)/NULLIF(a.trimestre_i, 0) *100, 'FM999999999.00') AS porcentaje");
        $this->db->from('distribucion_acc_especifica  AS a');
        $this->db->where('a.pk', $id);
        $query = $this->db->get();
        return $query->result();
    }

    // II
    public function list_actividad_proy_ii($id)
    {
        $this->db->select("a.id, a.acc_esp, a.unidad_medida,a.medio_verificacion, a.trimestre_i, a.trimestre_ii, a.trimestre_iii, a.trimestre_iv, a.total, a.i, a.ii, a.iii, a.iv,((a.i)+(a.ii)+(a.iii)+(a.iv)) AS ejecutado,to_char(float8 (a.ii)/NULLIF(a.trimestre_ii, 0) *100, 'FM999999999.00') AS porcentaje");
        $this->db->from('distribucion_acc_especifica  AS a');
        $this->db->where('a.pk', $id);
        $query = $this->db->get();
        return $query->result();
    }

    // III
    public function list_actividad_proy_iii($id)
    {
        $this->db->select("a.id, a.acc_esp, a.unidad_medida,a.medio_verificacion, a.trimestre_i, a.trimestre_ii, a.trimestre_iii, a.trimestre_iv, a.total, a.i, a.ii, a.iii, a.iv,((a.i)+(a.ii)+(a.iii)+(a.iv)) AS ejecutado,to_char(float8 (a.iii)/NULLIF(a.trimestre_iii, 0) *100, 'FM999999999.00') AS porcentaje");
        $this->db->from('distribucion_acc_especifica  AS a');
        $this->db->where('a.pk', $id);
        $query = $this->db->get();
        return $query->result();
    }

    // IV
    public function list_actividad_proy_iv($id)
    {
        $this->db->select("a.id, a.acc_esp, a.unidad_medida,a.medio_verificacion, a.trimestre_i, a.trimestre_ii, a.trimestre_iii, a.trimestre_iv, a.total, a.i, a.ii, a.iii, a.iv,((a.i)+(a.ii)+(a.iii)+(a.iv)) AS ejecutado,to_char(float8 (a.iv)/NULLIF(a.trimestre_iv, 0) *100, 'FM999999999.00') AS porcentaje");
        $this->db->from('distribucion_acc_especifica  AS a');
        $this->db->where('a.pk', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function list_estructura()
    {   
        $this->db->order_by("e.id", "ASC");
        $this->db->select("e.id, CONCAT(padre,'.',trim(to_char(partida,'00')) ,'.',trim(to_char(generica,'00')) ,'.',trim(to_char(especifica,'00')) ,'.',trim(to_char(sub_especifica,'00'))) AS partida, e.descripcion");
        $this->db->from('estructura_presupuestaria  AS e');
        $query = $this->db->get();
        return $query->result();
    }

    // Other data gestion proyecto
    public function proy_other($id)
    {   
        $this->db->select("da.id,da.proyecto_id,da.beneficiario,da.avance_fisico,da.municipio_ids,da.resumen,da.avatar_grafico_1,da.avatar_foto_1,da.indicador,da.avatar_foto_2,da.avatar_foto_3,da.avatar_foto_4,da.avatar_grafico_2,da.avatar_grafico_3,da.avatar_grafico_4");
        $this->db->from('gestion_proyecto  AS da');
        $this->db->join('proyecto_registro AS ar', 'da.proyecto_id=ar.id', 'inner');
        $this->db->order_by("da.id", "ASC");
        $this->db->where('da.proyecto_id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    
    // Lista de ejecucion financiera original
    public function list_eje_fin_original($id, $pk)
    {   
        $this->db->select("da.id, da.pk_accion, da.pk_proyecto, da.presupuesto_original, da.aumentado, da.aumentado, da.acordado, da.acordado, da.causado, CONCAT(to_char(float8 (da.causado/da.acordado)*100, 'FM9999999990.00'),'%') as porcentaje, (da.causado/da.acordado)*100 as porcentaje_real");
        $this->db->from('ejecucion_financiera_original  AS da');
        $this->db->join('acciones_registro AS ar', "da.$pk=ar.id", 'inner');
        $this->db->order_by("da.id", "ASC");
        $this->db->where("da.$pk", $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function updateAction($data)
    {
        $id           = $data['id_acc'];
        $datos['i']   = ($data['I'] == "") ? 0 : $data['I'];
        $datos['ii']  = ($data['II'] == "") ? 0 : $data['II'];
        $datos['iii'] = ($data['III'] == "") ? 0 : $data['III'];
        $datos['iv']  = ($data['IV'] == "") ? 0 : $data['IV'];
        $this->db->where('id', $id);
        $this->db->update($data['table'],$datos);
    }
    
    // Ejecucion financiera original de Accion, Proyecto
    public function ejecucion_fin_original($data)
    {
        $id = $data['id'];
        
        if($id == 0){
			unset($data['id']);
            $query = $this->db->insert("ejecucion_financiera_original", $data);
        }else if($id > 0){
            $this->db->where('id', $id);
            if($data['pk_accion'] > 0){
				$this->db->where('pk_accion', $data['pk_accion']);
			}else if($data['pk_proyecto'] > 0){
				$this->db->where('pk_proyecto', $data['pk_proyecto']);
			}
            $query = $this->db->update("ejecucion_financiera_original",$data);
        }
        
        return $query;
    }

    public function updateActionFAcc($data)
    {
        $id                  = $data['id'];
        $datos['accion_id']  = $data['accion_id'];
        $datos['compromiso'] = $data['compromiso'];
        $datos['causado']    = $data['causado'];
        $datos['pagado']     = $data['pagado'];
        $datos['partida_id'] = $data['partida_id'];
        $datos['indice']     = $data['indice'];

        if($id == 0){
            unset($id);
            $datos['acc']     = 1;
            $query = $this->db->insert("ejecucion_financiera_acc", $datos);
        }else if($id > 0 AND $datos['indice'] > 0){
            $this->db->where('id', $id);
            $this->db->where('acc', 1);
            $this->db->or_where('indice', $datos['indice']);
            $this->db->where('accion_id', $datos['accion_id']);
            $query = $this->db->update('ejecucion_financiera_acc',$datos);
        }

        return $query;
    }

    // Array file
    public function reArrayFiles(&$file_post) {

        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);

        for ($i=0; $i<$file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }

        return $file_ary;
    }


    public function send_proy($data)
    {
        if($data['id'] == 0){
            unset($data['id']);
            $query = $this->db->insert("gestion_proyecto", $data);
        }else if($data['id'] > 0){
            $this->db->where('id', $data['id']);
            $this->db->where('proyecto_id', $data['proyecto_id']);
            $query = $this->db->update('gestion_proyecto',$data);
        }

       //echo $this->db->last_query(); 

        return $query;
    }


    public function deleteActionFAcc($param)
    {
        $this->db->where('id', $param['id']);
        $result = $this->db->delete('ejecucion_financiera_acc');
        return $result;
    }


    public function count_cumplido_acc($id){
        $this->db->select('count(id) AS cumplido');
        $this->db->from('distribucion_actividad AS d');
        $this->db->where('d.id_acc_reg',$id);
        $this->db->where('d.cump_trimestral = d.prog_trimestral');
        $this->db->where('d.cump_trimestral != 0');
        $this->db->where('d.prog_trimestral != 0');
        $query = $this->db->get();
        return $query->row();
    }

    public function count_no_cumplido_acc($id){
        $this->db->select('count(id) AS no_cumplido');
        $this->db->from('distribucion_actividad AS d');
        $this->db->where('d.id_acc_reg',$id);
        $this->db->where('d.cump_trimestral < d.prog_trimestral');
        $this->db->where('d.cump_trimestral != 0');
        $this->db->where('d.prog_trimestral != 0');
        $query = $this->db->get();
        return $query->row();
    }
    
    // Graficos
    public function grafico($param)
    {
		$this->db->select("CONCAT(a.ano_fiscal || ' (', COUNT(a.id),')') AS name, COUNT(a.id) AS y");
        $this->db->from($param['table']." AS a");
        $this->db->where('a.estatus', 4);
        if(isset($param['acc']) == 1){
			$this->db->where("EXTRACT(MONTH FROM a.fecha_elaboracion) IN(".$param['trimestre'].")");
		}
        $this->db->group_by('a.ano_fiscal');
        $this->db->order_by('a.ano_fiscal', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
    
    // Hacer que sea por trimestre y por ano fiscal
    public function organos_entes($param)
    {
		$this->db->select("CONCAT(s.sector || ' (', COUNT(s.id),')') AS name, count(s.id) AS y");
        $this->db->from("sectores AS s");
        $this->db->join("organos_entes AS o", "o.sector=s.id", "inner");
        $this->db->join($param['table']." AS acc", "acc.ente=o.id", "inner");
        $this->db->where('acc.estatus', 4);
        $this->db->where('acc.ano_fiscal', $param['ano_fiscal']);
        if(isset($param['acc']) == 1){
			$this->db->where("EXTRACT(MONTH FROM acc.fecha_elaboracion) IN(".$param['trimestre'].")");
		}
        $this->db->group_by('s.codigo, s.sector');
        $this->db->order_by('s.codigo', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    // Accion centralizada y proyecto con sus distintos filtros
    public function search_aprobado($table, $ano_fiscal, $acc)
    {
        $this->db->select('r.id,r.codigo,o.siglas,o.nom_ins');
        $this->db->from("$table r");
        $this->db->join('organos_entes AS o', 'r.ente = o.id', 'inner');
        $this->db->where('r.estatus', 4);
        $this->db->where('r.cierre',$acc);
        $this->db->where('r.ano_fiscal', $ano_fiscal);
        $this->db->order_by('r.id', "ASC");
        $query = $this->db->get();
        return $query->result();
    }

    public function save_config($data)
    {   
        $acc = $data['cierre'];

        if (isset($data['ids_accion'])) {
            // Accion centralizada
            foreach ($data['ids_accion'] as $key => $value) {
                $ids_value = $value;
                $datos['cierre']     = $acc;
                $this->db->where('id', $ids_value);
                $query = $this->db->update($this->table_acc,$datos);
            }
        }

        if (isset($data['ids_proyecto'])) {
            // Proyecto
            foreach ($data['ids_proyecto'] as $key => $value) {
                $ids_value = $value;
                $datos['cierre']     = $acc;
                $this->db->where('id', $ids_value);
                $query = $this->db->update($this->table_proy,$datos);
            }
        }
    }

    public function get_config_sistem()
    {   
        $this->db->select('a.id, a.i, a.ii, a.iii, a.iv');
        $this->db->where('id', 1);
        $this->db->from("$this->table_sis_configuracion AS a");
        $query = $this->db->get();
        return $query->row();
    }

    public function save_config_sistem($data)
    {   
        $datos['i'] = FALSE;
        $datos['ii'] = FALSE;
        $datos['iii'] = FALSE;
        $datos['iv'] = FALSE;
        if(isset($data['ids_trimestre'][0]) == 1){ $datos['i'] = TRUE; }
        if(isset($data['ids_trimestre'][1]) == 2){ $datos['ii'] = TRUE; }
        if(isset($data['ids_trimestre'][2]) == 3){ $datos['iii'] = TRUE; }
        if(isset($data['ids_trimestre'][3]) == 4){ $datos['iv'] = TRUE; }

        unset($data['ids_trimestre']);
        $this->db->where('id', 1);
        unset($data['id']);
        $query = $this->db->update($this->table_sis_configuracion,$datos); 
    }

}
