<link rel="stylesheet" href="<?php echo assets_url('css/jquery.fancyform.css'); ?>">
<style type="text/css">
    li {
        list-style:none;
    }
    span + ul.hide{
        display:none;
    }
    span + ul.show{
        display:bloc;
    }
</style>
<?php
$attributes = array('id' => 'frmpermiso');
echo form_open('seguridad/permiso/agregar', $attributes);
?>
<?php echo form_hidden('token', $token) ?>
<?php
$data = array('name'=> 'id', 'id'=> 'id', 'value'=> $id, 'type'=>'hidden');
echo form_input($data);
?>
<div class="row">
    <div class="col-xs-12">
        <div class="form-group col-xs-6">
            <label >Perfil</label>
            <select name="perfil_id" id="perfil_id" class="form-control input-sm select2" data-add="id" data-mod="1">
                <option value="0">Seleccione</option>
                <?php
                foreach ($perfiles as $perfil) {
                    ?>
                    <option value="<?php echo $perfil->id;?>"><?php echo $perfil->perfil;?></option>
                    option
                    <?php
                }
                ?>
            </select>
        </div>
        <div class="form-group col-xs-6">
            <label >Usuario</label>
            <select name="user_id" id="user_id" class="form-control input-sm select2" data-add="id" data-mod="1">
                <option value="0">Seleccione</option>
                <?php
                foreach ($usuarios as $usuario) {
                    ?>
                    <option value="<?php echo $usuario->id;?>"><?php echo $usuario->si_user;?></option>
                    option
                    <?php
                }
                ?>
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="form-group col-xs-12" >
            <label >Modulos</label>
            <?php  echo modulos(); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-4 col-xs-push-4" style="text-align: center">
        <input type="button" class="btn btn-primary" data-accion="guardar" id="guardar" name="guardar" value="Guardar" />
        <input type="button" class="btn btn-warning" id="cancelar" name="cancelar" value="Cancelar" />
    </div>
</div>
<?php echo form_close(); ?>
<table data-counter="1" data-column='1'>
    <tr>
        <td></td>
    </tr>
</table>
<script type="text/javascript" src="<?php echo assets_url('js/jquery.fancyform.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('script/permiso.js'); ?>"></script>
