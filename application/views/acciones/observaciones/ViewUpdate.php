<?php
if (isset($this->session->userdata['logged_in'])) {
    $username = ($this->session->userdata['logged_in']['username']);
    $id       = ($this->session->userdata['logged_in']['id']);
    if (isset($_GET['ver'])) {
        $preliminar = $_GET['ver'];
    } else {
        $preliminar = "2";
    }
} else {
    $header = base_url();
    header("location: " . $header);
}
?>
<script>
    $(document).ready(function () {

        $("#ano_fiscal").select2('val', $("#id_ano_fiscal").val());

        // if (<?php echo $preliminar; ?> == 1) {
        //     $("input,textarea,select").prop('disabled', true);
        // }
        

        $("select").select2();
        var fecha = new Date();
        var ano = fecha.getFullYear();

        var estatus = $("#id_estatus").val();
        if(estatus == 4){
            $("li#monto_partida_modificado").css('display','block');
        }

        $("#estatus").select2('val', parseInt($("#id_estatus").val()));
        $("#organo").select2('val', parseInt($("#id_organo").val()));
        $("#accion").select2('val', parseInt($("#id_accion").val()));
        $("#revisado").select2('val', parseInt($("#id_revisado").val()));


        $('#plan_patria').alphanumeric({allow: " -.,"});
        $('#codigo').alphanumeric({allow: "-."});
        $("#registrar").click(function (e) {

            e.preventDefault();

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

                                datos = $("#estatus").val() + ";";
                                datos += $("#revisado").val() + ";";
                                datos += $("#estructura_id").val() + ";";
                                datos += $("#observaciones").val();

                                

                                $.post('<?php echo base_url(); ?>acciones/observaciones/ControllersObservaciones/modificar', $('#form_observacion_acciones').serialize(), function (response) {
                                    bootbox.alert("Se actualizo con exito", function () {
                                    }).on('hidden.bs.modal', function (event) {
                                        url = "<?php echo base_url(); ?>acciones/observaciones/ControllersObservaciones/procesar/<?php echo $detalles_lista->id_accion ?>";
                                        window.location = url;
                                    });
                                });

                            }
                        }
                    }
                });
             }
         });


$('#valid').find('input:text').keyup(function(){
    $('#valid').find('input:text').not(this).val("");
    // $('#valid').find('input:text').prop('disabled', false);
    // if($(this).val().length  > 0){
    //     $('#valid').find('input:text').not(this).prop('disabled', true);
    // }
    
});

$("#add-mount-poa").click(function (e) {

    e.preventDefault();
    var $this = $(this);
    var count = 0;
    $('#valid').find('input:text').each(function(i, v) {
        if($( this ).val().length > 0 ){
            count = 1;
            var m_asig = $( this ).val();
            $("#m_asig_mod").val(m_asig);
            
        }
    });
    
    if ($('#partida_id').val().trim() == '') {

        bootbox.alert("Ingrese la Denominación", function () {
        }).on('hidden.bs.modal', function (event) {
            $("#partida_id").parent('div').addClass('has-error');
            $("#partida_id").select2('open');
        });

    } else if (count == 0) {
        bootbox.alert("Ingrese el monto de la fuente de financiamiento", function () {
        }).on('hidden.bs.modal', function (event) {

        });
    } else {
        $this.prop('disabled', true)
        $.post('<?php echo base_url(); ?>acciones/observaciones/ControllersObservaciones/monto_modificado', $('#frm-add-monto').serialize(), function (response) {
            bootbox.alert("Se registro la fuente de Financiamiento", function () {
            }).on('hidden.bs.modal', function (event) {
                location.reload();
            });
        });
    }
});

