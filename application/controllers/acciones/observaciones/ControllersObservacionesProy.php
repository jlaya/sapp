<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllersObservacionesProy
 *
 * @author ING: Jesus Laya
 */
class ControllersObservacionesProy extends CI_Controller
{

    //put your code here

    public function __construct()
    {
        parent::__construct();
        $this->load->model('acciones/observaciones/ModelObservacionesProy'); # Llamado a el modelo de Plan de gobierno
        $this->load->model('entes/ModelEntes'); # Llamado a el modelo de Entes
    }

    public function index()
    {
        if (isset($this->session->userdata['logged_in'])):
            if ($this->session->userdata['logged_in']['is_superuser'] == 'f'):
                $sql = "SELECT p.codigo,o.cierre,o.id_accion,o.id,o.ano_fiscal,o.estatus,o.revisado,o.estructura,org.nom_ins FROM observaciones_acciones_proy AS o INNER JOIN proyecto_registro AS p ON(o.id_accion=p.id) INNER JOIN organos_entes AS org ON(p.ente=org.id) WHERE o.cierre = 1 AND p.cierre = 1 AND o.organo = $this->session->userdata['logged_in']['pk']";
            else:
                $sql = "SELECT p.codigo,o.cierre,o.id_accion,o.id,o.ano_fiscal,o.estatus,o.revisado,o.estructura,org.nom_ins FROM observaciones_acciones_proy AS o INNER JOIN proyecto_registro AS p ON(o.id_accion=p.id) INNER JOIN organos_entes AS org ON(p.ente=org.id) WHERE o.cierre = 1 AND p.cierre = 1";
            endif;

            $accion = $this->ModelStandard->query_set($sql, 'result');

            $datos['list_observaciones'] = $accion;
            $datos['lista_modulo']       = $this->ModelEntes->listar_table('modulo');
            $datos['lista_sub_modulo']   = $this->ModelEntes->listar_table('sub_modulo');
            $this->load->view("base/Base", $datos);
            $this->load->view("acciones/observaciones/ViewObjPLista", $datos);
            else:
                $header = base_url() . "?error=1";
            header("location: " . $header);
            endif;
        }

        public function nuevo()
        {
            $datos['codigo']           = $this->ModelStandard->count_all_table('observaciones_acciones');
            $datos['lista_modulo']     = $this->ModelEntes->listar_table('modulo');
            $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
            $datos['organos']          = $this->ModelEntes->listar('organos_entes');
            $datos['acc_centralizada'] = $this->ModelEntes->listar('accion_centralizada');
            $this->load->view("base/Base", $datos);
            $this->load->view("acciones/observaciones/ViewObjPAdd", $datos);
        }

        public function guardar()
        {
            $this->ModelObservacionesProy->insertar($this->input->post());
        // =========================================================================
        // Proceso de bitacora
        // =========================================================================
        $time   = "%h:%i %a"; // Se captura la hora actual
        $datos  = array(
            'modulo'              => 'OBSERVACIÓN DE REGISTRO DE ANTE PROYECTO (TABLA observaciones_acciones_proy)',
            'accion'              => 'NUEVA INGRESO DE OBSERVACIONES PARA EL REGISTRO DE ANTE PROYECTO',
            'id_usuario'          => $this->session->userdata['logged_in']['id'],
            'fecha_registro'      => date('Y-m-d', now()),
            'fecha_actualizacion' => NULL,
            'hora_registro'       => mdate($time),
            'hora_actualizacion'  => NULL,
            'ip'                  => $_SERVER['REMOTE_ADDR'],
            );
        $result = $this->ModelStandard->bitacora($datos);
        // =========================================================================
    }

    public function modificar()
    {   
        $param = $this->input->post();
        $this->ModelObservacionesProy->modificar($param);
        // =========================================================================
        // Proceso de bitacora
        // =========================================================================
        $time  = "%h:%i %a"; // Se captura la hora actual
        $datos = array(
            'modulo'              => 'OBSERVACIÓN DE REGISTRO DE ANTE PROYECTO (TABLA observaciones_acciones_proy)',
            'accion'              => 'NUEVA ACTUALIZACIÓN DE OBSERVACIONES PARA EL REGISTRO DE ANTE PROYECTO',
            'id_usuario'          => $this->session->userdata['logged_in']['id'],
            'fecha_registro'      => NULL,
            'fecha_actualizacion' => date('Y-m-d', now()),
            'hora_registro'       => NULL,
            'hora_actualizacion'  => mdate($time),
            'ip'                  => $_SERVER['REMOTE_ADDR'],
            );
        $this->ModelStandard->bitacora($datos);
        // =========================================================================
    }

