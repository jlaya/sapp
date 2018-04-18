<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of Modulo
 *
 * @author josue
 */
class MModulo extends SI_Model
{
    private $table = 'se_modulo';
    private $directorio = array();
    //private $ruta = "application/controllers";
    public function __construct()
    {
        parent::__construct();

    }
    public function modulo()
    {
        $this->db->select('id, modulo');
        $this->db->where_in('modulo_id', 0);
        $query = $this->db->get($this->table);
        return $query->result();
    }
    public function listar()
    {
        $this->db->select("m.id, m.modulo_id, CASE   WHEN modulo_id>0 THEN (SELECT modulo FROM se_modulo WHERE id=m.modulo_id) ELSE ''END as modulo, m.modulo as submodulo, m.posicion, m.route, m.activo");
        $this->db->order_by("id", "asc");
        $query = $this->db->get('se_modulo AS m');
        // echo $this->db->last_query();
        return $query->result();
    }
    public function agregar($data)
    {
        $insert = $this->db->insert($this->table, $data);
        return $insert;
    }
    public function buscar($id)
    {
        $this->db->select('modulo, posicion, controller, route, modulo_id, activo');
        $this->db->where('id',$id);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    public function mostrarcontroladores($rutas,$modulo)
    {
        $carpeta = $rutas;
        $pos = strpos($carpeta, 'migrations');
        if($pos === false){
            if(is_dir($carpeta)){
                if($dir = opendir($carpeta)){
                    while(($archivo = readdir($dir)) !== false){
                        $ext = substr($archivo, -3, 3);
                        if($ext == "php"){
                            $archi = $modulo.'/'.substr($archivo, 0, -4);
                            // echo $archi;
                            $this->db->where('controller', $archi);
                            $query = $this->db->get($this->table);
                            if($query->num_rows()==0){
                                //if($archivo != '.' && $archivo != '..' && $archivo != '.htaccess'){
                                $archivo = str_replace('.php', '', $archivo);
                                $this->directorio[] = $modulo.'/'.$archivo;
                            }
                        }
                    }
                    closedir($dir);
                }
            }
        }
    }

    function listar_directorios_ruta($ruta)
    {
        // abrir un directorio y listarlo recursivo
        if (is_dir($ruta)) {
            if ($dh = opendir($ruta)) {
                while (($file = readdir($dh)) !== false) {
                        //esta línea la utilizaríamos si queremos listar todo lo que hay en el directorio
                        //mostraría tanto archivos como directorios
                    if (is_dir($ruta . $file) && $file!="." && $file!=".."){
                        //solo si el archivo es un directorio, distinto que "." y ".."
                        $existe= strpos($file, 'migrations');
                        $this->listar_directorios_ruta($ruta . $file . "/");
                        $this->mostrarcontroladores($ruta . $file . "/",$file);
                    }
                }
                closedir($dh);
            }
        }else{
            echo "<br>No es ruta valida";
        }
        return $this->directorio;
    }

    public function modificar($id,$data)
    {
        $this->db->where('id', $id);
        $result = $this->db->update($this->table,$data);
        return $result;
    }
    public function eliminar($id)
    {
                
        $result = $this->db->where('modulo_id =', $id);
        $result = $this->db->get('se_permissions');

        if ($result->num_rows() > 0) {
            #echo "CORRECTO";
            #echo '1';
        } else {
            
            $datos['id'] = $id;
            return $this->db->delete($this->table, $datos);
        }
        
    }

    public function getParent($id)
    {
        $this->db->select('modulo_id');
        $this->db->where('id',$id);
        $query = $this->db->get($this->table);
        return $query->row()->modulo_id;
    }
}