$("table#tabla_fuente_financiamiento_modificado").on('change', 'textarea.capturar', function (e) {
    var id = this.getAttribute('name');
    var s_cons = $("#s_cons_" + id + "").val();
    var c_adicional = $("#c_adicional_" + id + "").val();
    var fcie = $("#fcie_" + id + "").val();
    var i_p = $("#i_p_" + id + "").val();
    var cantidad = $("#cantidad_" + id + "").val();


    $("table#tabla_fuente_financiamiento_modificado tr#tr_" + id + "").css("background-color", "#D5F2F1");

            // Condicional de Campos Vacios
            var s_cons = (s_cons == "") ? 0.00 : s_cons;
            var c_adicional = (c_adicional == "") ? 0.00 : c_adicional;
            var fcie = (fcie == "") ? 0.00 : fcie;
            var i_p = (i_p == "") ? 0.00 : i_p;

            suma = parseFloat(s_cons) + parseFloat(c_adicional) + parseFloat(fcie) + parseFloat(i_p);
            $("#m_asig_" + id + "").val(suma);

            var data = {
                'id': id,
                's_cons': s_cons,
                'c_adicional': c_adicional,
                'fcie': fcie,
                'i_p': i_p,
                'm_asig': parseFloat(suma)
            }
            $.post('<?php echo base_url(); ?>acciones/observaciones/ControllersObservaciones/monto_modificado', data , function (response) {

            });
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
                    $("#organo").select2('val', 0);
                    $("#id_accion").select2('val', "");
                });
            } else {

                $('#id_accion').find('option:gt(0)').remove().end().select2('val', "");
                $.post('<?php echo base_url(); ?>acciones/observaciones/ControllersObservaciones/ajax_search/' + organo + '/' + ano_fiscal + '', function (response) {
                    var option = "";
                    var estruc_presupuestaria = "";
                    $.each(response, function (i) {
                        estruc_presupuestaria = response[i]['estruc_presupuestaria'];

                        option += "<option value=" + response[i]['id'] + ">" + response[i]['codigo'] + "</option>";
                    });
                    $('#id_accion').append(option);
                    $("#revisado").select2('val', parseInt($("#organo").val()));
                    $('#estructura_id_id').val(estruc_presupuestaria);
                }, 'json');
            }
        });

        // Carga de de los IDS del organo
        var organo = $("#id_organo").val();
        var ano_fiscal = $("#id_ano_fiscal").val();
        var id_accion = $("#accion").val();

        $.post('<?php echo base_url(); ?>acciones/observaciones/ControllersObservaciones/ajax_search/' + organo + '/' + ano_fiscal + '', function (response) {
            var option = "";
            $.each(response, function (i) {
                estruc_presupuestaria = response[i]['estruc_presupuestaria'];
                option += "<option value=" + response[i]['id'] + ">" + response[i]['codigo'] + "</option>";
            });
            $('#id_accion').append(option);
            $("#id_accion").select2('val', parseInt(id_accion));
        }, 'json');


        // Add monto modificado
        $("a.add-mount-modified").click(function () {
            // $("#id_act,#actividad,#unidad_medida,#medio_verificacion,#cantidad,#indicador_actividad,#id_acc_reg").val("");
            $.fancybox.open({
                'autoScale': false,
                'href': '#frm-add-monto',
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


        // Validacion ajax para reflejar los datos en formato json los datos asociados al ID de Accion
        $("#id_accion").change(function () {

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

        // Carga de los datos asociados al identificador
        var accion = $("#accion").val();

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
                bootbox.alert("Disculpe, no se encuentran mostos asociados a la imputación presupuestaria ", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#nom_accion").select2('val', "");
                    $('#ano_fiscal,#monto_solicitado').val("");
                });
            }
        }, 'json');

        /*var fecha = new Date();
         var fecha_actual = fecha.getDate() + "/" + fecha.getMonth() + 1 + "/" + fecha.getFullYear();
         $("#fecha_elaboracion").val(fecha_actual);*/

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

         var FuenteFM = $('#tabla_fuente_financiamiento_modificado').dataTable({
            "iDisplayLength": 10,
            "iDisplayStart": 0,
            "sPaginationType": "full_numbers",
            "aLengthMenu": [25, 50, 75, 100],
            "oLanguage": {"sUrl": "<?php echo base_url(); ?>assets/js/es.txt"},
            //"order": [[1, "asc"]],
            "aoColumns": [
            {"sClass": "control", "sWidth": "1%"},
            {"sClass": "registro center", "sWidth": "5%"},
            {"sClass": "registro center", "sWidth": "5%"},
            {"sClass": "registro center", "sWidth": "5%"},
            {"sClass": "registro center", "sWidth": "5%"},
            {"sClass": "registro center", "sWidth": "5%"},
            {"sClass": "registro center", "sWidth": "5%"},
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
            $("#m_asig_" + id + "").val(suma);

            datos = id + "-";
            datos += s_cons + "-";
            datos += g_fiscal + "-";
            datos += fci + "-";
            datos += ticr + "-";
            datos += suma;


            $.post('<?php echo base_url(); ?>acciones/observaciones/ControllersObservaciones/cargar/' + datos + '', function (response) {

            });
        }); // Fin



        // Fuentes de financiamientos modificado
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
            $("#m_asig_" + id + "").val(suma);

            datos = id + "-";
            datos += s_cons + "-";
            datos += g_fiscal + "-";
            datos += fci + "-";
            datos += ticr + "-";
            datos += suma;


            $.post('<?php echo base_url(); ?>acciones/observaciones/ControllersObservaciones/cargar/' + datos + '', function (response) {

            });
        }); // Fin

    });

