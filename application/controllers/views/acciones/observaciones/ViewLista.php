
<script>
    $(document).ready(function () {
        $("select").select2();

        var TPP = $('#tab_observaciones_acc').dataTable({
            "iDisplayLength": 10,
            "iDisplayStart": 0,
            "sPaginationType": "full_numbers",
            "aLengthMenu": [25, 50, 75, 100],
            "oLanguage": {"sUrl": "<?php echo base_url(); ?>assets/js/es.txt"},
            //"order": [[1, "asc"]],
            "aoColumns": [
                {"sClass": "control", "sWidth": "1%"},
                {"sClass": "registro center", "sWidth": "1%"},
                {"sClass": "registro center", "sWidth": "1%"},
                {"sClass": "registro center", "sWidth": "15%"},
                {"sClass": "registro center", "sWidth": "2%"},
                {"sWidth": "1%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
                {"sWidth": "1%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
                {"sWidth": "1%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
                {"sWidth": "1%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}

            ]
        });

        //detalles-search
        $("table#tab_observaciones_acc").on('click', 'a.detalles-search', function (e) {
            var id = this.getAttribute('id');
            $("#id").val(id);
            $.fancybox.open({
                'autoScale': false,
                'href': '#form_observaciones_acc',
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

        $("#registrar").click(function (e) {

            e.preventDefault();  // Para evitar que se envíe por defecto
            

            if ($('#ano_fiscal').val().trim() == 0) {

                bootbox.alert("Seleccione el Año fiscal", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#ano_fiscal").parent('div').addClass('has-error');
                    $("#ano_fiscal").select2('open');
                });

            } else if ($('#estatus').val().trim() == '') {

                bootbox.alert("Seleccione el Estátus", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#estatus").parent('div').addClass('has-error');
                    $("#estatus").select2('open');
                });

            } else if ($('#observaciones').val() == "") {
                bootbox.alert("Ingrese la observación", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#observaciones").parent('div').addClass('has-error');
                    $("#observaciones").focus();
                });
            } else {

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

                                $.post('<?php echo base_url(); ?>acciones/observaciones/ControllersObservaciones/modificar', $('#form_observaciones_acc').serialize(), function (response) {
                                    bootbox.alert("Se actualizo con exito", function () {
                                    }).on('hidden.bs.modal', function (event) {
                                        url = '<?php echo base_url(); ?>acciones/observaciones/ControllersObservaciones';
                                        window.location = url;
                                    });
                                });

                            }
                        }
                    }
                });
            }
        });

        // Validacion para borrar
        $("table#tab_observaciones_acc").on('click', 'img.borrar', function (e) {
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
                            $.post('<?php echo base_url(); ?>acciones/observaciones/ControllersObservaciones/delete/' + id + '', function (response) {

                                if (response == "existe") {

                                    bootbox.alert("Disculpe, Se encuentra en estatus Aprobado", function () {
                                    }).on('hidden.bs.modal', function (event) {
                                    });

                                } else {
                                    bootbox.alert("Se elimino con exito", function () {
                                    }).on('hidden.bs.modal', function (event) {
                                        url = '<?php echo base_url(); ?>acciones/observaciones/ControllersObservaciones';
                                        window.location = url;
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
<div class="row-fluid" >
    <div class="container mainbody-section text-center"  style="width:100%;">
        <a href="<?php echo base_url('acciones/observaciones/ControllersObservaciones/nuevo'); ?>">
            <button role="button" class="btn btn-default" style="font-weight: bold;font-size: 13px" id="enviar" >
                &nbsp;<span class="glyphicon glyphicon-plus"></span>&nbsp;
                Agregar Observación
            </button>
        </a>
        </br>
        </br>
        <div class='tab_acc'>
            <div style="font-weight:bold; color: #000000;" class="alert alert-danger">Nota: Para agilizar la consulta del registro, realize la busqueda por Organo u Ente</div>
            <table style="width:100%;" border="0" align="center" cellspacing="1" id="tab_observaciones_acc" align="center"
                   class="table table-bordered table-striped table-hover table-condensed dt-responsive table-responsive" style="width:30%">
                <thead style="font-size: 16px">
                    <tr style="background-color: #263238">
                        <th style='text-align: center;color: white' colspan="15">Observaciones</th>
                    </tr>
                    <tr style="background-color: #8BA8A7">
                        <th></th>
                        <th style='text-align: center'>Item</th>
                        <th style='text-align: center'>Código</th>
                        <th style='text-align: center'>Organo</th>
                        <th style='text-align: center'>Año fiscal</th>
                        <th style='text-align: center'>Estátus</th>
                        <th style='text-align: center'>Observación</th>
                        <th style='text-align: center'>F / Financiamiento</th>
                        <th style='text-align: center'>Eliminar</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $i = 1;
                    foreach ($list_observaciones as $value) {
//                    if((int)$value->cierre == 1){
                        ?>

                        <tr style="font-size: 16px" class="{% cycle 'impar' 'par' %}">
                            <td></td>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $value->codigo; ?></td>
                            <td>
                                <a href="<?php echo base_url('acciones/observaciones/ControllersObservaciones/procesar/' . $value->id . "?ver=1"); ?>" style="text-decoration: none;cursor: pointer;" title="Ver información preliminar">
                                    <?php echo $value->nom_ins; ?>
                                </a>

                            </td>
                            <td><?php echo $value->ano_fiscal; ?></td>
                            <td>
                                <?php
                                if ((int) $value->estatus == 1) {
                                    echo "Revisando";
                                } else if ((int) $value->estatus == 2) {
                                    echo "Rechazado";
                                } else if ((int) $value->estatus == 3) {
                                    echo "Para Ajuste";
                                } else if ((int) $value->estatus == 4) {
                                    echo "Aprobado";
                                }
                                ?>
                            </td>
                            <td>
                                <a class="detalles-search" id='<?php echo $value->id . "*" . $value->revisado . "*" . $value->estructura. "*". $value->id_accion; ?>'>
                                    <img style="width:50px;height: 50px" src="<?php echo base_url("assets/image/detalles.png"); ?>"/>   
                                </a>
                            </td>
                            <td style='text-align: center'>
                                <a href="<?php echo base_url('acciones/observaciones/ControllersObservaciones/procesar/' . $value->id); ?>">
                                    <img style="width:50px;height: 50px" src="<?php echo base_url("assets/image/fuente_financiamiento.png"); ?>"/>   
                                </a>
                            </td>
                            <td style='text-align: center'>
                                <?php if ($value->estatus == 1 or $value->estatus == 3) { ?>
                                <img title="Borrar observación" class='borrar' id='<?php echo $value->id . "-" . $value->ano_fiscal; ?>'  style="width:25px;height: 25px;cursor:pointer;" src="<?php echo base_url("assets/image/eliminar.png"); ?>"/>
                                <?php } else { ?>
                                    <img style="width:25px;height: 25px" src="<?php echo base_url("assets/image/block.png"); ?>"/>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php
                        $i = $i + 1;
//                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<form id='form_observaciones_acc' action="" method="POST" style='display: none;'>
    <div style="width: 95%;text-transform:uppercase;box-shadow: 0 1px 5px rgba(0,0,0,.85);margin: auto;" class="panel panel-default">
        <div class="panel-heading" style='background: linear-gradient(#2F9292, #3B7272);color:#FFFFFF;' >
            <label>Observaciones</label>
            <br>
        </div>
        <div class="panel-body">
            <div class="col-xs-2">Año Fiscal</div>
            <div class="col-xs-10">
                <select id='ano_fiscal' name='ano_fiscal' style='width: 100%;'>
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
            <div class="col-xs-2" >Estátus</div>
            <div class="col-xs-10">
                <input name="id" id="id" type="hidden"/>
                <select id='estatus' name='estatus' style='width: 100%;'>
                    <option value=''>Seleccione</option>
                    <option value='1'>Revisando</option>
                    <option value='2'>Rechazado</option>
                    <option value='3'>Para Ajuste</option>
                    <option value='4'>Aprobado</option>
                </select>

            </div>
        </div>

        <div class="panel-body">
            <div class="col-xs-2" >Observación</div>
            <div class="col-xs-10">
                <textarea class="form-control" id="observaciones" name="observaciones" style='width: 100%;'></textarea>
            </div>
        </div>
        <br/>
        <div class="row" style="text-align: center">
            <input type="button" id="registrar" style="font-weight: bold;font-size: 13px" class="btn btn-success" value="Guardar cambios"/>
        </div>
        <br/>
    </div>
</form>