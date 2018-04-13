<div class="title_left">
    <h3>MEDIDAS CAUTELARES</h3>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Registro de Medidas Cautelares</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br />
                <?php
                $attributes = array('id' => 'frmmedidas');
                echo form_open('registro/medida/guardar', $attributes);
                ?>
                <?php echo form_hidden('token', $token) ?>
                <input type="hidden" name="id" value="<?php echo $id?>" id="id">
                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-6 ">
                        <label for="ci">Cédula de Identidad *</label>
                        <input id="ci" name="ci" class="form-control" type="text" >
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 ">
                        <label for="causa_medida">Causa *</label>
                        <input id="causa_medida" name="causa_medida" class="form-control" type="text" >
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-6 ">
                        <label for="tribunal">Tribunal *</label>
                        <input id="tribunal" name="tribunal" class="form-control" type="text" >
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 ">
                        <label for="delito_id">Delito * </label>
                        <select id="delito_id" name="delito_id" class="form-control" required>
                            <option value="0">Seleccione...</option>
                            <?php
                            foreach ($delito as $delito) {
                                ?>
                                <option value="<?php echo $delito->id?>"><?php echo $delito->delito?></option>

                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-6 ">
                        <label for="dias">Días *</label>
                        <input id="dias" name="dias" class="form-control" type="text" >
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 ">
                        <label for="meses">Meses *</label>
                        <input id="meses" name="meses" class="form-control" type="text" >
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-6 ">
                        <label for="fecha_inicio">Fecha de Inicio</label>
                        <div class="col-md-12 xdisplay_inputx form-group has-feedback">
                            <input type="text"  readonly="readonly" style="background-color: #FFFFFF" id="fecha_inicio" name="fecha_inicio" class="form-control has-feedback-left">
                            <span aria-hidden="true" class="fa fa-calendar-o form-control-feedback left"></span>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 ">
                        <label for="fecha_final">Fecha Final</label>
                        <div class="col-md-12 xdisplay_inputx form-group has-feedback">
                            <input type="text"  readonly="readonly" style="background-color: #FFFFFF" id="fecha_final" name="fecha_final" class="form-control has-feedback-left">
                            <span aria-hidden="true" class="fa fa-calendar-o form-control-feedback left"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <label for="estado">Estado *</label>
                        <input id="estado" name="estado" class="form-control" type="text" >
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
                        <table id="tblticket" class="tabla table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action">
                            <thead>
                                <tr>
                                    <th class="column-title">#</th>
                                    <th class="column-title">Cedula</th>
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
                                        <td><?php echo $lista->ci?></td>
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
    <script src="<?php echo assets_url('script/medidas.js'); ?>" type="text/javascript" charset="utf-8" ></script>

