<div class="panel-body">

    <?php
        $attributes = array('id' => 'frmusers', 'class'=>'frmform');
        echo form_open('seguridad/users/agregar', $attributes);
        ?>
        <?php echo form_hidden('token', $token) ?>
        <?php
        $data = array('name'=> 'id', 'id'=> 'id', 'value'=> $id, 'type'=>'hidden');
        echo form_input($data);
         ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="form-group col-xs-4">
                    <label >Usuario</label>
                    <input type="text" id="si_user" name="si_user" data-validate='required|max(20)|min(5)' data-type="alphanumeric" data-text="lower" data-add="id"  class="form-control input-sm" value="">
                </div>
                <div class="form-group col-xs-4">
                    <label >Nombre</label>
                    <input type="text" id="first_name" name="first_name" data-validate='required|max(20)|min(5)' data-type="alphaspace" data-text="capitalize" data-add="id" class="form-control input-sm" value="">
                </div>
                <div class="form-group col-xs-4">
                    <label >Apellido</label>
                    <input type="text" id="last_name" name="last_name" data-validate='required|max(20)|min(5)' data-type="alphaspace" data-text="capitalize" data-add="id" class="form-control input-sm" value="">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="form-group col-xs-4">
                    <label >Correo</label>
                    <input type="text" id="correo" name="correo" data-validate='required|email' data-text="lower" data-add="id" class="form-control input-sm" value="">
                </div>
                <div class="form-group col-xs-4">
                    <label >Clave</label>
                    <input type="password" id="si_password" name="si_password" data-validate='required|max(20)|min(5)' class="form-control input-sm" value="">
                </div>
                <div class="form-group col-xs-4">
                    <label >Repetir Clave</label>
                    <input type="password" id="si_rpassword" name="si_rpassword" data-nosend="true" data-validate='required|max(20)|min(5)|match(si_password)'  data-match="si_password" class="form-control input-sm" value="">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="form-group col-xs-4" >
                    <label >Perfil</label>
                    <select name="perfil_id" id="perfil_id" class="form-control input-sm select2" data-add="id" data-validate='required'>
                        <option value="0">Seleccione</option>
                        <?php
                        foreach ($perfiles as $perfil) {
                            ?>
                            <option value="<?php echo $perfil->id;?>"><?php echo $perfil->perfil;?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-xs-4">
                    <label >Nombre a Mostrar</label>
                    <select name="show_panel" id="show_panel" data-add="id" class="form-control input-sm select2">
                        <option value="1">Nombre de Usuario</option>
                        <option value="2">Nombre y Apellido</option>
                    </select>
                </div>
                <div class="form-group col-xs-4">
                    <label >Estatus</label>
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-default active">
                            <input type="radio" name="active" value="1" data-add="name" checked="checked"><span>Activo</span>
                        </label>
                        <label class="btn btn-default">
                            <input type="radio" name="active" value="0"><span>Inactivo</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4 col-xs-push-4" style="text-align: center">
                <input type="button" class="btn btn-primary" data-accion="agregar" data-method="agregar" id="guardar" name="guardar" value="Guardar" />
                <input type="button" class="btn btn-warning" id="cancelar" name="cancelar" value="Cancelar" />
                <!-- para user el plugin inputNumber() ->
                    <!-- <div class="div-input-number">
                        <input type="text" class="form-control input-sm input-number" max="10" min="0" jump="3" length="2" begin="2">
                    </div> -->
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>

    <div class="row" style="width: 98%;margin: auto">
        <div class="col-xs-12">
            <table id="tblusers"  data-counter="1"  data-column='6' class="table table-striped table-bordered table-hover tbl-table dt-responsive" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Usuario</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Perfil</th>
                    <th>Estatus</th>
                    <th>Modificar</th>
                    <!--<th>Eliminar</th>-->
                </tr>
            </thead>
            <tbody>
                <?php
                $i=1;
                foreach ($listar as $lista) {
                        $activo = 'Activo';
                        if($lista->active=='f'){
                            $activo = 'Inactivo';
                        }
                    ?>
                    <tr id="<?php echo $lista->id;?>" data-ids="<?php echo $lista->id;?>">
                        <td><?php echo $i?></td>
                        <td><?php echo $lista->si_user; ?></td>
                        <td><?php echo $lista->first_name; ?></td>
                        <td><?php echo $lista->last_name; ?></td>
                        <td><?php echo $lista->perfil; ?></td>
                        <td><?php echo $activo; ?></td>
                        <td>
                            <img data-id="<?php echo $lista->id?>"  class="modificar mouse" src="<?php echo assets_url('img/datatable/modificar.png') ?>" alt="">
                        </td>
                        <!--<td>
                            <img data-id="<?php echo $lista->id?>" title="Eliminar" class="eliminar mouse" src="<?php echo assets_url('img/datatable/eliminar.png') ?>" alt="">
                        </td> -->
                    </tr>
                    <?php
                    $i++;
                }
                ?>
            </tbody>
        </table>
        </div>
    </div>
</div>


<script src="<?php echo assets_url('script/users.js'); ?>" type="text/javascript" charset="utf-8" ></script>