<div class="title_left">
    <h3>Form Elements</h3>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Forme Design <small>different form elements</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br />
                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-6 ">
                        <label for="si_user">Desde *</label>
                        <div class="col-md-12 xdisplay_inputx form-group has-feedback">
                            <input type="text"  readonly="readonly" style="background-color: #FFFFFF" placeholder="Desde" id="desde" name="desde" class="form-control has-feedback-left">
                            <span aria-hidden="true" class="fa fa-calendar-o form-control-feedback left"></span>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 ">
                        <label for="first_name">Hasta * </label>
                        <div class="col-md-12 xdisplay_inputx form-group has-feedback">
                            <input type="text"  readonly="readonly" style="background-color: #FFFFFF" placeholder="Hasta" id="hasta" name="hasta" class="form-control has-feedback-left">
                            <span aria-hidden="true" class="fa fa-calendar-o form-control-feedback left"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
                        <button type="button" class="btn btn-success" id="generarsolicitud"><i class="fa fa-download"></i> Generar  PDF</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo assets_url('js/moment.min.js'); ?>"></script>
<script src="<?php echo assets_url('js/daterangepicker.js'); ?>"></script>
<script src="<?php echo assets_url('script/ticket.js'); ?>" type="text/javascript" charset="utf-8" ></script>