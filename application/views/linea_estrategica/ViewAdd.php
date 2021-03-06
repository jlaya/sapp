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
        
        $('#linea_estrategica').alpha({allow:" -.,:"});
        $("#registrar").click(function (e) {
            
            e.preventDefault();  // Para evitar que se envíe por defecto

            if ($('#plan_gobierno').val().trim() == '') {

                bootbox.alert("Seleccione un Plan de Gobierno", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#plan_gobierno").parent('div').addClass('has-error');
                    $("#plan_gobierno").select2('open');
                });

            } else if ($('#linea_estrategica').val().trim() == '') {
                bootbox.alert("Rellene el campo Línea Estratégica", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#linea_estrategica").parent('div').addClass('has-error');
                    $("#linea_estrategica").focus();
                });
            } else {

                $.post('<?php echo base_url(); ?>linea_estrategica/ControllersLineaE/guardar', $('#form_linea_estrategica').serialize(), function (response) {
                    
                    if (response == '1') {
                        
                        bootbox.alert("Disculpe, ya existe una Linea Estratégica registrado, verifique los datos ", function () {
                        }).on('hidden.bs.modal', function (event) {
                            $("#linea_estrategica").parent('div').addClass('has-error');
                            $("#linea_estrategica").focus();
                        });
                        
                    }else{
                        bootbox.alert("Se registro con exito", function () {
                        }).on('hidden.bs.modal', function (event) {
                            url = '<?php echo base_url(); ?>linea_estrategica/ControllersLineaE'
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
<form id='form_linea_estrategica' action="" method="POST">
    <div style="width: 95%;text-transform:uppercase;box-shadow: 0 1px 5px rgba(0,0,0,.85);margin: auto;" class="panel panel-default">
        <div class="panel-heading" style='background: linear-gradient(#2F9292, #3B7272);color:#FFFFFF;' >
            <label style="float: left" class="panel-title " ><a  href="<?php echo base_url();?>linea_estrategica/ControllersLineaE" >Configuraciones</a>
                > Registrar Línea Estratégica</label>
            <br>
        </div>
        <fieldset><legend class="titulo text-center">Datos de la Línea Estratégica</legend></fieldset>
        <div class="panel-body">
            <div class="col-xs-2" >Plan de Gobierno</div>
            <div class="col-xs-4">
                <select id='plan_gobierno' name="plan_gobierno" class="form-control" style="width: 100%">
                    <option value="">Seleccione</option>
                    <?php
                    foreach ($lista_plan_gobierno as $value) {
                        ?>
                        <option value="<?php echo $value->id; ?>"><?php echo $value->codigo." / "; echo $value->plan_gobierno; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-xs-2" >Línea Estratégica</div>
            <div class="col-xs-4">
                <input id="linea_estrategica" style="width: 100%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Ingrese la línea Estratégica" name="linea_estrategica" type="text" class="form-control" />
            </div>
        </div>
        <br/>
        <div class="row" style="text-align: center">
            <a href="<?php echo base_url('linea_estrategica/ControllersLineaE'); ?>">
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
