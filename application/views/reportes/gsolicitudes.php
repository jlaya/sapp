<div class="title_left">
    <h3>Solicitudes</h3>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Graficas de Solicitudes</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br />
                <form id="frmtickets" autocomplete="off" action="" method="post" data-parsley-validate class="form-horizontal form-label-left">
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-6 ">
                            <label for="mesanios">Mes y Año</label>
                            <div class="col-md-12 xdisplay_inputx form-group has-feedback">
                                <input type="text"  readonly="readonly" id="mesanio" name="mesanio" class="form-control has-feedback-left" style="background-color: #FFFFFF" placeholder="Ano">
                                <span aria-hidden="true" class="fa fa-calendar-o form-control-feedback left"></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 ">
                            <div class="radio">
                                <label>
                                    <input type="radio" class="flat" checked name="tipo" value="1"> Estatus
                                </label>
                                <label>
                                    <input type="radio" class="flat" name="tipo" value="2"> Prioridad
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-1 col-sm-12 col-xs-12 ">
                            <button type="button" class="btn btn-primary" id="generargrafica"><i class="fa fa-pie-chart"></i> Generar  PDF</button>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Pie Graph</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                <div id="piesolicitudes" style="height:350px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo assets_url('js/moment.min.js'); ?>"></script>
<script src="<?php echo assets_url('js/daterangepicker.js'); ?>"></script>
<script src="<?php echo assets_url('vendors/echarts/dist/echarts.min.js'); ?>"></script>
<script src="<?php echo assets_url('script/ticket.js'); ?>" type="text/javascript" charset="utf-8" ></script>