<style>
    img.mouse:hover{
        cursor: pointer;
    }
    .table-hover tbody tr:hover{
        background-color: #E0E0E0;
    }
    .selected{
        background-color: blue !important;
    }
</style>
<?php
$attributes = array('id' => 'frmperfil', 'class'=>'frmform');
echo form_open('seguridad/perfil/agregar', $attributes);
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
            <input type="text" data-validate='required|max(20)|min(5)' data-type="alpha" data-text="upper" data-add="id" data-mod="1" class="form-control input-sm" id="perfil" name="perfil" value="">
        </div>
        <div class="form-group col-xs-6" style="margin-top: 20px;">
            <label>Estatus</label>
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-default active">
                    <input type="radio" name="activo" value="1" data-add="name" data-mod="2" checked="checked"><span>Activo</span>
                </label>
                <label class="btn btn-default">
                    <input type="radio" name="activo" value="0"><span>Inactivo</span>
                </label>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-4 col-xs-push-4" style="text-align: center">
        <input type="button" class="btn btn-primary" data-action="guardar" data-accion="agregar" id="guardar" name="guardar" value="Guardar" />
        <input type="button" class="btn btn-warning" id="cancelar" name="cancelar" value="Cancelar" />

    </div>
</div>
<?php echo form_close(); ?>
<div class="row" style="width: 98%;margin: auto">
    <div class="col-xs-12">
        <table id="tblperfil" data-counter="1"  data-column='1' class="table table-striped table-bordered table-hover tbl-table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Perfil</th>
                    <th>Estatus</th>
                    <th>Modificar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i=1;
                foreach ($listar as $lista) {

                    $activo = 'Activo';
                    if($lista->activo=='0'){
                        $activo = 'Inactivo';
                    }
                    ?>
                    <tr id="<?php echo $lista->id;?>" data-ids="<?php echo $lista->id;?>">
                        <td><?php echo $i?></td>
                        <td><?php echo $lista->perfil; ?></td>
                        <td><?php echo $activo; ?></td>
                        <td>
                            <img data-id="<?php echo $lista->id?>" class="modificar mouse" src="<?php echo assets_url('img/datatable/modificar.png') ?>" alt="">
                        </td>
                        <td>
                            <img data-id="<?php echo $lista->id?>" class="eliminar mouse" src="<?php echo assets_url('img/datatable/eliminar.png') ?>" alt="">
                        </td>
                    </tr>
                    <?php
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<script src="<?php echo assets_url('script/perfil.js'); ?>" type="text/javascript" charset="utf-8" ></script>