<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MDetalle extends SI_Model {

    private $table = 'detalles';

    public function __construct()
    {
        parent::__construct();
    }

    public function listar()
    {
        $query = $this->db->select("*")
        ->get($this->table);
        return $query->result();
    }

    public function buscar($id)
    {
        $query = $this->db->select("*")
        ->where('ci', $id)
        ->get('ficha');
        return $query->row();
    }

    public function buscar_falta($ci)
    {
        $result = $this->db->select("d.causa,d.detalle_falta,de.delito,es.estado,d.fecha_de_presentacion,d.decision_tribunal,d.abogado_defensor")->where('ci', $ci);
        $result = $this->db->from('detalles d');
        $result = $this->db->join('delito de','d.delito_id=de.id');
        $result = $this->db->join('estados es','d.estado_id=es.cod_estado');
        $result = $this->db->get();
        return $result->result();
    }
    
    public function buscar_ced($ci)
    {
        $query = $this->db->select("*")
        ->where('ci', $ci)
        ->get('ficha');
        return $query->row();
    }

    public function guardar($data)
    {
        $insert = $this->insert($this->table, $data);
        return $insert;
    }

    public function modificar($data)
    {
        $result = $this->update($this->table,$data);
        return $result;
    }
    public function eliminar($id)
    {
        $datos['estatus'] = 0;
        $this->db->where('id', $id);
        $result = $this->db->update($this->table,$datos);
        return $result;
    }

}
