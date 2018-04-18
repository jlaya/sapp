<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Login
 *
 * @author josue
 */
class CUsers extends SI_Controller {

    private $dir = 'seguridad/';
    private $files = array('new' => 'users', 'list' => 'users', 'login' => 'login');
    private $vista = '';
    private $table = 'se_users';

    public function __construct() {

        parent::__construct();
        $this->files = (object) $this->files;
        $this->load->model('seguridad/MUsers', 'users');
        $this->load->model('seguridad/M_perfil', 'perfil');
    }

    public function index() {

        $this->vista = $this->dir . $this->files->new;
        $datos['id'] = $this->users->lastId($this->table);
        $datos['token'] = $this->libreria->token();
        $datos['perfiles'] = $this->perfil->perfil_active();
        $datos['listar'] = $this->users->listar();
        $this->template->write('title', 'Usuario');
        $this->template->write('module', 'Registro de Usuarios');
        $this->template->write_view('content', $this->vista, $datos);
        $this->template->render();
    }

    public function guardar() {


        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'sisadmidesarrollo@gmail.com',
            'smtp_pass' => 'administradordesarrollo',
            'mailtype' => 'html',
            'charset' => 'UTF-8',
            'wordwrap' => TRUE
        );
     
           
            $data = $this->input->post();
            unset($data['csrf_test_name']);
            unset($data['token']);
            unset($data['si_rpassword']);
            $si_user = $data['si_user'];
            $si_pasword = $data['si_password'];
            $this->email->initialize($config);
            $this->email->from('sisadmidesarrollo@gmail.com');
            $this->email->to($data['correo']);
            $this->email->subject('Cuenta de usuario');
            $this->email->message("<div>El usuario  <span style='font-weight:bold'>$si_user</div> fue creado su clave es <span style='font-weight:bold'>$si_pasword</span></div><div><a href='" . base_url() . "' >Acceder al sistema</a></div>");
            $pass = $this->libreria->generatePassword($data['si_password']);
            $data['si_password'] = $pass;
            $result = $this->users->agregar($data);
            if ($result) {
                $response_data['success'] = 'ok';
                $response_data['msg'] = '<div>Registro exitoso</div>';
                $response_data['action'] = 'save';
                //$this->email->send();
            }else {
                $response_data['success'] = 'error';
                $response_data['msg'] = '<div>Registro existe</div>';

            }
            $resul_activity = $this->libreria->generateActivity('Registro de Usuario');

             echo json_encode($response_data);
    }

    public function modificar() {
        if ($this->input->post('token') && $this->input->post('token') == $this->session->userdata('token')) {
            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://smtp.googlemail.com',
                'smtp_port' => 465,
                'smtp_user' => 'sisadmidesarrollo@gmail.com',
                'smtp_pass' => 'administradordesarrollo',
                'mailtype' => 'html',
                'charset' => 'UTF-8',
                'wordwrap' => TRUE
            );
            $response_data['success'] = 'error';
            $data = $this->input->post();
            $id = $data['id'];
            unset($data['csrf_test_name']);
            unset($data['token']);
            unset($data['si_rpassword']);
            $si_user = $data['si_user'];
            $si_pasword = $data['si_password'];
            $this->email->initialize($config);
            $this->email->from('sisadmidesarrollo@gmail.com');
            $this->email->to($data['correo']);
            $this->email->subject('Cuenta de usuario');
            $this->email->message("<div>El usuario  <span style='font-weight:bold'>$si_user</div> fue creado su clave es <span style='font-weight:bold'>$si_pasword</span></div><div><a href='" . base_url() . "' >Acceder al sistema</a></div>");
            $pass = $this->libreria->generatePassword($data['si_password']);
            $data['si_password'] = $pass;
            $result = $this->users->modificar($id, $data);
            if ($result) {
                $response_data['success'] = 'ok';
                $response_data['msg'] = '<div>Registro modificado con exito, <span class="text-danger"> la p&aacute;gina se actualizara para realizar los cambios</span></div>';
            }
        } else {
            $response_data['success'] = 'error';
        }
        echo json_encode($response_data);
    }

    public function login() {
        $this->vista = $this->dir . $this->files->login;
        $this->load->view($this->vista);
    }

    public function buscar() {
        $id = $this->input->get('id');
        $resultado = $this->users->buscar($id);
        echo json_encode($resultado);
    }

    public function logout() {
        $resul_activity = $this->libreria->generateActivity('Cerro Sesi&oacute;n');
        if ($resul_activity) {
            if (isset($this->session)) {
                $this->session->sess_destroy();
            }
            $this->db->select("slug");
            $this->db->where("default_route", true);
            $query = $this->db->get('se_app_routes', 1);
            $route = $query->row()->slug;
            redirect('index.php/' . $route, 'refresh');
        }
    }

    public function validateLogin() {

        $data_response['status'] = 'error';
        $user = $this->input->post('user');
        $pass = $this->input->post('password');
        $result = $this->users->login($user, $pass);
        if ($result) {
            $resul_activity = $this->libreria->generateActivity('Inicio de Sesi&oacute;n');
            $user_id = $this->session->userdata('user_id');
            if ($resul_activity) {
                $data_response['status'] = 'success';
            }
        }
        echo json_encode($data_response);
    }

    public function changePassword() {
        $data_response['success'] = 'error';
        $id = $this->session->userdata('user_id');
        $pass = $this->libreria->generatePassword($this->input->post('clave_new'));
        $data['si_password'] = $pass;
        $result = $this->users->changePassword($id, $data);
        if ($result) {
            $data_response['success'] = 'ok';
        }
        echo json_encode($data_response);
    }

}
