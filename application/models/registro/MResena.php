<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

ini_set('memory_limit', '512M');

class MResena extends SI_Model {

    private $table = 'ficha';

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
    
    public function listar_nacionalidad()
    {
        $query = $this->db->select("*")
        ->get('nacionalidad');
        
        return $query->result();
    }
    
    public function listarf()
    {
        $query = $this->db->from('ficha f');
        $query = $this->db->join('ficha_foto ff','f.ci=ff.ci','left');
        $query = $this->db->get();
        return $query->result();
    }


    public function buscar($id)
    {
        /*$query = $this->db->select("*")->where('id', $id)->get($this->table);
        return $query->row(); */
        $result = $this->db->from('ficha f');
        $result = $this->db->join('resena r','f.ci=r.ci');
        $result = $this->db->where('f.id=', $id);
        $result = $this->db->get();
        return $result->row();
    }

    public function search_ficha($cedula)
    {
        $result = $this->db->from('ficha f');
        $result = $this->db->join('ficha_foto ff','f.ci=ff.ci','left');
        $result = $this->db->where('f.ci=', $cedula);
        $result = $this->db->get();
        return $result->row();
    }

    public function search_delito($cedula)
    {
        $query = $this->db->from('detalles de');
        $query = $this->db->join('delito dl','de.delito_id=dl.id','left');
        $query = $this->db->join('estados e','de.estado_id=e.cod_estado','left');
        $query = $this->db->where('de.ci=', $cedula);
        $query = $this->db->get();
        return $query->result();
    }
    
    
    
    public function search_delitos($delito)
    {
        $query = $this->db->from('detalles de');
         $query = $this->db->join('ficha f','de.ci=f.ci','left');
        $query = $this->db->join('delito dl','de.delito_id=dl.id','left');
        $query = $this->db->join('estados e','de.estado_id=e.cod_estado','left');
        $query = $this->db->where('de.delito_id=', $delito);
        $query = $this->db->get();
        return $query->result();
    }

    public function search_rasgos_fisicos($cedula)
    {
        $query = $this->db->select(""
                . "rc.descripcion cabeza,"
                . "rf.descripcion frente,"
                . "rce.descripcion cejas,"
                . "rn.descripcion nariz,"
                . "rb.descripcion boca,"
                . "rl.descripcion labios,"
                . "rm.descripcion menton,"
                . "rp.descripcion piel,"
                . "rcp.descripcion color_piel,"
                . "roj.descripcion ojos,"
                . "rco.descripcion color_ojos,"
                . "rca.descripcion cabello,"
                . "rcc.descripcion color_cabello,"
                . "rcon.descripcion contextura,"
                . "r.estatura,"
                . "r.peso,"
                . "r.cicatrices,"
                . "r.lunares,"
                . "r.tatuaje,"
                . "r.amputaciones,"
                . "r.quemaduras,"
                . "r.protesis,"
                );
        $query = $this->db->from('resena r');
        $query = $this->db->join('rasgos_cabeza rc','r.cabeza_id=rc.id','left');
        $query = $this->db->join('rasgos_frente rf','r.frente_id=rf.id','left');
        $query = $this->db->join('rasgos_cejas rce','r.cejas_id=rce.id','left');
        $query = $this->db->join('rasgos_nariz rn','r.nariz_id=rn.id','left');
        $query = $this->db->join('rasgos_boca rb','r.boca_id=rb.id','left');
        $query = $this->db->join('rasgos_labios rl','r.labios_id=rl.id','left');
        $query = $this->db->join('rasgos_menton rm','r.menton_id=rm.id','left');
        $query = $this->db->join('rasgos_orejas ro','r.orejas_id=ro.id','left');
        $query = $this->db->join('rasgos_piel rp','r.piel_id=rp.id','left');
        $query = $this->db->join('rasgos_color_piel rcp','r.color_piel_id=rcp.id','left');
        $query = $this->db->join('rasgos_ojos roj','r.ojos_id=roj.id','left');
        $query = $this->db->join('rasgos_color_ojos rco','r.color_ojos_id=rco.id','left');
        $query = $this->db->join('rasgos_cabello rca','r.cabello_id=rca.id','left');
        $query = $this->db->join('rasgos_color_cabello rcc','r.color_cabello_id=rcc.id','left');
        $query = $this->db->join('rasgos_contextura rcon','r.contextura=rcon.id','left');
        $query = $this->db->where('r.ci=', $cedula);
        $query = $this->db->get();
        return $query->row();
    }

