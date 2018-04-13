<?php
if (isset($this->session->userdata['logged_in'])) {
    $username = ($this->session->userdata['logged_in']['username']);
    $id       = ($this->session->userdata['logged_in']['id']);
} else {
    $header = base_url();
    header("location: " . $header);
}
?>
<script>
    $(document).ready(function () {

        $("select").select2();

        $("#registrar").click(function (e) {

            e.preventDefault();  // Para evitar que se envíe por defecto

            if ($('#plan_patria').val().trim() == '') {

                bootbox.alert("Seleccione el plan de la Patria", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#plan_patria").parent('div').addClass('has-error');
                    $("#plan_patria").select2('open');
                });

            } else if ($('#objetivo_historico').val().trim() == '') {
                bootbox.alert("Seleccione el Objetivo Histórico", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#objetivo_historico").parent('div').addClass('has-error');
                    $("#objetivo_historico").select2('open');
                });
            } else if ($('#objetivo_nacional').val().trim() == '') {

                bootbox.alert("Seleccione el Objetivo Nacional", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#objetivo_nacional").parent('div').addClass('has-error');
                    $("#objetivo_nacional").select2('open');
                });

            } else if ($('#objetivo_estrategico').val().trim() == '') {

                bootbox.alert("Ingrese el Objetivo Estratégico", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#objetivo_estrategico").parent('div').addClass('has-error');
                    $("#objetivo_estrategico").focus();
                });

            } else {

                $.post('<?php echo base_url(); ?>objetivo_estrategico/ControllersObjE/guardar', $('#form_obj_estrategico').serialize(), function (response) {

                    if (response == '1') {

                        bootbox.alert("Disculpe, el objetivo Estratégico se encuentra asociado al plan de la patria, Objetivo Histórico, Objetivo Nacional, verifique los datos ", function () {
                        }).on('hidden.bs.modal', function (event) {
                            $("#objetivo_estrategico").parent('div').addClass('has-error');
                             $("#objetivo_estrategico").focus();
                        });

                    } else {
                        bootbox.alert("Se registro con exito", function () {
                        }).on('hidden.bs.modal', function (event) {
                            url = '<?php echo base_url(); ?>objetivo_estrategico/ControllersObjE'
                            window.location = url
                        });
                    }
                });
            }
        });


        // Validacion ajax para reflejar los datos en formato json
        $("#plan_patria").click(function (e) {

            var plan_p = $(this).val();
            $('#objetivo_historico,#objetivo_nacional').find('option:gt(0)').remove().end().select2('val', "");
            $.post('<?php echo base_url(); ?>objetivo_estrategico/ControllersObjE/ajax_search/' + plan_p + '', function (response) {

                var option = "";
                $.each(response, function (i) {

                    option += "<option value=" + response[i]['id'] + ">" + response[i]['objetivo_historico'] + "</option>";
                });
                $('#objetivo_historico').append(option);
            }, 'json');
        });
        
        
        // Validacion ajax para reflejar los datos en formato json
        $("#plan_patria,#objetivo_historico").click(function (e) {

            var plan_p = $("#plan_patria").val();
            var obj_h  = $("#objetivo_historico").val();
            $('#objetivo_nacional').find('option:gt(0)').remove().end().select2('val', "");
            $.post('<?php echo base_url(); ?>objetivo_estrategico/ControllersObjE/ajax_search_multiple_two/' + plan_p + '/'+ obj_h +'', function (response) {

                var option = "";
                $.each(response, function (i) {

                    option += "<option value=" + response[i]['id'] + ">" + response[i]['objetivo_nacional'] + "</option>";
                });
                $('#objetivo_nacional').append(option);
            }, 'json');
        });
        
    });

</script>
<br/>
<br/>
<br/>
<br/>
<form id='form_obj_estrategico' action="" method="POST">
    <div style="width: 95%;text-transform:uppercase;box-shadow: 0 1px 5px rgba(0,0,0,.85);margin: auto;" class="panel panel-default">
        <div class="panel-heading" style='background: linear-gradient(#2F9292, #3B7272);color:#FFFFFF;' >
            <label style="float: left" class="panel-title " ><a  href="<?php echo base_url(); ?>objetivo_estrategico/ControllersObjE" >Configuraciones</a>
                > Registrar Objetivo Estratégico</label>
            <br>
        </div>
        <fieldset><legend class="titulo text-center">Datos del Objetivo Estratégico</legend></fieldset>
        <div class="panel-body">
            <div class="col-xs-2">Plan de la Patria</div>
            <div class="col-xs-7">
                <select id='plan_patria' name='plan_patria' style='width: 130%;'>
                    <option value=''>Seleccione</option>
                    <?php
                    foreach ($lista_plan_patria as $value) {
                        ?>
                        <option value="<?php echo $value->id; ?>"><?php
                            echo $value->codigo . " / ";
                            echo $value->plan_patria;
                            ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-2">Objetivo Histórico</div>
            <div class="col-xs-7">
                <select id='objetivo_historico' name='objetivo_historico' style='width: 130%;'>
                    <option value=''>Seleccione</option>
                </select>
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-2">Objetivo Nacional</div>
            <div class="col-xs-7">
                <select id='objetivo_nacional' name='objetivo_nacional' style='width: 130%;'>
                    <option value=''>Seleccione</option>
                </select>
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-2">Objetivo Estratégico</div>
            <div class="col-xs-7">
                <textarea class="form-control" id="objetivo_estrategico" name="objetivo_estrategico" rows="4" cols="50" style="width: 130%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();"></textarea> 
            </div>
        </div>
        <br/>
        <div class="row" style="text-align: center">
            <a href="<?php echo base_url(); ?>objetivo_estrategico/ControllersObjE">
                <button type="button" id="volver" style="font-weight: bold;font-size: 13px" class="btn btn-warning " >
                    &nbsp;<span class="glyphicon glyphicon-chevron-left"></span>&nbsp;Volver
                </button>
            </a>
            <input type="submit" id="registrar" style="font-weight: bold;font-size: 13px" class="btn btn-success" value="Guardar cambios"/>
            <button type="reset" id="limpiar" style="font-weight: bold;font-size: 13px; background: -moz-linear-gradient(#f4eb2f, #e5a32d); color: white " class="btn"/>
            &nbsp;<span class="glyphicon glyphicon-retweet"></span>&nbsp;&nbsp;Limpiar
            </button>
        </div>
        <br/>
    </div>
</form>