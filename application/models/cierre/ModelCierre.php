<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ModelCierre
 *
 * @author jesus
 */
class ModelCierre extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }
    
    // Metodo publico, para el cierre de año fiscal
    public function cierre()
    {
        $data = array( 'cierre' => 2, );
        $this->db->where('ano_fiscal', date('Y',now()));
        $this->db->update('acciones_registro', $data); // Acciones de Registro
        $this->db->update('proyecto_registro', $data); // Ante Proyectos de Registro
        $this->db->update('observaciones_acciones', $data); // Observaciones de de Acciones
        $this->db->update('observaciones_acciones_proy', $data); // Observaciones de Ante Proyectos
    }
    
    
}
