<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllersObservaciones
 *
 * @author ING: Jesus Laya
 */
class ControllersObservaciones extends CI_Controller
{

    //put your code here

    public function __construct()
    {
        parent::__construct();
        $this->load->model('acciones/observaciones/ModelObservaciones'); # Llamado a el modelo de Plan de gobierno
        $this->load->model('entes/ModelEntes'); # Llamado a el modelo de Entes
    }

    public function index()
    {
        if (isset($this->session->userdata['logged_in'])):
            if ($this->session->userdata['logged_in']['is_superuser'] == 'f'):
                $sql = "SELECT ob.id,o.nom_ins,ob.ano_fiscal,ob.cierre,ob.estatus,acc.codigo,ob.id_accion,ob.revisado,ob.estructura FROM observaciones_acciones AS ob INNER JOIN organos_entes AS o ON(ob.organo=o.id) INNER JOIN acciones_registro AS acc ON(ob.organo = acc.id) WHERE ob.cierre = 1 AND ob.organo = $this->session->userdata['logged_in']['pk']";
            else:
                $sql = "SELECT ob.id,o.nom_ins,ob.ano_fiscal,ob.cierre,ob.estatus,acc.codigo,ob.id_accion,ob.revisado,ob.estructura FROM observaciones_acciones AS ob INNER JOIN organos_entes AS o ON(ob.organo=o.id) INNER JOIN acciones_registro AS acc ON(ob.organo = acc.id) WHERE ob.cierre = 1";
            endif;
            $accion                      = $this->ModelStandard->query_set($sql, 'result');
            $datos['list_observaciones'] = $accion;
            $datos['lista_modulo']     = $this->ModelEntes->listar_table('modulo');
            $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
            $this->load->view("base/Base", $datos);
            $this->load->view("acciones/observaciones/ViewLista", $datos);
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
            $this->load->view("acciones/observaciones/ViewAdd", $datos);
        }

        public function guardar()
        {
            $this->ModelObservaciones->insertar($this->input->post());
        // =========================================================================
        // Proceso de bitacora
        // =========================================================================
        $time   = "%h:%i %a"; // Se captura la hora actual
        $datos  = array(
            'modulo'              => 'OBSERVACIÓN DE REGISTRO DE ACCIONES CENTRALIZADAS (TABLA observaciones_acciones)',
            'accion'              => 'NUEVO INGRESO DE OBSERVACIONES PARA EL REGISTRO DE ACCIONES CENTRALIZADAS',
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
        $this->ModelObservaciones->modificar($param);
        // =========================================================================
        // Proceso de bitacora
        // =========================================================================
        $time   = "%h:%i %a"; // Se captura la hora actual
        $datos  = array(
            'modulo'              => 'OBSERVACIÓN DE REGISTRO DE ACCIONES CENTRALIZADAS (TABLA observaciones_acciones)',
            'accion'              => 'NUEVA ACTUALIZACIÓN DE OBSERVACIONES PARA EL REGISTRO DE ACCIONES CENTRALIZADAS',
            'id_usuario'          => $this->session->userdata['logged_in']['id'],
            'fecha_registro'      => NULL,
            'fecha_actualizacion' => date('Y-m-d', now()),
            'hora_registro'       => NULL,
            'hora_actualizacion'  => mdate($time),
            'ip'                  => $_SERVER['REMOTE_ADDR'],
            );
        $result = $this->ModelStandard->bitacora($datos);
        // =========================================================================
    }

    public function procesar($id)
    {
        $datos['detalles_lista']     = $this->ModelObservaciones->datos($id);
        $datos['lista_modulo']       = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo']   = $this->ModelEntes->listar_table('sub_modulo');
        $datos['organos']            = $this->ModelEntes->listar('organos_entes');
        $datos['acc_centralizada']   = $this->ModelEntes->listar('accion_centralizada');
        $id_accion                   = $datos['detalles_lista']->id_accion;
        $datos['imp_presupuestaria'] = $this->ModelStandard->join_table('imp_presupuestaria i', 'partida_presupuestaria p', 'i.partida', 'p.id', 'i.id_acc_reg', $id_accion);
        $datos['partida']           = $this->ModelEntes->listar('partida_presupuestaria');
        $sql = "SELECT d.id, p.codigo, p.partida_presupuestaria, d.s_cons, d.c_adicional, d.fcie, d.i_p, d.m_asig FROM imp_presupuestaria_modificado d JOIN partida_presupuestaria p ON d.partida_id=p.id INNER JOIN acciones_registro AS acc ON(acc.id = d.pk) WHERE d.id_acc_reg = $id_accion";
        $datos['distribucion_mod'] = $this->ModelStandard->query_set($sql, 'result');
        $this->load->view("base/Base", $datos);
        $this->load->view('acciones/observaciones/ViewUpdate', $datos);
    }

    public function delete($id)
    {
        $this->ModelObservaciones->eliminar($id);
    }

    // Método publico para traer las lineas estrategicas segun la asociacion con el plan de la nacion
    public function ajax_search($id, $ano_fiscal)
    {
        $sql  = "SELECT * FROM acciones_registro WHERE ente = $id AND ano_fiscal = $ano_fiscal AND cierre = 1";
        $ajax = $this->ModelStandard->query_set($sql, 'result');
        
        /*echo $this->db->last_query();
        exit;*/
        
        
        echo json_encode($ajax);
    }

    // Método publico para traer las lineas estrategicas segun la asociacion con el plan de la nacion
    public function ajax_table($id)
    {
        $result = $this->ModelObservaciones->ajax_table($id);
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

        $array = array(
            's_cons'   => $s_cons,
            'g_fiscal' => $g_fiscal,
            'fci'      => $fci,
            'ticr'     => $ticr,
            'm_asig'   => $m_asig,
            );

        $this->ModelObservaciones->procesar($id, $array);
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
        $data['accion']      = 1;
        
        if ($post['s_cons'] == "") { $data['s_cons'] = NULL; } else { $data['s_cons'] = $post['s_cons']; }
        if ($post['c_adicional'] == "") { $data['c_adicional'] = NULL; } else { $data['c_adicional'] = $post['c_adicional']; } 
        if ($post['fcie'] == "") { $data['fcie'] = NULL; } else { $data['fcie'] = $post['fcie']; } 
        if ($post['i_p'] == "") { $data['i_p'] = NULL; } else { $data['i_p'] = $post['i_p']; }

        $this->ModelObservaciones->monto_modificado($id, $data);
    }

}
