<!-- page content -->
<div  role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Solicitudes sin atender</h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-11 xdisplay_inputx form-group has-feedback">
                <input type="text"  placeholder="First Name" id="fecha" class="form-control has-feedback-left">
                <span aria-hidden="true" class="fa fa-calendar-o form-control-feedback left"></span>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo assets_url('js/moment.min.js'); ?>"></script>
<script src="<?php echo assets_url('js/daterangepicker.js'); ?>"></script>
<script src="<?php echo assets_url('script/ticket.js'); ?>" type="text/javascript" charset="utf-8" ></script>

<script type="text/javascript">
    $(document).ready(function() {

        $('#fecha').daterangepicker({
            //startDate: moment(),
            endDate: moment().subtract(30,'days'),
            //minDate: moment().subtract(30,'days'),
            minDate: moment().subtract(30,'days'),
            maxDate: moment(),
            singleDatePicker: true,
            calender_style: "picker_4",
            format: 'DD/MM/YYYY',
            locale: {
                daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            }
        });
    });
</script>