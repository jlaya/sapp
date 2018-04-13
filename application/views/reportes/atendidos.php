<div class="x_content">
    <br />
    <form id="frmtickets" autocomplete="off" action="<?php echo base_url('index.php/registro/usuario/guardar');?>" method="post" data-parsley-validate class="form-horizontal form-label-left">
        <div class="form-group">
            <div class="col-md-5 col-sm-5 col-xs-5 ">
                <label for="si_user">Desde *</label>
                <div class="col-md-11 xdisplay_inputx form-group has-feedback">
                    <input type="text"  placeholder="Desde" id="desde" name="desde" class="form-control has-feedback-left">
                    <span aria-hidden="true" class="fa fa-calendar-o form-control-feedback left"></span>
                </div>
            </div>
            <div class="col-md-5 col-sm-5 col-xs-5 ">
                <label for="first_name">Hasta * </label>
                <div class="col-md-11 xdisplay_inputx form-group has-feedback">
                    <input type="text"  placeholder="Hasta" id="hasta" name="hasta" class="form-control has-feedback-left">
                    <span aria-hidden="true" class="fa fa-calendar-o form-control-feedback left"></span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-1 col-sm-12 col-xs-12 ">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </form>
</div>
<script src="<?php echo assets_url('js/moment.min.js'); ?>"></script>
<script src="<?php echo assets_url('js/daterangepicker.js'); ?>"></script>
<script src="<?php echo assets_url('script/ticket.js'); ?>" type="text/javascript" charset="utf-8" ></script>

<script type="text/javascript">
    $(document).ready(function() {

        var ano = (new Date).getFullYear();
        ano = parseInt(ano);
        var enero = '01-01-' + ano;
        var fech_desde = '';

        var startDate   = new Date('01/01/' + ano);
        var FromEndDate = new Date();
        var ToEndDate   = new Date();
        ToEndDate.setDate(ToEndDate.getDate() + 90);


        $('#desde').datepicker({
        language: "es",
        format: 'dd/mm/yyyy',
        //weekStart: 1,
        //daysOfWeekDisabled: "0,6",
        startDate: '01/01/' + ano,
        endDate: '1d',
        autoclose: true,
        clearBtn: true,
        //todayBtn: "linked",
        orientation: "top auto"
    }).on('changeDate', function(selected, e) {
        $('#l_hoy').removeClass('success');
        $('#l_hoy').addClass('disabled');
        $('#btnaccion').prop('disabled', false);
        $('#hasta').val('');
        var consul = $('select#consultorio').find('option:selected').val();
        var ps = $('select#ps').find('option:selected').val();
        if ($(this).val() != '') {
            startDate = new Date(selected.date.valueOf());
            startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())) + 1);
            $('#hasta').datepicker('setStartDate', startDate);
        } else if ($(this).val() == '' && $('#hasta').val() == '' && consul == 0 && ps == 0) {
            var FromEndDate = new Date();
            var ToEndDate = new Date();
            ToEndDate.setDate(ToEndDate.getDate() + 90);
            $('#desde').datepicker('setEndDate', ToEndDate);
            $('#l_hoy').removeClass('disabled');
            $('#btnaccion').prop('disabled', true);
        }
    });

    $('#hasta').datepicker({
        language: "es",
        format: 'dd/mm/yyyy',
        ///weekStart: 1,
        //daysOfWeekDisabled: "0,6",
        startDate: startDate,
        endDate: '1d',
        autoclose: true,
        clearBtn: true,
        //todayBtn: "linked",
        orientation: "top auto"
    }).on('changeDate', function(selected) {
        $('#l_hoy').removeClass('success');
        $('#l_hoy').addClass('disabled');
        $('#btnaccion').prop('disabled', false);
        var consul = $('select#consultorio').find('option:selected').val();
        var ps = $('select#ps').find('option:selected').val();
        if ($(this).val() != '') {
            FromEndDate = new Date(selected.date.valueOf());
            FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf()))-1);
            var FromEndDate = new Date();
            var ToEndDate = new Date();
            ToEndDate.setDate(ToEndDate.getDate() + 90);
            $('#desde').datepicker('setEndDate', ToEndDate);
        } else if ($(this).val() == '' && $('#desde').val() == '' && consul == 0 && ps == 0) {
            var FromEndDate = new Date();
            var ToEndDate = new Date();
            ToEndDate.setDate(ToEndDate.getDate() + 90);
            $('#desde').datepicker('setEndDate', ToEndDate);
            $('#l_hoy').removeClass('disabled');
            $('#btnaccion').prop('disabled', true);
        }
    });
});
</script>