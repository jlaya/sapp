<?php
/**
*
*/
class MConfiguracion extends CI_Model
{
    private $table = 'sis_configuracion';
    private $table_acc = 'acciones_registro';
    private $table_proy = 'proyecto_registro';
    function __construct()
    {
        parent::__construct();
    }

    // Accion centralizada y proyecto con sus distintos filtros
    public function busqueda_aprobado($table, $ano_fiscal, $acc)
    {
        $this->db->select('r.id,r.codigo,o.siglas,o.nom_ins');
        $this->db->from("$table r");
        $this->db->join('organos_entes AS o', 'r.ente = o.id', 'inner');
        $this->db->where('r.estatus', 4);
        $this->db->where('r.cierre',$acc);
        $this->db->where('r.ano_fiscal', $ano_fiscal);
        $this->db->order_by('r.id', "ASC");
        $query = $this->db->get();
        return $query->result();
    }

    public function save($data)
    {   
        $acc = $data['cierre'];

        if (isset($data['ids_accion'])) {
            // Accion centralizada
            foreach ($data['ids_accion'] as $key => $value) {
                $ids_value = $value;
                $datos['cierre']     = $acc;
                $this->db->where('id', $ids_value);
                $query = $this->db->update($this->table_acc,$datos);
            }
        }

        if (isset($data['ids_proyecto'])) {
            // Proyecto
            foreach ($data['ids_proyecto'] as $key => $value) {
                $ids_value = $value;
                $datos['cierre']     = $acc;
                $this->db->where('id', $ids_value);
                $query = $this->db->update($this->table_proy,$datos);
            }
        }
    }
}