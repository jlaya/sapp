<?php
if (isset($this->session->userdata['logged_in'])) {
    $username   = ($this->session->userdata['logged_in']['username']);
    $id         = ($this->session->userdata['logged_in']['id']);
    
    if(isset($_GET['ver'])){
        $preliminar = $_GET['ver'];
    }else{
        $preliminar = "2";
    }
    
} else {
    $header = base_url();
    header("location: " . $header);
}
?>

<script>
    $(document).ready(function () {
        
        if(<?php echo $preliminar;?> == 1){
            $("input,textarea,select,button#c_p,button#c_a").prop('disabled',true);
            $("img.eliminar_actividad").prop('disabled',true);
        }
        
        $("select").select2();
        $("#reg_registro,#ente").select2('val', parseInt($("#id_reg_registro").val()));
        $("#estatus").select2('val', parseInt($("#id_estatus").val()));
        $("#ano_fiscal").select2('val', parseInt($("#id_ano_fiscal").val()));
        $("#reg_res").select2('val', parseInt($("#id_reg_res").val()));
        $("#acc_centralizada").select2('val', parseInt($("#id_acc_centralizada").val()));

        $('#plan_patria').alphanumeric({allow: " -.,"});
        $('#codigo').alphanumeric({allow: "-."});
        $('#m_autoridad,#cargo').alpha({allow: " "});
        $('#cedula').numeric({allow: ""});
        $('#tlf').numeric({allow: "/"});
        $('#correo').alphanumeric({allow: "@."});
        $("#registrar").click(function (e) {

            e.preventDefault();  // Para evitar que se envíe por defecto
            var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

            if ($('#reg_registro').val().trim() == '') {

                bootbox.alert("Seleccione el registrado", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#reg_registro").parent('div').addClass('has-error');
                    $("#reg_registro").select2('open');
                });

            } else if ($('#ano_fiscal').val().trim() == '') {
                bootbox.alert("Seleccione el Año Fiscal", function () {
                    $('.nav-tabs a[href=#tabs_identificacion]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#ano_fiscal").parent('div').addClass('has-error');
                    $("#ano_fiscal").select2('open');
                });
            } else if ($('#ente').val().trim() == '') {
                bootbox.alert("Seleccione el Organismo/Ente/Empresa", function () {
                    $('.nav-tabs a[href=#tabs_identificacion]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#ente").parent('div').addClass('has-error');
                    $("#ente").select2('open');
                });
            } else if ($('#m_autoridad').val().trim() == '') {
                bootbox.alert("Ingrese el Nombre de la Maxima Autoridad de la Institución", function () {
                    $('.nav-tabs a[href=#tabs_identificacion]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#m_autoridad").parent('div').addClass('has-error');
                    $("#m_autoridad").focus();
                });
            } else if ($('#cedula').val().trim() == '') {
                bootbox.alert("Ingrese la Cédula", function () {
                    $('.nav-tabs a[href=#tabs_identificacion]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#cedula").parent('div').addClass('has-error');
                    $("#cedula").focus();
                });
            } else if ($('#cargo_b').val().trim() == "") {
                bootbox.alert("Ingrese el Cargo", function () {
                    $('.nav-tabs a[href=#tabs_identificacion]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#cargo_b").parent('div').addClass('has-error');
                    $("#cargo_b").focus();
                });
            } else if ($('#tlf_b').val().trim() == '') {
                bootbox.alert("Ingrese el Teléfono", function () {
                    $('.nav-tabs a[href=#tabs_identificacion]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#tlf_b").parent('div').addClass('has-error');
                    $("#tlf_b").focus();
                });
            } else if (regex.test($('#correo_b').val().trim()) == "") {

                //Se utiliza la funcion test() nativa de JavaScript
                if (regex.test($('#correo_b').val().trim())) {

                    return false;

                } else {

                    bootbox.alert("Dirección de correo no es valida", function () {
                        $('.nav-tabs a[href=#tabs_identificacion]').tab('show');
                    }).on('hidden.bs.modal', function (event) {
                        $('.nav-tabs a[href=#tabs_B]').tab('show');
                        $('#correo_b').parent('div').addClass('has-error');
                        $("#correo_b").focus()
                    });
                }

            } else if ($('#politica_presupuestaria').val().trim() == '') {
                bootbox.alert("Por favor describa de forma breve la política presupuestaria con la que trabajará", function () {
                    $('.nav-tabs a[href=#tabs_politica_accion]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#politica_presupuestaria").parent('div').addClass('has-error');
                    $("#politica_presupuestaria").focus();
                });
            } else if ($('#acc_centralizada').val().trim() == '') {
                bootbox.alert("Seleccione la Acción Centralizada", function () {
                    $('.nav-tabs a[href=#tabs_politica_accion]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#acc_centralizada").parent('div').addClass('has-error');
                    $("#acc_centralizada").select2('open');
                });
            } else {

                $.post('<?php echo base_url(); ?>acciones/registro/ControllersRegistro/modificar', $('#form_reg_acc').serialize(), function (response) {

                    if (response == '1') {

                        bootbox.alert("Disculpe, ya existe un código o Plan de la Patria registrado, verifique los datos ", function () {
                        }).on('hidden.bs.modal', function (event) {
                            $("#plan_patria").parent('div').addClass('has-error');
                            $("#plan_patria").focus();
                        });

                    } else {
                        bootbox.alert("Se actualizo con exito", function () {
                        }).on('hidden.bs.modal', function (event) {
                            url = window.location.href;
                            window.location = url;
                        });
                    }
                });
            }
        });

        $(".carga_partidas").click(function () {
            var acc_centralizada = $("#acc_centralizada").val();
            var id_model = $("#id_model").val();

            datos = id_model + "-";
            datos += acc_centralizada;

            $.post('<?php echo base_url(); ?>acciones/registro/ControllersRegistro/cargar/1/' + datos + '', function (response) {
                location.reload();
            });
        });


        $(".anadir_tarea").click(function () {
            $("#id_act,#actividad,#unidad_medida,#medio_verificacion,#cantidad,#indicador_actividad,#id_acc_reg").val("");
            $.fancybox.open({
                'autoScale': false,
                'href': '#form_carga_tarea',
                'type': 'inline',
                'hideOnContentClick': false,
                'transitionIn': 'fade',
                'transitionOut': 'fade',
                'openSpeed': 1000,
                'closeSpeed': 1000,
                'maxWidth': 960,
                'maxHeight': 600,
                'width': '960px',
                'height': '70px',
            });
        });

        var codigo = $("#codigo").val().trim();
        var cargo = $("#cargo").val().trim();
        var m_autoridad = $("#m_autoridad").val().trim();
        $("#codigo").val(codigo);
        $("#cargo").val(cargo);
        $("#m_autoridad").val(m_autoridad);

        // Validacion ajax para reflejar los datos en formato json para las Acciones Especifica
        $("#acc_centralizada").change(function (e) {

            var acc_centralizada = $(this).val();

            $('#nom_especifica').val("");
            $.post('<?php echo base_url(); ?>acciones/registro/ControllersRegistro/ajax_search/' + acc_centralizada + '', function (response) {
                var option = "";
                $.each(response, function (i) {
                    option += "->" + response[i]['accion_especifica'] + "\n";
                });
                $('#nom_especifica').val(option).trim("");
            }, 'json');
        });

        var acc_centralizada = $("#acc_centralizada").val();
        
        $('#nom_especifica').val("");
        $.post('<?php echo base_url(); ?>acciones/registro/ControllersRegistro/ajax_search/' + acc_centralizada + '', function (response) {
            var option = "";
            $.each(response, function (i) {
                option += "->" + response[i]['accion_especifica'] + "\n";
            });
            $('#nom_especifica').val(option);
        }, 'json');
        
      
        	$("#ente").select2('val',parseInt($("#reg_registro").val()));
        	//var ente = $(this).val();
            $.post('<?php echo base_url(); ?>acciones/registro/ControllersRegistro/search_table/id/organos_entes/' + <?php echo $detalles_lista->reg_registro ?> + '', function (response) {
                $("#cargo_b").val(response[0]['cargo']);
                $("#m_autoridad").val(response[0]['nom_resp']);
                $("#tlf_b").val(response[0]['tlf']);
                $("#cedula").val(response[0]['cedula']);
                $("#correo_b").val(response[0]['correo']);
            }, 'json');

        $("#ente").change(function () {
            var ente = $(this).val();
            $.post('<?php echo base_url(); ?>acciones/registro/ControllersRegistro/search_table/id/organos_entes/' + ente + '', function (response) {
                $("#cargo_b").val(response[0]['cargo']);
                $("#m_autoridad").val(response[0]['nom_resp']);
                $("#tlf_b").val(response[0]['tlf']);
                $("#cedula").val(response[0]['cedula']);
                $("#correo_b").val(response[0]['correo']);
            }, 'json');
        });

    });

</script>
<script src="<?php echo base_url('assets/js/accion.js'); ?>"></script>
<br/>
<br/>
<br/>
<br/>
<style>
    input.capturar_item{
        text-align: right;
    }
    
    .fancybox-inner {
        overflow: hidden;
        width:960px !important;
        margin: 15px !important;
        margin-left: 5px !important;
    }

    .fancybox-skin {
        position: relative;
        background: #f9f9f9;
        color: #444;
        width:995px !important;
        text-shadow: none;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
    }

    .fancybox-inner fancybox_img {
        overflow: hidden;
        width:100px !important;
        margin: 15px !important;
        margin-left: 5px !important;
    }

    .fancybox-skin fancybox_img {
        position: relative;
        background: #f9f9f9;
        color: #444;
        width:100px !important;
        text-shadow: none;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
    }
    .fancybox-opened .fancybox-skin {
        -webkit-box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
        -moz-box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
        box-shadow: 0 10px 25px rgba(0, 104, 149, 0.9);
    }

</style>
<form id='form_reg_acc' action="" method="POST">
    <div style="width: 95%;text-transform:uppercase;box-shadow: 0 1px 5px rgba(0,0,0,.85);margin: auto;" class="panel panel-default">
        <div class="panel-heading" style='background: linear-gradient(#2F9292, #3B7272);color:#FFFFFF;'>
            <label style="float: left" class="panel-title " ><!--<a href="<?php echo base_url(); ?>acciones/registro/ControllersRegistro" >Configuraciones</a>-->
                Registrar Acción</label>
            <br>
        </div>
        <fieldset><legend class="titulo text-center">Datos de la Acción</legend></fieldset>
        <br/>
        <div class="panel-body">
            <div class="col-xs-2" hidden='hidden'>ID</div>
            <div class="col-xs-4" hidden='hidden'>
                <input id="codigo" readonly="" value="<?php echo $detalles_lista->codigo ?>" style="width: 25%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="" name="codigo" type="text" class="form-control" />
            </div>
            <div class="col-xs-2" style="margin-left: -9%" hidden='true'>Fecha de Elaboración</div>
            <div class="col-xs-2" hidden='true'>
                <input id="id_model" type="hidden" value="<?php echo $detalles_lista->id ?>"/>
                <input id="fecha_elaboracion" readonly="" value="<?php echo $detalles_lista->fecha_elaboracion; ?>" style="width: 80%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="" name="fecha_elaboracion" type="text" class="form-control" />
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-2">Registrado por</div>
            <div class="col-xs-10">
                <select id='reg_registro' name='reg_registro' style='width: 65%;'>
                    <option value=''>Seleccione</option>
                    <?php
                    foreach ($organos as $value) {
                        ?>
                        <option value="<?php echo $value->id; ?>">

                            <?php
                            if ($value->tipo_ins == 1) {
                                $ins = "Órgano";
                            } elseif ($value->tipo_ins == 2) {
                                $ins = "Ente";
                            } elseif ($value->tipo_ins == 3) {
                                $ins = "Empresa";
                            } elseif ($value->tipo_ins == 4) {
                                $ins = "Unidad de Apoyo";
                            }

                            echo $ins . " - " . $value->nom_ins;
                            ?>
                        </option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-2">Estátus</div>
            <div class="col-xs-10">
                <?php
                 $ingresos_propios = $this->input->get('ingreso');
                 if($ingresos_propios == 1){
                    $bandera = "?ingreso=1";
                 }else{
                    $bandera = "";
                 }

                 ?>
                <input type="hidden" id="estatus" name="estatus" value="<?php echo $detalles_lista->estatus; ?>"/>
                <!-- Estatus Acciones centralizada y Proyectos -->
                <?php if ($detalles_lista->estatus == 1) { ?>
                    <span class="label label-success" style='width: 65%;color: #FFFFFF;'>Revisando</span>
                <?php } ?>
                <?php if ($detalles_lista->estatus == 2) { ?>
                    <span class="label label-success" style='width: 65%;color: #FFFFFF;'>Rechazado</span>
                <?php } ?>
                <?php if ($detalles_lista->estatus == 3) { ?>
                    <span class="label label-success" style='width: 65%;color: #FFFFFF;'>Para Ajuste</span>
                <?php } ?>
                <?php if ($detalles_lista->estatus == 4) { ?>
                    <span class="label label-success" style='width: 65%;color: #FFFFFF;'>Aprobado</span>
                <?php } ?>
                <!-- Ingresos Propios -->
                <?php if ($detalles_lista->estatus == 5) { ?>
                    <span class="label label-success" style='width: 65%;color: #FFFFFF;'>Ingresos Propios</span>
                <?php }/* ?>
                <?php if ($detalles_lista->estatus == 6) { ?>
                    <span class="label label-success" style='width: 65%;color: #FFFFFF;'>Rechazado | Ingresos Propios</span>
                <?php } ?>
                <?php if ($detalles_lista->estatus == 7) { ?>
                    <span class="label label-success" style='width: 65%;color: #FFFFFF;'>Para Ajuste | Ingresos Propios</span>
                <?php } ?>
                <?php if ($detalles_lista->estatus == 8) { ?>
                    <span class="label label-success" style='width: 65%;color: #FFFFFF;'>Aprobado | Ingresos Propios</span>
                <?php }*/ ?>
            </div>
        </div>
        <!-- Apertura de Tabs (Secciones) -->
        <ul class="nav nav-tabs">
            <li class="active" data-toggle="popover" data-trigger="focus" title="Identificación" data-placement="top">
                <a data-toggle="tab" href="#tabs_identificacion">Identificación</a>
            </li>
            <li id="#tabs_2" data-toggle="popover" data-trigger="focus" title="Política y Acción" data-placement="top">
                <a data-toggle="tab" href="#tabs_politica_accion">Política y Acción</a>
            </li>
            <li id="#tabs_2" data-toggle="popover" data-trigger="focus" title="Actividades específicas" data-placement="top">
                <a data-toggle="tab" href="#tabs_actividad_esp">Actividades específicas</a>
            </li>
            <li id="#tabs_2" data-toggle="popover" data-trigger="focus" title="Distribución trimestral" data-placement="top">
                <a data-toggle="tab" href="#tabs_dis_trimestral">Distribución trimestral</a>
            </li>
            <li id="#tabs_2" data-toggle="popover" data-trigger="focus" title="Metas específicas" data-placement="top">
                <a data-toggle="tab" href="#tabs_metas_esp">Metas específicas</a>
            </li>
            <li id="#tabs_2" data-toggle="popover" data-trigger="focus" title="Imputación General" data-placement="top">
                <a data-toggle="tab" href="#tabs_imputacion">Imputación General</a>
            </li>
            <li id="#tabs_2" data-toggle="popover" data-trigger="focus" title="Imputación Específica" data-placement="top">
                <a data-toggle="tab" href="#tabs_imputacion_es">Imputación Específica</a>
            </li>
            <li id="#tabs_2" data-toggle="popover" data-trigger="focus" title="Observaciones" data-placement="top">
                <a data-toggle="tab" href="#tabs_observacion">Observaciones</a>
            </li>
        </ul>
        <br>
        <div class="tab-content">
            <div id="tabs_identificacion" class="tab-pane fade in active">
                <div class="panel-body">
                    <fieldset>1. Identificación del proponente</fieldset>
                    <br/>
                    <div class="col-xs-2">Año Fiscal</div>
                    <div class="col-xs-10">
                        <select id='ano_fiscal' name='ano_fiscal' style='width: 10%;'>
                            <option value=''>Año</option>
                            <?php
                            foreach (range(2013, 2045) as $número) {
                                ?>
                                <option value="<?php echo $número; ?>"><?php echo $número; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-xs-2" >1.1 Organismo/Ente/Empresa</div>
                    <div class="col-xs-4">
                        <select id='ente' name='ente' style='width: 100%;'>
                            <option value=''>Seleccione</option>
                            <?php
                            foreach ($organos as $value) {
                                ?>
                                <option value="<?php echo $value->id; ?>">

                                    <?php
                                    if ($value->tipo_ins == 1) {
                                        $ins = "Órgano";
                                    } elseif ($value->tipo_ins == 2) {
                                        $ins = "Ente";
                                    } elseif ($value->tipo_ins == 3) {
                                        $ins = "Empresa";
                                    } elseif ($value->tipo_ins == 4) {
                                        $ins = "Unidad de Apoyo";
                                    }

                                    echo $ins . " - " . $value->nom_ins;
                                    ?>

                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-1">1.4 Cargo</div>
                    <div class="col-xs-4">
                        <input maxlength="20" readonly id="cargo_b" value="<?php echo $detalles_lista->cargo ?>" style="width: 65%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Ingrese el cargo" name="cargo" type="text" class="form-control" />
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-xs-2" >1.2 Nombre de la Maxima Autoridad de la Institución</div>
                    <div class="col-xs-4">
                        <input maxlength="30" readonly value="<?php echo $detalles_lista->m_autoridad ?>" id="m_autoridad" style="width: 100%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Ingrese la Maxima Autoridad" name="m_autoridad" type="text" class="form-control" />
                    </div>
                    <div class="col-xs-1">1.5 Teléfono</div>
                    <div class="col-xs-4">
                        <input maxlength="15" readonly value="<?php echo $detalles_lista->tlf ?>" id="tlf_b" style="width: 65%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Ingrese el teléfono" name="tlf" type="text" class="form-control" />
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-xs-2" >1.3 Cédula</div>
                    <div class="col-xs-4">
                        <input maxlength="9" readonly value="<?php echo $detalles_lista->cedula ?>" id="cedula" style="width: 25%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Cédula" name="cedula" type="text" class="form-control" />
                    </div>
                    <div class="col-xs-1">1.6 Correo</div>
                    <div class="col-xs-4">
                        <input maxlength="30" readonly value="<?php echo $detalles_lista->correo ?>" id="correo_b" style="width: 65%;" placeholder="Ingrese el correo" name="correo" type="text" class="form-control" />
                    </div>
                </div>
            </div>
            <div id="tabs_politica_accion" class="tab-pane fade">
                <div class="panel-body">
                    <div class="col-xs-3">3.1 Nombre de la Acción Centralizada</div>
                    <div class="col-xs-7">
                        <select id='acc_centralizada' name='acc_centralizada' style='width: 80%;'>
                            <option value=''>Seleccione</option>
                            <?php
                            foreach ($acc_centralizada as $value) {
                                ?>
                                <option value="<?php echo $value->id; ?>"><?php echo $value->accion_centralizada; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="panel-body">                    
                    <div class="col-xs-6">
                        <fieldset style="margin-left: 1%">2. Política Presupuestaria</fieldset>
                        <textarea maxlength='600' id="politica_presupuestaria" name="politica_presupuestaria" cols="2" rows="10" style="width: 60%;text-transform:uppercase" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Por favor describa de forma breve la política presupuestaria con la que trabajará" class="form-control"><?php echo $detalles_lista->politica_presupuestaria ?></textarea>
                    </div>
                    <div class="col-xs-6" style="margin-left: -9%">
                        <fieldset style="margin-left: 1%">Acciones Específicas</fieldset>
                        <textarea id="nom_especifica" cols="2" rows="10" style="width: 60%;width: 60%;text-transform:uppercase" onblur="javascript:this.value = this.value.toUpperCase();" readonly="" placeholder="3.2 Nombre de la Acción Específica" class="form-control"></textarea>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-xs-6">
                        <button id='c_p' type="button" title="Cargar Partidas" class="btn btn-primary carga_partidas">Cargar partidas</button>
                    </div>
                </div>
            </div>
            <div id="tabs_actividad_esp" class="tab-pane fade">
                <div class="panel-body">
                    <table style="width:100%;" border="0" align="center" cellspacing="1" id="tabla_actividades_especificas" align="center"
                           class="table table-bordered table-striped table-hover table-condensed dt-responsive table-responsive" style="width:30%">
                        <thead style="font-size: 13px;">
                            <tr>
                                <th style='text-align: center;color: white' colspan="9">4.1 Distribución de las Actividades</th>
                            </tr>
                            <tr class="background-first">
                                <th></th>
                                <th style='text-align: center'>Actividad</th>
                                <th style='text-align: center'>Unidad/Medida</th>
                                <th style='text-align: center'>Medio/Verificación</th>
                                <th style='text-align: center'>Cantidad</th>
                                <th style='text-align: center'>Indicador</th> 
                                <th style='text-align: center'>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($actividades as $value) {
                                ?>
                                <tr style="font-size: 13px" class="{% cycle 'impar' 'par' %}">
                                    <td></td>
                                    <td style="width:50%;"><?php echo $value->actividad; ?></td>
                                    <td><?php echo $value->unidad_medida; ?></td>
                                    <td><?php echo $value->medio_verificacion; ?></td>
                                    <td style="text-align: right;">
                                        <span class="label label-info" style='color: #000000;'>
                                            <?php echo $value->cantidad; ?>
                                        </span>
                                    </td>
                                    <td style="width:50%;"><?php echo $value->indicador_actividad; ?></td>
                                    <td style='text-align: center;width:5%;'>
                                        <img title="Editar" id='<?php echo $value->id; ?>' class='capturar_actividad' style="width:25px;height: 25px;cursor:pointer;" src="<?php echo base_url("assets/image/editar.png"); ?>"/>   
                                        <img title="Eliminar" id='<?php echo $value->id; ?>' class='eliminar_actividad' style="width:25px;height: 25px;cursor:pointer;" src="<?php echo base_url("assets/image/eliminar.png"); ?>"/>
                                    </td>
                                </tr>
                                <?php
                                $i = $i + 1;
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr style="font-size: 16px">
                                <td></td>
                                <td><a class="anadir_tarea" style="text-decoration:none;text-align: left"><button type="button" class="btn btn-default">Añadir elemento</button></a></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td style='text-align: center'></td>
                                <td style='text-align: center'></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div id="tabs_dis_trimestral" class="tab-pane fade">
                <div class="panel-body">
                    <table style="width:100%;" border="0" align="center" cellspacing="1" id="tab_distribucion_trimestral" align="center"
                           class="table table-bordered table-striped table-hover table-condensed dt-responsive table-responsive" style="width:30%">

                        <button id='c_a' type="button" title="Cargar Actividades" class="btn btn-primary cargar_actividades" style="margin-left:87%;margin-top: -2%">Cargar Actividades</button>
                        <br/>
                        <br/>
                        <thead style="font-size: 16px">
							
                            <tr class="background-first">
                                <th style='text-align: center;color: white' colspan="7">4.2 Distribución trimestral de las Actividades</th>
                            </tr>
                            <tr>
                                <div style='color:000000;' class='alert alert-info'>Celda resaltada en verde, es que se ha guardado la información, no es necesario dar clic al botón Guardar cambios...</div>
                            </tr>
                            <tr style="background-color: #8BA8A7">
                                <th></th>
                                <th style='text-align: center'>Actividad</th>
                                <th style='text-align: center'>I Trimestre</th>
                                <th style='text-align: center'>II Trimestre</th>
                                <th style='text-align: center'>III Trimestre</th>
                                <th style='text-align: center'>IV Trimestre</th>
                                <th style='text-align: center'>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($distrib_tri_act as $value) {
                                ?>
                                <tr style="font-size: 16px" id="tr_<?php echo $value->id_actividad ?>">
                                    <td></td>
                                    <td><?php echo $value->actividad; ?></td>
                                    <td style='width:5% !important;'>
										<input type="text" style="width:130px;text-align: right;" class="capturar_item form-control" id="trimestre_i_<?php echo $value->id_actividad; ?>" name="<?php echo $value->id_actividad; ?>" value="<?php echo $value->trimestre_i; ?>"/>
									</td>
                                    <td style='width:5% !important;'>
										<input type="text" style="width:130px;text-align: right;text-align: right;text-align: right;text-align: right;" class="capturar_item form-control" id="trimestre_ii_<?php echo $value->id_actividad; ?>" name="<?php echo $value->id_actividad; ?>" value="<?php echo $value->trimestre_ii; ?>"/>
									</td>
                                    <td style='width:5% !important;'>
										<input type="text" style="width:130px;text-align: right;text-align: right;text-align: right;" class="capturar_item form-control" id="trimestre_iii_<?php echo $value->id_actividad; ?>" name="<?php echo $value->id_actividad; ?>" value="<?php echo $value->trimestre_iii; ?>"/>
									</td>
                                    <td style='width:5% !important;'>
										<input type="text" style="width:130px;text-align: right;text-align: right;" class="capturar_item form-control" id="trimestre_iv_<?php echo $value->id_actividad; ?>" name="<?php echo $value->id_actividad; ?>" value="<?php echo $value->trimestre_iv; ?>"/>
									</td>
                                    <td style='width:5% !important;'>
										<input readonly="readonly" type="text" style="width:130px;text-align: right;" class="capturar_item form-control" id="total_<?php echo $value->id_actividad; ?>" name="<?php echo $value->id_actividad; ?>" value="<?php echo $value->total; ?>"/>
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
            <div id="tabs_metas_esp" class="tab-pane fade">
                <div class="panel-body">
                    <table style="width:100%;" border="0" align="center" cellspacing="1" id="tab_distribucion_trimestral_financiera" align="center"
                           class="table table-bordered table-striped table-hover table-condensed dt-responsive table-responsive" style="width:30%">
                        <thead style="font-size: 16px">
                            <tr class="background-first">
                                <th style='text-align: center;color: white' colspan="7">5.1 Distribución trimestral financiera</th>
                            </tr>
                            <tr>
								<div style='color:000000;' class='alert alert-info'>Celda resaltada en verde, es que se ha guardado la información, no es necesario dar clic al botón Guardar cambios...</div>
							</tr>
                            <tr style="background-color: #8BA8A7">
                                <th></th>
                                <th style='text-align: center'>Actividad</th>
                                <th style='text-align: center'>I Trimestre</th>
                                <th style='text-align: center'>II Trimestre</th>
                                <th style='text-align: center'>III Trimestre</th>
                                <th style='text-align: center'>IV Trimestre</th>
                                <th style='text-align: center'>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($distrib_tri_fin as $value) {
                                ?>
                                <tr style="font-size: 16px" id="tr_<?= $value->id_actividad ?>">
                                    <td></td>
                                    <td><?php echo $value->actividad; ?></td>
                                    <td style='width:5% !important;'><input type="text" style="width:130px;" class="capturar_item form-control" id="trimestre_if_<?php echo $value->id_actividad; ?>" name="<?php echo $value->id_actividad; ?>" value="<?php echo $value->trimestre_i; ?>"/></td>
                                    <td style='width:5% !important;'><input type="text" style="width:130px;" class="capturar_item form-control" id="trimestre_iif_<?php echo $value->id_actividad; ?>" name="<?php echo $value->id_actividad; ?>" value="<?php echo $value->trimestre_ii; ?>"/></td>
                                    <td style='width:5% !important;'><input type="text" style="width:130px;" class="capturar_item form-control" id="trimestre_iiif_<?php echo $value->id_actividad; ?>" name="<?php echo $value->id_actividad; ?>" value="<?php echo $value->trimestre_iii; ?>"/></td>
                                    <td style='width:5% !important;'><input type="text" style="width:130px;" class="capturar_item form-control" id="trimestre_ivf_<?php echo $value->id_actividad; ?>" name="<?php echo $value->id_actividad; ?>" value="<?php echo $value->trimestre_iv; ?>"/></td>
                                    <td style='width:5% !important;'><input readonly="readonly" type="text" style="width:130px;" class="capturar_item form-control" id="totalf_<?php echo $value->id_actividad; ?>" name="<?php echo $value->id_actividad; ?>" value="<?php echo $value->total; ?>"/></td>
                                </tr>
                                <?php
                                $i = $i + 1;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="tabs_imputacion" class="tab-pane fade">
                <div class="panel-body">
                    <table style="width:100%;" border="0" align="center" cellspacing="1" id="tabla_imputacion_presupuestaria" align="center"
                           class="table table-bordered table-striped table-hover table-condensed dt-responsive table-responsive" style="width:30%">
                        <thead style="font-size: 16px">
                            <tr class="background-first">
                                <th style='text-align: center;color: white' colspan="9">6. Imputación Presupuestaria</th>
                            </tr>
                            <tr style="background-color: #8BA8A7">
                                <th></th>
                                <th style='text-align: center'>Código</th>
                                <th style='text-align: center'>Denominación</th>
                                <th style='text-align: center'>I Trimestre</th>
                                <th style='text-align: center'>II Trimestre</th>
                                <th style='text-align: center'>III Trimestre</th>
                                <th style='text-align: center'>IV Trimestre</th>
                                <th style='text-align: center'>Cantidad</th>
                                <th hidden='hidden' style='text-align: center'>Solicitud</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($imp_presupuestaria as $value) {
                                ?>
                                <tr style="font-size: 16px" id="tr_<?php echo $value->pk ?>">
                                    <td></td>
                                    <td><?php echo $value->codigo; ?></td>
                                    <td><?php echo $value->partida_presupuestaria; ?></td>
                                    <td><input type="text" style="width:130px;" class="capturar_item form-control" id="trimestre_1_<?php echo $value->pk; ?>" name="<?php echo $value->pk; ?>" value="<?php echo $value->trimestre_i; ?>"/></td>
                                    <td><input type="text" style="width:130px;" class="capturar_item form-control" id="trimestre_2_<?php echo $value->pk; ?>" name="<?php echo $value->pk; ?>" value="<?php echo $value->trimestre_ii; ?>"/></td>
                                    <td><input type="text" style="width:130px;" class="capturar_item form-control" id="trimestre_3_<?php echo $value->pk; ?>" name="<?php echo $value->pk; ?>" value="<?php echo $value->trimestre_iii; ?>"/></td>
                                    <td><input type="text" style="width:130px;" class="capturar_item form-control" id="trimestre_4_<?php echo $value->pk; ?>" name="<?php echo $value->pk; ?>" value="<?php echo $value->trimestre_iv; ?>"/></td>
                                    <td><input readonly="" type="text" style="width:130px;" class="capturar_item form-control" id="cantidad_<?php echo $value->pk; ?>" name="<?php echo $value->pk; ?>" value="<?php echo $value->cantidad; ?>"/></td>
                                    <td hidden='hidden'><input readonly type="text" style="width:130px;" class="capturar_item form-control" id="monto_<?php echo $value->pk; ?>" name="<?php echo $value->pk; ?>" value="<?php echo $value->monto; ?>"/></td>
                                </tr>
                                <?php
                                $i = $i + 1;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="tabs_imputacion_es" class="tab-pane fade">
                <div class="panel-body">
                    <div class="panel-body">
                        <div class="form-inline">
                        <div class="form-group col-xs-12">
                            <!--<object type="application/php" data='' style="width:100%; height:600px;"></object>-->
                            <object type="application/php" data='<?php echo base_url("acciones/registro/ControllersRegistro/lista/$detalles_lista->id");?>'  style="width:100%; height:600px;">
							  <embed src='<?php echo base_url("acciones/registro/ControllersRegistro/lista/$detalles_lista->id");?>'  style="width:100%; height:600px;" frameborder="0" style="border:0;">
							</object>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="tabs_observacion" class="tab-pane fade">
                <div class="panel-body">                    
                    <div class="col-xs-2" >Revisado por</div>
                    <div class="col-xs-4">
                        <select id='reg_res' name='reg_res' style='width: 90%;'>
                            <option value=''>Seleccione</option>
                            <?php
                            foreach ($organos as $value) {
                                ?>
                                <option value="<?php echo $value->id; ?>">

                                    <?php
                                    if ($value->tipo_ins == 1) {
                                        $ins = "Órgano";
                                    } elseif ($value->tipo_ins == 2) {
                                        $ins = "Ente";
                                    } elseif ($value->tipo_ins == 3) {
                                        $ins = "Empresa";
                                    } elseif ($value->tipo_ins == 4) {
                                        $ins = "Unidad de Apoyo";
                                    }

                                    echo $ins . " - " . $value->nom_ins;
                                    ?>

                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-2">Fecha de revisión</div>
                    <div class="col-xs-4">
                        <input id="fecha_revision" <?php if ($detalles_lista->fecha_revision == "") { ?> value="" <?php } else { ?> value="<?php $fecha = explode('-', $detalles_lista->fecha_revision);
                                echo $fecha[2] . "/" . $fecha[1] . "/" . $fecha[0] ?>" <?php } ?> style="width:33%;text-transform:uppercase" placeholder="Fecha de revisión" readonly="" type="text" class="form-control" />
                    </div>
                </div>
                <div class="panel-body">                    
                    <div class="col-xs-2">Estructura Presupuestaria</div>
                    <div class="col-xs-4">
                        <input id="estruc_presupuestaria" value="<?php echo $detalles_lista->estruc_presupuestaria; ?>" style="width:50%;text-transform:uppercase" placeholder="Estructura Presupuestaria" readonly="" name="estruc_presupuestaria" type="text" class="form-control" />
                    </div>
                </div>
                <div class="panel-body">                    
                    <div class="col-xs-2">Observaciones</div>
                    <div class="col-xs-10">
                        <textarea maxlength="1000" id="observaciones" name="observaciones" cols="2" rows="5" style="width: 74%;text-transform:uppercase" onblur="javascript:this.value = this.value.toUpperCase();" readonly="" placeholder="Observaciones" class='form-control'><?php echo $detalles_lista->observaciones ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <br/>
        <br/>
        <div class="row" style="text-align: center">
            <a href='<?php echo base_url("acciones/registro/ControllersRegistro$bandera"); ?>'>
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
        </div>
        <br/>
    </div>
    <input id="id_reg_registro" type="hidden" value="<?php echo $detalles_lista->reg_registro ?>"/>
    <input id="id_estatus" type="hidden" value="<?php echo $detalles_lista->estatus ?>"/>
    <input id="id_ano_fiscal" type="hidden" value="<?php echo $detalles_lista->ano_fiscal ?>"/>
    <input id="id_acc_centralizada" type="hidden" value="<?php echo $detalles_lista->acc_centralizada ?>"/>
    <input id="id_reg_res" type="hidden" value="<?php echo $detalles_lista->reg_res ?>"/>
    <input type="hidden" name="id" value="<?php echo $this->uri->rsegment(3) ?>" />
    <input type="hidden" name="accion_id" id="accion_id" value="<?php echo $detalles_lista->id ?>" />
    <input type="hidden" id="last_id" value="<?php echo $last_id ?>" />
</form>

<script>
    $(document).ready(function () {
        $('#unidad_medida,#medio_verificacion,#indicador_actividad').alpha({allow: " -.,"});
        $('#cantidad').numeric({allow: ""});

        var TAE = $('#tabla_actividades_especificas').dataTable({
            "iDisplayLength": 10,
            "iDisplayStart": 0,
            "sPaginationType": "full_numbers",
            "aLengthMenu": [25, 50, 75, 100],
            "oLanguage": {"sUrl": "<?php echo base_url(); ?>assets/js/es.txt"},
            //"order": [[1, "asc"]],
            "aoColumns": [
                {"sClass": "control", "sWidth": "1%"},
                {"sClass": "registro center", "sWidth": "70%"},
                {"sClass": "registro center", "sWidth": "20%"},
                {"sClass": "registro center", "sWidth": "20%"},
                {"sClass": "registro center", "sWidth": "20%"},
                {"sWidth": "3%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
                {"sWidth": "3%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
            ]
        });

        var DT = $('#tab_distribucion_trimestral').dataTable({
            "iDisplayLength": 10,
            "iDisplayStart": 0,
            "sPaginationType": "full_numbers",
            "aLengthMenu": [25, 50, 75, 100],
            "oLanguage": {"sUrl": "<?php echo base_url(); ?>assets/js/es.txt"},
            //"order": [[1, "asc"]],
            "aoColumns": [
                {"sClass": "control", "sWidth": "1%"},
                {"sClass": "registro center", "sWidth": "3%"},
                {"sClass": "registro center", "sWidth": "10%"},
                {"sClass": "registro center", "sWidth": "30%"},
                {"sClass": "registro center", "sWidth": "30%"},
                {"sWidth": "3%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
                {"sWidth": "3%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
            ]
        });

        var DTF = $('#tab_distribucion_trimestral_financiera').dataTable({
            "iDisplayLength": 10,
            "iDisplayStart": 0,
            "sPaginationType": "full_numbers",
            "aLengthMenu": [25, 50, 75, 100],
            "oLanguage": {"sUrl": "<?php echo base_url(); ?>assets/js/es.txt"},
            //"order": [[1, "asc"]],
            "aoColumns": [
                {"sClass": "control", "sWidth": "1%"},
                {"sClass": "registro center", "sWidth": "3%"},
                {"sClass": "registro center", "sWidth": "10%"},
                {"sClass": "registro center", "sWidth": "30%"},
                {"sClass": "registro center", "sWidth": "30%"},
                {"sWidth": "3%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
                {"sWidth": "3%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
            ]
        });

        var IMP = $('#tabla_imputacion_presupuestaria').dataTable({
            "iDisplayLength": 10,
            "iDisplayStart": 0,
            "sPaginationType": "full_numbers",
            "aLengthMenu": [25, 50, 75, 100],
            "oLanguage": {"sUrl": "<?php echo base_url(); ?>assets/js/es.txt"},
            //"order": [[1, "asc"]],
            "aoColumns": [
                {"sClass": "control", "sWidth": "1%"},
                {"sClass": "registro center", "sWidth": "1%"},
                {"sClass": "registro center", "sWidth": "10%"},
                {"sClass": "registro center", "sWidth": "30%"},
                {"sClass": "registro center", "sWidth": "30%"},
                {"sClass": "registro center", "sWidth": "30%"},
                {"sClass": "registro center", "sWidth": "30%"},
                {"sWidth": "3%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
                {"sWidth": "3%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
            ]
        });

        $("#registrar_actividad").click(function (e) {

            e.preventDefault();  // Para evitar que se envíe por defecto

            if ($('#actividad').val().trim() == '') {

                bootbox.alert("Ingrese la actividad", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#actividad").parent('div').addClass('has-error');
                    $("#actividad").focus();
                });

            } else if ($('#unidad_medida').val().trim() == '') {
                bootbox.alert("Ingrese la unidad de medida", function () {

                }).on('hidden.bs.modal', function (event) {
                    $("#unidad_medida").parent('div').addClass('has-error');
                    $("#unidad_medida").focus();
                });
            } else if ($('#medio_verificacion').val().trim() == '') {
                bootbox.alert("Ingrese el medio de verificación", function () {

                }).on('hidden.bs.modal', function (event) {
                    $("#medio_verificacion").parent('div').addClass('has-error');
                    $("#medio_verificacion").focus();
                });
            } else if ($('#cantidad').val().trim() == '') {
                bootbox.alert("Ingrese la cantidad", function () {

                }).on('hidden.bs.modal', function (event) {
                    $("#cantidad").parent('div').addClass('has-error');
                    $("#cantidad").focus();
                });
            } else if ($('#indicador_actividad').val().trim() == '') {
                bootbox.alert("Ingrese el indicador de la actividad", function () {

                }).on('hidden.bs.modal', function (event) {
                    $("#indicador_actividad").parent('div').addClass('has-error');
                    $("#indicador_actividad").focus();
                });
            } else {

                if ($("#id_act").val() == "") {

                    $.post('<?php echo base_url(); ?>acciones/registro/ControllersRegistro/cargar/2/' + $("#codigo").val() + '', $('#form_carga_tarea').serialize(), function (response) {

                        if (response == '1') {

                            bootbox.alert("Disculpe, ya se encuentra una actividad asignada con este nombre...", function () {
                            }).on('hidden.bs.modal', function (event) {
                                $("#actividad").parent('div').addClass('has-error');
                                $("#actividad").focus();
                            });

                        } else {
                            bootbox.alert("Se registro la actividad", function () {
                            }).on('hidden.bs.modal', function (event) {
                                url = '<?php echo base_url(); ?>acciones/registro/ControllersRegistro/procesar_list/' + $("#codigo").val() + ''
                                window.location = url;
                            });
                        }
                    });
                } else {
                    var id = $("#id_act").val();
                    $.post('<?php echo base_url(); ?>acciones/registro/ControllersRegistro/cargar/3/' + id + '', $('#form_carga_tarea').serialize(), function (response) {
                        bootbox.alert("Se actualizo la actividad", function () {
                        }).on('hidden.bs.modal', function (event) {
                            url = '<?php echo base_url(); ?>acciones/registro/ControllersRegistro/procesar_list/' + $("#codigo").val() + ''
                            window.location = url
                        });
                    });
                }
            }
        });
        // proceso para la captura de los datos de la actic}vidad
        $("table#tabla_actividades_especificas").on('click', 'img.capturar_actividad', function (e) {
            //e.preventDefault();
            var id = this.getAttribute('id');

            $("#id_act").val('1');
            $.post('<?php echo base_url(); ?>acciones/registro/ControllersRegistro/cargar/4/' + id + '', function (response) {

                $.each(response, function (i) {
                    $("#id_act").val(response[i]['id']);
                    $("#id_acc_reg").val(response[i]['id_acc_reg']);
                    $("#actividad").val(response[i]['actividad']);
                    $("#unidad_medida").val(response[i]['unidad_medida']);
                    $("#medio_verificacion").val(response[i]['medio_verificacion']);
                    $("#cantidad").val(response[i]['cantidad']);
                    $("#indicador_actividad").val(response[i]['indicador_actividad']);
                });
            }, 'json');

            $.fancybox.open({
                'autoScale': false,
                'href': '#form_carga_tarea',
                'type': 'inline',
                'hideOnContentClick': false,
                'transitionIn': 'fade',
                'transitionOut': 'fade',
                'openSpeed': 1000,
                'closeSpeed': 1000,
                'maxWidth': 960,
                'maxHeight': 600,
                'width': '960px',
                'height': '70px',
            });
        });
        //"proceso para eliminar una actividad"
        $("table#tabla_actividades_especificas").on('click', 'img.eliminar_actividad', function (e) {
            var id = this.getAttribute('id');
            /*var aPos = TAE.fnGetPosition(this.parentNode.parentNode);
             TAE.fnDeleteRow(aPos);*/
            $.post('<?php echo base_url(); ?>acciones/registro/ControllersRegistro/cargar/5/' + id + '', function (response) {
                bootbox.alert("Se ha eliminado la Actividad", function () {
                }).on('hidden.bs.modal', function (event) {
                    url = '<?php echo base_url(); ?>acciones/registro/ControllersRegistro/procesar_list/' + $("#codigo").val() + ''
                    window.location = url;
                });
            });
        });

        // Validación para la captura de los campos dinamicos de cada registro para el proceso de carga de montos para la distribución trimestral de las actividades
        $("table#tab_distribucion_trimestral").on('change', 'input.capturar_item', function (e) {
            var id = this.getAttribute('name');
            var trimestre_i = $("#trimestre_i_" + id + "").val();
            var trimestre_ii = $("#trimestre_ii_" + id + "").val();
            var trimestre_iii = $("#trimestre_iii_" + id + "").val();
            var trimestre_iv = $("#trimestre_iv_" + id + "").val();
            var total = $("#total_" + id + "").val();

            $("table#tab_distribucion_trimestral tr#tr_" + id + "").css("background-color", "#D5F2F1");

            // Condicional de Campos Vacios
            var trimestre_i = (trimestre_i == "") ? 0.00 : trimestre_i;
            var trimestre_ii = (trimestre_ii == "") ? 0.00 : trimestre_ii;
            var trimestre_iii = (trimestre_iii == "") ? 0.00 : trimestre_iii;
            var trimestre_iv = (trimestre_iv == "") ? 0.00 : trimestre_iv;

            suma = parseFloat(trimestre_i) + parseFloat(trimestre_ii) + parseFloat(trimestre_iii) + parseFloat(trimestre_iv);
            $("#total_" + id + "").val(suma);

            datos = id + "-";
            datos += trimestre_i + "-";
            datos += trimestre_ii + "-";
            datos += trimestre_iii + "-";
            datos += trimestre_iv + "-";
            datos += parseFloat(suma);

            $.post('<?php echo base_url(); ?>acciones/registro/ControllersRegistro/cargar/7/' + datos + '', function (response) {
				
				bootbox.alert("Distribución trimestral cargado con exito...", function () {
				});

            });
        }); // Fin

        // Validación para la captura de los campos dinamicos de cada registro para el proceso de carga de montos para la distribución trimestral financiera
        $("table#tab_distribucion_trimestral_financiera").on('change', 'input.capturar_item', function (e) {
            var id = this.getAttribute('name');
            var trimestre_i = $("#trimestre_if_" + id + "").val();
            var trimestre_ii = $("#trimestre_iif_" + id + "").val();
            var trimestre_iii = $("#trimestre_iiif_" + id + "").val();
            var trimestre_iv = $("#trimestre_ivf_" + id + "").val();
            var total = $("#totalf_" + id + "").val();

            $("table#tab_distribucion_trimestral_financiera tr#tr_" + id + "").css("background-color", "#D5F2F1");

            // Condicional de Campos Vacios
            var trimestre_i = (trimestre_i == "") ? 0.00 : trimestre_i;
            var trimestre_ii = (trimestre_ii == "") ? 0.00 : trimestre_ii;
            var trimestre_iii = (trimestre_iii == "") ? 0.00 : trimestre_iii;
            var trimestre_iv = (trimestre_iv == "") ? 0.00 : trimestre_iv;

            suma = parseFloat(trimestre_i) + parseFloat(trimestre_ii) + parseFloat(trimestre_iii) + parseFloat(trimestre_iv);
            $("#totalf_" + id + "").val(suma);

            datos = id + "-";
            datos += trimestre_i + "-";
            datos += trimestre_ii + "-";
            datos += trimestre_iii + "-";
            datos += trimestre_iv + "-";
            datos += parseFloat(suma);

            $.post('<?php echo base_url(); ?>acciones/registro/ControllersRegistro/cargar/8/' + datos + '', function (response) {

            });
        }); // Fin

        // Validacion para la captura de los montos
        $("table#tabla_imputacion_presupuestaria").on('change', 'input.capturar_item', function (e) {
            var id = this.getAttribute('name');
            var trimestre_i = $("#trimestre_1_" + id + "").val();
            var trimestre_ii = $("#trimestre_2_" + id + "").val();
            var trimestre_iii = $("#trimestre_3_" + id + "").val();
            var trimestre_iv = $("#trimestre_4_" + id + "").val();
            var cantidad = $("#cantidad_" + id + "").val();
            var monto = $("#monto_" + id + "").val();

            $("table#tabla_imputacion_presupuestaria tr#tr_" + id + "").css("background-color", "#D5F2F1");

            //alert(trimestre_i)

            // Condicional de Campos Vacios
            var trimestre_i = (trimestre_i == "") ? 0.00 : trimestre_i;
            var trimestre_ii = (trimestre_ii == "") ? 0.00 : trimestre_ii;
            var trimestre_iii = (trimestre_iii == "") ? 0.00 : trimestre_iii;
            var trimestre_iv = (trimestre_iv == "") ? 0.00 : trimestre_iv;
            var cantidad = (cantidad == "") ? 0.00 : cantidad;
            var monto = (monto == "") ? 0.00 : monto;

            suma = parseFloat(trimestre_i) + parseFloat(trimestre_ii) + parseFloat(trimestre_iii) + parseFloat(trimestre_iv);
            $("#monto_" + id + "").val(suma);
            $("#cantidad_" + id + "").val(suma);

            datos = id + "-";
            datos += trimestre_i + "-";
            datos += trimestre_ii + "-";
            datos += trimestre_iii + "-";
            datos += trimestre_iv + "-";
            datos += suma + "-";
            datos += suma;

            $.post('<?php echo base_url(); ?>acciones/registro/ControllersRegistro/cargar/9/' + datos + '', function (response) {

            });
        }); // Fin



        // proceso para la captura de las actividades segun el id del registro principal
        $(".cargar_actividades").click(function () {
            var id = $("#id_model").val();

            $.post('<?php echo base_url(); ?>acciones/registro/ControllersRegistro/cargar/6/' + id + '', function (response) {

                bootbox.alert("Se encuentran cargadas las actividades en la sección Distribución Trimestral / Metas Específicas", function () {
                }).on('hidden.bs.modal', function (event) {
                    url = '<?php echo base_url(); ?>acciones/registro/ControllersRegistro/procesar_list/' + $("#codigo").val() + ''
                    window.location = url;
                });

            });
        });

    });
</script>

<form id='form_carga_tarea' action="" method="POST" style='display: none;'>
    <div style="width: 95%;text-transform:uppercase;box-shadow: 0 1px 5px rgba(0,0,0,.85);margin: auto;" class="panel panel-default">
        <div class="panel-heading" style='background: linear-gradient(#2F9292, #3B7272);color:#FFFFFF;' >
            <label>Actualizar Actividad</label>
            <br>
        </div>
        <fieldset><legend class="titulo text-center">Datos de la Actividad</legend></fieldset>
        <div class="panel-body">
            <div class="col-xs-1" >Actividad</div>
            <div class="col-xs-10">
                <input id="id_act" type="hidden" class="form-control"/>
                <input name="id_acc_reg" type="hidden" value="<?php echo $detalles_lista->id ?>"/>
                <textarea maxlength="198" id='actividad' name='actividad' style='width: 90%;float:right;text-transform:uppercase' onblur="javascript:this.value = this.value.toUpperCase();" placeholder='Maximo de caracteres permitidos 500' class="form-control"></textarea>
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-1" >Unidad/medida</div>
            <div class="col-xs-10">
                <input maxlength='40' id="unidad_medida" style="width: 90%;float:right;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Ingrese la unidad de medida" name="unidad_medida" type="text" class="form-control" />
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-1" >Medio/verificación</div>
            <div class="col-xs-10">
                <input maxlength='40' id="medio_verificacion" style="width: 90%;float:right;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Ingrese el medio de verifcación" name="medio_verificacion" type="text" class="form-control" />
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-1" >Cantidad</div>
            <div class="col-xs-3">
                <input maxlength="9" id="cantidad" style="width: 60%;float:right;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="0.00" name="cantidad" type="text" class="form-control" />
            </div>
            <div class="col-xs-1" >Indicador</div>
            <div class="col-xs-6">
                <input maxlength='40' id="indicador_actividad" style="width: 98%;float:right;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Ingrese el indicador" name="indicador_actividad" type="text" class="form-control" />
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-1" >Programado</div>
            <div class="col-xs-3">
                <input type="checkbox" id="programado" name="programado" class="form-control" checked="checked"/>
            </div>
        </div>
        <br/>
            <div class="row" style="text-align: center">
                <input type="submit" id="registrar_actividad" style="font-weight: bold;font-size: 13px" class="btn btn-success" value="Guardar cambios"/>
                <button type="reset" id="limpiar" style="font-weight: bold;font-size: 13px; background: -moz-linear-gradient(#f4eb2f, #e5a32d); color: white " class="btn"/>
                &nbsp;<span class="glyphicon glyphicon-retweet"></span>&nbsp;&nbsp;Limpiar
                </button>
            </div>
        <br/>
    </div>
</form>
