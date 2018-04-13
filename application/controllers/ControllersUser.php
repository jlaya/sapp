<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllersUser
 *
 * @author ING: Jesus Laya
 */
class ControllersUser extends CI_Controller
{

    //put your code here

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url'));
        $this->load->library('session');
        $this->load->helper('date');
        $this->load->model('user/ModelUser'); # Llamado a el modelo de Usuarios
        $this->load->model('entes/ModelEntes'); # Llamado a el modelo de Entes
        $this->load->model('gestion/GestionModel','gestion'); # Llamado a el modelo GestionModel
    }

    public function index($id=0)
    {   
        $row = $this->ModelUser->detailList_avatar_result($id)[0];
        $this->load->view("user/ViewUser", compact('row'));
    }

    public function add_image($id=0)
    {   
        $lista_modulo     = $this->ModelEntes->listar_table('modulo');
        $lista_sub_modulo = $this->ModelEntes->listar_table('sub_modulo');
        $row              = $this->ModelUser->detailList_avatar_result($id)[0];
        $avatar_result    = $this->ModelUser->detailList_avatar_all();
        $this->load->view("base/Base", compact('lista_modulo','lista_sub_modulo'));
        $this->load->view("user/image", compact('row','avatar_result'));
    }

    public function ajax_avatar(){
        $id = $this->input->get('id');
        $avatar_result =$this->ModelUser->detailList_avatar_result($id);
        // $this->load->view("user/image", compact('avatar_result'));
        redirect(base_url('ControllersUser/add_image'),'refresh');
    }

    public function listar()
    {
        if (isset($this->session->userdata['logged_in'])):
            /* if($this->session->userdata['logged_in']['is_superuser'] == 'f'):
              $accion = $this->ModelStandard->search('id', 'auth_user', $this->session->userdata['logged_in']['id']);
              else:
              $accion = $this->ModelEntes->listar('auth_user');
              endif; */
              //$datos['lista_user']       = $this->ModelEntes->listar('auth_user');
              $datos['list_group']       = $this->ModelEntes->listar('auth_group');
              $datos['lista_modulo']     = $this->ModelEntes->listar_table('modulo');
              $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
              $this->load->view("base/Base", $datos);
              $this->load->view("user/ViewList", $datos);
              else:
                $header = base_url() . "?error=1";
            header("location: " . $header);
            endif;
    }

        public function ajax()
        {
            $result['data'] = $this->ModelUser->ajax();
            echo json_encode($result);
        }

        public function home()
        {
            $datos['lista_modulo']     = $this->ModelEntes->listar_table('modulo');
            $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
            $this->load->view("base/Base", $datos);
            $this->load->view("user/Home");
        }

        public function dashboard()
        {
            $this->load->view("user/redirect_home");
        }

        public function guardar()
        {
        // Proceso de manejo de la imagen
            if ($_FILES['foto']['name'] != ""):
                $archivo = $_FILES['foto']['name'];
            $ex      = explode('.', $archivo);
            $ex      = $ex[1]; // Extencion
            $archivo = $this->input->post('cedula') . "." . $ex;
            $ruta    = getcwd();  // Obtiene el directorio actual en donde se esta trabajando
            //echo $ruta;
            move_uploaded_file($_FILES['foto']['tmp_name'], $ruta . "/assets/foto/usuario/" . $archivo);
            $array['foto']         = $archivo;
            endif;

        # Validacion los distintos acceso de usuarios
            if ($this->input->post('is_active') == '') {
                $is_active = 'False';
            } else {
                $is_active = 'True';
            }

            if ($this->input->post('is_superuser') == '') {
                $is_superuser = 'False';
            } else {
                $is_superuser = 'True';
            }

            if ($this->input->post('is_staff') == '') {
                $is_staff = 'False';
            } else {
                $is_staff = 'True';
            }


            $array['password']     = 'pbkdf2_sha256$12000$' . hash("sha256", $this->input->post('password'));
            $array['is_superuser'] = $is_superuser;
            $array['username']     = $this->input->post('username');
            $array['first_name']   = $this->input->post('first_name');
            $array['ente']         = $this->input->post('ente');
            $array['cedula']       = $this->input->post('cedula');
            $array['is_staff']     = $is_staff;
            $array['is_active']    = $is_active;


            if ($this->input->post('id') == '') {

                $this->ModelUser->insertar($array);
            } else {
                $id = $this->input->post('id');
                $this->ModelUser->actualizar($id, $array);
            }
        }

        public function guardar_image()
        {
        // Proceso de manejo de la imagen avatar
            $data = $this->input->post();

            if ($_FILES['avatar']['name'] !=""){
                $archivo = $_FILES['avatar']['name'];
                $ruta    = getcwd();  // Obtiene el directorio actual en donde se esta trabajando
                if($archivo){
                    move_uploaded_file($_FILES['avatar']['tmp_name'], $ruta . "/assets/foto/" . $archivo);
                    $data['avatar']         = ltrim($archivo);
                }
                
            }

            if ($_FILES['avatar_login']['name'] !=""){
                $avatar_login = $_FILES['avatar_login']['name'];
                $ruta    = getcwd();  // Obtiene el directorio actual en donde se esta trabajando

                if($avatar_login){
                    move_uploaded_file($_FILES['avatar_login']['tmp_name'], $ruta . "/assets/foto/" . $avatar_login);
                    $data['avatar_login']         = ltrim($avatar_login);
                }
                
            }



            if($data['status'] == "on"){
                $data['status'] = 1;
            }else{
                $data['status'] = 0;
            }

            $data['panel_p'] = $this->explode("#",$this->input->post('panel_p'))[1];
            $data['panel_s'] = $this->explode("#",$this->input->post('panel_s'))[1];
            $data['panel_d'] = $this->explode("#",$this->input->post('panel_d'))[1];
            $data['titulo'] = $this->input->post('titulo');
            $result = $this->ModelUser->insert_image($data);
            if($result){
                $param['titulo']  = $data['titulo'];
                $param['panel_p'] = "#".$data['panel_p'];
                $param['panel_s'] = "#".$data['panel_s'];
                $param['panel_d'] = "#".$data['panel_d'];

                if(isset($_FILES['avatar']['name']) == ""){
                    $param['avatar'] = $_FILES['avatar']['name'];
                }else{
                    $param['avatar'] = $this->session->userdata['logged_in']['avatar'];
                }

                $this->ModelStandard->set_userdata_refresh($param);
            }
        }

        public function status($id, $status)
        {
            $data_array = array(
                'is_active' => $status,
                );

            $this->ModelUser->actualizar($id, $data_array);
        }

        public function explode($ext, $string)
        {
            return explode($ext, $string);
        }

        public function procesar($id)
        {
            $datos['detalles_lista']   = $this->ModelUser->detailList($id);
            $datos['list_group']       = $this->ModelEntes->listar('auth_group');
            $datos['lista_modulo']     = $this->ModelEntes->listar_table('modulo');
            $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
            $this->load->view("base/Base", $datos);
            $datos['organos']          = $this->ModelEntes->listar('organos_entes');
            $this->load->view('user/ViewUpdate', $datos);
        }

        public function new_user()
        {
            $datos['lista_modulo']     = $this->ModelEntes->listar_table('modulo');
            $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
            $this->load->view("base/Base", $datos);
            $datos['list_group']       = $this->ModelEntes->listar('auth_group');
            $datos['organos']          = $this->ModelEntes->listar('organos_entes');
            $this->load->view("user/ViewNew", $datos);
        }

    // Acceso a vistas
        public function acceso()
        {
            $datos['list_acceso']      = $this->ModelEntes->listar('auth_acceso');
            $datos['lista_modulo']     = $this->ModelEntes->listar_table('modulo');
            $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
            $datos['list_org']         = $this->ModelEntes->listar('organos_entes');
            $this->load->view("base/Base", $datos);
            $this->load->view("user/ViewAccesoList", $datos);
        }

        public function actualizacion($id)
        {
            $datos['detalles']         = $this->ModelUser->detailList_access($id);
            $datos['lista_modulo']     = $this->ModelEntes->listar_table('modulo');
            $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
            $this->load->view("base/Base", $datos);
            $datos['auth_user']        = $this->ModelStandard->search_in('ente', 'auth_user', $datos['detalles']->id_org);
            $datos['list_org']         = $this->ModelEntes->listar('organos_entes');
            $datos['list_modulo']      = $this->ModelEntes->listar_table('modulo');
            $datos['list_sub_modulo']  = $this->ModelStandard->count_all_table('sub_modulo');
            $this->load->view("user/ViewAccesoUpdate", $datos);
        }

        public function nuevo_acceso()
        {
            $datos['lista_modulo']     = $this->ModelEntes->listar_table('modulo');
            $datos['lista_sub_modulo'] = $this->ModelEntes->listar_table('sub_modulo');
            $this->load->view("base/Base", $datos);
            $datos['list_group']       = $this->ModelEntes->listar('auth_group');
            $datos['list_org']         = $this->ModelEntes->listar('organos_entes');
            $datos['list_modulo']      = $this->ModelEntes->listar_table('modulo');
            $datos['list_sub_modulo']  = $this->ModelStandard->count_all_table('sub_modulo');
            $this->load->view("user/ViewAccesoAdd", $datos);
        }

        public function ajax_search($id)
        {
        #Campo  #Tabla       ID
            $result = $this->ModelStandard->search('ente', 'auth_user', $id);
            echo json_encode($result);
        }

    // Metodo para la Busqueda de los Sub modulo asociados a los Módulos
        public function ajax_search_sub($id)
        {
            $id_replace = $this->ModelStandard->replace_string('-', ',', $id);

            $result = $this->ModelStandard->search_in('id_modulo', 'sub_modulo', $id_replace);
            echo json_encode($result);
        }

        public function guardar_acceso()
        {

        # Validacion para los distintos permisos de acceso al usuario
            if ($this->input->post('agregar') == '') {
                $agregar = 'False';
            } else {
                $agregar = 'True';
            }
            if ($this->input->post('modificar') == '') {
                $modificar = 'False';
            } else {
                $modificar = 'True';
            }
            if ($this->input->post('eliminar') == '') {
                $eliminar = 'False';
            } else {
                $eliminar = 'True';
            }
            if ($this->input->post('ver') == '') {
                $ver = 'False';
            } else {
                $ver = 'True';
            }

            $array = array(
                'id_user'       => $this->ModelStandard->replace_string(',', '-', $this->input->post('user_ids')),
                'id_org'        => $this->input->post('id_org'),
                'id_modulo'     => $this->input->post('modulo_ids'),
                'id_sub_modulo' => $this->input->post('sub_modulo_ids'),
                'agregar'       => $agregar,
                'modificar'     => $modificar,
                'eliminar'      => $eliminar,
                'ver'           => $ver,
                );

        #echo print_r($array);
        #return true;

            if ($this->input->post('id') == '') {

                $result = $this->ModelUser->insertar_acceso($array);
            } else {
                $id     = $this->input->post('id');
                $result = $this->ModelUser->actualizar_acceso($id, $array);
            }
        }

        public function picture()
        {
            $username  = $this->input->get('username');
            $resultado = $this->ModelUser->picture($username);
            echo json_encode($resultado);
        }

        public function iniciar()
        {
        #$result = $this->ModelUser->login($_POST['username'], md5($_POST['password']));
            $result_login = $this->ModelUser->login($this->input->post('username'), 'pbkdf2_sha256$12000$' . hash("sha256", $this->input->post('password')));
            $result       = $this->ModelUser->information($this->input->post('username'));
            if ($result_login == '1') {
                if ($result_login != false) {
                    $result_org = $this->ModelUser->information_auth_group('id', $result[0]->ente, 'organos_entes');


                // Permiso de Acceso para los Módulos y Sub Módulos
                    $permissions = $this->ModelStandard->listar('auth_acceso');
                    foreach ($permissions AS $value) {
                        foreach (explode('-', $value->id_user) AS $key) {
                            if ($key == $result[0]->id AND $value->id_org == $result_org[0]->id) {
                                $modulo     = $value->id_modulo;
                                $sub_modulo = $value->id_sub_modulo;
                                $agregar    = $value->agregar;
                                $modificar  = $value->modificar;
                                $eliminar   = $value->eliminar;
                                $ver        = $value->ver;
                            }
                        }
                    }
                    $session_data = array(
                        'username'     => $result[0]->username,
                        'id'           => $result[0]->id,
                        'sigla'        => $result_org[0]->siglas,
                        'first_name'   => $result[0]->first_name,
                        'org_id'       => "<a id=" . $result_org[0]->id . " class='myModal' style='cursor:pointer;text-decoration:none;'><font style='color:#0075C5;font-weight:bold;'>(" . $result_org[0]->siglas . ") </font> <font style='color:#FFFFFF;font-weight:bold;'>" . $result_org[0]->nom_ins . "</font></a>",
                        'pk'           => $result_org[0]->id,
                        'nom_ins'      => $result_org[0]->nom_ins,
                        'correo'       => $result_org[0]->correo,
                        'is_superuser' => $result[0]->is_superuser,
                        'modulo'       => $modulo,
                        'sub_modulo'   => $sub_modulo,
                        'agregar'      => $agregar,
                        'modificar'    => $modificar,
                        'eliminar'     => $eliminar,
                        'ver'          => $ver,
                        'change_id'    => $result[0]->change_id,
                        'avatar'       => $this->ModelUser->detailList_avatar()->avatar,
                        'titulo'       => $this->ModelUser->detailList_avatar()->titulo,
                        'panel_p'       => "#".$this->ModelUser->detailList_avatar()->panel_p,
                        'panel_s'       => "#".$this->ModelUser->detailList_avatar()->panel_s,
                        'panel_d'       => "#".$this->ModelUser->detailList_avatar()->panel_d
                        );
                    $this->session->set_userdata('logged_in', $session_data);
                    echo 1;
                }
            // =========================================================================
            // Proceso de bitacora
            // =========================================================================
            $time   = "%h:%i %a"; // Se captura la hora actual
            $datos  = array(
                'modulo'              => 'USUARIO  (TABLA auth_user)',
                'accion'              => 'NUEVO INGRESO DE SESIÓN',
                'id_usuario'          => $this->session->userdata['logged_in']['id'],
                'fecha_registro'      => date('Y-m-d', now()),
                'fecha_actualizacion' => NULL,
                'hora_registro'       => mdate($time),
                'hora_actualizacion'  => NULL,
                'ip'                  => $_SERVER['REMOTE_ADDR'],
                );
            $result = $this->ModelStandard->bitacora($datos);
            // =========================================================================
        } else {

            if ($result == true and $result[0]->is_active == True) {
                echo 2;
            } else {
                echo 3;
            }
        }
    }

    // Cambio de contraseña por primera vez
    public function cambio_password()
    {
        $datos = $this->input->post();
        $this->ModelUser->cambio_password($datos);
    }

    // Proceso para recuperar la contraseña
    public function remember_password($remember)
    {
        $this->ModelUser->remember_password($remember);
    }

    public function close_session()
    {
        $result = $this->ModelUser->logout();
        // =========================================================================
        // Proceso de bitacora
        // =========================================================================
        $time   = "%h:%i %a"; // Se captura la hora actual
        $datos  = array(
            'modulo'              => 'USUARIO  (TABLA auth_user)',
            'accion'              => 'NUEVO CIERRE DE SESIÓN',
            'id_usuario'          => $this->session->userdata['logged_in']['id'],
            'fecha_registro'      => date('Y-m-d', now()),
            'fecha_actualizacion' => NULL,
            'hora_registro'       => mdate($time),
            'hora_actualizacion'  => NULL,
            'ip'                  => $_SERVER['REMOTE_ADDR'],
            );
        $result = $this->ModelStandard->bitacora($datos);
        // =========================================================================
        if ($result) {
            echo 1;
        }
    }
    
    public function send_notifications()
    {
        $data   = $this->input->post();
		$result = $this->ModelUser->send_notifications($data);
		$res['r'] = "success";
		$res['m'] = "Se envio con exito el reporte...";
		
        try {
			
			if((int)$result == 1){
				$res['r'] = "existe";
				$res['m'] = "No se puede enviar una nueva nota, ya se encuentra notificado en el dia";
			}
		}
		catch (Exception $e) {
			$res['r'] = "error";
			$res['message'] = $e->getMessage();
		}
        
		echo json_encode($res);
    }
    
    public function notifications()
    {
		$result['data'] = $this->ModelUser->notifications();
		echo json_encode($result);
	}
    
    public function list_notifications()
    {
		$lista_modulo     = $this->ModelEntes->listar_table('modulo');
        $lista_sub_modulo = $this->ModelEntes->listar_table('sub_modulo');
        $this->load->view("base/Base", compact('lista_modulo','lista_sub_modulo'));
        $this->load->view("user/notificaciones");
    }
    
    public function enviar_correo()
    {
		$this->load->library('email');
        $param  = $this->input->post();
        //$config['protocol']  = "smtp";
        $config['protocol']  = "mail";
        $config['smtp_host'] = "ssl://smtp.gmail.com";
        $config['smtp_port'] = "465";
        $config['smtp_user'] = "sisadmidesarrollo@gmail.com";
        $config['smtp_pass'] = "administradordesarrollo";
        $config['charset']   = "utf-8";
        $config['mailtype']  = "html";
        $config['newline']   = "\r\n";
        //$config['send_multipart'] = TRUE;

        $path_email    = base_url("assets/image/email.png");
        $type_email    = pathinfo($path_email, PATHINFO_EXTENSION);
        $data_email    = file_get_contents($path_email);
        $email     = $param['correo'];
        $from      = "sppppcg@gmail.com";
        $name      = $param['nom_organo'];
        $respuesta = $param['respuesta'];
        
        $email_html = $this->load->view('user/send_email', compact('name','respuesta'), true);

        $this->email->initialize($config);
        $this->email->from($from, "Comentario / Estátus de cuenta");
        $list = array($email);
        $this->email->to($list);
        $this->email->cc($from);
        $this->email->subject($name);
        $this->email->message($email_html);
        $result = $this->email->send();

        $response['success'] = 'error';
        if($result){
            $response['success'] = 'ok';
        }
        echo json_encode($response);
        //var_dump($this->email->print_debugger());
    }
    
    public function activacion_cuenta($correo, $nom_organo, $mensaje)
    {
		$this->load->library('email');
        $param  = $this->input->post();
        //$config['protocol']  = "smtp";
        $config['protocol']  = "mail";
        $config['smtp_host'] = "ssl://smtp.gmail.com";
        $config['smtp_port'] = "465";
        $config['smtp_user'] = "sisadmidesarrollo@gmail.com";
        $config['smtp_pass'] = "administradordesarrollo";
        $config['charset']   = "utf-8";
        $config['mailtype']  = "html";
        $config['newline']   = "\r\n";
        //$config['send_multipart'] = TRUE;

        $path_email    = base_url("assets/image/email.png");
        $type_email    = pathinfo($path_email, PATHINFO_EXTENSION);
        $data_email    = file_get_contents($path_email);
        $email     = $correo;
        $from      = "sppppcg@gmail.com";
        $name      = $nom_organo;
        $respuesta = "$mensaje puede cumplir sus funciones dentro del Sistema (SAPP) Sistema Automatizado para la Planificación y Presupuesto";
        
        $email_html = $this->load->view('user/send_email', compact('name','respuesta'), true);

        $this->email->initialize($config);
        $this->email->from($from, "<b>Activación de cuenta</b>");
        $list = array($email);
        $this->email->to($list);
        $this->email->cc($from);
        $this->email->subject($name);
        $this->email->message($email_html);
        $result = $this->email->send();

        $response['success'] = 'error';
        if($result){
            $response['success'] = 'ok';
        }
        echo json_encode($response);
        //var_dump($this->email->print_debugger());
    }
    
    public function change_status()
    {
		$param = $this->input->get();
		$this->ModelUser->change_status($param);
	}

    public function error_404()
    {
        $this->load->view("base/404", array());
    }
}
