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
        $("select").select2();
        $('#sub_modulo').alpha({allow:" /"});
        //$('#url').alphanumeric({allow:"_#()"});
        $('#posicion').numeric({allow:""});
        $("#registrar").click(function (e) {

            e.preventDefault();  // Para evitar que se envíe por defecto

             if ($('#id_modulo').val().trim() == '') {
                bootbox.alert("Seleccione el módulo", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#id_modulo").parent('div').addClass('has-error');
                    $("#id_modulo").select2('open');
                });
            } else if ($('#sub_modulo').val().trim() == '') {
                bootbox.alert("Rellene el campo Sub módulo", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#sub_modulo").parent('div').addClass('has-error');
                    $("#sub_modulo").focus();
                });
            } else if ($('#url ').val().trim() == '') {
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

                $.post('<?php echo base_url(); ?>sub_modulo/ControllersSubModulo/guardar', $('#form_sub_modulo').serialize(), function (response) {
                    
                    if (response == '1') {
                        
                        bootbox.alert("Disculpe, ya existe una url o un sub modulo registrado, verifique los datos ", function () {
                        }).on('hidden.bs.modal', function (event) {
                            $("#id_modulo").parent('div').addClass('has-error');
                            $("#id_modulo").focus();
                        });
                        
                    }else{
                        bootbox.alert("Se registro con exito", function () {
                        }).on('hidden.bs.modal', function (event) {
                            url = '<?php echo base_url(); ?>sub_modulo/ControllersSubModulo/'
                            window.location = url
                        });
                    }
                });
            }
        });
        
        
    });

</script>
<br/>
<br/>
<br/>
<br/>
<form id='form_sub_modulo' action="" method="POST">
    <div style="width: 95%;text-transform:uppercase;box-shadow: 0 1px 5px rgba(0,0,0,.85);margin: auto;" class="panel panel-default">
        <div class="panel-heading" style='background: linear-gradient(#2F9292, #3B7272);color:#FFFFFF;' >
            <label style="float: left" class="panel-title " ><a  href="<?php echo base_url();?>modulo/ControllersModulo">Configuraciones > Configuración</a>
                > Registrar Sub Módulo</label>
            <br>
        </div>
        <fieldset><legend class="titulo text-center">Datos del Sub Módulo</legend></fieldset>
        <div class="panel-body">
            <div class="col-xs-2" >Módulo</div>
            <div class="col-xs-10">
                <select id="id_modulo" name='id_modulo' style="width: 100%;" class='form-control'>
                    <option value=''>Seleccione</option>
                    <?php foreach ($lista_modulo as $value) {
                        if($value->desplegable == "f" and $value->activo == "t"){
                        ?>
                        <option value='<?php echo $value->id;?>'><?php echo $value->modulo;?></option>
                    <?php }}?>
                </select>
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-2" >Sub Módulo</div>
            <div class="col-xs-10">
                <input id="sub_modulo" style="width: 100%;" placeholder="Ingrese el nombre del sub módulo" name="sub_modulo" type="text" class="form-control" />
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-2" >Url</div>
            <div class="col-xs-10">
                <input id="url" style="width: 100%;"  placeholder="Ingrese la url" name="url" type="text" class="form-control" />
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-2" >Posición</div>
            <div class="col-xs-6">
                <input id="posicion" style="width: 20%;" placeholder="Posición" name="posicion" type="text" class="form-control" />
            </div>
            <div class="col-xs-2" style='margin-left: -35%'>
                <label>Activo&nbsp;&nbsp;</label>
                <input id="activo" name="activo" checked='checked' type="checkbox" />
            </div>
        </div>
        <br/>
        <div class="row" style="text-align: center">
            <a href="<?php echo base_url('sub_modulo/ControllersSubModulo'); ?>">
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