    public function procesar($id)
    {
        $datos['detalles_lista']     = $this->ModelObservacionesProy->datos($id);
        
        
        /*echo $this->db->last_query();
        exit;*/
        
        $datos['lista_modulo']       = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo']   = $this->ModelEntes->listar_table('sub_modulo');
        $datos['organos']            = $this->ModelEntes->listar('organos_entes');
        $datos['acc_centralizada']   = $this->ModelEntes->listar('accion_centralizada');
        $datos['partida']           = $this->ModelEntes->listar('partida_presupuestaria');
        //$id                          = $datos['detalles_lista']->id;
        $id_accion                   = $datos['detalles_lista']->id_accion;
        $select                      = 'd.id,p.codigo,p.partida_presupuestaria,d.cantidad,d.s_cons,d.g_fiscal,d.fci,d.ticr,d.m_asig';
        $datos['imp_presupuestaria'] = $this->ModelStandard->join_table_select('distribucion_trimestral_imp_pre d', 'partida_presupuestaria p', 'd.denominacion', 'p.id', 'd.pk', $id_accion, $select);
        $sql = "SELECT d.id, p.codigo, p.partida_presupuestaria, d.s_cons, d.c_adicional, d.fcie, d.i_p, d.m_asig FROM imp_presupuestaria_modificado d JOIN partida_presupuestaria p ON d.partida_id=p.id INNER JOIN acciones_registro AS acc ON(acc.id = d.pk) WHERE d.id_acc_reg = $id_accion";
        $datos['distribucion_mod'] = $this->ModelStandard->query_set($sql, 'result');
        $this->load->view("base/Base", $datos);
        $this->load->view('acciones/observaciones/ViewObjPUpdate', $datos);
    }

    public function delete($id)
    {
        $this->ModelObservacionesProy->eliminar($id);
    }

    // Método publico para traer las lineas estrategicas segun la asociacion con el plan de la nacion
    public function ajax_search($id, $ano_fiscal)
    {
        $sql  = "SELECT * FROM proyecto_registro WHERE ente = $id AND ano_fiscal = $ano_fiscal AND cierre = 1";
        $ajax = $this->ModelStandard->query_set($sql, 'result');
        //echo $this->db->last_query();
        echo json_encode($ajax);
    }

    // Método publico para traer las lineas estrategicas segun la asociacion con el plan de la nacion
    public function ajax_table($id)
    {
        $result = $this->ModelObservacionesProy->ajax_table($id);
        echo json_encode($result);
    }

    // Método publico para traer todas las Acciones Centralizadas asociadas al Organismo seleccionado
    public function ajax_table_busqueda($id)
    {
        $result = $this->ModelStandard->search_element('organo', 'observaciones_acciones', 'row', $id);
        echo json_encode($result);
    }

    public function cargar($id)
    {
        $dato = explode('-', $id);

        if ($dato[1] == "") {
            $s_cons = null;
        } else {
            $s_cons = $dato[1];
        }
        if ($dato[2] == "") {
            $g_fiscal = null;
        } else {
            $g_fiscal = $dato[2];
        }
        if ($dato[3] == "") {
            $fci = null;
        } else {
            $fci = $dato[3];
        }
        if ($dato[4] == "") {
            $ticr = null;
        } else {
            $ticr = $dato[4];
        }
        if ($dato[5] == "") {
            $m_asig = null;
        } else {
            $m_asig = $dato[5];
        }

        $id = $dato[0];

        $datos = array(
            's_cons'   => $s_cons,
            'g_fiscal' => $g_fiscal,
            'fci'      => $fci,
            'ticr'     => $ticr,
            'm_asig'   => $m_asig,
            );

        $this->ModelObservacionesProy->procesar($id, $datos);
    }

    public function monto_modificado()
    {   
        $post = $this->input->post();
        $id = $post['id'];
        if($id == ""){
            $id = $id;
            $data['id_acc_reg']  = $post['id_acc_reg'];
            $data['partida_id']  = $post['partida_id'];
            $data['m_asig']      = $post['m_asig'];
        }else{
            $data['m_asig']      = $post['m_asig'];
        }
        $data['accion']      = 2;
        
        if ($post['s_cons'] == "") { $data['s_cons'] = NULL; } else { $data['s_cons'] = $post['s_cons']; }
        if ($post['c_adicional'] == "") { $data['c_adicional'] = NULL; } else { $data['c_adicional'] = $post['c_adicional']; } 
        if ($post['fcie'] == "") { $data['fcie'] = NULL; } else { $data['fcie'] = $post['fcie']; } 
        if ($post['i_p'] == "") { $data['i_p'] = NULL; } else { $data['i_p'] = $post['i_p']; }

        $this->ModelObservacionesProy->monto_modificado($id, $data);
    }

}
