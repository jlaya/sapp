<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class CResena extends SI_Controller {

    private $dir = 'registro/';
    private $files = array('new' => 'resena');
    public $_unique = array('ci' => '<div>Disculpe esta Cedula se encuentra registrada</div>', 'nombres' => '<div>Disculpe este Nombre se encuentra registrado</div>');
    private $vista = '';
    private $table = 'ficha';

    public function __construct() {
        parent::__construct();
        $this->files = (object) $this->files;
        $this->load->model('registro/MResena', 'resena');
        $this->load->model('registro/MCabeza', 'cabeza');
        $this->load->model('registro/MPiel', 'piel');
        $this->load->model('registro/MColorPiel', 'color_piel');
        $this->load->model('registro/MFrente', 'frente');
        $this->load->model('registro/MOjos', 'ojos');
        $this->load->model('registro/MColorOjos', 'color_ojos');
        $this->load->model('registro/MCabello', 'cabellos');
        $this->load->model('registro/MColorCabello', 'color_cabellos');
        $this->load->model('registro/MCejas', 'cejas');
        $this->load->model('registro/MNariz', 'nariz');
        $this->load->model('registro/MBoca', 'boca');
        $this->load->model('registro/MLabios', 'labios');
        $this->load->model('registro/MContextura', 'contextura');
        $this->load->model('registro/MMenton', 'menton');
        $this->load->model('registro/MOrejas', 'orejas');
        $this->load->model('registro/MDetalle', 'detalle');
        $this->load->model('registro/MDelito', 'delito');
        $this->load->model('topologia/MEstado', 'estado');
        //echo strtolower(substr($this->router->fetch_class(),1));
    }

    public function index() {

        $datos['id'] = $this->modulo->lastId($this->table);
        $datos['lista_resena'] = $this->resena->listar();
        $datos['token'] = $this->libreria->token();

        $datos['lista_cabeza'] = $this->cabeza->listar();
        $datos['lista_piel'] = $this->piel->listar();
        $datos['lista_color_piel'] = $this->color_piel->listar();
        $datos['lista_frente'] = $this->frente->listar();
        $datos['lista_ojos'] = $this->ojos->listar();
        $datos['lista_color_ojos'] = $this->color_ojos->listar();
        $datos['lista_cabellos'] = $this->cabellos->listar();
        $datos['lista_color_cabellos'] = $this->color_cabellos->listar();
        $datos['lista_cejas'] = $this->cejas->listar();
        $datos['lista_nariz'] = $this->nariz->listar();
        $datos['lista_boca'] = $this->boca->listar();
        $datos['lista_labios'] = $this->labios->listar();
        $datos['lista_contextura'] = $this->contextura->listar();
        $datos['lista_menton'] = $this->menton->listar();
        $datos['lista_orejas'] = $this->orejas->listar();
        $datos['lista_nacionalidad'] = $this->resena->listar_nacionalidad();


        $datos['lista'] = $this->detalle->listar();
        $datos['delito'] = $this->delito->listar();
        $datos['estado'] = $this->estado->listar();

        $this->vista = $this->dir . $this->files->new;
        $this->template->write_view('content', $this->vista, $datos);
        $this->template->render();
    }

    public function buscar() {
        $id = $this->input->get('id');
        $row = $this->resena->buscar($id);
        echo json_encode($row);
    }

    public function guardar() {




        if ($this->input->post('token') && $this->input->post('token') == $this->session->userdata('token')) {
            $data = $this->input->post();
            $response_data['success'] = 'error';
            $result = $this->resena->guardar($data);

            if ($result == 1) {
                $response_data['success'] = 'ok';
                $response_data['msg'] = '<div>Registro guardado con exito</div>';
            } else if (count($result) > 0) {
                $response_data['key_unique'] = 'existe';
                $response_data['unique_key'] = $result['unique_key'];
                $response_data['msg'] = $this->_unique[$result['unique_key']];
            }

            $campos = $this->input->post('campos');


            foreach ($campos as $deli) {

                $deli = explode(";", $deli);
                
                $decision_tribunal = $deli[0];
                $delito_id = $deli[1];
                $estado_id = $deli[2];
                $abogado_defensor = $deli[3];
                $causa = $deli[4];
                $fecha_de_presentacion = $deli[5];
                $detalle_falta = $deli[6];
                
                $datos = array(
                'ci' => $this->input->post('ci'),
                'decision_tribunal' => $decision_tribunal,
                'delito_id' => $delito_id,
                'estado_id' => $estado_id,
                'abogado_defensor' => $abogado_defensor,
                'causa' => $causa,
                'fecha_de_presentacion' => $fecha_de_presentacion,
                'detalle_falta' => $detalle_falta,
                );
                
        
            $result = $this->detalle->guardar($datos);
                

            }
            
      
            
            $resul_activity = $this->libreria->generateActivity('Registro una Resena');
        } else {
            $response_data['success'] = 'error';
        }
        echo json_encode($response_data);
    }

    public function modificar() {
        if ($this->input->post('token') && $this->input->post('token') == $this->session->userdata('token')) {
            $data = $this->input->post();
            $result = $this->resena->modificar($data);
            if ($result) {
                $response_data['success'] = 'ok';
                $response_data['msg'] = '<div>Registro modifcado con exito</div>';
            }
            $resul_activity = $this->libreria->generateActivity('Modifico una Resena');
        } else {
            $response_data['success'] = 'error';
        }
        echo json_encode($response_data);
    }

    public function eliminar() {
        $response_data['success'] = 'error';
        $id = $this->input->get('id');
        $resultado = $this->resena->eliminar($id);
        if ($resultado) {
            $response_data['success'] = 'ok';
            $response_data['msg'] = '<div>El registro fue eliminado exitosamente</div>';
        }
        $resul_activity = $this->libreria->generateActivity('Eliminar una Resena');
        echo json_encode($response_data);
    }

}
