<?php
    if(isset($_GET['ver'])){
        $preliminar = $_GET['ver'];
    }else{
        $preliminar = "2";
    }
?>
<script>
    $(document).ready(function () {
        if(<?php echo $preliminar;?> == 1){
            $("input,textarea,select").prop('disabled',true);
        }

        $("select").select2();

        $("#plan_patria").select2('val', $("#id_plan_patria").val());

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

                bootbox.alert("Ingrese los Objetivos Nacionales", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#objetivo_nacional").parent('div').addClass('has-error');
                    $("#objetivo_nacional").focus();
                });

            } else {

                $.post('<?php echo base_url(); ?>objetivo_nacional/ControllersObjN/modificar', $('#form_plan_nacional').serialize(), function (response) {

                    if (response == '1') {

                        bootbox.alert("Disculpe, el objetivo se encuentra asociado al plan de la nación y la linea estratégica, verifique los datos ", function () {
                        }).on('hidden.bs.modal', function (event) {
                            $("#objetivo_nacional").parent('div').addClass('has-error');
                            $("#objetivo_nacional").focus();
                        });

                    } else {
                        bootbox.alert("Se actualizo con exito", function () {
                        }).on('hidden.bs.modal', function (event) {
                            url = '<?php echo base_url(); ?>objetivo_nacional/ControllersObjN'
                            window.location = url
                        });
                    }
                });

            }
        });

        // Validacion ajax para reflejar los datos en formato json
        $("#plan_patria").click(function (e) {

            var plan_p = $(this).val();
            $('#objetivo_historico').find('option:gt(0)').remove().end().select2('val', "");
            $.post('<?php echo base_url(); ?>objetivo_nacional/ControllersObjN/ajax_search/' + plan_p + '', function (response) {

                var option = "";
                $.each(response, function (i) {

                    option += "<option value=" + response[i]['id'] + ">" + response[i]['objetivo_historico'] + "</option>";
                });
                $('#objetivo_historico').append(option);
            }, 'json');
        });

        var plan_p = $("#id_plan_patria").val();
        var obj_h = $("#id_objetivo_historico").val();
        $('#objetivo_historico').find('option:gt(0)').remove().end().select2('val', "");
        $.post('<?php echo base_url(); ?>objetivo_nacional/ControllersObjN/ajax_search/' + plan_p + '', function (response) {

            var option = "";
            $.each(response, function (i) {

                option += "<option value=" + response[i]['id'] + ">" + response[i]['objetivo_historico'] + "</option>";
            });
            $('#objetivo_historico').append(option);
            $("#objetivo_historico").select2('val', parseInt(obj_h));
        }, 'json');

    });

</script>
<br/>
<br/>
<br/>
<br/>
<form id="form_plan_nacional" action="" method="POST">
    <div style="width: 95%;text-transform:uppercase;box-shadow: 0 1px 5px rgba(0,0,0,.85);margin: auto;" class="panel panel-default">
        <div class="panel-heading" style='background: linear-gradient(#2F9292, #3B7272);color:#FFFFFF;' >
            <label style="float: left" class="panel-title " ><a  href="<?php echo base_url(); ?>objetivo_nacional/ControllersObjN" >Configuraciones</a>
                > Modificar Objetivo Nacional</label>
            <br>
        </div>
        <fieldset><legend class="titulo text-center">Datos de los Objetivos Nacionales</legend></fieldset>
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
            <div class="col-xs-2">Objetivos Nacionales</div>
            <div class="col-xs-7">
                <textarea class="form-control" id="objetivo_nacional" name="objetivo_nacional" rows="4" cols="50" style="width: 130%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();"><?php echo $detalles_lista->objetivo_nacional; ?></textarea> 
            </div>
        </div>
        <br/>
        <div class="row" style="text-align: center">
            <a href="<?php echo base_url(); ?>objetivo_nacional/ControllersObjN">
                <button type="button" id="volver" style="font-weight: bold;font-size: 13px" class="btn btn-warning " >
                    &nbsp;<span class="glyphicon glyphicon-chevron-left"></span>&nbsp;Volver
                </button>
            </a>
            <?php if($preliminar !=1){?>
                <input type="submit" id="registrar" style="font-weight: bold;font-size: 13px" class="btn btn-success" value="Guardar cambios"/>
                <button type="reset" id="limpiar" style="font-weight: bold;font-size: 13px; background: -moz-linear-gradient(#f4eb2f, #e5a32d); color: white " class="btn"/>
                &nbsp;<span class="glyphicon glyphicon-retweet"></span>&nbsp;&nbsp;Limpiar
                </button>
            <?php }?>
            <input type="hidden" name="id" value="<?php echo $this->uri->rsegment(3) ?>" />
        </div>
        <br/>
    </div>
</form>
<input type="hidden" id="id_plan_patria" value="<?php echo $detalles_lista->plan_patria ?>" />
<input type="hidden" id="id_objetivo_historico" value="<?php echo $detalles_lista->objetivo_historico ?>" />