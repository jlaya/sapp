<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllersRegistro
 *
 * @author ING: Jesus Laya
 */
class ControllersRegistro extends CI_Controller
{

    //put your code here

    public function __construct()
    {
        parent::__construct();
        $this->load->model('acciones/registro/ModelRegistro'); # Llamado a el modelo de Registro de Acciones
        $this->load->model('entes/ModelEntes'); # Llamado a el modelo de Entes
        $this->load->model('gestion/GestionModel','gestion'); # Llamado a el modelo GestionModel
        $this->load->model('model_standard/ModelStandard');
    }

    public function index()
    {	
		$id = 1;
        $ingresos_propios = $this->input->get('ingreso');
        $ano_fiscal = $this->input->get('ano_fiscal');
        
        if(isset($ingresos_propios)){
			$id = 1;
            $ingresos_propios = "AND acc.estatus IN(5)";
        }

        if(isset($ano_fiscal)){
			$id = 2;
            $ano_fiscal = "AND acc.ano_fiscal = $ano_fiscal";
        }

        if (isset($this->session->userdata['logged_in'])):
            if ($this->session->userdata['logged_in']['is_superuser'] == 'f'):
                $sql = "SELECT acc.id, acc.codigo, acc.m_autoridad, o.nom_ins, acc.ano_fiscal AS organo, acc.estatus, acc.accion, acc.cierre, acc.ano_fiscal, (SELECT COUNT(id) accion FROM ejecucion_financiera_acc where accion_id = acc.id AND acc= 2) AS accion FROM acciones_registro AS acc INNER JOIN organos_entes AS o ON(acc.reg_registro = o.id) WHERE acc.cierre = 1 AND acc.ente = ".$this->session->userdata['logged_in']['pk']." $ano_fiscal $ingresos_propios ORDER BY o.nom_ins DESC";
                $accion = $this->ModelStandard->query_set($sql, 'result');
            else:
                $sql = "SELECT acc.id, acc.codigo, acc.m_autoridad, o.nom_ins AS organo, acc.estatus, acc.accion, acc.cierre, acc.ano_fiscal, (SELECT COUNT(id) accion FROM ejecucion_financiera_acc where accion_id = acc.id AND acc= 2) AS accion FROM acciones_registro AS acc INNER JOIN organos_entes AS o ON(acc.reg_registro = o.id) WHERE acc.cierre = $id $ano_fiscal $ingresos_propios ORDER BY o.nom_ins DESC";
                $accion = $this->ModelStandard->query_set($sql, 'result');
            
            endif;
            
            //echo $this->db->last_query(); exit;
            
            $datos['acc_centralizada'] = $this->ModelEntes->listar('accion_centralizada');
            $datos['list_acc_reg']     = $accion;
            $datos['lista_modulo']     = $this->ModelEntes->listar_table('modulo');
            $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
            $this->load->view("base/Base", $datos);
            $this->load->view("acciones/registro/ViewLista", $datos);
        else:
            $header = base_url() . "?error=1";
            header("location: " . $header);
        endif;
    }

    public function ultimo_id()
    {
        $result = $this->ModelStandard->count_all_table_all('acciones_registro');
        //echo count($result->id);
        if (count($result->id) == '0') {
            $codigo = str_pad((int) $result->id + (int) 1, (int) 5, '0', STR_PAD_LEFT);
            echo json_encode($codigo);
        }
        /* $codigo = str_pad((int)$result->id + (int)1,(int)5,'0',STR_PAD_LEFT);

          if($codigo == ""){
          echo json_encode('00001');
          }else{
          echo json_encode($codigo);
          } */


        //echo json_encode($codigo);
    }

    public function nuevo()
    {
        $datos['lista_modulo'] = $this->ModelEntes->listar_table('modulo');

        $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');

        //$datos['codigo']           = $this->ModelStandard->count_all_table('acciones_registro');
        $datos['organos'] = $this->ModelEntes->listar('organos_entes');

        $datos['acc_centralizada'] = $this->ModelEntes->listar('accion_centralizada');
        $this->load->view("base/Base", $datos);
        $this->load->view("acciones/registro/ViewAdd", $datos);
    }

