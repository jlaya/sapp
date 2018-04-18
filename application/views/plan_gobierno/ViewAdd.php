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
        $('#plan_gobierno').alphanumeric({allow:" -.,:"});
        $('#codigo').alphanumeric({allow:"-."});
        $("#registrar").click(function (e) {

            e.preventDefault();  // Para evitar que se envíe por defecto

            if ($('#codigo').val().trim() == '') {

                bootbox.alert("Rellene el campo de Código", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#codigo").parent('div').addClass('has-error');
                    $("#codigo").focus();
                });

            } else if ($('#plan_gobierno').val().trim() == '') {
                bootbox.alert("Rellene el campo de Plan de Gobierno", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#plan_gobierno").parent('div').addClass('has-error');
                    $("#plan_gobierno").focus();
                });
            } else {

                $.post('<?php echo base_url(); ?>plan_gobierno/ControllersPlanGobierno/guardar', $('#form_plan_gobierno').serialize(), function (response) {
                    
                    if (response == '1') {
                        
                        bootbox.alert("Disculpe, ya existe un código o Plan de Gobierno registrado, verifique los datos ", function () {
                        }).on('hidden.bs.modal', function (event) {
                            $("#plan_gobierno").parent('div').addClass('has-error');
                            $("#plan_gobierno").focus();
                        });
                        
                    }else{
                        bootbox.alert("Se registro con exito", function () {
                        }).on('hidden.bs.modal', function (event) {
                            url = '<?php echo base_url(); ?>plan_gobierno/ControllersPlanGobierno'
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
<form id='form_plan_gobierno' action="" method="POST">
    <div style="width: 95%;text-transform:uppercase;box-shadow: 0 1px 5px rgba(0,0,0,.85);margin: auto;" class="panel panel-default">
        <div class="panel-heading" style='background: linear-gradient(#2F9292, #3B7272);color:#FFFFFF;' >
            <label style="float: left" class="panel-title " ><a href="<?php echo base_url();?>plan_gobierno/ControllersPlanGobierno" >Configuraciones</a>
                > Registrar Plan de Gobierno</label>
            <br>
        </div>
        <fieldset><legend class="titulo text-center">Datos del Plan de Gobierno</legend></fieldset>
        <div class="panel-body">
            <div class="col-xs-1" >Código</div>
            <div class="col-xs-4">
                <input id="codigo" style="width: 100%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Ingrese el código" name="codigo" type="text" class="form-control" />
            </div>
            <div class="col-xs-2" >Plan de Gobierno</div>
            <div class="col-xs-4">
                <input id="plan_gobierno" style="width: 100%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Ingrese el Plan de Gobierno" name="plan_gobierno" type="text" class="form-control" />
            </div>
        </div>
        <br/>
        <div class="row" style="text-align: center">
            <a href="<?php echo base_url('plan_gobierno/ControllersPlanGobierno'); ?>">
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
