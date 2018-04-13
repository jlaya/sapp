    <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class CConfiguracion extends CI_Controller
    {
        private $table = 'sis_configuracion';
        public function __construct()
        {
            parent::__construct();
            $this->load->model('configuracion/MConfiguracion','configuracion');
            $this->load->model('entes/ModelEntes','entes'); # Llamado a el modelo de Entes
            $this->load->model('gestion/GestionModel','gestion'); # Llamado a el modelo GestionModel
        }

        public function index()
        {   
            $acc = $this->input->get('accion');
            $ano_fiscal = $this->input->get('ano_fiscal');
            if($ano_fiscal == "" && $acc == ""){
                $acc = 1;
                $ano_fiscal = date('Y', now());
            }

            $accion  = $this->configuracion->busqueda_aprobado("acciones_registro", $ano_fiscal, $acc);
            //echo $this->db->last_query(); exit;
            $proyecto = $this->configuracion->busqueda_aprobado("proyecto_registro", $ano_fiscal, $acc);
            $datos['lista_modulo'] = $this->entes->listar_table('modulo');
            $datos['lista_sub_modulo'] = $this->entes->listar_table('sub_modulo');
            $this->load->view("base/Base",$datos);
            $this->load->view("configuracion/index", compact('accion','proyecto','ano_fiscal','acc'));
        }

        // Guardar cambios
        public function save()
        {
            $data = $this->input->post();
            $obj = $this->configuracion->save($data);
            //echo $this->db->last_query(); exit;
            if ($obj) {
                $response['success'] = 'ok';
            }
           // echo json_encode($response);
        }
    }
