<?php

/**
*
*/
class MigrationsUser extends SI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('migration');
        $this->load->dbutil();
    }
    public function index()
    {
        // if ( ! $this->migration->current()){
        if ( ! $this->migration->version(0)){
            echo 'Error' . $this->migration->error_string();
        } else {
            echo 'Migrations ran successfully!';
        }
    }
    public function generateBackup()
    {
        $prefs = array(
                'tables'      => array('se_users'),  // Array of tables to backup.
                'ignore'      => array(),           // List of tables to omit from the backup
                'format'      => 'txt',             // gzip, zip, txt
                'filename'    => APPPATH.'migrations/mybackup.sql',    // File name - NEEDED ONLY WITH ZIP FILES
                'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
                'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
                'newline'     => "\n"               // Newline character used in backup file
                );

        if($this->dbutil->backup($prefs)){
            echo 'Exitoso';
        }
    }
}