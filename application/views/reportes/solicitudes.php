<div class="title_left">
    <h3>Solicitudes</h3>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Reporte de Solicitudes</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br />
                <form id="frmtickets" autocomplete="off" action="<?php echo base_url('index.php/registro/usuario/guardar');?>" method="post" data-parsley-validate class="form-horizontal form-label-left">
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-6 ">
                            <label for="estatus">Estatus</label>
                            <select id="estatus" name="estatus" class="form-control" required>
                                <option value="0">Seleccione..</option>
                                <?php
                                foreach ($estatus as $estatus) {
                                    ?>
                                    <option value="<?php echo $estatus->id;?>"><?php echo $estatus->estatus;?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 ">
                            <label for="prioridad">Prioridad</label>
                            <select id="prioridad" name="prioridad" class="form-control" required>
                                <option value="0">Seleccione..</option>
                                <?php
                                foreach ($prioridad as $prioridad) {
                                    ?>
                                    <option value="<?php echo $prioridad->id;?>"><?php echo $prioridad->prioridad;?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-6 ">
                            <label for="servicio">Servicio</label>
                            <select id="servicio" name="servicio" class="form-control" required>
                                <option value="0">Seleccione..</option>
                                <?php
                                foreach ($servicio as $servicio) {
                                    ?>
                                    <option value="<?php echo $servicio->id;?>"><?php echo $servicio->servicio;?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 ">
                            <label for="tecnico">Tecnico</label>
                            <select id="tecnico" name="tecnico" class="form-control" required>
                                <option value="0">Seleccione..</option>
                                <?php
                                foreach ($tecnico as $tecnico) {
                                    ?>
                                    <option value="<?php echo $tecnico->id;?>"><?php echo $tecnico->first_name.' '.$tecnico->last_name;?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-6 ">
                            <label for="last_name">Desde</label>
                            <div class="col-md-12 xdisplay_inputx form-group has-feedback">
                                <input type="text"  readonly="readonly" style="background-color: #FFFFFF" placeholder="Desde" id="desde" name="desde" class="form-control has-feedback-left">
                                <span aria-hidden="true" class="fa fa-calendar-o form-control-feedback left"></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 ">
                            <label for="last_name">Hasta</label>
                            <div class="col-md-12 xdisplay_inputx form-group has-feedback">
                                <input type="text"  readonly="readonly" style="background-color: #FFFFFF" placeholder="Hasta" id="hasta" name="hasta" class="form-control has-feedback-left">
                                <span aria-hidden="true" class="fa fa-calendar-o form-control-feedback left"></span>
                            </div>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-1 col-sm-12 col-xs-12 ">
                            <button type="button" class="btn btn-success" id="generarsolicitud"><i class="fa fa-download"></i> Generar  PDF</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo assets_url('js/moment.min.js'); ?>"></script>
<script src="<?php echo assets_url('js/daterangepicker.js'); ?>"></script>
<script src="<?php echo assets_url('script/ticket.js'); ?>" type="text/javascript" charset="utf-8" ></script>