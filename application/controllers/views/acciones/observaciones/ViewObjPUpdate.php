<?php
if (isset($this->session->userdata['logged_in'])) {
    $username = ($this->session->userdata['logged_in']['username']);
    $id       = ($this->session->userdata['logged_in']['id']);
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
        $("#ano_fiscal").select2('val', parseInt($("#id_ano_fiscal").val()));
        if(<?php echo $preliminar;?> == 1){
            $("input,textarea,select").prop('disabled',true);
        }

        $("select").select2();
        var fecha = new Date();
        var ano = fecha.getFullYear();

        var estatus = $("#id_estatus").val();
        /*if(estatus == 2 || estatus == 4){
            $("input,select,textarea").prop('disabled',true);
            
        }*/
        
        $("#estatus").select2('val',parseInt($("#id_estatus").val()));
        $("#organo").select2('val',parseInt($("#id_organo").val()));
        $("#accion").select2('val',parseInt($("#id_accion").val()));
        $("#revisado").select2('val',parseInt($("#id_revisado").val()));

        //$("#ano_fiscal").select2('val', ano);

        $('#plan_patria').alphanumeric({allow: " -.,"});
        $('#codigo').alphanumeric({allow: "-."});
        $("#registrar").click(function (e) {

            e.preventDefault();  // Para evitar que se envíe por defecto

            if ($('#estatus').val().trim() == '') {

                bootbox.alert("Seleccione el Estátus", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#estatus").parent('div').addClass('has-error');
                    $("#estatus").select2('open');
                });

            } else if ($('#ano_fiscal').val() == 0) {

                bootbox.alert("Seleccione el Estátus", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#ano_fiscal").parent('div').addClass('has-error');
                    $("#ano_fiscal").select2('open');
                });

            } else if ($('#organo').val().trim() == '') {
                bootbox.alert("Seleccione el Organo", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#organo").parent('div').addClass('has-error');
                    $("#organo").select2('open');
                });
            } else if ($('#id_accion').val().trim() == '') {
                bootbox.alert("Seleccione Un Identificador de la Acción", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#id_accion").parent('div').addClass('has-error');
                    $("#id_accion").select2('open');
                });
            } else if ($('#revisado').val().trim() == '') {
                bootbox.alert("Ingrese el responsable", function () {
                    $('.nav-tabs a[href=#tabs_observacion]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#revisado").parent('div').addClass('has-error');
                    $("#revisado").select2('open');
                });
            } else if ($('#estructura').val().trim() == '') {
                bootbox.alert("Ingrese la Estructura", function () {
                    $('.nav-tabs a[href=#tabs_observacion]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#estructura").parent('div').addClass('has-error');
                    $("#estructura").focus();
                });
            } else if ($('#observaciones').val().trim() == '') {
                bootbox.alert("Ingrese las Observaciones", function () {
                    $('.nav-tabs a[href=#tabs_observacion]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#observaciones").parent('div').addClass('has-error');
                    $("#observaciones").focus();
                });
            } else {
                /*var fecha = new Date();
                var fecha_actual = fecha.getFullYear() + "-" + fecha.getMonth() + 1 + "-" + fecha.getDate()
                $("#fecha_elaboracion").val(fecha_actual); */

                bootbox.dialog({
                    message: "¿Desea procesar la información",
                    title: "Enviar observación",
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

                            datos =  $("#estatus").val()+ ";";
                            datos += $("#revisado").val() + ";";
                            datos += $("#estructura").val() + ";";
                            datos += $("#observaciones").val();

                            /*alert(datos);

                            return true;*/
                            
                            $.post('<?php echo base_url(); ?>acciones/observaciones/ControllersObservacionesProy/modificar', $('#form_observacion_acciones').serialize(), function (response) {
                                bootbox.alert("Se actualizo con exito", function () {
                                }).on('hidden.bs.modal', function (event) {
                                    url = '<?php echo base_url(); ?>acciones/observaciones/ControllersObservacionesProy'
                                    window.location = url;
                                });
                            });
                            
                        }
                    }
                }
            });
            }
        });
        
        $("#ano_fiscal").change(function () {
            var ano_fiscal = $(this).val();
            $("#id_ano_fiscal").val(ano_fiscal);
        });
        
        
        // Validacion ajax para reflejar los datos en formato json los ID de Accion
        $("#organo").change(function () {

            
            var organo = $("#id_organo").val();
            var ano_fiscal = $("#ano_fiscal").val();
            
            
            $('#id_accion').find('option:gt(0)').remove().end().select2('val', "");
            $.post('<?php echo base_url(); ?>acciones/observaciones/ControllersObservacionesProy/ajax_search/' + organo + '/'+ano_fiscal+'', function (response) {
                var option = "";
                $.each(response, function (i) {
                    option += "<option value=" + response[i]['id'] + ">" + response[i]['codigo'] + "</option>";
                });
                $('#id_accion').append(option);
            }, 'json');
        });
        
        // Carga de de los IDS del organo
            var organo = $("#id_organo").val();
            var ano_fiscal = $("#id_ano_fiscal").val();
            
            $.post('<?php echo base_url(); ?>acciones/observaciones/ControllersObservacionesProy/ajax_search/' + organo + '/'+ano_fiscal+'', function (response) {
                var option = "";
                $.each(response, function (i) {
                    option += "<option value=" + response[i]['id'] + ">" + response[i]['codigo'] + "</option>";
                });
                $('#id_accion').append(option);
                $("#id_accion").select2('val',parseInt(id_accion));
            }, 'json');
        
        // Validacion ajax para reflejar los datos en formato json los datos asociados al ID de Accion
        $("#id_accion").change(function () {

            var accion = $(this).val();

            $.post('<?php echo base_url(); ?>acciones/observaciones/ControllersObservacionesProy/ajax_table/' + accion + '', function (response) {
                monto_solicitado = 0;
                if (response != "") {
                    $.each(response, function (i) {

                        nom_proyecto = response[i]['nom_proyecto'];
                        ano_fiscal = response[i]['ano_fiscal'];
                        $('#nom_proyecto').val(nom_proyecto);
                        $('#ano_fiscal').val(ano_fiscal);

                        monto_solicitado += parseFloat(response[i]['cantidad']);
                        $('#monto_solicitado').val(monto_solicitado);
                    });
                } else {
                    bootbox.alert("Disculpe, no se encuentran montos asociados a la imputación presupuestaria ", function () {
                    }).on('hidden.bs.modal', function (event) {
                        $("#nom_proyecto").val("");
                        $('#ano_fiscal,#monto_solicitado').val("");
                    });
                }
            }, 'json');

        });
        
        // Carga de los datos asociados al identificador
        var accion = $("#accion").val();
            
        $.post('<?php echo base_url(); ?>acciones/observaciones/ControllersObservacionesProy/ajax_table/' + accion + '', function (response) {
            monto_solicitado = 0;
            if (response != "") {
                $.each(response, function (i) {

                    nom_proyecto = response[i]['nom_proyecto'];
                    ano_fiscal = response[i]['ano_fiscal'];
                    $('#nom_proyecto').val(nom_proyecto);
                    $('#ano_fiscal').val(ano_fiscal);

                    monto_solicitado += parseFloat(response[i]['cantidad']);
                    $('#monto_solicitado').val(monto_solicitado);
                });
            } else {
                bootbox.alert("Disculpe, no se encuentran montos asociados a la imputación presupuestaria ", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#nom_proyecto").val("");
                    $('#ano_fiscal,#monto_solicitado').val("");
                });
            }
        }, 'json');
            
        /*var fecha = new Date();
        var fecha_actual = fecha.getDate() + "/" + fecha.getMonth() + 1 + "/" + fecha.getFullYear();
        $("#fecha_elaboracion").val(fecha_actual); */

        var FuenteF = $('#tabla_fuente_financiamiento').dataTable({
            "iDisplayLength": 10,
            "iDisplayStart": 0,
            "sPaginationType": "full_numbers",
            "aLengthMenu": [25, 50, 75, 100],
            "oLanguage": {"sUrl": "<?php echo base_url(); ?>assets/js/es.txt"},
            //"order": [[1, "asc"]],
            "aoColumns": [
                {"sClass": "control", "sWidth": "1%"},
                {"sClass": "registro center", "sWidth": "1%"},
                {"sClass": "registro center", "sWidth": "30%"},
                {"sClass": "registro center", "sWidth": "1%"},
                {"sClass": "registro center", "sWidth": "1%"},
                {"sClass": "registro center", "sWidth": "1%"},
                {"sClass": "registro center", "sWidth": "1%"},
                {"sClass": "registro center", "sWidth": "1%"},
                {"sClass": "registro center", "sWidth": "1%"},
            ]
        });

        // Validacion para la captura de los montos
        $("table#tabla_fuente_financiamiento").on('change', 'input.capturar_item', function (e) {
            var id = this.getAttribute('name');
            var s_cons = $("#s_cons_" + id + "").val();
            var g_fiscal = $("#g_fiscal_" + id + "").val();
            var fci = $("#fci_" + id + "").val();
            var ticr = $("#ticr_" + id + "").val();
            var m_asig = $("#m_asig_" + id + "").val();

            $("table#tabla_fuente_financiamiento tr#tr_" + id + "").css("background-color", "#D5F2F1");

            
            // Condicional de Campos Vacios
            var s_cons = (s_cons == "") ? 0.00 : s_cons;
            var g_fiscal = (g_fiscal == "") ? 0.00 : g_fiscal;
            var fci = (fci == "") ? 0.00 : fci;
            var ticr = (ticr == "") ? 0.00 : ticr;
            var m_asig = (m_asig == "") ? 0.00 : m_asig;

            suma = parseFloat(s_cons) + parseFloat(g_fiscal) + parseFloat(fci) + parseFloat(ticr);
            $("#m_asig_"+id+"").val(suma);

            datos = id + "-";
            datos += s_cons + "-";
            datos += g_fiscal + "-";
            datos += fci + "-";
            datos += ticr + "-";
            datos += suma;


            $.post('<?php echo base_url(); ?>acciones/observaciones/ControllersObservacionesProy/cargar/' + datos + '', function (response) {

            });
        }); // Fin

    });

