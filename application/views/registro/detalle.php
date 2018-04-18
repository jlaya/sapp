<div class="title_left">
    <h3>DETALLE DE RESEÑA</h3>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Detalle de la Ficha</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br />
                <?php
                $attributes = array('id' => 'frmdetalles');
                echo form_open('registro/resena/sa_detalle', $attributes);
                ?>
                <?php echo form_hidden('token', $token) ?>
                <input type="hidden" name="id" value="<?php echo $id ?>" id="id">



                <div style="display: none;" id="div_falta" class="col-xs-12">
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-6 ">
                            <label for="ci">Cédula de Identidad *</label>
                            <input id="ci" name="ci" class="form-control" type="text" readonly="">
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 ">
                            <label for="nombre">Nombres*</label>
                            <input id="nombre" disabled="disabled" name="nombre" class="form-control" type="text" readonly="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <label for="decision_tribunal">Decisión del tribunal</label>
                            <select id="decision_tribunal" name="decision_tribunal" class="form-control" required style="width:100%">
                                <option value="0">Seleccione...</option>
                                <option value="1">Privativo de libertad</option>
                                <option value="2">Liberta Plena</option>
                                <option value="3">Medida cautelar sustitutiva de libertad</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 ">
                            <label for="delito_id">Delito o Falta* </label>
                            <select id="delito_id" name="delito_id" class="form-control" required style="width:100%">
                                <option value="0">Seleccione...</option>
                                <?php
                                foreach ($delito as $delito) {
                                    ?>
                                    <option value="<?php echo $delito->id ?>"><?php echo $delito->delito ?></option>

                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-6 ">
                            <label for="estado_id">Estado * </label>
                            <select id="estado_id" name="estado_id" class="form-control" required style="width:100%">
                                <option value="0">Seleccione...</option>
                                <?php
                                foreach ($estado as $estado) {
                                    ?>
                                    <option value="<?php echo $estado->cod_estado ?>"><?php echo $estado->estado ?></option>

                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-6 ">
                            <label for="abogado_defensor">Abogado *</label>
                            <select id="abogado_defensor" name="abogado_defensor" class="form-control" required style="width:100%">
                                <option value="0">Seleccione...</option>
                                <option value="1">Publico</option>
                                <option value="2">Privado</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-6 ">
                            <label for="causa">Causa *</label>
                            <input id="causa" name="causa" class="form-control" type="text" >
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 ">
                            <label for="fecha_de_presentacion">Fecha de Presentación</label>
                            <div class="col-md-12  has-feedback">
                                <input type="text"  readonly="readonly" style="background-color: #FFFFFF" id="fecha_de_presentacion" name="fecha_de_presentacion" class="form-control has-feedback-left">
                                <span aria-hidden="true" class="fa fa-calendar-o form-control-feedback left"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="control-label ">Detalles de la falta
                                <span class="required">*</span>
                            </label>
                            <textarea id="detalle_falta" name="detalle_falta" class="resizable_textarea form-control"  style="overflow: hidden; word-wrap: break-word; resize: horizontal;"></textarea>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                    <br/>
                    <div class="form-group">
                        <div class="col-xs-4 col-xs-push-4" style="text-align: center">
                            <input type="button" class="btn btn-primary" data-accion="guardar" id="guardar" name="guardar" value="Guardar" />
                            <input type="button" class="btn btn-warning close-falta" id="cancelar" name="cancelar" value="Cancelar" />
                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="table-responsive">
                        <div class="form-horizontal">

                            <div class="modal-body">
                                <div><span style="font-weight: bold;">Nota:</span> El código resaltado en color indica la identificación de la reseña en caso de que no posea cédula de identidad</div>
                                <table id="tblticket" class="tabla table dataTable table-striped table-bordered dt-responsive nowrap jambo_table bulk_action"  cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Foto</th>
                                            <th>Cédula</th>
                                            <th>Nombres y Apellidos</th>
                                            <th>Apodo</th>
                                            <th style="width:5%;">Agregar</th>
                                            <th style="width:5%;">Ver</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th style="color:white;">Foto</th>
                                            <th>Cédula</th>
                                            <th>Nombres y Apellidos</th>
                                            <th>Apodo</th>
                                            <th style="width:5%;color:white;">Agregar</th>
                                            <th style="width:5%;color:white;">Ver</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($lista_resena as $lista) {
                                            ?>
                                            <tr id="<?php echo $lista->ci ?>">
                                                <td>
                                                    <?php
                                                    if (isset($lista->ruta_file)) {
                                                        ?>
                                                    <a class="ejemplo_1" href="<?php echo base_url() . "assets/$lista->ruta_file"; ?>" title="<?php echo $lista->nombres . ' ' . $lista->apellidos." <span style='color:#A52A2A'>N° de indentificación:</span> ".$lista->codigo ?>">
                                                        <img src="<?php echo base_url() . "assets/$lista->ruta_file"; ?>" width="35px" style="text-align: center;"/>
                                                    </a>
                                                    <?php } else { ?>
                                                        <img title="No posee imagen de perfil..." src="<?php echo base_url() . "assets/images/default_avatar_male.jpg"; ?>" width="35px" style="text-align: center;cursor: pointer;"/>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if ($lista->ci == $lista->codigo) { ?>
                                                        <span class="label label-warning" style="font-weight: bold;"><?php echo $lista->ci ?></span>
                                                    <?php } else { ?>
                                                        <?php echo $lista->ci ?>
                                                    <?php } ?>
                                                </td>
                                                <td><?php echo $lista->nombres . ' ' . $lista->apellidos ?></td>
                                                <td><?php echo $lista->apodo; ?></td>
                                                <td>
                                                    <button title="Agregar nueva falta" class="btn btn-info add-falta cursor modificar"><span class="fa fa-plus"></span></button>
                                                </td>
                                                <td>
                                                    <button title="Ver faltas" class="btn btn-info serch-falta"><span class="fa fa-list"></span></button>
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
                    <!--                        <table id="tblticket" class="tabla table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action">
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
                                                                <tr id="<?php echo $lista->id ?>">
                                                                    <td><?php echo $i ?></td>
                                                                    <td><?php echo $lista->ci ?></td>
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
                                            </table>-->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--APERTURA LISTA DE FALTA-->
    <div class="modal fade" id="mostrar_falta" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog" style="width: 70%;margin-left: 23%;">
        <div class="modal-content form-horizontal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <div id="Heading"></div>
                <div class="titulo">Delitos cometidos</div>
            </div>
            <div class="modal-body" style="width: 100%;">
                <table id="tblfalta" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Estado</th>
                            <th>Desición</th>
                            <th>Delito</th>
                            <th>Abogado</th>
                            <th>Fecha</th>
                            <th>Causa</th>
                            <th>Delito</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
    <!--FIN DE LISTA DE FALTA-->

    <script src="<?php echo assets_url('script/detalle.js'); ?>" type="text/javascript" charset="utf-8" ></script>

