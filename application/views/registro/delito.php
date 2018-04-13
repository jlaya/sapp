<div class="title_left">
    <h3>Delitos</h3>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Registro de Delitos</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br />
                <?php
                $attributes = array('id' => 'frmdelito');
                echo form_open('registro/delito/guardar', $attributes);
                ?>
                <?php echo form_hidden('token', $token) ?>
                <input type="hidden" name="id" value="<?php echo $id?>" id="id">
                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-6 ">
                        <label for="delito">Delito *</label>
                        <input id="delito" name="delito" class="form-control" type="text" >
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 ">
                        <label for="last_name">Estatus * </label>
                        <select id="estatus" name="estatus" class="form-control" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                </div>
                <?php echo form_close();?>
                <br/>
                <div class="form-group">
                    <div class="col-xs-4 col-xs-push-4" style="text-align: center">
                        <input type="button" class="btn btn-primary" data-accion="guardar" id="guardar" name="guardar" value="Guardar" />
                        <input type="button" class="btn btn-warning" id="cancelar" name="cancelar" value="Cancelar" />
                    </div>
                </div>
                <br/>
                <div class="ln_solid"></div>
                <div class="col-xs-12">
                    <div class="table-responsive">
                        <table id="tbldelito" class="tabla table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action">
                            <thead>
                                <tr>
                                    <th class="column-title">#</th>
                                    <th class="column-title">Delito</th>
                                    <th class="column-title">Modificar</th>
                                    <th class="column-title">Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($lista as $lista) {
                                    ?>
                                    <tr id="<?php echo $lista->id?>">
                                        <td><?php echo $i?></td>
                                        <td><?php echo $lista->delito?></td>
                                        <td>
                                            <img class="cursor modificar" src="<?php echo assets_url('img/datatable/modificar.png') ?>" alt="">
                                        </td>
                                        <td>
                                            <img class="cursor eliminar" src="<?php echo assets_url('img/datatable/eliminar.png') ?>" alt="">
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
        </div>
    </div>
    <script src="<?php echo assets_url('script/delito.js'); ?>" type="text/javascript" charset="utf-8" ></script>

