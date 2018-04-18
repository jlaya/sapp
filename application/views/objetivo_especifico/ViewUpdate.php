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
        
        $("#plan_gobierno").select2('val',$("#id_plan_gobierno").val());

        $("#registrar").click(function (e) {

            e.preventDefault();  // Para evitar que se envíe por defecto

            if ($('#plan_gobierno').val().trim() == '') {

                bootbox.alert("Seleccione el plan de Gobierno", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#plan_gobierno").parent('div').addClass('has-error');
                    $("#plan_gobierno").select2('open');
                });

            } else if ($('#linea_estrategica').val().trim() == '') {
                bootbox.alert("Seleccione la linea Estratégica", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#linea_estrategica").parent('div').addClass('has-error');
                    $("#linea_estrategica").select2('open');
                });
            } else if ($('#objetivo_especifico').val().trim() == '') {

                bootbox.alert("Ingrese los Objetivos Específicos", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#objetivo_especifico").parent('div').addClass('has-error');
                    $("#objetivo_especifico").focus();
                });

            } else {

                $.post('<?php echo base_url(); ?>objetivo_especifico/ControllersObjE/modificar', $('#form_obj_esp').serialize(), function (response) {

                    if (response == '1') {

                        bootbox.alert("Disculpe, el objetivo se encuentra asociado al plan de la nación y la linea estratégica, verifique los datos ", function () {
                        }).on('hidden.bs.modal', function (event) {
                            $("#objetivo_especifico").parent('div').addClass('has-error');
                             $("#objetivo_especifico").focus();
                        });

                    } else {
                        bootbox.alert("Se actualizo con exito", function () {
                        }).on('hidden.bs.modal', function (event) {
                            url = '<?php echo base_url(); ?>objetivo_especifico/ControllersObjE'
                            window.location = url
                        });
                    }
                });

            }
        });
        
        // Validacion ajax para reflejar los datos en formato json
        $("#plan_gobierno").click(function (e) {

            var plan_g = $(this).val();
            $('#linea_estrategica').find('option:gt(0)').remove().end().select2('val', "");
            $.post('<?php echo base_url(); ?>objetivo_especifico/ControllersObjE/ajax_search/' + plan_g + '', function (response) {

                var option = "";
                $.each(response, function (i) {

                    option += "<option value=" + response[i]['id'] + ">" + response[i]['linea_estrategica'] + "</option>";
                });
                $('#linea_estrategica').append(option);
            }, 'json');
        });
        
        var plan_g = $("#id_plan_gobierno").val();
        var linea = $("#id_linea_estrategica").val();
        $('#linea_estrategica').find('option:gt(0)').remove().end().select2('val', "");
        $.post('<?php echo base_url(); ?>objetivo_especifico/ControllersObjE/ajax_search/' + plan_g + '', function (response) {

            var option = "";
            $.each(response, function (i) {

                option += "<option value=" + response[i]['id'] + ">" + response[i]['linea_estrategica'] + "</option>";
            });
            $('#linea_estrategica').append(option);
            $("#linea_estrategica").select2('val',parseInt(linea));
        }, 'json');
        
    });

</script>
<br/>
<br/>
<br/>
<br/>
<form id="form_obj_esp" action="" method="POST">
    <div style="width: 95%;text-transform:uppercase;box-shadow: 0 1px 5px rgba(0,0,0,.85);margin: auto;" class="panel panel-default">
        <div class="panel-heading" style='background: linear-gradient(#2F9292, #3B7272);color:#FFFFFF;' >
            <label style="float: left" class="panel-title " ><a  href="<?php echo base_url(); ?>objetivo_especifico/ControllersObjE" >Configuraciones</a>
                > Modificar Objetivo Específico</label>
            <br>
        </div>
        <fieldset><legend class="titulo text-center">Datos de los Objetivos Específicos</legend></fieldset>
        <div class="panel-body">
            <div class="col-xs-2">Plan de Gobierno</div>
            <div class="col-xs-7">
                <select id='plan_gobierno' name='plan_gobierno' style='width: 130%;'>
                    <option value=''>Seleccione</option>
                    <?php
                    foreach ($lista_plan_gobierno as $value) {
                        ?>
                        <option value="<?php echo $value->id; ?>"><?php
                            echo $value->codigo . " / ";
                            echo $value->plan_gobierno;
                            ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-2">Linea Estratégica</div>
            <div class="col-xs-7">
                <select id='linea_estrategica' name='linea_estrategica' style='width: 130%;'>
                    <option value=''>Seleccione</option>
                </select>
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-2">Objetivos Específicos</div>
            <div class="col-xs-7">
                <textarea class="form-control" id="objetivo_especifico" name="objetivo_especifico" rows="4" cols="50" style="width: 130%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();"><?php echo $detalles_lista->objetivo_especifico ?></textarea> 
            </div>
        </div>
        <br/>
        <div class="row" style="text-align: center">
            <a href="<?php echo base_url(); ?>objetivo_especifico/ControllersObjE">
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
<input type="hidden" id="id_plan_gobierno" value="<?php echo $detalles_lista->plan_gobierno ?>" />
<input type="hidden" id="id_linea_estrategica" value="<?php echo $detalles_lista->linea_estrategica ?>" />