    public function guardar()
    {

        if ($this->input->post('fecha_revision') == "") {
            $fecha_revision = null;
        }
        if ($this->input->post('reg_res') == "") {
            $reg_res = null;
        }

        $query  = "SELECT a.id + 1 AS id FROM acciones_registro AS a ORDER BY a.id DESC LIMIT 1";
        $cod    = $this->ModelStandard->query_set($query, 'row');
        $codigo = str_pad($cod->id, (int) 9, '0', STR_PAD_LEFT);

        $array = array(
            'estatus'                 => $this->input->post('estatus'),
            'codigo'                  => $codigo,
            'fecha_elaboracion'       => $this->input->post('fecha_elaboracion'),
            'ano_fiscal'              => $this->input->post('ano_fiscal'),
            'ente'                    => $this->input->post('ente'),
            'cargo'                   => $this->input->post('cargo'),
            'm_autoridad'             => $this->input->post('m_autoridad'),
            'tlf'                     => $this->input->post('tlf'),
            'cedula'                  => $this->input->post('cedula'),
            'correo'                  => $this->input->post('correo'),
            'politica_presupuestaria' => $this->input->post('politica_presupuestaria'),
            'acc_centralizada'        => $this->input->post('acc_centralizada'),
            #'nom_especifica'          => $this->input->post('nom_especifica'),
            'reg_res'                 => $reg_res,
            'fecha_revision'          => $fecha_revision,
            'estruc_presupuestaria'   => $this->input->post('estruc_presupuestaria'),
            'observaciones'           => $this->input->post('observaciones'),
            'reg_registro'            => $this->input->post('reg_registro'),
            'cierre'                  => 1,
            'accion'                  => 1,
        );


        $result = $this->ModelRegistro->insertar($array);
        // =========================================================================
        // Proceso de bitacora
        // =========================================================================
        $time   = "%h:%i %a"; // Se captura la hora actual
        $datos  = array(
            'modulo'              => 'REGISTRO DE ACCIÓNES CENTRALIZADAS (TABLA acciones_registro)',
            'accion'              => 'NUEVO INGRESO DE REGISTRO DE ACCIÓNES CENTRALIZADAS',
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
        if ($this->input->post('fecha_revision') == "") {
            $fecha_revision = null;
        }
        if ($this->input->post('reg_res') == "") {
            $reg_res = null;
        }

        $array = array(
            'estatus'                 => $this->input->post('estatus'),
            'codigo'                  => $this->input->post('codigo'),
            'fecha_elaboracion'       => $this->input->post('fecha_elaboracion'),
            'ano_fiscal'              => $this->input->post('ano_fiscal'),
            'ente'                    => $this->input->post('ente'),
            'cargo'                   => $this->input->post('cargo'),
            'm_autoridad'             => $this->input->post('m_autoridad'),
            'tlf'                     => $this->input->post('tlf'),
            'cedula'                  => $this->input->post('cedula'),
            'correo'                  => $this->input->post('correo'),
            'politica_presupuestaria' => $this->input->post('politica_presupuestaria'),
            'acc_centralizada'        => $this->input->post('acc_centralizada'),
            #'nom_especifica'          => $this->input->post('nom_especifica'),
            #'reg_res'                 => $reg_res,
            #'fecha_revision'          => $fecha_revision,
            'estruc_presupuestaria'   => $this->input->post('estruc_presupuestaria'),
            'observaciones'           => $this->input->post('observaciones'),
            'reg_registro'            => $this->input->post('reg_registro'),
            'cierre'                  => 1,
            'accion'                  => 2,
        );

        $result = $this->ModelRegistro->actualizar($array);
        // =========================================================================
        // Proceso de bitacora
        // =========================================================================
        $time   = "%h:%i %a"; // Se captura la hora actual
        $datos  = array(
            'modulo'              => 'REGISTRO DE ACCIÓNES CENTRALIZADAS (TABLA acciones_registro)',
            'accion'              => 'NUEVA ACTUALIZACIÓN DE REGISTRO DE ACCIÓNES CENTRALIZADAS',
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

    public function procesar_list($codigo)
    {   
        $datos['detalles_lista'] = $this->ModelRegistro->datos($codigo);

        $datos['lista_modulo']       = $this->ModelEntes->listar_table('modulo');
        $datos['lista_sub_modulo']   = $this->ModelEntes->listar_table('sub_modulo');
        $datos['organos']            = $this->ModelEntes->listar('organos_entes');
        $datos['acc_centralizada']   = $this->ModelEntes->listar('accion_centralizada');
        $id                          = $datos['detalles_lista']->id;
        $datos['last_id']            = $this->ModelStandard->count_all_table_all('ejecucion_financiera_acc')->id + 1;
        $datos['actividades']        = $this->ModelStandard->search('id_acc_reg', 'distribucion_actividad', $id);
        $datos['distrib_tri_act']    = $this->ModelStandard->join_table('distribucion_trimestral_actividad dis', 'distribucion_actividad d', 'dis.id_actividad', 'd.id', 'dis.id_acc_reg', $id);
        
        #echo $this->db->last_query(); exit;
        
        $datos['distrib_tri_fin']    = $this->ModelStandard->join_table('distribucion_trimestral_financiera dis', 'distribucion_actividad d', 'dis.id_actividad', 'd.id', 'dis.id_acc_reg', $id);
        #echo $this->db->last_query(); exit;
        $datos['imp_presupuestaria'] = $this->ModelStandard->join_table('imp_presupuestaria i', 'partida_presupuestaria p', 'i.partida', 'p.id', 'i.id_acc_reg', $id);

        $this->load->view("base/Base", $datos);
        $this->load->view('acciones/registro/ViewUpdate', $datos);
    }

    public function eliminar($id)
    {
        $this->ModelRegistro->eliminar($id);
    }

    public function last_id()
    {   $table = $this->input->get('param');
        $result = $this->ModelStandard->count_all_table_all($table)->id + 1;
        echo json_encode($result);
    }

    // Método publico para traer las lineas estrategicas segun la asociacion con el plan de la nacion
    public function ajax_search($id)
    {
        #Campo                  #Tabla              ID
        $result = $this->ModelStandard->search('accion_centralizada', 'accion_especifica', $id);
        echo json_encode($result);
    }

    // Método para cargar las partidas presupuestarias asociados a la acción centralizada
    public function cargar($P, $id)
    {   # Se retorna los datos de las acciones especificas segun el tipo de accion centralizada
        if ($P == "1") {

            $result = $this->ModelRegistro->procesar('6', $id, '');

            # Proceso para el registro de una actividad
        } else if ($P == "2") {

            $result = $this->ModelRegistro->procesar('1', '0', $this->input->post());

            if ($result) {
                redirect('acciones/registro/ControllersRegistro/procesar_list/' . $id);
            }
            # Proceso para la actualización de una actividad
        } else if ($P == "3") {
            $result = $this->ModelRegistro->procesar('2', $id, $this->input->post());

            if ($result) {
                redirect('acciones/registro/ControllersRegistro/procesar_list/' . $id);
            }
            # Proceso para la captura de los datos de la actividad
        } else if ($P == "4") {
            #Campo #Tabla                   ID
            $result = $this->ModelStandard->search('id', 'distribucion_actividad', $id);
            echo json_encode($result);
            # Proceso para la eliminación de una actividad
        } else if ($P == "5") {
            $result = $this->ModelRegistro->procesar('3', $id, "");
            if ($result) {
                redirect('acciones/registro/ControllersRegistro/procesar_list/' . $id);
            }
            # Proceso para la captura de las actividades segun el id principal del registro
        } else if ($P == "6") {
            #CampoA      CampoB        Tabla                     IDA   IDB
            $result = $this->ModelStandard->search_multiple_two('programado', 'id_acc_reg', 'distribucion_actividad', 'True', $id);
            $result = $this->ModelRegistro->insert_act_trimestral($result);
        } else if ($P == "7") {

            $dato = explode('-', $id);

            if ($dato[1] == "") {
                $trimestre_i = null;
            } else {
                $trimestre_i = $dato[1];
            }
            if ($dato[2] == "") {
                $trimestre_ii = null;
            } else {
                $trimestre_ii = $dato[2];
            }
            if ($dato[3] == "") {
                $trimestre_iii = null;
            } else {
                $trimestre_iii = $dato[3];
            }
            if ($dato[4] == "") {
                $trimestre_iv = null;
            } else {
                $trimestre_iv = $dato[4];
            }
            if ($dato[5] == "") {
                $total = null;
            } else {
                $total = $dato[5];
            }

            $id_act = $dato[0];
            $array  = array(
                'trimestre_i'   => $trimestre_i,
                'trimestre_ii'  => $trimestre_ii,
                'trimestre_iii' => $trimestre_iii,
                'trimestre_iv'  => $trimestre_iv,
                'total'         => $total,
            );
            $result = $this->ModelRegistro->procesar('4', $id_act, $array);
        } else if ($P == "8") {

            $dato = explode('-', $id);

            if ($dato[1] == "") {
                $trimestre_i = null;
            } else {
                $trimestre_i = $dato[1];
            }
            if ($dato[2] == "") {
                $trimestre_ii = null;
            } else {
                $trimestre_ii = $dato[2];
            }
            if ($dato[3] == "") {
                $trimestre_iii = null;
            } else {
                $trimestre_iii = $dato[3];
            }
            if ($dato[4] == "") {
                $trimestre_iv = null;
            } else {
                $trimestre_iv = $dato[4];
            }
            if ($dato[5] == "") {
                $total = null;
            } else {
                $total = $dato[5];
            }

            $id_act = $dato[0];
            $array  = array(
                'trimestre_i'   => $trimestre_i,
                'trimestre_ii'  => $trimestre_ii,
                'trimestre_iii' => $trimestre_iii,
                'trimestre_iv'  => $trimestre_iv,
                'total'         => $total,
            );
            $result = $this->ModelRegistro->procesar('5', $id_act, $array);
        } else if ($P == "9") {

            $dato = explode('-', $id);

            if ($dato[1] == "") {
                $trimestre_i = null;
            } else {
                $trimestre_i = $dato[1];
            }
            if ($dato[2] == "") {
                $trimestre_ii = null;
            } else {
                $trimestre_ii = $dato[2];
            }
            if ($dato[3] == "") {
                $trimestre_iii = null;
            } else {
                $trimestre_iii = $dato[3];
            }
            if ($dato[4] == "") {
                $trimestre_iv = null;
            } else {
                $trimestre_iv = $dato[4];
            }
            if ($dato[5] == "") {
                $cantidad = null;
            } else {
                $cantidad = $dato[5];
            }
            if ($dato[6] == "") {
                $monto = null;
            } else {
                $monto = $dato[6];
            }

            $id_act = $dato[0];

            $array = array(
                'trimestre_i'   => $trimestre_i,
                'trimestre_ii'  => $trimestre_ii,
                'trimestre_iii' => $trimestre_iii,
                'trimestre_iv'  => $trimestre_iv,
                'cantidad'      => $cantidad,
                'monto'         => $monto,
            );

            $result = $this->ModelRegistro->procesar('7', $id_act, $array);
        }
    }

    // Método publico para traer de forma dinamica los valores para la sumatoria
    public function search_table($campo, $table, $id)
    {
        #Campo  Tabla   ID
        $result = $this->ModelStandard->search($campo, $table, $id);
        echo json_encode($result);
    }

    public function list_estructura(){
        $data['estructura'] = $this->gestion->list_estructura();
        echo json_encode($data);
    }

    public function updateActionFAcc()
    {   
        $data = $this->input->post();
        $response['success'] = 'ok';
        $this->ModelRegistro->updateActionFAcc($data);
        echo json_encode($response);
    }

    public function deleteActionFAcc()
    {
        $param = $this->input->get();
        $result = $this->ModelRegistro->deleteActionFAcc($param);
        $response['success'] = 'error';
        if($result){
            $response['success'] = 'ok';
        }
        echo json_encode($response);
    }

    public function search(){
        $param = $this->input->get();
        $result = $this->gestion->search($param);
        $data['financiero_acc'] = $this->ModelRegistro->list_financiero_acc($param['id']);
        if($result){
            echo json_encode($data);
        }
    }


    // Reportes
    public function pdf($id)
    {
        $this->load->library('rpdf');
        require_once APPPATH . "libraries/mpdf/jpgraph/jpgraph.php";
        require_once APPPATH . "libraries/mpdf/jpgraph/jpgraph_pie.php";
        require_once APPPATH . "libraries/mpdf/jpgraph/jpgraph_pie3d.php";
        $this->load->library('twig');
        date_default_timezone_set("America/Caracas");
        $mpdf = $this->rpdf->load('utf-8', 'A4-L');
        $accion = $this->ModelRegistro->pdf($id);
        $mpdf->SetHTMLHeader($html_header);
        $mpdf->SetHTMLFooter($html_footer);
        $mpdf->AddPage('L');
        // $this->twig->display("gestion/pdf/accion", compact('accion','count_cumplido_acc','count_no_cumplido_acc','id'));
        $html = $this->twig->render('acciones/registro/pdf/accion', compact('accion'), true);
        $mpdf->WriteHTML($html);
        $mpdf->Output('accion.pdf', 'I');
    }

    // Guardar cambios
    public function save()
    {
        $data = $this->input->post();
        $this->ModelRegistro->save($data);
    }

    // Lista proceso de carga de partidas especificas
    public function lista($id)
    {
        $data['id']         = $id;
        $data['obj']        = $this->ModelRegistro->list_financiero_acc($id);
        $data['estructura'] = $this->gestion->list_estructura();
        $this->load->view("acciones/registro/list", $data);
    }

}
