
<script>
    $(document).ready(function () {
        $("select").select2();


        var TModulo = $('#tab_comunidad').dataTable({
            "iDisplayLength": 10,
            "iDisplayStart": 0,
            "sPaginationType": "full_numbers",
            "aLengthMenu": [25, 50, 75, 100],
            "oLanguage": {"sUrl": "<?php echo base_url(); ?>assets/js/es.txt"}
            //"order": [[1, "asc"]],
        });

        var TCalleV = $('#tabla_calle_vereda').dataTable({
            "iDisplayLength": 10,
            "iDisplayStart": 0,
            "sPaginationType": "full_numbers",
            "aLengthMenu": [25, 50, 75, 100],
            "oLanguage": {"sUrl": "<?php echo base_url(); ?>assets/js/es.txt"}
            //"order": [[1, "asc"]],
        });
        
        $("#jefe_com").prop('disabled',true);

        $("#cedula").change(function (event) {
            var cedula = $('#cedula').val();
            //var hosting = $('#id_hosting').val(); // Captura del hosting (dominio)
            var hosting = "consultaelectoral.bva.org.ve/cedula="
            if (hosting) {
                $.get("http://" + hosting + cedula, function (data) {
                    var option = "";
                    $.each(data, function (i) {
                        $("#jefe_com").val(data[i].p_nombre + " " + data[i].s_nombre + " " + data[i].p_apellido + " " + data[i].s_apellido)
                    });
                    // Proceso para validar con la clase error 404 Not Found
                }, 'json').error(function () {
                    bootbox.alert("No se encuentra registrado en el CNE", function () {
                        }).on('hidden.bs.modal', function (event) {
                            $("#jefe_com").prop('disabled',false);
                        });
                });
            }
        });

        // Validacion para borrar
        $("table#tab_comunidad").on('click', 'img.borrar', function (e) {
            e.preventDefault();
            var id = this.getAttribute('id');


            bootbox.dialog({
                message: "¿Desea manipular la información",
                title: "Borrar registro de bien",
                buttons: {
                    success: {
                        label: "Descartar",
                        className: "btn-primary",
                        callback: function () {

                        }
                    },
                    danger: {
                        label: "Procesar",
                        className: "btn-warning",
                        callback: function () {
                            //alert(id)
                            $.post('<?php echo base_url(); ?>modulo/ControllersModulo/delete/' + id + '', function (response) {

                                if (response == "existe") {

                                    bootbox.alert("Disculpe, Se encuentra asociado a un sub módulo", function () {
                                    }).on('hidden.bs.modal', function (event) {
                                    });

                                } else {
                                    bootbox.alert("Se elimino con exito", function () {
                                    }).on('hidden.bs.modal', function (event) {
                                        url = '<?php echo base_url(); ?>modulo/ControllersModulo'
                                        window.location = url
                                    });
                                }
                            });
                        }
                    }
                }
            });
        });
    });

</script>
<br/>
<br/>
<br/>
<br/>
<div class="row-fluid" >
    <div class="container mainbody-section text-center"  style="width:100%;">
        <button data-title="modNuevo" data-toggle="modal" data-target="#modNuevo" role="button" class="btn btn-default" style="font-weight: bold;font-size: 13px" id="enviar" >
            &nbsp;<span class="glyphicon glyphicon-plus"></span>&nbsp;
            Agregar Elemento
        </button>
        </br>
        </br>
        <table style="width:100%;" border="0" align="center" cellspacing="1" id="tab_comunidad" align="center"
               class="table table-bordered table-striped table-hover table-condensed dt-responsive table-responsive" style="width:30%">
            <thead style="font-size: 16px">
                <tr>
                    <th style='text-align: center;color: #000000' colspan="15">Comunidades</th>
                </tr>
                <tr>
                    <th></th>
                    <th style='text-align: center'>Item</th>
                    <th style='text-align: center'>Nombre / Comunidad</th>
                    <th style='text-align: center'>Jefe / Comunidad</th>
                    <th style='text-align: center'>Centro / Acopio</th>
                    <th style='text-align: center'>CLAP</th>
                    <th style='text-align: center'>Estado</th>
                    <th style='text-align: center'>Municipio</th>
                    <th style='text-align: center'>Parroquia</th>
                    <th style='text-align: center'>Comuna</th>
                    <th style='text-align: center'>Consejo Comunal</th>
                    <th style='text-align: center'>Editar</th>
                    <th style='text-align: center'>Borrar</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $i = 1;
                foreach ($lista_comunidad as $value) {
                    ?>

                    <tr style="font-size: 16px">
                        <td></td>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $value->modulo; ?></td>
                        <td>
                            <?php
                            if ($value->url != "") {
                                echo $value->url;
                            } else {
                                echo "N/A";
                            }
                            ?>
                        </td>
                        <td>
                            <input type='checkbox'
                            <?php if ($value->activo == 't') {
                                ?>
                                       checked='checked' disabled='disabled'
                                   <?php } else { ?>
                                       disabled='disabled'
                                   <?php } ?>
                                   />
                        </td>
                        <td><?php echo $value->posicion; ?></td>
                        <td>
                            <input type='checkbox'
                            <?php if ($value->desplegable == 't') {
                                ?>
                                       checked='checked' disabled='disabled'
                                   <?php } else { ?>
                                       disabled='disabled'
                                   <?php } ?>
                                   />
                        </td>
                        <td style='text-align: center'>
                            <a href="<?php echo base_url('modulo/ControllersModulo/procesar/' . $value->id); ?>">
                                <img style="width:25px;height: 25px" src="<?php echo base_url("assets/image/editar.png"); ?>"/>   
                            </a>
                        </td>
                        <td style='text-align: center'>
                            <a href="">
                                <img class='borrar' id='<?php echo $value->id; ?>'  style="width:25px;height: 25px" src="<?php echo base_url("assets/image/eliminar.png"); ?>"/>

                            </a>
                        </td>
                    </tr>
                    <?php
                    $i = $i + 1;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<!-- INICIO DE FORMULARIO DE COMUNIDAD ADD -->
<div class="modal fade" id="modNuevo" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <form id='form_comunidad' action="" method="POST">
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
</div>
<!-- CIERRE DE FORMULARIO DE COMUNIDAD ADD -->