</script>
<br/>
<br/>
<br/>
<br/>
<form id='form_observacion_acciones' action="" method="POST">
    <div style="width: 95%;text-transform:uppercase;box-shadow: 0 1px 5px rgba(0,0,0,.85);margin: auto;" class="panel panel-default">
        <div class="panel-heading" style='background: linear-gradient(#2F9292, #3B7272);color:#FFFFFF;'>
            <label style="float: left" class="panel-title " ><!--<a href="<?php echo base_url(); ?>acciones/observaciones/ControllersObservaciones" >Configuraciones</a>-->
                Registrar Fuente de Financiamiento</label>
            <br>
        </div>
        <!--<fieldset><legend class="titulo text-center">Datos de la Observación</legend></fieldset>-->
        <br/>

        <div class="panel-body" hidden='true'>
            <div class="col-xs-2">Fecha</div>
            <div class="col-xs-5">
                <input style="width: 16%" id="fecha_elaboracion" value="<?=$detalles_lista->fecha_elaboracion?>" name="fecha_elaboracion" type="text" class="form-control" />
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-2">Estátus</div>
            <div class="col-xs-10">
                <select id='estatus' name='estatus' style='width: 65%;' disabled="">
                    <option value=''>Seleccione</option>
                    <option value='1'>Revisando</option>
                    <option value='2'>Rechazado</option>
                    <option value='3'>Para Ajuste</option>
                    <option value='4'>Aprobado</option>
                </select>
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-2">Año Fiscal</div>
            <div class="col-xs-10">
                <select id='ano_fiscal' name='ano_fiscal' style='width: 65%;' disabled="">
                    <option value='0'>Año</option>
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
            <div class="col-xs-2">Institución</div>
            <div class="col-xs-8">
                <input type="hidden" name='id' value="<?php echo $detalles_lista->id ?>" />
                <select id='organo' name='organo' style='width: 70%;' disabled="">
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
                <select id='id_accion' name='id_accion' style='width: 11.5%;' disabled="">
                    <option value=''>ID</option>
                </select>
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-2">Nombre del Proyecto</div>
            <div class="col-xs-10">
                <textarea id='nom_proyecto' style='width: 65%;' disabled="" class='form-control'></textarea>
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-2">Monto</div>
            <div class="col-xs-2">
                <input type="text" disabled="" id="monto_solicitado" placeholder="0.00" class="form-control" style='width: 70%;'/>
            </div>
        </div>
        <!-- Apertura de Tabs (Secciones) -->
        <ul class="nav nav-tabs">
            <li class="active" data-toggle="popover" data-trigger="focus" title="Observaciones" data-placement="top">
                <a data-toggle="tab" href="#tabs_observacion">Observaciones</a>
            </li>
            <li data-toggle="popover" data-trigger="focus" title="Fuente de Financiamiento" data-placement="top">
                <a data-toggle="tab" href="#tabs_monto_partida">Fuente de Financiamiento</a>
            </li>
        </ul>
        <br>
        <div class="tab-content">
            <div id="tabs_observacion" class="tab-pane fade in active">
                <div class="panel-body">
                    <div class="col-xs-2">Revisado por</div>
                    <div class="col-xs-10">
                        <select id='revisado' name='revisado' style='width: 65%;'>
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
                    <div class="col-xs-2">Estructura</div>
                    <div class="col-xs-10">
                        <div style="float: left;">
                            <input readonly="" placeholder="00-00-00-00" value="<?php echo $detalles_lista->estructura; ?>" type="text" id="estructura" name="estructura" placeholder="0000" class="form-control" style='width: 90%;'/>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-xs-2">Observaciones</div>
                    <div class="col-xs-10">
                        <textarea id="observaciones" name="observaciones" placeholder="Ingrese las Observaciones" class="form-control" style='width: 65%;text-transform:uppercase' onblur="javascript:this.value = this.value.toUpperCase();"><?php echo $detalles_lista->observaciones; ?></textarea>
                    </div>
                </div>
            </div>
            <div id="tabs_monto_partida" class="tab-pane fade" style="width:98%;margin: auto;">
                <table style="width:100%;" border="0" align="center" cellspacing="1" id="tabla_fuente_financiamiento" align="center"
                       class="table table-bordered table-striped table-hover table-condensed dt-responsive table-responsive" style="width:20%">
                    <thead style="font-size: 16px">
                        <tr style="background-color: #8BA8A7;font-size: 14px;">
                            <th></th>
                            <th style='text-align: center'>Código</th>
                            <th style='text-align: center'>Denominación</th>
                            <th style='text-align: center'>Solicitud</th>
                            <th style='text-align: center'>Situado Constitucional</th>
                            <th style='text-align: center'>Gestión Fiscal</th>
                            <th title="Fondo de Compensación Interterritorial" style='text-align: center'>(FCI)</th>
                            <th title="Transferencias Internas Corrientes de la República" style='text-align: center'>(TICR)</th>
                            <th style='text-align: center'>Asignación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($imp_presupuestaria as $value) {
                            ?>
                        <tr style="font-size: 16px" id="tr_<?php echo $value->id?>">
                                <td></td>
                                <td><?php echo $value->codigo; ?></td>
                                <td><?php echo $value->partida_presupuestaria; ?></td>
                                <td><input readonly type="text" style="width:130px;" class="capturar_item form-control" id="monto_<?php echo $value->id; ?>" name="<?php echo $value->id; ?>" value="<?php echo $value->cantidad; ?>"/></td> 
                                <td><input type="text" style="width:130px;" class="capturar_item form-control" id="s_cons_<?php echo $value->id; ?>" name="<?php echo $value->id; ?>" value="<?php echo $value->s_cons; ?>"/></td>
                                <td><input type="text" style="width:130px;" class="capturar_item form-control" id="g_fiscal_<?php echo $value->id; ?>" name="<?php echo $value->id; ?>" value="<?php echo $value->g_fiscal; ?>"/></td>
                                <td><input type="text" style="width:130px;" class="capturar_item form-control" id="fci_<?php echo $value->id; ?>" name="<?php echo $value->id; ?>" value="<?php echo $value->fci; ?>"/></td>
                                <td><input type="text" style="width:130px;" class="capturar_item form-control" id="ticr_<?php echo $value->id; ?>" name="<?php echo $value->id; ?>" value="<?php echo $value->ticr; ?>"/></td>
                                <td><input readonly type="text" style="width:130px;color: red;" class="capturar_item form-control" id="m_asig_<?php echo $value->id; ?>" name="<?php echo $value->id; ?>" value="<?php echo $value->m_asig; ?>"/></td>
                            </tr>
                            <?php
                            $i = $i + 1;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <br/>
        <br/>
        <div class="row" style="text-align: center">
            <a href="<?php echo base_url('acciones/observaciones/ControllersObservacionesProy'); ?>">
                <button type="button" id="volver" style="font-weight: bold;font-size: 13px" class="btn btn-warning " >
                    &nbsp;<span class="glyphicon glyphicon-chevron-left"></span>&nbsp;Volver
                </button>
            </a>
            
        </div>
        <br/>
    </div>
    <input type="hidden" id="id_estatus" value="<?php echo $detalles_lista->estatus ?>"/>
    <input type="hidden" id="id_organo" value="<?php echo $detalles_lista->organo ?>"/>
    <input type="hidden" id="accion" value="<?php echo $detalles_lista->id_accion ?>"/>
    <input type="hidden" id="id_revisado" value="<?php echo $detalles_lista->revisado ?>"/>
    <input type="hidden" id="id" value="<?php echo $detalles_lista->id ?>" />
    <input id="id_ano_fiscal" type="hidden" value="<?php echo $detalles_lista->ano_fiscal ?>"/>
</form>
