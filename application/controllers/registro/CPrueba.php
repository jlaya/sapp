<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class CPrueba extends SI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('registro/MPrueba','prueba');
    }

    public function index()
    {
        echo 'fffff';
    }
    public function listar()
    {
        $datos['listar'] = $this->prueba->listar();
        $this->load->view('principal/prueba', $datos);
    }

    public function insertar()
    {
        $this->prueba->insertar();
    }

    public function exportar()
    {
        $this->load->dbutil();


        $prefs = array(
        //'tables'        => array('table1', 'table2'),   // Array of tables to backup.
        'ignore'        => array(),                     // List of tables to omit from the backup
        'format'        => 'txt',                       // gzip, zip, txt
        'filename'      => 'policia.sql',              // File name - NEEDED ONLY WITH ZIP FILES
        'add_drop'      => TRUE,                        // Whether to add DROP TABLE statements to backup file
        'add_insert'    => TRUE,                        // Whether to add INSERT data to backup file
        'newline'       => "\n"                         // Newline character used in backup file
        );

        $backup = $this->dbutil->backup($prefs);


        $this->load->helper('file');
        write_file('policia.sql', $backup);

        $this->load->helper('download');
        force_download('policia.sql', $backup);
    }

}