</script>
<style>

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

            <div class="panel-body" hidden="">
                <div class="col-xs-2">Fecha</div>
                <div class="col-xs-5">
                    <input style="width: 16%" value="<?= date('Y-m-d', now()) ?>" id="fecha_elaboracion" name="fecha_elaboracion" type="text" class="form-control" />
                </div>
            </div>
            <div class="panel-body">
                <div class="col-xs-2">Estátus</div>
                <div class="col-xs-10">
                    <select id='estatus' style='width: 65%;'>
                        <!-- Acciones centralida y Proyectos -->
                        <option value=''>Seleccione</option>
                        <option value='1'>Revisando</option>
                        <option value='2'>Rechazado</option>
                        <option value='3'>Para Ajuste</option>
                        <option value='4'>Aprobado</option>
                        <!-- Ingresos Propios -->
                        <!--<option value='5'>Revisando | Ingresos Propios</option>
                        <option value='6'>Rechazado | Ingresos Propios</option>
                        <option value='7'>Para Ajuste | Ingresos Propios</option>
                        <option value='8'>Aprobado | Ingresos Propios</option>-->
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
                    <select id='id_accion' name='id_accion' style='width: 11.5%;' >
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
                <li id='monto_partida_modificado' data-toggle="popover" data-trigger="focus" title="Fuente de Financiamiento (Modificado)" data-placement="top" style="display: none;">
                    <a data-toggle="tab" href="#tabs_monto_partida_modificado">Fuente de Financiamiento (Modificado)</a>
                </li>
            </ul>
            <br>
            <div class="panel-body">
                <div class="col-xs-12">
                    <div class="alert alert-danger" style="color: #000000;">
                        Nota: 
                        <span> Se debe realizar la carga de la Fuente de Financiamiento / Fuente de Financiamiento Modificado para que se refleje en el POAE Modificado.</span>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div id="tabs_observacion" class="tab-pane fade in active">
                    <div class="panel-body">
                        <div class="col-xs-2">Revisado por</div>
                        <div class="col-xs-10">
                            <select id='revisado' name='revisado' style='width: 65%;' disabled="">
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
                                <input placeholder="00-00-00-00" value="<?php echo $detalles_lista->estructura; ?>" type="text" id="estructura_id" name="estructura" placeholder="0000" class="estructura form-control" style='width: 90%;'/>
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
                        <tr class='background-first' style="color:#FFFFFF;">
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
                            <tr style="font-size: 16px" id="tr_<?= $value->pk ?>">
                                <td></td>
                                <td><?php echo $value->codigo; ?></td>
                                <td><?php echo $value->partida_presupuestaria; ?></td>
                                <td><input readonly type="text" style="width:130px;" class="capturar_item form-control" id="monto_<?php echo $value->pk; ?>" name="<?php echo $value->pk; ?>" value="<?php echo $value->monto; ?>"/></td> 
                                <td><input type="text" style="width:130px;" class="capturar_item form-control" id="s_cons_<?php echo $value->pk; ?>" name="<?php echo $value->pk; ?>" value="<?php echo $value->s_cons; ?>"/></td>
                                <td><input type="text" style="width:130px;" class="capturar_item form-control" id="g_fiscal_<?php echo $value->pk; ?>" name="<?php echo $value->pk; ?>" value="<?php echo $value->g_fiscal; ?>"/></td>
                                <td><input type="text" style="width:130px;" class="capturar_item form-control" id="fci_<?php echo $value->pk; ?>" name="<?php echo $value->pk; ?>" value="<?php echo $value->fci; ?>"/></td>
                                <td><input type="text" style="width:130px;" class="capturar_item form-control" id="ticr_<?php echo $value->pk; ?>" name="<?php echo $value->pk; ?>" value="<?php echo $value->ticr; ?>"/></td>
                                <td><input readonly type="text" style="width:130px;" class="capturar_item form-control" id="m_asig_<?php echo $value->pk; ?>" name="<?php echo $value->pk; ?>" value="<?php echo str_replace(',', '.', number_format($value->m_asig, 2, ",", ".")); ?>"/></td>
                            </tr>
                            <?php
                            $i = $i + 1;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div id="tabs_monto_partida_modificado" class="tab-pane fade" style="width:98%;margin: auto;">
                <table style="width:100%;" border="0" align="center" cellspacing="1" id="tabla_fuente_financiamiento_modificado" align="center"
                class="table table-bordered table-striped table-hover table-condensed dt-responsive table-responsive" style="width:20%">
                <thead style="font-size: 16px">
                    <tr class='background-first' style="color:#FFFFFF;">
                        <th style='text-align: center'>Código</th>
                        <th style='text-align: center'>Denominación</th>
                        <th style='text-align: center'>Situado Constitucional</th>
                        <th style='text-align: center'>Créditos Adicionales</th>
                        <th title="Fondo de Compensación Interterritorial Especiales" style='text-align: center'>(FCIE)</th>
                        <th title="Ingresos Propios" style='text-align: center'>Ingresos Propios</th>
                        <th style='text-align: center'>Asignación</th>
                    </tr>
                </thead>
                <tbody style="background-color: #FFFFFF;">
                    <?php
                    $i = 1;
                    foreach ($distribucion_mod as $value) {
                        ?>
                        <tr style="font-size: 16px;font-size: 14px;" id="tr_<?php echo $value->id; ?>">
                            <td><?php echo $value->codigo; ?></td>
                            <td style='text-align: center;width: 50%'>
                                <?php echo $value->partida_presupuestaria; ?>
                            </td>
                            <td>
                                <textarea style="height: 38px;" class="form-control capturar numeric" id='s_cons_<?= $value->id ?>' name='<?= $value->id ?>'><?php echo $value->s_cons; ?></textarea>
                            </td>
                            <td>
                                <textarea style="height: 38px;" class="form-control capturar numeric" id='c_adicional_<?= $value->id ?>' name='<?= $value->id ?>'><?php echo $value->c_adicional; ?></textarea>
                            </td>
                            <td>
                                <textarea style="height: 38px;width: 120px;" class="form-control capturar numeric" id='fcie_<?= $value->id ?>' name='<?= $value->id ?>'><?php echo $value->fcie; ?></textarea>
                            </td>
                            <td>
                                <textarea style="height: 38px;width: 120px;" class=" form-control capturar numeric" id='i_p_<?= $value->id ?>' name='<?= $value->id ?>'><?php echo $value->i_p; ?></textarea>
                            </td>
                            <td>
                                <textarea readonly='' style="height: 38px;width: 120px;" class=" form-control capturar numeric" id='m_asig_<?= $value->id ?>' name='<?= $value->id ?>'><?php echo $value->m_asig; ?></textarea>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr style="font-size: 16px">
                        <td></td>
                        <td>
                            <a class="add-mount-modified" style="text-decoration:none;text-align: left">
                                <button type="button" class="btn btn-default">Añadir elemento</button>
                            </a>
                        </td>
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
    <br/>
    <br/>
    <div class="row" style="text-align: center">
        <a href="<?php echo base_url('acciones/observaciones/ControllersObservaciones'); ?>">
            <button type="button" id="volver" style="font-weight: bold;font-size: 13px" class="btn btn-warning " >
                &nbsp;<span class="glyphicon glyphicon-chevron-left"></span>&nbsp;Volver
            </button>
        </a>
        
        <button type="button" id="registrar" style="font-weight: bold;font-size: 13px" class="btn btn-primary " >
            &nbsp;<span class="glyphicon glyphicon-chevron-left"></span>&nbsp;Guardar cambios
        </button>

        <!-- <input type="button" id="registrar" style="font-weight: bold;font-size: 13px" class="btn btn-success" value="Guardar cambios"/> -->

        
    </div>
    <br/>
</div>
<input type="hidden" id="id_estatus" name='estatus' value="<?php echo $detalles_lista->estatus ?>"/>
<input type="hidden" id="id_organo" value="<?php echo $detalles_lista->organo ?>"/>
<input type="hidden" id="accion" value="<?php echo $detalles_lista->id_accion ?>"/>
<input type="hidden" id="id_revisado" value="<?php echo $detalles_lista->revisado ?>"/>
<input type="hidden" id="id" value="<?php echo $detalles_lista->id ?>" />
<input id="id_ano_fiscal" type="hidden" value="<?php echo $detalles_lista->ano_fiscal ?>"/>
</form>

<form id='frm-add-monto' action="" method="POST" style='display: none;'>
    <div style="width: 95%;text-transform:uppercase;box-shadow: 0 1px 5px rgba(0,0,0,.85);margin: auto;" class="panel panel-default">
        <div class="panel-heading" style='background: linear-gradient(#2F9292, #3B7272);color:#FFFFFF;' >
            <label>Registrar Imputación</label>
            <br>
        </div>
        <fieldset><legend class="titulo text-center">Datos de la Imputación Presupuestaria</legend></fieldset>
        <div class="panel-body">
            <div class="col-xs-2" >Denominación</div>
            <div class="col-xs-10">
                <input name="id" type="hidden"/>
                <input name="m_asig" id="m_asig_mod" type="hidden"/>
                <input name="id_acc_reg" type="hidden" value="<?= $detalles_lista->id_accion ?>"/>
                <select id='partida_id' name='partida_id' style='width: 90%;'>
                    <option value=''>Seleccione</option>
                    <?php foreach ($partida as $row): ?>
                        <option value="<?php echo $row->id; ?>">
                            (<?php echo $row->codigo; ?>) <?php echo $row->partida_presupuestaria; ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="panel-body" id='valid'>
            <div class="col-xs-1" >Fuente F</div>
            <div style="float: left;">
                <input maxlength="10" id="s_cons" style="width: 52%;float:right;" name="s_cons" type="text" class="form-control" placeholder="" />
            </div>
            <div style="float: left;">
                <input maxlength="10" id="c_adicional" style="width: 52%;float:right;" name="c_adicional" type="text" class="form-control" placeholder=""/>
            </div>
            <div style="float: left;">
                <input maxlength="10" id="fcie" style="width: 52%;float:right;" name="fcie" type="text" class="form-control" placeholder=""/>
            </div>
            <div style="float: left;">
                <input maxlength="10" id="i_p" style="width: 52%;float:right;" name="i_p" type="text" class="form-control" placeholder=""/>
            </div>
        </div>
        <br/>
        <div class="row" style="text-align: center">
            <input type="button" id="add-mount-poa" style="font-weight: bold;font-size: 13px" class="btn btn-success" value="Guardar cambios"/>
        </div>
        <br/>
    </div>
</form>