    public function guardar($data)
    {

        $insert = $this->insert($this->table, $data, array('ci'=>$data['ci'],'nombres'=>$data['nombres']));

        if($insert == 1){

            $result = $this->insert('resena', $data);
            if($result){

                $input_file = 'foto';
                $cedula     = $data['ci'];
                $ruta_file  = 'fotos/';

                $config['upload_path']   = 'assets/'.$ruta_file;
                $config['allowed_types'] = 'gif|jpg|png';
                $config['overwrite'] = TRUE;

                $this->load->library('upload',$config);



                $config1['image_library']  = 'gd2';
                $config1['maintain_ratio'] = TRUE;
                $config1['width']          = 200;
                $config1['height']         = 200;
                // $config1['create_thumb']   = TRUE;

                $this->load->library('image_lib', $config1);


                $files = $_FILES;

                $cpt = count ($_FILES [$input_file]['name']);
                $j   = 1;

                $bandera      = TRUE;
                $bandera_file = FALSE;
                $h = 0;
                $this->db->trans_begin();

                for($i = 0; $i < $cpt; $i ++) {

                    $_FILES[$input_file]['name']     = $files[$input_file]['name'][$i];
                    $_FILES[$input_file]['type']     = $files[$input_file]['type'][$i];
                    $_FILES[$input_file]['tmp_name'] = $files[$input_file]['tmp_name'][$i];
                    $_FILES[$input_file]['error']    = $files[$input_file]['error'][$i];
                    $_FILES[$input_file]['size']     = $files[$input_file]['size'][$i];

                    $ext = pathinfo($_FILES[$input_file]['name'], PATHINFO_EXTENSION);
                    $config['file_name']     = $cedula."_$j.".$ext;
                    $this->upload->initialize ($config);
                    if (!$this->upload->do_upload($input_file)){
                        break;
                    }

                    $name_file = FCPATH.'assets/'.$ruta_file.$cedula."_$j.".$ext;
                    $img_redi  = FCPATH.'assets/fotos/redime/'.$cedula."_$j.".$ext;

                    $config1['source_image']   = $name_file;
                    $config1['new_image']      = $img_redi;


                    $this->image_lib->initialize ($config1);
                    if (!$this->image_lib->resize()) {
                        echo $this->image_lib->display_errors();
                    }
                    $this->image_lib->clear();

                    $imagedata = file_get_contents($img_redi);
                    $base64 = base64_encode($imagedata);

                    $datos['ci']        = $cedula;
                    $datos['ruta_file'] = $ruta_file.$cedula."_$j.".$ext;
                    $datos['foto_64']   = $base64;

                    if(is_file($name_file)){
                        $inser_file = $this->insert('ficha_foto', $datos);
                        if($inser_file){
                            $h++;
                        }
                    }

                    $j++;
                }

                $this->db->where('ci', $cedula);
                $this->db->from('ficha_foto');
                $count_fotos = $this->db->count_all_results();

                if($count_fotos == $h){
                    $this->db->trans_commit();
                }else{
                    $this->db->trans_rollback();
                }

            }

        }else if(count($insert) > 0){
            $result =  $insert;
        }

        return $result;

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

    public function delete_multiple_file($nombre, $ruta_foto)
    {
        FCPATH.$ruta_foto;
    }
}
