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

        $('#partida_presupuestaria').alpha({allow: " -."});
        $("#registrar").click(function (e) {

            e.preventDefault();  // Para evitar que se envíe por defecto
            
            if ($('#partida_presupuestaria').val().trim() == '') {
                bootbox.alert("Seleccione la Partida Presupuestaria", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#partida_presupuestaria").parent('div').addClass('has-error');
                    $("#partida_presupuestaria").select2('open');
                });
            } else if ($('#codigo').val().trim() == '') {

                bootbox.alert("Ingrese el código", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#codigo").parent('div').addClass('has-error');
                    $("#codigo").focus();
                });

            } else if ($('#accion_centralizada').val().trim() == '') {

                bootbox.alert("Seleccione la Acción Centralizada", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#accion_centralizada").parent('div').addClass('has-error');
                    $("#accion_centralizada").select2('open');
                });

            } else {

                $.post('<?php echo base_url(); ?>partida_presupuestaria_centralizada/ControllersPartidaPresupuestariaCentralizada/guardar', $('#form_partida_centralizada').serialize(), function (response) {

                    if (response == '1') {

                        bootbox.alert("Disculpe, ya existe un código asociado a una Partida Presupuestaria Centralizada, verifique los datos ", function () {
                        }).on('hidden.bs.modal', function (event) {
                            /*$("#partida_presupuestaria").parent('div').addClass('has-error');
                            $("#partida_presupuestaria").focus();*/
                        });

                    } else {
                        bootbox.alert("Se registro con exito", function () {
                        }).on('hidden.bs.modal', function (event) {
                            url = '<?php echo base_url(); ?>partida_presupuestaria_centralizada/ControllersPartidaPresupuestariaCentralizada'
                            window.location = url
                        });
                    }
                });
            }
        });
        
        $("#partida_presupuestaria").change(function () {
            var codigo = $("#partida_presupuestaria").find('option').filter(':selected').text().split('/')[0];
            $("#codigo").val(codigo);
        });
        
    });

</script>
<br/>
<br/>
<br/>
<br/>
<form id='form_partida_centralizada' action="" method="POST">
    <div style="width: 95%;text-transform:uppercase;box-shadow: 0 1px 5px rgba(0,0,0,.85);margin: auto;" class="panel panel-default">
        <div class="panel-heading" style='background: linear-gradient(#2F9292, #3B7272);color:#FFFFFF;' >
            <label style="float: left" class="panel-title " ><a  href="<?php echo base_url(); ?>partida_presupuestaria_centralizada/ControllersPartidaPresupuestariaCentralizada" >Configuraciones</a>
                > Registrar Partida Centralizada</label>
            <br>
        </div>
        <fieldset><legend class="titulo text-center">Datos de la Partida Centralizada</legend></fieldset>
        <div class="panel-body">
            <div class="col-xs-2">Partida presupuestaria</div>
            <div class="col-xs-4">
                <select id='partida_presupuestaria' name='partida_presupuestaria' style='width: 100%;'>
                    <option value=''>Seleccione</option>
                    <?php
                    foreach ($lista_partida_presupuestaria as $value) {
                        ?>
                        <option value="<?php echo $value->id; ?>"><?php echo $value->codigo . " / ";
                            echo $value->partida_presupuestaria; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-xs-1">Código</div>
            <div class="col-xs-4">
                <input readonly='readonly' id="codigo" style="width: 100%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Ingrese el código" name="codigo" type="text" class="form-control" />
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-2" >Acción centralizada</div>
            <div class="col-xs-10">
                <select id='accion_centralizada' name='accion_centralizada' style='width: 90%;'>
                    <option value=''>Seleccione</option>
                    <?php
                    foreach ($lista_acc_centralizada as $value) {
                        ?>
                        <option value="<?php echo $value->id; ?>"><?php echo $value->codigo . " / ";
                            echo $value->accion_centralizada; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <br/>
        <div class="row" style="text-align: center">
            <a href="<?php echo base_url(); ?>partida_presupuestaria_centralizada/ControllersPartidaPresupuestariaCentralizada">
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


<!--FORMULARIO PARA LA CREACION DE UNA PARTIDA PADRE-->

<form id='form_partida_padre' action="" method="POST" style='display: none;'>
    <div style="width: 95%;text-transform:uppercase;box-shadow: 0 1px 5px rgba(0,0,0,.85);margin: auto;" class="panel panel-default">
        <div class="panel-heading" style='background: linear-gradient(#2F9292, #3B7272);color:#FFFFFF;' >
            <label>Registrar Partida padre</label>
            <br>
        </div>
        <fieldset><legend class="titulo text-center">Datos de la Partida padre</legend></fieldset>
        <div class="panel-body">
            <div class="col-xs-1" >Padre</div>
            <div class="col-xs-10">
                <select name='partida_padre' style='width: 100%;' disabled='disabled'>
                    <option value=''>Seleccione partida padre</option>
                    <option value='nuevo'>Nueva partida padre</option>
                </select>
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-1" >Código</div>
            <div class="col-xs-4">
                <input id="codigo_padre" style="width: 100%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Ingrese el código" name="codigo" type="text" class="form-control" />
            </div>
            <div class="col-xs-2" >Nombre de la partida</div>
            <div class="col-xs-4">
                <input id="partida_presupuestaria_padre" style="width: 100%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Ingrese la Partida Presupuestaria" name="partida_presupuestaria" type="text" class="form-control" />
            </div>
        </div>
        <br/>
        <div class="row" style="text-align: center">
            <input type="submit" id="registrar_padre" style="font-weight: bold;font-size: 13px" class="btn btn-success" value="Guardar cambios"/>
            <button type="reset" id="limpiar" style="font-weight: bold;font-size: 13px; background: -moz-linear-gradient(#f4eb2f, #e5a32d); color: white " class="btn"/>
            &nbsp;<span class="glyphicon glyphicon-retweet"></span>&nbsp;&nbsp;Limpiar
            </button>
        </div>
        <br/>
    </div>
</form>
