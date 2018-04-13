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
        $("#desde,#hasta").mask("99-99-9999", {placeholder: "dd-mm-yyyy"});

        $("select").select2();
        // GENERION POR ACCION CENTRALIZADA
        $("#ano_fiscal").click(function () {
            var ano_fiscal = $("#ano_fiscal").val();
            $('#accion_centralizada').find('option:gt(0)').remove().end().select2('val', "");
            $.post('<?php echo base_url(); ?>reportes/generacion/ControllersReportes/search_datos/' + ano_fiscal + '/1', function (response) {

                var option = "";
                $.each(response, function (i) {

                    option += "<option value=" + response[i]['id'] + ">" + response[i]['codigo'] + " - " + response[i]['nom_ins'] + "</option>";
                });
                $('#accion_centralizada').append(option);
            }, 'json');

        });
        // GENERACION POR PROYECTO
        $("#ano_fiscal_p").click(function () {
            var ano_fiscal = $("#ano_fiscal_p").val();
            $('#proyecto').find('option:gt(0)').remove().end().select2('val', "");
            $.post('<?php echo base_url(); ?>reportes/generacion/ControllersReportes/search_datos/' + ano_fiscal + '/2', function (response) {

                var option = "";
                $.each(response, function (i) {

                    option += "<option value=" + response[i]['id'] + ">" + response[i]['codigo'] + " - " + response[i]['nom_ins'] + "</option>";
                });
                $('#proyecto').append(option);
            }, 'json');

        });

        // Generacion de PDF Acción Centralizada
        $(".generar_pdf").click(function (e) {

            e.preventDefault();  // Para evitar que se envíe por defecto

            if ($('#ano_fiscal').val().trim() == '') {

                bootbox.alert("Seleccione el Año Fiscal", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#ano_fiscal").parent('div').addClass('has-error');
                    $("#ano_fiscal").select2('open');
                });

            } else if ($('#accion_centralizada').val().trim() == '') {

                bootbox.alert("Seleccione la Acción Centralizada", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#accion_centralizada").parent('div').addClass('has-error');
                    $("#accion_centralizada").select2('open');
                });

            } else {
                var id = $("#accion_centralizada").val();
                URL = '<?php echo base_url(); ?>accion/' + id + '';
                $.fancybox.open({padding: 0, href: URL, type: 'iframe', width: 2000, height: 1024, });
            }
        });
        
        // Generacion de PDF Proyecto
        $(".generar_pdf_proy").click(function (e) {

            e.preventDefault();  // Para evitar que se envíe por defecto

            if ($('#ano_fiscal_p').val().trim() == '') {

                bootbox.alert("Seleccione el Año Fiscal", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#ano_fiscal_p").parent('div').addClass('has-error');
                    $("#ano_fiscal_p").select2('open');
                });

            } else if ($('#proyecto').val().trim() == '') {

                bootbox.alert("Seleccione el Proyecto", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#proyecto").parent('div').addClass('has-error');
                    $("#proyecto").select2('open');
                });

            } else {
                var id = $("#proyecto").val();
                URL = '<?php echo base_url(); ?>proyecto/' + id + '';
                $.fancybox.open({padding: 0, href: URL, type: 'iframe', width: 2000, height: 1024, });
            }
        });

        // Generacion de PDF Acción Centralizada para modulo de gestion

        $("#ano_fiscal_gestion").click(function () {
            var ano_fiscal = $("#ano_fiscal_gestion").val();
            $('#gestion_accion_centralizada_gestion').find('option:gt(0)').remove().end().select2('val', "");
            $.post('<?php echo base_url(); ?>reportes/generacion/ControllersReportes/search_datos_gestion/' + ano_fiscal + '/1', function (response) {

                var option = "";
                $.each(response, function (i) {

                    option += "<option value=" + response[i]['id'] + ">" + response[i]['codigo'] + " - " + response[i]['nom_ins'] + "</option>";
                });
                $('#gestion_accion_centralizada_gestion').append(option);
            }, 'json');

        });
        // GENERACION POR PROYECTO
        $("#ano_fiscal_proy_gestion").click(function () {
            var ano_fiscal = $("#ano_fiscal_proy_gestion").val();
            $('#proyecto').find('option:gt(0)').remove().end().select2('val', "");
            $.post('<?php echo base_url(); ?>reportes/generacion/ControllersReportes/search_datos_gestion/' + ano_fiscal + '/2', function (response) {

                var option = "";
                $.each(response, function (i) {

                    option += "<option value=" + response[i]['id'] + ">" + response[i]['codigo'] + " - " + response[i]['nom_ins'] + "</option>";
                });
                $('#proyecto_gestion').append(option);
            }, 'json');

        });

        $(".generar_pdf_gestion").click(function (e) {

            e.preventDefault();  // Para evitar que se envíe por defecto

            if ($('#ano_fiscal_gestion').val().trim() == '') {

                bootbox.alert("Seleccione el Año Fiscal", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#ano_fiscal_gestion").parent('div').addClass('has-error');
                    $("#ano_fiscal_gestion").select2('open');
                });

            } else if ($('#gestion_accion_centralizada_gestion').val().trim() == '') {

                bootbox.alert("Seleccione la Acción Centralizada", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#gestion_accion_centralizada_gestion").parent('div').addClass('has-error');
                    $("#gestion_accion_centralizada_gestion").select2('open');
                });

            } else {
                var id = $("#gestion_accion_centralizada_gestion").val();
                URL = '<?php echo base_url(); ?>accion/' + id + '';
                $.fancybox.open({padding: 0, href: URL, type: 'iframe', width: 2000, height: 1024, });
            }
        });

        $(".generar_pdf_proy_gestion").click(function (e) {

            e.preventDefault();  // Para evitar que se envíe por defecto

            if ($('#ano_fiscal_proy_gestion').val().trim() == '') {

                bootbox.alert("Seleccione el Año Fiscal", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#ano_fiscal_proy_gestion").parent('div').addClass('has-error');
                    $("#ano_fiscal_proy_gestion").select2('open');
                });

            } else if ($('#proyecto_gestion').val().trim() == '') {

                bootbox.alert("Seleccione el Proyecto", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#proyecto_gestion").parent('div').addClass('has-error');
                    $("#proyecto_gestion").select2('open');
                });

            } else {
                var id = $("#proyecto_gestion").val();
                URL = '<?php echo base_url(); ?>proyecto/' + id + '';
                $.fancybox.open({padding: 0, href: URL, type: 'iframe', width: 2000, height: 1024, });
            }
        });

        // Generacion de pdf para la emision de los Tomos I y II
        $(".generar_tomo").click(function (e) {
        

            e.preventDefault();  // Para evitar que se envíe por defecto
            

            if ($('#ano_fiscal_tomo').val().trim() == '') {

                bootbox.alert("Seleccione el Año Fiscal", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#ano_fiscal_tomo").parent('div').addClass('has-error');
                    $("#ano_fiscal_tomo").select2('open');
                });

            } else if ($('#tomo').val().trim() == '') {

                bootbox.alert("Seleccione un tipo de Tomo", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#tomo").parent('div').addClass('has-error');
                    $("#tomo").select2('open');
                });

            } else {
                var ano_fiscal_tomo = $("#ano_fiscal_tomo").val();
                var tomo = $("#tomo").val();
                URL = '<?php echo base_url(); ?>tomo/' + ano_fiscal_tomo + '/' + tomo;
                $.fancybox.open({padding: 0, href: URL, type: 'iframe', width: 2000, height: 1024, });
            }
        });

        // Generacion de pdf POA - PLAN OPERATIVO ANUAL
        $(".generar_POA").click(function (e) {

            e.preventDefault();  // Para evitar que se envíe por defecto

            if ($('#ano_fiscal_poa').val().trim() == '') {

                bootbox.alert("Seleccione el Año Fiscal", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#ano_fiscal_poa").parent('div').addClass('has-error');
                    $("#ano_fiscal_poa").select2('open');
                });

            } else if ($('#tomo_poa').val().trim() == '') {

                bootbox.alert("Seleccione un tipo de Plan Operativo Anual", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#tomo_poa").parent('div').addClass('has-error');
                    $("#tomo_poa").select2('open');
                });

            } else {
                var ano_fiscal_poa = $("#ano_fiscal_poa").val();
                var tomo_poa = $("#tomo_poa").val();
                var accion = $("#tomo_poa option:selected").attr('data-id');
				if(accion == 1){
					var poa = "poam/";
				}else{
					var poa = "poa/";
				}
                
                URL = '<?php echo base_url(); ?>'+poa+''+ ano_fiscal_poa + '/' + tomo_poa;
                $.fancybox.open({padding: 0, href: URL, type: 'iframe', width: 2000, height: 1024, });
            }
        });

        // Generacion de pdf - Control General de los Procesos Contables (Presupuesto)
        $(".generar_control").click(function (e) {

            e.preventDefault();  // Para evitar que se envíe por defecto

            if ($('#ano_fiscal_control').val().trim() == '') {

                bootbox.alert("Seleccione el Año Fiscal", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#ano_fiscal_control").parent('div').addClass('has-error');
                    $("#ano_fiscal_control").select2('open');
                });

            } else if ($('#control_general').val().trim() == '') {

                bootbox.alert("Seleccione un tipo Reporte", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#control_general").parent('div').addClass('has-error');
                    $("#control_general").select2('open');
                });

            } else {
                var ano_fiscal_control = $("#ano_fiscal_control").val();
                var control_general = $("#control_general").val();
                URL = '<?php echo base_url(); ?>control_general/' + ano_fiscal_control + '/' + control_general;
                $.fancybox.open({padding: 0, href: URL, type: 'iframe', width: 2000, height: 1024, });
            }
        });
        
        $(".filtro_bitacora").click(function (e) {

            e.preventDefault();  // Para evitar que se envíe por defecto
            
            var $bitacora = $("#tipo").val();
            var $usuario  = $("#user").val();
            var $accion   = $("#accion").val().trim();
            var $desde    = $("#desde").val().trim();
            var $hasta    = $("#hasta").val().trim();
            
            //alert($accion.replace(" ", "-");
            
            if ($('#tipo').val() == 0) {

                bootbox.alert("Seleccione un valor valido para la Bitácora", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#tipo").parent('div').addClass('has-error');
                    $("#tipo").select2('open');
                });

            } else if ($('#tipo').val() == 1 && $('#user').val() == 0) {

                bootbox.alert("Seleccione el Usuario", function () {
                    $('#user').select2('val',0).prop('disabled', false);
                }).on('hidden.bs.modal', function (event) {
                    $("#user").parent('div').addClass('has-error');
                    $("#user").select2('open');
                });

            } else if ($('#tipo').val() == 2 && $('#accion').val() == 0) {

                bootbox.alert("Seleccione una Acción", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#accion").parent('div').addClass('has-error');
                    $("#accion").select2('open');
                });

            } else if ($('#tipo').val() == 3 && $('#user').val() == "0") {

                bootbox.alert("Seleccione el Usuario", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#user").parent('div').addClass('has-error');
                    $("#user").select2('open');
                });

            } else if (($('#tipo').val() == 3 && $('#desde').val() == "00-00-000" && $('#hasta').val() == "00-00-000") || ($('#tipo').val() == 3 && $('#desde').val() == "" && $('#hasta').val() == "")) {

                bootbox.alert("Seleccione un Rango de Fechas", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#desde,#hasta").parent('div').addClass('has-error');
                });

            } else if (($('#tipo').val() == 4 && $('#user').val() == "0" && $('#accion').val() == "0") || $('#tipo').val() == 4 && $('#user').val() != "0" && $('#accion').val() == "0") {

                bootbox.alert("Seleccione el Usuario y la Acción", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#user,#accion").parent('div').addClass('has-error');
                });

            } else {

                URL = '<?php echo base_url(); ?>bitacora/'+ $bitacora+ "/" + $usuario + '/' + 0 + "/" + $desde + "/" + $hasta + "?acc="+$accion;
                window.open(URL);

                
                /*$.fancybox.open({padding: 0, href: URL, type: 'iframe', width: 2000, height: 1024, });*/
            }
        });
        
        $("a.fancybox-close").click(function () {
            $('button.generar_control').prop('disabled', false);
        });

        // PROCESO PARA GENERAR BITACORA GENERAL DE LOS PROCESOS
        $("#control_general,#tipo").change(function (e) {
            var $control = $(this).val();
            
            if ($control == 5) {
                $('button.generar_control').prop('disabled', true);
                e.preventDefault();  // Para evitar que se envíe por defecto
                //$("#id_act,#acc_esp,#unidad_medida,#medio_verificacion,#trimestre_i,#trimestre_ii,#trimestre_iii,#trimestre_iv,#total,#pk").val("");
                $.fancybox.open({
                    'autoScale': false,
                    'href': '#form_generacion_bitacora',
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
            } else {
                $('button.generar_control').prop('disabled', false);
            }
        });

        $("#tipo").change(function () {
            var $tipo    = $(this).val();
            $('button.generar_control').prop('disabled', true);
            if ($tipo == 1) {
                $('#user').select2('val',0).prop('disabled', false);
            }else{
                $('#user').select2('val',0).prop('disabled', false);
            }

            if ($tipo == 2) {
                $('#accion').prop('disabled', false);
            }else{
                $('#accion').select2('val',0).prop('disabled', true);
            }

            if ($tipo == 3) {
                $('#desde,#hasta,#user').prop('disabled', false);
            }else{
                $('#desde,#hasta').val("00-00-000").prop('disabled', true);
                $('#user').select2('val',0).prop('disabled', false);
            }
            
            if ($tipo == 4) {
                $('#user,#accion').prop('disabled', false);
            }
        });

    });

