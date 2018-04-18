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
        var fecha = new Date();
        var ano = fecha.getFullYear();

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
                bootbox.alert("Seleccione el Año fiscal", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#ano_fiscal").parent('div').addClass('has-error');
                    $("#ano_fiscal").select2('open');
                });
            }else if ($('#organo').val().trim() == '') {
                bootbox.alert("Seleccione el Organo", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#organo").parent('div').addClass('has-error');
                    $("#organo").select2('open');
                });
            } else if ($('#accion_id').val().trim() == '') {
                bootbox.alert("Seleccione Un Identificador de la Acción", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#accion_id").parent('div').addClass('has-error');
                    $("#accion_id").select2('open');
                });
            } else if ($('#revisado').val().trim() == '') {
                bootbox.alert("Ingrese el responsable", function () {
                    $('.nav-tabs a[href=#tabs_observacion]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#revisado").parent('div').addClass('has-error');
                    $("#revisado").select2('open');
                });
            } else if ($('#estructura_id').val().trim() == '') {
                bootbox.alert("Ingrese la Estructura", function () {
                    $('.nav-tabs a[href=#tabs_observacion]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#estructura_id").parent('div').addClass('has-error');
                    $("#estructura_id").focus();
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
                 $("#fecha_elaboracion").val(fecha_actual);*/

                $.post('<?php echo base_url(); ?>acciones/observaciones/ControllersObservaciones/guardar', $('#form_observacion_acciones').serialize(), function (response) {

                    if (response == "existe") {
                        bootbox.alert("Disculpe, ya se encuentra registrado la estructura_id n° " + $("#estructura_id").val() + ", verifique los datos", function () {
                            $('.nav-tabs a[href=#tabs_observacion]').tab('show');
                        }).on('hidden.bs.modal', function (event) {
                            $("#estructura_id").parent('div').addClass('has-error');
                            $("#estructura_id").focus();
                        });
                    } else {
                        bootbox.alert("Se registro con exito", function () {
                        }).on('hidden.bs.modal', function (event) {
                            url = '<?php echo base_url(); ?>acciones/observaciones/ControllersObservaciones/procesar/' + $("#accion_id").val() + '';
                            window.location = url;
                        });
                    }
                });
            }
        });

        // Validacion ajax para reflejar los datos en formato json los ID de Accion
        $("#organo").change(function () {

            var organo = $(this).val();
            var ano_fiscal = $("#ano_fiscal").val();
            
            
            if ($('#ano_fiscal').val() == 0) {
                bootbox.alert("Seleccione el Año fiscal", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#ano_fiscal").parent('div').addClass('has-error');
                    $("#ano_fiscal").select2('open');
                    $("#organo").select2('val',0);
                    $("#accion_id").select2('val',"");
                });
            }else{
            
            $('#accion_id').find('option:gt(0)').remove().end().select2('val', "");
            $.post('<?php echo base_url(); ?>acciones/observaciones/ControllersObservaciones/ajax_search/' + organo + '/'+ano_fiscal +'', function (response) {
                var option = "";
                var estruc_presupuestaria = "";
                $.each(response, function (i) {
                    var estruc_presupuestaria = response[i]['codigo'];
                    
//                    if (response[i]['estatus'] == 1) {

                        option += "<option value=" + response[i]['id'] + ">" + response[i]['codigo'] + "</option>";
//                    }
                });
                $('#accion_id').append(option);
                $("#revisado").select2('val', parseInt($("#organo").val()));
                $('#estructura_id').val(estruc_presupuestaria);
            }, 'json');
        }
        });

        // Validacion ajax para reflejar los datos en formato json los datos asociados al ID de Accion
        $("#accion_id").change(function () {

            var accion = $(this).val();

            $.post('<?php echo base_url(); ?>acciones/observaciones/ControllersObservaciones/ajax_table/' + accion + '', function (response) {
                monto_solicitado = 0;
                if (response != "") {
                    $.each(response, function (i) {

                        acc_centralizada = response[i]['acc_centralizada'];
                        ano_fiscal = response[i]['ano_fiscal'];
                        $('#nom_accion').select2('val', parseInt(acc_centralizada));
                        $('#ano_fiscal').val(ano_fiscal);

                        if (response[i]['monto'] > 0) {
                            monto_solicitado += parseFloat(response[i]['monto']);
                        }
                        $('#monto_solicitado').val(monto_solicitado);
                    });
                } else {
                    bootbox.alert("Disculpe, no se encuentran montos asociados a la imputación presupuestaria ", function () {
                    }).on('hidden.bs.modal', function (event) {
                        $("#nom_accion").select2('val', "");
                        $('#ano_fiscal,#monto_solicitado').val("");
                    });
                }
            }, 'json');

        });

        /* var fecha = new Date();
         var fecha_actual = fecha.getDate() + "/" + fecha.getMonth() + 1 + "/" + fecha.getFullYear()
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
                {"sClass": "registro center", "sWidth": "2%"},
                {"sClass": "registro center", "sWidth": "2%"},
                {"sClass": "registro center", "sWidth": "2%"},
                {"sClass": "registro center", "sWidth": "2%"},
                {"sClass": "registro center", "sWidth": "2%"},
                {"sClass": "registro center", "sWidth": "2%"},
                {"sWidth": "3%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
            ]
        });

        // Validacion para autocompletar un guion (-) por cada 2 digitos
        $("#estructura_id").keyup(function () {
            var nums = new Array();
            var simb = "-"; //Éste es el separador
            var valor = $("#estructura_id").val();
            valor = valor.toString();
            valor = valor.replace(/\D/g, "");   //Ésta expresión regular solo permitira ingresar números
            nums = valor.split(""); //Se vacia el valor en un arreglo
            var long = nums.length - 1; // Se saca la longitud del arreglo
            var patron = 2; //Indica cada cuanto se ponen las comas
            var prox = 1; // Indica en que lugar se debe insertar la siguiente coma
            var res = "";

            while (long > prox) {
                nums.splice((long - prox), 0, simb); //Se agrega la coma
                prox += patron; //Se incrementa la posición próxima para colocar la coma
            }

            for (var i = 0; i <= nums.length - 1; i++) {
                res += nums[i]; //Se crea la nueva cadena para devolver el valor formateado
            }

            $("#estructura_id").val(res);
        });

    });

</script>
<br/>
<br/>
<br/>
<br/>
<?php
foreach ($codigo as $value) {
    $codigo = $value->id;
}
?>
<form id='form_observacion_acciones' action="" method="POST">
    <div style="width: 95%;text-transform:uppercase;box-shadow: 0 1px 5px rgba(0,0,0,.85);margin: auto;" class="panel panel-default">
        <div class="panel-heading" style='background: linear-gradient(#2F9292, #3B7272);color:#FFFFFF;'>
            <label style="float: left" class="panel-title " ><!--<a href="<?php echo base_url(); ?>acciones/observaciones/ControllersObservaciones" >Configuraciones</a>-->
                Registrar Observación </label>
            <br>
        </div>
        <fieldset><legend class="titulo text-center">Datos de la Observación</legend></fieldset>

        <div class="panel-body" hidden='true'>
            <div class="col-xs-2">Fecha</div>
            <div class="col-xs-5">
                <input style="width: 16%" value="<?= date('Y-m-d', now()) ?>" id="fecha_elaboracion" name="fecha_elaboracion" type="text" class="form-control" />
                <input type="text" value='1' name='cierre'/>
                <!--<input type="hidden" value='1' name='ano_fiscal' value="<?=date('Y',now())?>"/>-->
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-2">Estátus</div>
            <div class="col-xs-10">
                <select id='estatus' name='estatus' style='width: 65%;'>
                    <option value=''>Seleccione</option>
                    <option value='1'>Revisando</option>
                    <option value='2'>Rechazado</option>
                    <option value='3'>Para Ajuste</option>
                    <option value='4'>Aprobado</option>
                </select>
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-2">Año fiscal</div>
            <div class="col-xs-10">
                <select id='ano_fiscal' name='ano_fiscal' style='width: 65%;'>
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
                <select id='organo' name='organo' style='width: 70%;'>
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
                <select id='accion_id' name='id_accion' style='width: 11.5%;'>
                    <option value=''>ID</option>
                </select>
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-2">Nombre de la Acción</div>
            <div class="col-xs-10">
                <select id='nom_accion' style='width: 65%;' disabled="">
                    <option value=''>Seleccione</option>
                    <?php foreach ($acc_centralizada as $value) { ?>
                        <option value="<?php echo $value->id; ?>"> <?php echo $value->accion_centralizada; ?> </option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-2">Monto</div>
            <div class="col-xs-2">
                <input type="text" disabled="" id="monto_solicitado" placeholder="0.00" class="form-control" style='width: 90%;'/>
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
                            <input placeholder="00-00-00-00" type="text" id="estructura_id" name="estructura" placeholder="0000" class="form-control" style='width: 90%;'/>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-xs-2">Observaciones</div>
                    <div class="col-xs-10">
                        <textarea id="observaciones" name="observaciones" placeholder="Ingrese las Observaciones" class="form-control" style='width: 65%;text-transform:uppercase' onblur="javascript:this.value = this.value.toUpperCase();"></textarea>
                    </div>
                </div>
            </div>
            <div id="tabs_monto_partida" class="tab-pane fade" style="width:98%;margin: auto;">
                <table style="width:100%;" border="0" align="center" cellspacing="1" id="tabla_fuente_financiamiento" align="center"
                       class="table table-bordered table-striped table-hover table-condensed dt-responsive table-responsive" style="width:20%">
                    <thead style="font-size: 16px">
                        <tr style="background-color: #8BA8A7">
                            <th></th>
                            <th style='text-align: center'>Código</th>
                            <th style='text-align: center'>Denominación</th>
                            <th style='text-align: center'>Monto Solicitado</th>
                            <th style='text-align: center'>Situado Constitucional</th>
                            <th style='text-align: center'>Gestión Fiscal</th>
                            <th title="Fondo de Compensación Interterritorial" style='text-align: center'>(FCI)</th>
                            <th title="Transferencias Internas Corrientes de la República" style='text-align: center'>(TICR)</th>
                            <th style='text-align: center'>Monto Asignado</th>
                            <th style='text-align: center'>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
        <br/>
        <br/>
        <div class="row" style="text-align: center">
            <a href="<?php echo base_url('acciones/observaciones/ControllersObservaciones'); ?>">
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
