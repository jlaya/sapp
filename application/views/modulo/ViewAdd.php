<?php
    if (isset($this->session->userdata['logged_in'])) {
        $username = ($this->session->userdata['logged_in']['username']);
        $id = ($this->session->userdata['logged_in']['id']);
    } else {
        $header = base_url();
        header("location: ".$header);
    }
?>
<script>
    $(document).ready(function () {
        $('#modulo').alpha({allow:" /"});
        $('#url').alpha({allow:"_/"});
        $('#posicion').numeric({allow:""});
        $("#registrar").click(function (e) {

            e.preventDefault();  // Para evitar que se envíe por defecto

             if ($('#modulo').val().trim() == '') {
                bootbox.alert("Rellene el campo módulo", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#modulo").parent('div').addClass('has-error');
                    $("#modulo").focus();
                });
            } else if ($('#url ').val().trim() == '' && $('#desplegable').is(':checked') == true) {
                bootbox.alert("Ingrese la url", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#url").parent('div').addClass('has-error');
                    $("#url").select2('open');
                });
            } else if ($('#posicion').val().trim() == '') {
                bootbox.alert("Seleccione la posición", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#posicion").parent('div').addClass('has-error');
                    $("#posicion").select2('open');
                });
            } else {

                $.post('<?php echo base_url(); ?>modulo/ControllersModulo/guardar', $('#form_modulo').serialize(), function (response) {
                    
                    if (response == '1') {
                        
                        bootbox.alert("Disculpe, ya existe un modulo registrado, verifique los datos ", function () {
                        }).on('hidden.bs.modal', function (event) {
                            $("#modulo").parent('div').addClass('has-error');
                            $("#modulo").focus();
                        });
                        
                    }else{
                        $("#url").prop('disabled',false);
                        bootbox.alert("Se registro con exito", function () {
                        }).on('hidden.bs.modal', function (event) {
                            url = '<?php echo base_url(); ?>modulo/ControllersModulo'
                            window.location = url
                        });
                    }
                });
            }
        });
        
        $("#desplegable").click(function () {
            var desplegable = $('#desplegable').is(':checked');
            if (desplegable == true) {
                $("#url").attr('readonly',false);
            }else{
                $("#url").attr('readonly',true);
            }
        });
    });

</script>
<br/>
<br/>
<br/>
<br/>
<form id='form_modulo' action="" method="POST">
    <div style="width: 95%;text-transform:uppercase;box-shadow: 0 1px 5px rgba(0,0,0,.85);margin: auto;" class="panel panel-default">
        <div class="panel-heading" style='background: linear-gradient(#2F9292, #3B7272);color:#FFFFFF;' >
            <label style="float: left" class="panel-title " ><a  href="<?php echo base_url();?>modulo/ControllersModulo">Configuraciones > Configuración</a>
                > Registrar Módulo</label>
            <br>
        </div>
        <fieldset><legend class="titulo text-center">Datos del Módulo</legend></fieldset>
        <div class="panel-body">
            <div class="col-xs-2" >Módulo</div>
            <div class="col-xs-10">
                <input id="modulo" autofocus="" style="width: 100%;" placeholder="Ingrese el nombre del módulo" name="modulo" type="text" class="form-control" />
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-2" >Url</div>
            <div class="col-xs-10">
                <input id="url" readonly='readonly' style="width: 100%;"  placeholder="Ingrese la url" name="url" type="text" class="form-control" />
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-2" >Posición</div>
            <div class="col-xs-6">
                <input id="posicion" style="width: 20%;" placeholder="Posición" name="posicion" type="text" class="form-control" />
            </div>
            <div class="col-xs-2" style='margin-left: -37%'>
                <label>¿Enlace?&nbsp;&nbsp;</label>
                <input id="desplegable" name="desplegable" type="checkbox" />
            </div>
            <div class="col-xs-2" style='margin-left: -15%'>
                <label>Activo&nbsp;&nbsp;</label>
                <input id="activo" name="activo" checked='checked' type="checkbox" />
            </div>
        </div>
        <br/>
        <div class="row" style="text-align: center">
            <a href="<?php echo base_url('modulo/ControllersModulo'); ?>">
                <button type="button" id="volver" style="font-weight: bold;font-size: 13px" class="btn btn-warning " >
                    &nbsp;<span class="glyphicon glyphicon-chevron-left"></span>&nbsp;Volver
                </button>
            </a>
            <input type="submit" id="registrar" style="font-weight: bold;font-size: 13px" class="btn btn-success" value="Guardar cambios"/>
            <button type="reset" id="limpiar" style="font-weight: bold;font-size: 13px; background: -moz-linear-gradient(#f4eb2f, #e5a32d); color: white " class="btn"/>
            &nbsp;<span class="glyphicon glyphicon-retweet"></span>&nbsp;&nbsp;Limpiar
            </button>
            <input type="hidden" name="id" value="" />
        </div>
        <br/>
    </div>
</form>
