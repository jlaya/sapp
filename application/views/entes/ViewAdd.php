<?php echo validation_errors(); ?>
<script>
    $(document).ready(function () {
        $('#sector').alpha();
        $("#tipo_ins,#sector,#tipo_estructura").select2();
        $('#codigo').alphanumeric({allow: "-."});
        $('#cedula').numeric({allow: "-"});
        $("#telefono").mask("(9999) 999-9999");
        $('#email').alphanumeric({allow: "@._-"});
        $('#nombre_ins,#siglas,#nom_resp,#nom_cargo').alphanumeric({allow: " -.()/,"});
        $("#registrar").click(function (e) {

            e.preventDefault();  // Para evitar que se envíe por defecto
            var regex = /[\w-\.]{2,}([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

            if ($('#nombre_ins').val().trim() == '') {

                bootbox.alert("Rellene el campo de Institución", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#nombre_ins").parent('div').addClass('has-error');
                    $("#nombre_ins").focus();
                });

            } else if ($('#siglas').val().trim() == '') {
                bootbox.alert("Rellene el campo de Siglas", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#siglas").parent('div').addClass('has-error');
                    $("#siglas").focus();
                });
            } else if ($('#tipo_ins').val().trim() == '') {
                bootbox.alert("Selecccione un tipo de institución", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#tipo_ins").parent('div').addClass('has-error');
                    $("#tipo_ins").select2('open');
                });
            } else if ($('#nom_resp').val().trim() == '') {
                bootbox.alert("Ingrese el nombre del responsable", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#nom_resp").parent('div').addClass('has-error');
                    $("#nom_resp").focus();
                });
            } else if ($('#cedula').val().trim() == '') {
                bootbox.alert("Ingrese la cédula", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#cedula").parent('div').addClass('has-error');
                    $("#cedula").focus();
                });
            } else if ($('#telefono').val().trim() == '') {
                bootbox.alert("Ingrese el teléfono", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#telefono").parent('div').addClass('has-error');
                    $("#telefono").focus();
                });
            } else if ($('#nom_cargo').val().trim() == '') {
                bootbox.alert("Ingrese el nombre del cargo", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#nom_cargo").parent('div').addClass('has-error');
                    $("#nom_cargo").focus();
                });
            } else if ($('#sector').val().trim() == '') {
                bootbox.alert("Seleccione un sector", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#sector").parent('div').addClass('has-error');
                    $("#sector").select2('open');
                });
            } else if ($('#email').val().trim() == '') {
                bootbox.alert("Ingrese el correo", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#email").parent('div').addClass('has-error');
                    $("#email").focus();
                });
            } else if (regex.test($('#email').val().trim()) == "") {

                //Se utiliza la funcion test() nativa de JavaScript
                if (regex.test($('#email').val().trim())) {

                    return false;

                } else {

                    bootbox.alert("Dirección de email no es valida", function () {
                        $('#email').parent('div').addClass('has-error');
                        $("#email").focus()
                    }).on('hidden.bs.modal', function (event) {
                        $("#email").parent('div').addClass('has-error');
                        $("#email").focus();
                    });
                }

            } else if ($('#tipo_estructura').val().trim() == '') {
                bootbox.alert("Seleccione un tipo de estructura", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#tipo_estructura").parent('div').addClass('has-error');
                    $("#tipo_estructura").select2('open');
                });
            } else if ($('#direccion_hab').val().trim() == '') {
                bootbox.alert("Ingrese la dirección completa de la institución", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#direccion_hab").parent('div').addClass('has-error');
                    $("#direccion_hab").focus();
                });
            } else {

                $.post('<?php echo base_url(); ?>entes/ControllersEntes/guardar', $('#form_organos').serialize(), function (response) {

                    if (response == '1') {

                        bootbox.alert("Disculpe, ya existe una institución o las siglas con este nombre registrado, verifique los datos ", function () {
                        }).on('hidden.bs.modal', function (event) {
                            $("#nombre_ins").parent('div').addClass('has-error');
                            $("#nombre_ins").focus();
                        });

                    } else {
                        bootbox.alert("Se registro con exito", function () {
                        }).on('hidden.bs.modal', function (event) {
                            url = '<?php echo base_url(); ?>entes/ControllersEntes'
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
<form id='form_organos' action="" method="POST">
    <div style="width: 95%;text-transform:uppercase;box-shadow: 0 1px 5px rgba(0,0,0,.85);margin: auto;" class="panel panel-default">
        <div class="panel-heading" style='background: linear-gradient(#2F9292, #3B7272);color:#FFFFFF;' >
            <label style="float: left" class="panel-title " ><a href="<?php echo base_url(); ?>entes/ControllersEntes/" >Configuraciones</a>
                > Registrar Organos / Entes</label>
            <br>
        </div>
        <fieldset><legend class="titulo text-center">Datos del Organo o Ente</legend></fieldset>
        <div class="panel-body">
            <div class="col-xs-1" >Institución</div>
            <div class="col-xs-4">
                <input maxlength="300" autofocus="autofocus" id="nombre_ins" style="width: 100%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Ingrese la institución" name="nom_ins" type="text" class="form-control" />
            </div>

            <div class="col-xs-2">
                <input maxlength="10" id="siglas" style="width: 70%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Siglas" name="siglas" type="text" class="form-control" />
            </div>
            <div class="col-xs-1" style="margin-left: -5%">Tipo/institución</div>
            <div class="col-xs-4" style="margin-left: 5%">
                <select id='tipo_ins' name="tipo_ins" class="form-control" style="width: 90%">
                    <option value="">Seleccione</option>
                    <option value="1">Órgano</option>
                    <option value="2">Ente</option>
                    <option value="3">Empresa</option>
                    <option value="4">Unidad de Apoyo</option>
                </select>
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-1" >Responsable</div>
            <div class="col-xs-4">
                <input maxlength="300" id="nom_resp" style="width: 100%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Ingrese nombre del responsable" name="nom_resp" type="text" class="form-control" />
            </div>

            <div class="col-xs-2">
                <input maxlength="9" id="cedula" style="width: 70%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Cédula" name="cedula" type="text" class="form-control" />
            </div>
            <div class="col-xs-1" style="margin-left: -5%">Teléfono</div>
            <div class="col-xs-4" style="margin-left: 5%">
                <input maxlength="26" id="telefono" style="width: 90%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Ejemplo: 0426-1234567/0243-12345678" name="tlf" type="text" class="form-control" />
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-1">Cargo</div>
            <div class="col-xs-4">
                <input maxlength="50" id="nom_cargo" style="width: 100%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Ingrese el nom_cargo" name="cargo" type="text" class="form-control" />
            </div>
            <div class="col-xs-1">Sector</div>
            <div class="col-xs-5" style="margin-left: 3%">
                <select id='sector' name="sector" class="form-control" style="width: 106%">
                    <option value="">Seleccione</option>
                    <?php
                    foreach ($list_sector as $value) {
                        ?>
                        <option value="<?php echo $value->id; ?>"><?php echo $value->codigo . " / ";
                    echo $value->sector; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-1" >Correo</div>
            <div class="col-xs-4">
                <input maxlength="300" id="email" style="width: 100%;" placeholder="INGRESE EL CORREO" name="correo" type="text" class="form-control" />
            </div>
            <div class="col-xs-1">Estructura</div>
            <div class="col-xs-5" style="margin-left: 3%">
                <select id='tipo_estructura' name="tipo_estructura" class="form-control" style="width: 106%">
                    <option value="">Seleccione</option>
                    <?php
                    foreach ($estructura as $value) {
                        ?>
                        <option value="<?php echo $value->id; ?>"><?php echo $value->codigo . " / ";
                    echo $value->estructura; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-1" >Dirección</div>
            <div class="col-xs-11">
                <textarea onblur="javascript:this.value = this.value.toUpperCase();" style="width:97%;text-transform: uppercase;" id="direccion_hab" name="direccion" rows="3" cols="50" class="form-control"></textarea>
            </div>
        </div>
        <br/>
        <div class="row" style="text-align: center">
            <a href="<?php echo base_url('entes/ControllersEntes'); ?>">
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
