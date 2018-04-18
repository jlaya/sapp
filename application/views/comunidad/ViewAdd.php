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
        $('#modulo').alpha({allow: " /"});
        $('#url').alpha({allow: "_/"});
        $('#posicion').numeric({allow: ""});
        
        
        
        var TCalleV = $('#tabla_calle_vereda').dataTable({
            "iDisplayLength": 10,
            "iDisplayStart": 0,
            "sPaginationType": "full_numbers",
            "aLengthMenu": [25, 50, 75, 100],
            "oLanguage": {"sUrl": "<?php echo base_url();?>assets/js/es.txt"}
            //"order": [[1, "asc"]],
        });
        
        
        
        
        
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

                    } else {
                        $("#url").prop('disabled', false);
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
                $("#url").attr('readonly', false);
            } else {
                $("#url").attr('readonly', true);
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
        <div class="panel-heading" style=';color:#000000;' >
            <label style="float: left" class="panel-title " >Comunidad</label>
            <br>
        </div>
        <div class="panel-body">
            <div class="col-xs-2" >Nombre de la Comunidad</div>
            <div class="col-xs-10">
                <input id="nom_comunidad" maxlength="250" autofocus="" style="width: 100%;" placeholder="Nombre de la Comunidad, Maximo 250 Caracteres permitidos" name="nom_comunidad" type="text" class="form-control" />
            </div>
        </div>
        <div class="panel-body">
            <ul class="nav nav-tabs">
                <li class="active" data-toggle="popover" data-trigger="focus" title="Información Principal" data-placement="top">
                    <a data-toggle="tab" href="#tabs_informacion">Información Principal</a>
                </li>
                <li id="#tabs_2" data-toggle="popover" data-trigger="focus" title="Calles o Veredas" data-placement="top">
                    <a data-toggle="tab" href="#tab_calle_vereda">Calles o Veredas</a>
                </li>
                <li id="#tabs_2" data-toggle="popover" data-trigger="focus" title="Localización Geográfica" data-placement="top">
                    <a data-toggle="tab" href="#tab_localizacion">Localización Geográfica</a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="tabs_informacion" class="tab-pane fade in active">
                    <div class="panel-body">
                        <div class="col-xs-2" >Cédula</div>
                        <div class="col-xs-4">
                            <input maxlength="9" id="cedula" style="width: 100%;" placeholder="Cédula" name="cedula" type="text" class="form-control" />
                        </div>
                        <div class="col-xs-2">Jefe de la Comunidad</div>
                        <div class="col-xs-4">
                            <input maxlength="20" id="jefe_com" style="width: 100%;" placeholder="Jefe de la Comunidad" name="jefe_com" type="text" class="form-control" />
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-xs-2" >Centro de Acopio</div>
                        <div class="col-xs-4">
                            <select id='centro_acopio' name='centro_acopio' style='width: 100%;' class="form-control">
                                <option value=''>Seleccione</option>                                
                            </select>
                        </div>
                        <div class="col-xs-2">CLAP</div>
                        <div class="col-xs-4">
                             <select id='clap' name='clap' style='width: 100%;' class="form-control">
                                <option value=''>Seleccione</option>                                
                            </select>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-xs-2" >Estado</div>
                        <div class="col-xs-4">
                            <select id='estado' name='estado' style='width: 100%;' class="form-control">
                                <option value=''>Seleccione</option>                                
                            </select>
                        </div>
                        <div class="col-xs-2">Municipio</div>
                        <div class="col-xs-4">
                             <select id='municipio' name='municipio' style='width: 100%;' class="form-control">
                                <option value=''>Seleccione</option>                                
                            </select>
                        </div>
                    </div>
                     <div class="panel-body">
                        <div class="col-xs-2" >Parroquia</div>
                        <div class="col-xs-10">
                            <select id='parroquia' name='parroquia' style='width: 100%;' class="form-control">
                                <option value=''>Seleccione</option>                                
                            </select>
                        </div>
                    </div>
                </div>
                <div id="tab_calle_vereda" class="tab-pane fade in">
                    <div class="panel-body">
                        <table style="width:100%;background-color: #FFFFFF;" border="0" align="center" cellspacing="1" id="tabla_calle_vereda" align="center"
                           class="table table-bordered table-striped table-hover table-condensed dt-responsive table-responsive" style="width:20%;">
                        <thead style="font-size: 16px">
                            <tr style="font-size: 14px">
                                <th></th>
                                <th style='text-align: center;width: 50%'>Calle Vereda</th>
                                <th style='text-align: center'>Cédula/Calle/Vereda</th>
                                <th style='text-align: center'>Nombre/Calle/Vereda</th>
                                <th style='text-align: center'>Total Familias</th>
                                <th style='text-align: center'>Familias/Cargadas</th>
                                <th style='text-align: center'>% Avance</th>
                            </tr>
                        </thead>
                        <tbody style="background-color: #FFFFFF;">
                            
                        </tbody>
                    </table>
                    </div>
                </div>
                <div id="tab_localizacion" class="tab-pane fade in">
                    <div class="panel-body">
                        En construccion
                    </div>
                </div>
            </div>
        </div>

        <br/>
        <div class="row" style="text-align: center">
            <a href="<?php echo base_url('comunidad/ControllersComunidad'); ?>">
                <button type="button" id="volver" style="font-weight: bold;font-size: 13px" class="btn btn-warning " >
                    &nbsp;<span class="glyphicon glyphicon-chevron-left"></span>&nbsp;Volver
                </button>
            </a>
            <input type="submit" id="registrar" style="font-weight: bold;font-size: 13px" class="btn btn-success" value="Guardar cambios"/>
            <input type="hidden" name="id" value="" />
        </div>
        <br/>
    </div>
</form>
