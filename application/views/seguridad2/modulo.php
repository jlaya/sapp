<style>
    img.mouse:hover{
        cursor: pointer;
    }
    .table-hover tbody tr:hover{
        background-color: #E0E0E0;
    }
    .sub-rayar:hover{
        text-decoration: underline;
        cursor: pointer;
        color: #0154A0;
    }
    #contextMenuClap.dropdown-menu{
        width: 20% !important;
        min-width: 20%
    }
    #contextMenuClap{
        position: absolute;
        display:none;
    }
    .datos{
        cursor: pointer;
    }
    .jefe_familia
    {
        background-image: url(<?php echo assets_url('img/COMUNIDAD.png'); ?>);
        background-position: 25 25;
        background-size: 1200px 320px;
        background-repeat: no-repeat;
    }
</style>
<div class="panel-body" style="background-color: white;">

    <?php
        $attributes = array('id' => 'frmmodulo');
        echo form_open('index.php/seguridad/modulo/agregar', $attributes);
        ?>
        <?php echo form_hidden('token', $token) ?>
        <?php echo form_hidden('id', $id) ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="form-group col-xs-6">
                    <label >Modulo</label>
                    <input type="text" data-validate='required|max(15)|min(3)' data-type="alpha" data-text="upper" class="form-control input-sm" id="modulo" name="modulo" value="" data-add="id" data-mod="1" >
                </div>
                <div class="form-group col-xs-6" >
                    <label>Posici&oacute;n</label>
                    <input type="text" data-validate='required|max(2)' data-type="numeric" class="form-control input-sm" id="posicion" name="posicion" value="" data-add="id" data-mod="1" >
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="form-group col-xs-6" >
                    <label>Controller</label>
                    <!--<input type="text"  class="form-control input-sm" id="controller" name="controller" value="">-->
                    <select name="controller" id="controller" class="form-control select2 input-sm">
                        <option value="0">Seleccione</option>
                        <?php
                        foreach ($directorio as $directorio) {
                            ?>
                            ?>
                            <option value="<?php echo $directorio ?>"><?php echo $directorio ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-xs-6">
                    <label>Route</label>
                    <input type="text"  class="form-control input-sm" id="route" name="route" value="">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
            <div class="form-group col-xs-6">
                    <label >Modulo Padre</label>
                    <select name="modulo_id" id="modulo_id" class="form-control select2 input-sm">
                        <option value="0">Seleccione</option>
                        <?php
                        foreach ($modulos as $modulo) {
                            ?>
                            <option value="<?php echo $modulo->id?>"><?php echo $modulo->modulo?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-xs-6" style="margin-top: 20px;">
                    <label>Estatus</label>
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-default active">
                            <input type="radio" name="activo" value="1" checked="checked"> Activo
                        </label>
                        <label class="btn btn-default">
                            <input type="radio" name="activo" value="0"> Inactivo
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4 col-xs-push-4" style="text-align: center">
                <input type="button" class="btn btn-primary" data-accion="agregar" id="guardar" name="guardar" value="Guardar" />
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
            <table id="tblmodulo" data-counter="1" data-column='1' class="tabla table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Modulo</th>
                    <th>Posici&oacute;n</th>
                    <th>Estatus</th>
                    <th>Sub Modulo</th>
                    <th>Posici&oacute;n</th>
                    <th>Estatus</th>
                    <th>Modificar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i=1;
                foreach ($lista as $modulo) {

                    $modul = $modulo->modulo;
                    $modpo = '';
                    $modac = '';
                    if($modulo->modulo==''){
                        $modul = $modulo->submodulo;
                        $modpo = $modulo->posicion;
                        $modac = 'Activo';

                        if($modulo->activo=='f'){
                            $modac = 'Inactivo';
                        }
                    }
                    $submodu = '';
                    $submodpo = '';
                    $submodac = '';
                    if($modulo->modulo!=''){
                        $submodu = $modulo->submodulo;
                        $submodpo = $modulo->posicion;
                        $submodac = 'Activo';
                        if($modulo->activo=='f'){
                            $submodac = 'Inactivo';
                        }
                    }
                    ?>
                    <tr id="<?php echo $modulo->id;?>" data-ids="<?php echo $modulo->id;?>">
                        <td><?php echo $i?></td>
                        <td><?php echo $modul; ?></td>
                        <td><?php echo $modpo; ?></td>
                        <td><?php echo $modac; ?></td>
                        <td><?php echo $submodu; ?></td>
                        <td><?php echo $submodpo; ?></td>
                        <td><?php echo $submodac; ?></td>
                        <td>
                            <img data-id="<?php echo $modulo->id?>" class="modificar mouse" src="<?php echo assets_url('img/datatable/modificar.png') ?>" alt="">
                        </td>
                        <td>
                            <img data-id="<?php echo $modulo->id?>" class="eliminar mouse" src="<?php echo assets_url('img/datatable/eliminar.png') ?>" alt="">
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
</div>

<div id="contextMenuClap" class="dropdown clearfix menu-clap" style="width:20%">
    <ul class="dropdown-menu animated fadeInDown" role="menu" aria-labelledby="dropdownMenu" style="display:block;position:static;margin-bottom:5px;">
        <li><a style="cursor: pointer" id="a_integrantes" class="integrantes">Comunidad</a></li>
        <li class="divider"></li>
        <li><a style="cursor: pointer" id="a_mod" class="action">Modificar</a></li>
        <li><a style="cursor: pointer" id="a_eli" class="action">Eliminar</a></li>
        <!--<li><a style="cursor: pointer" id="ver" class="action">Ver Calles Asociadas</a></li>-->
    </ul>
</div>
<script src="<?php echo assets_url('script/modulo.js'); ?>" type="text/javascript" charset="utf-8" ></script>