</script>
<br/>
<br/>
<br/>
<br/>

<form id='form_sectores' action="" method="POST">
    <div style="width: 95%;text-transform:uppercase;box-shadow: 0 1px 5px rgba(0,0,0,.85);margin: auto;" class="panel panel-default">
        <div class="panel-heading" style='background: linear-gradient(#2F9292, #3B7272);color:#FFFFFF;' >
            <label style="float: left" class="panel-title " ><a  href="<?php echo base_url(); ?>sectores/ControllersSectores" >Reportes</a>
                > Acciones / Proyectos</label>
            <br>
        </div>
        <br>
        <fieldset>
            <legend style="font-size: 18px;">Acciones y Proyectos en ley</legend>
            <div class="panel-body" >
                <div class="col-xs-2">Accion Centralizada</div>
                <div class="col-xs-9">
                    <div class="col-md-12">
                        <div class="input-group">
                            <select id="ano_fiscal" style="width: 10%;font-size: 13px" class="form-control input-lg">
                                <option value="">Año</option>
                                <?php
                                foreach (range(2013, date('Y', now())+1) as $número) {
                                    ?>
                                    <option value="<?php echo $número; ?>"><?php echo $número; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <select id="accion_centralizada" style="width: 630px !important;font-size: 13px" class="form-control input-lg">
                                <option value="">Seleccione</option>
                            </select>
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-lg btn-info generar_pdf"><span class="glyphicon glyphicon-download-alt"></span> Generar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--SECCION PARA LA GENERACION DE PDF PARA LOS PROYECTOS-->
            <div class="panel-body">
                <div class="col-xs-2">Proyecto</div>
                <div class="col-xs-9">
                    <div class="col-md-12">
                        <div class="input-group">
                            <select id="ano_fiscal_p" style="width: 10%;font-size: 13px" class="form-control input-lg">
                                <option value="">Año</option>
                                <?php
                                foreach (range(2013, date('Y', now())+1) as $número) {
                                    ?>
                                    <option value="<?php echo $número; ?>"><?php echo $número; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <select id="proyecto" style="width: 630px !important;font-size: 13px" class="form-control input-lg">
                                <option value="">Seleccione</option>
                            </select>
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-lg btn-info generar_pdf_proy"><span class="glyphicon glyphicon-download-alt"></span> Generar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- SECCION PARA LA GENERACION DE PDF (TOMO I: ORGANOS Y UNIDADES DE APOYO) Y (TOMO II: ENTES Y EMPRESAS) -->
            <?php
            if ($this->session->userdata['logged_in']['ver'] == 't'):
                ?>
                <div class="panel-body">
                    <div class="col-xs-2">Ley Presupuestaria</div>
                    <div class="col-xs-9">
                        <div class="col-md-12">
                            <div class="input-group">
                                <select id="ano_fiscal_tomo" style="width: 10%;font-size: 13px" class="form-control input-lg">
                                    <option value="">Año</option>
                                    <?php
                                    foreach (range(2013,date('Y', now())+1) as $número) {
                                        ?>
                                        <option value="<?php echo $número; ?>"><?php echo $número; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <select id="tomo" style="width: 630px !important;font-size: 13px" class="form-control input-lg">
                                    <option value="">Seleccione</option>
                                    <option value="1-4">Tomo I - ORGANOS Y UNIDADES DE APOYO</option>
                                    <option value="2-3">Tomo II - ENTES Y EMPRESAS</option>
                                </select>
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-lg btn-info generar_tomo"><span class="glyphicon glyphicon-download-alt"></span> Generar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            endif;
            ?>
            <!-- SECCION PARA LA GENERACION DEL POA (PLAN OPERATIVO ANUAL) -->
            <?php
            if ($this->session->userdata['logged_in']['ver'] == 't'):
                ?>
                <div class="panel-body">
                    <div class="col-xs-2"><span title='PLAN OPERATIVO ANUAL'></span>Plan Operativo Anual</div>
                    <div class="col-xs-9">
                        <div class="col-md-12">
                            <div class="input-group">
                                <select id="ano_fiscal_poa" style="width: 10%;font-size: 13px" class="form-control input-lg">
                                    <option value="">Año</option>
                                    <?php
                                    foreach (range(2013, date('Y', now())+1) as $número) {
                                        ?>
                                        <option value="<?php echo $número; ?>"><?php echo $número; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <select id="tomo_poa" style="width: 630px !important;font-size: 13px" class="form-control input-lg">
                                    <option value="">Seleccione</option>
                                    <option value="1-4-0">TOMO I - ORGANOS Y UNIDADES DE APOYO (Oficial)</option>
                                    <option value="2-3-0">TOMO II - ENTES Y EMPRESAS (Oficial)</option>
                                    <option value="1-4-5" data-id="1">TOMO I - ORGANOS Y UNIDADES DE APOYO (Modificado)</option>
                                    <option value="2-3-5" data-id="1">TOMO II - ENTES Y EMPRESAS (Modificado)</option>
                                </select>
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-lg btn-info generar_POA"><span class="glyphicon glyphicon-download-alt"></span> Generar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php
            if ($this->session->userdata['logged_in']['ver'] == 't'):
                ?>
                <div class="panel-body">
                    <div class="col-xs-2"><span title='Control General'></span>Control General</div>
                    <div class="col-xs-9">
                        <div class="col-md-12">
                            <div class="input-group">
                                <select id="ano_fiscal_control" style="width: 10%;font-size: 13px" class="form-control input-lg">
                                    <option value="">Año</option>
                                    <?php
                                    foreach (range(2013, date('Y', now())+1) as $número) {
                                        ?>
                                        <option value="<?php echo $número; ?>"><?php echo $número; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <select id="control_general" style="width: 630px !important;font-size: 13px" class="form-control input-lg">
                                    <option value="">Seleccione</option>
                                    <option value="1">Distribucion Partidas Presupuestarias</option>
                                    <option value="2">Resumen de Partidas Presupuestaria (Acciones y Proyectos)</option>
                                    <option value="3">Estructura Presupuestaria</option>
                                    <option value="4">Fuente de Financiamiento (Acciones y Proyectos)</option>
                                    <option value="5">Auditoría de Usuarios</option>
                                </select>
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-lg btn-info generar_control"><span class="glyphicon glyphicon-download-alt"></span> Generar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </fieldset>
        <fieldset>
            <legend style="font-size: 18px;">Acciones y Proyectos Ingresos Presupuestarios</legend>
            <div class="panel-body" >
                <div class="col-xs-2">Accion Centralizada</div>
                <div class="col-xs-9">
                    <div class="col-md-12">
                        <div class="input-group">
                            <select id="ano_fiscal_gestion" style="width: 10%;font-size: 13px" class="form-control input-lg">
                                <option value="">Año</option>
                                <?php
                                foreach (range(2013, date('Y', now())+1) as $num) {
                                    ?>
                                    <option value="<?php echo $num; ?>"><?php echo $num; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <select id="gestion_accion_centralizada_gestion" style="width: 630px !important;font-size: 13px" class="form-control input-lg">
                                <option value="">Seleccione</option>
                            </select>
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-lg btn-info generar_pdf_gestion"><span class="glyphicon glyphicon-download-alt"></span> Generar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-xs-2">Proyecto</div>
                <div class="col-xs-9">
                    <div class="col-md-12">
                        <div class="input-group">
                            <select id="ano_fiscal_proy_gestion" style="width: 10%;font-size: 13px" class="form-control input-lg">
                                <option value="">Año</option>
                                <?php
                                foreach (range(2013, date('Y', now())+1) as $numero) {
                                    ?>
                                    <option value="<?php echo $numero; ?>"><?php echo $numero; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <select id="proyecto_gestion" style="width: 630px !important;font-size: 13px" class="form-control input-lg">
                                <option value="">Seleccione</option>
                            </select>
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-lg btn-info generar_pdf_proy_gestion"><span class="glyphicon glyphicon-download-alt"></span> Generar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <br/>
        <br/>
    </div>
</form>



<!-- VISTA BASADA PARA LA GENERACIÓN DE LAS BITACORAS ORIENTADOS A LAS ACCIONES QUE ALLA EMPRENDIDO EL USUARIO EN LE SISTEMA -->
<form id='form_generacion_bitacora' action="" method="POST" style='display: none;'>
    <div style="width: 95%;text-transform:uppercase;box-shadow: 0 1px 5px rgba(0,0,0,.85);margin: auto;" class="panel panel-default">
        <div class="panel-heading" style='background: linear-gradient(#2F9292, #3B7272);color:#FFFFFF;' >
            <label>BITÁCORA</label>
            <br>
        </div>
        <div class="panel-body">
            <div class="col-xs-2" >Bitácora</div>
            <div class="col-xs-10">
                <select id='tipo' style='width: 90%;'>
                    <option value='0'>Seleccione</option>
                    <optgroup LABEL="Busqueda por Usuario">
                        <option value='1'>Usuario</option>
                    </optgroup>
                    <optgroup LABEL="Busqueda por Usuario y Acciones">
                        <option value='4'>Usuario y Acciones</option>
                    </optgroup>
                    <optgroup LABEL="Busqueda por Rango de fechas">
                        <option value='3'>Rango de Fechas - Ejempo: Desde: 00/00/0000 Hasta: 00/00/0000</option>
                    </optgroup>
                </select>
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-2" >Usuario</div>
            <div class="col-xs-10">
                <select id='user' name="user" style='width: 90%;'>
                    <option value='0'>Seleccione</option>
                    <?php
                    foreach ($list_user as $row) {
                        if ($row->is_active == "t") {
                            ?>
                            <optgroup LABEL="<?php echo $row->first_name; ?>">
                                <option value="<?php echo $row->id; ?>"><?php echo $row->username; ?></option>
                            </optgroup>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-2" >Acción</div>
            <div class="col-xs-10">
                <select id='accion' name="accion" style='width: 90%;' disabled="disabled">
                    <option value='0'>Seleccione</option>
                    <?php
                    foreach ($list_accion as $row) {
                        ?>
                        <optgroup LABEL="<?php echo $row->modulo; ?>">
                            <option value="<?php echo $row->accion; ?>"><?php echo $row->accion; ?></option>
                        </optgroup>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-2" >Desde</div>
            <div class="col-xs-4">
                <input type="text" id="desde" name="desde" class="form-control" disabled="disabled" value="00-00-0000"/>
            </div>
            <div class="col-xs-1" >Hasta</div>
            <div class="col-xs-4">
                <input type="text" id="hasta" name="hasta" class="form-control" disabled="disabled" value="00-00-0000"/>
            </div>
        </div>
        <br/>
        <div class="row" style="text-align: center">
            <button type="button" id="filtro_bitacora" style="font-weight: bold;font-size: 13px" class="btn btn-info filtro_bitacora">
                <span class="glyphicon glyphicon-download-alt"></span> Generar
            </button>
        </div>
        <br/>
    </div>
</form>
<!-- FIN DEL PROCESO -->
