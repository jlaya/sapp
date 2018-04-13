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
<!--#8BA8A7-->
<script>
    $(document).ready(function () {
        $("select").select2();

        $("#estatus").select2('val', parseInt($("#id_estatus").val()));
        if (<?php echo $preliminar; ?> == 1) {
            $("input,textarea,select").prop('disabled', true);
        }

        $("#fin").change(function (e) {

            var acc_centralizada = $(this).val();

            respuesta = acc_centralizada.split('/');

            $("#ano_fiscal").val(respuesta[2]);
        });

        $("select").select2();
        $("#tlf").mask("(9999) 999-9999");
        $("#inicio,#fin").mask("99/99/9999", {placeholder: "dd/mm/yyyy"});

        $('#I,#II,#III,#IV, #trimestre_i, #trimestre_ii, #trimestre_iii, #trimestre_iv, #total').numeric({allow: "."});


        // Proceso para montar los datos en los combos select de forma automatica
        $("#reg_registro,#ente").select2('val', $("#id_reg_registro").val());
        $("#f_financiamiento").select2('val', $("#id_f_financiamiento").val());
        $("#etapa").select2('val', $("#id_etapa").val());
        $("#ambito").select2('val', $("#id_ambito").val());
        $("#plan_patria").select2('val', $("#id_plan_patria").val());
        $("#plan_gobierno").select2('val', $("#id_plan_gobierno").val());
        $("#sector").select2('val', $("#id_sector").val());
        $("#tipo_inversion").select2('val', $("#id_tipo_inversion").val());
        $("#req_acciones").select2('val', $("#id_req_acciones").val());
        $("#acc_institucion").select2('val', $("#id_acc_institucion").val());
        $("#con_acciones").select2('val', $("#id_con_acciones").val());
        $("#en_acciones").select2('val', $("#id_en_acciones").val());
        $("#con_institucion").select2('val', $("#id_con_institucion").val());
        $("#en_institucion").select2('val', $("#id_en_institucion").val());
        $("#reg_res").select2('val', $("#id_reg_res").val());
        $("#ano_fiscal").select2('val', $("#id_ano_fiscal").val());


        // Carga automatica
        var plan_p = $("#plan_patria").val();
        var objetivo_historico = $("#id_objetivo_historico").val();
        var objetivo_nacional = $("#id_objetivo_nacional").val();
        var objetivo_estrategico = $("#id_objetivo_estrategico").val();
        var objetivo_general = $("#id_objetivo_general").val();
        var plan_gobierno = $("#id_plan_gobierno").val();
        var linea_estrategica = $("#id_linea_estrategica").val();
        // Objetivo Historico
        $('#objetivo_historico,#objetivo_nacional').find('option:gt(0)').remove().end().select2('val', "");
        $.post('<?php echo base_url(); ?>objetivo_general/ControllersObjG/ajax_search/' + plan_p + '', function (response) {

            var option = "";
            $.each(response, function (i) {

                option += "<option value=" + response[i]['id'] + ">" + response[i]['objetivo_historico'] + "</option>";
            });
            $('#objetivo_historico').append(option);
            $('#objetivo_historico').select2('val', parseInt(objetivo_historico));
        }, 'json');

        // Objetivo Nacional
        $('#objetivo_nacional').find('option:gt(0)').remove().end().select2('val', "");
        $.post('<?php echo base_url(); ?>objetivo_general/ControllersObjG/ajax_search_multiple_two/' + plan_p + '/' + objetivo_historico + '', function (response) {

            var option = "";
            $.each(response, function (i) {

                option += "<option value=" + response[i]['id'] + ">" + response[i]['objetivo_nacional'] + "</option>";
            });
            $('#objetivo_nacional').append(option);
            $('#objetivo_nacional').select2('val', parseInt(objetivo_nacional));
        }, 'json');

        // Objetivo Estrategico
        $('#objetivo_estrategico').find('option:gt(0)').remove().end().select2('val', "");
        $.post('<?php echo base_url(); ?>objetivo_general/ControllersObjG/ajax_search_multiple_three/' + plan_p + '/' + objetivo_historico + '/' + objetivo_nacional + '', function (response) {

            var option = "";
            $.each(response, function (i) {

                option += "<option value=" + response[i]['id'] + ">" + response[i]['objetivo_estrategico'] + "</option>";
            });
            $('#objetivo_estrategico').append(option);
            $('#objetivo_estrategico').select2('val', parseInt(objetivo_estrategico));
        }, 'json');

        // Objetivo General
        $('#objetivo_general').find('option:gt(0)').remove().end().select2('val', "");
        $.post('<?php echo base_url(); ?>acciones/proyecto/ControllersProyecto/ajax_search_multiple_four/' + plan_p + '/' + objetivo_historico + '/' + objetivo_nacional + '/' + objetivo_estrategico + '', function (response) {

            var option = "";
            $.each(response, function (i) {

                option += "<option value=" + response[i]['id'] + ">" + response[i]['objetivo_general'] + "</option>";
            });
            $('#objetivo_general').append(option);
            $('#objetivo_general').select2('val', parseInt(objetivo_general));
        }, 'json');

        // Linea Estrategica
        $('#linea_estrategica').find('option:gt(0)').remove().end().select2('val', "");
        $.post('<?php echo base_url(); ?>acciones/proyecto/ControllersProyecto/ajax_search_lineas_e_planG/' + plan_gobierno + '', function (response) {

            var option = "";
            $.each(response, function (i) {

                option += "<option value=" + response[i]['id'] + ">" + response[i]['linea_estrategica'] + "</option>";
            });
            $('#linea_estrategica').append(option);
            $('#linea_estrategica').select2('val', parseInt(linea_estrategica));
        }, 'json');







        $('#plan_patria').alphanumeric({allow: " -.,"});
        $('#ubicacion,#identificador,#nom_proyecto').alphanumeric({allow: " *,"});
        $('#m_autoridad,#cargo,#responsable,#indicador_g,#m_verificacion,#area_inversion').alpha({allow: " "});
        $('#cedula,#duracion').numeric({allow: ""});
        $('#tlf').numeric({allow: "()- "});
        $('#ben_femeninos,#ben_masculinos,#estimado_fem,#estimado_mas,#estimado_t_direc,#estimado_t_indirec,#estimado_t_indirec').numeric({allow: "."});
        $('#correo').alphanumeric({allow: "@."});


        var TAEsp = $('#tabla_acciones_especificas').dataTable({
            "iDisplayLength": 10,
            "iDisplayStart": 0,
            "sPaginationType": "full_numbers",
            "aLengthMenu": [25, 50, 75, 100],
            "oLanguage": {"sUrl": "<?php echo base_url(); ?>assets/js/es.txt"},
            //"order": [[1, "asc"]],
            "aoColumns": [
            {"sClass": "control", "sWidth": "1%"},
            {"sClass": "registro center", "sWidth": "50%"},
            {"sClass": "registro center", "sWidth": "1%"},
            {"sClass": "registro center", "sWidth": "1%"},
            {"sClass": "registro center", "sWidth": "1%"},
            {"sClass": "registro center", "sWidth": "1%"},
            {"sClass": "registro center", "sWidth": "1%"},
            {"sWidth": "3%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
            {"sWidth": "3%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
            {"sWidth": "3%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
            ]
        });


        // Validacion respectiva para la actualizacion de los datos(1)
        $("table#tabla_acciones_especificas").on('change', 'textarea.capturar', function (e) {
            var id = this.getAttribute('name');
            var acc_esp = $("#acc_esp_" + id + "").val().toUpperCase();
            var unidad_medida = $("#unidad_medida_" + id + "").val().toUpperCase();
            var medio_verificacion = $("#medio_verificacion_" + id + "").val().toUpperCase();
            var trimestre_i = $("#trimestre_i_" + id + "").val();
            var trimestre_ii = $("#trimestre_ii_" + id + "").val();
            var trimestre_iii = $("#trimestre_iii_" + id + "").val();
            var trimestre_iv = $("#trimestre_iv_" + id + "").val();
            var total = $("#total_" + id + "").val();

            $("table#tabla_acciones_especificas tr#tr_" + id + "").css("background-color", "#D5F2F1");

            // Condicional de Campos Vacios
            var trimestre_i = (trimestre_i == "") ? 0.00 : trimestre_i;
            var trimestre_ii = (trimestre_ii == "") ? 0.00 : trimestre_ii;
            var trimestre_iii = (trimestre_iii == "") ? 0.00 : trimestre_iii;
            var trimestre_iv = (trimestre_iv == "") ? 0.00 : trimestre_iv;

            suma = parseFloat(trimestre_i) + parseFloat(trimestre_ii) + parseFloat(trimestre_iii) + parseFloat(trimestre_iv);

            $("#total_" + id + "").val(suma);

            datos = id + "-";
            datos += acc_esp + "-";
            datos += unidad_medida + "-";
            datos += medio_verificacion + "-";
            datos += trimestre_i + "-";
            datos += trimestre_ii + "-";
            datos += trimestre_iii + "-";
            datos += trimestre_iv + "-";
            datos += parseFloat(suma);

            $.post('<?php echo base_url(); ?>acciones/proyecto/ControllersProyecto/cargar/1/' + datos + '', function (response) {

            });
        });

        // Validacion respectiva para la actualizacion de los datos(2)
        $("table#tabla_metas_financieras").on('change', 'textarea.capturar', function (e) {
            var id = this.getAttribute('name');
            var I = $("#I_" + id + "").val();
            var II = $("#II_" + id + "").val();
            var III = $("#III_" + id + "").val();
            var IV = $("#IV_" + id + "").val();
            var cantidad = $("#cantidad_" + id + "").val();


            $("table#tabla_metas_financieras tr#tr_" + id + "").css("background-color", "#D5F2F1");

            // Condicional de Campos Vacios
            var I = (I == "") ? 0.00 : I;
            var II = (II == "") ? 0.00 : II;
            var III = (III == "") ? 0.00 : III;
            var IV = (IV == "") ? 0.00 : IV;

            suma = parseFloat(I) + parseFloat(II) + parseFloat(III) + parseFloat(IV);
            $("#cantidad_" + id + "").val(suma);

            datos = id + "-";
            datos += I + "-";
            datos += II + "-";
            datos += III + "-";
            datos += IV + "-";
            datos += parseFloat(suma);

            $.post('<?php echo base_url(); ?>acciones/proyecto/ControllersProyecto/cargar/3/' + datos + '', function (response) {

            });
        });


        //Proceso para la actualizacion de los montos trimestrales de las Imputaciones Presupuestarias
        //tabla_imputacion_presupuestaria
        $("table#tabla_imputacion_presupuestaria").on('change', 'textarea.capturar', function (e) {
            var id = this.getAttribute('name');
            var I = $("#IP_" + id + "").val();
            var II = $("#IIP_" + id + "").val();
            var III = $("#IIIP_" + id + "").val();
            var IV = $("#IVP_" + id + "").val();
            var cantidad = $("#CANTIDADP_" + id + "").val();
            var asignacion = $("#ASIGNACIONP_" + id + "").val();

            $("table#tabla_imputacion_presupuestaria tr#tr_" + id + "").css("background-color", "#D5F2F1");

            // Condicional de Campos Vacios
            var I = (I == "") ? 0.00 : I;
            var II = (II == "") ? 0.00 : II;
            var III = (III == "") ? 0.00 : III;
            var IV = (IV == "") ? 0.00 : IV;

            suma = parseFloat(I) + parseFloat(II) + parseFloat(III) + parseFloat(IV);
            $("#CANTIDADP_" + id + "").val(suma);
            $("#ASIGNACIONP_" + id + "").val(suma);

            datos = id + "-";
            datos += I + "-";
            datos += II + "-";
            datos += III + "-";
            datos += IV + "-";
            datos += parseFloat(suma) + "-";
            datos += suma;

            $.post('<?php echo base_url(); ?>acciones/proyecto/ControllersProyecto/cargar/5/' + datos + '', function (response) {

            });
        });




        //Se habre una ventana modal para el ingreso de una impútacion presupuestaria datos(3)
        //tabla_imputacion_presupuestaria
        $(".anadir_imp_pre").click(function (e) {
            e.preventDefault();  // Para evitar que se envíe por defecto
            $("#id_act,#acc_esp,#unidad_medida,#medio_verificacion,#trimestre_i,#trimestre_ii,#trimestre_iii,#trimestre_iv,#total,#pk").val("");
            $.fancybox.open({
                'autoScale': false,
                'href': '#form_imp_pres',
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

        var TMEsp = $('#tabla_metas_financieras').dataTable({
            "iDisplayLength": 10,
            "iDisplayStart": 0,
            "sPaginationType": "full_numbers",
            "aLengthMenu": [25, 50, 75, 100],
            "oLanguage": {"sUrl": "<?php echo base_url(); ?>assets/js/es.txt"},
            //"order": [[1, "asc"]],
            "aoColumns": [
            {"sClass": "control", "sWidth": "1%"},
            {"sClass": "registro center", "sWidth": "50%"},
            {"sClass": "registro center", "sWidth": "1%"},
            {"sClass": "registro center", "sWidth": "1%"},
            {"sClass": "registro center", "sWidth": "1%"},
            {"sWidth": "3%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
            {"sWidth": "3%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
            ]
        });

        var TIPre = $('#tabla_imputacion_presupuestaria').dataTable({
            "iDisplayLength": 10,
            "iDisplayStart": 0,
            "sPaginationType": "full_numbers",
            "aLengthMenu": [25, 50, 75, 100],
            "oLanguage": {"sUrl": "<?php echo base_url(); ?>assets/js/es.txt"},
            //"order": [[1, "asc"]],
            "aoColumns": [
            {"sClass": "control", "sWidth": "1%"},
            {"sClass": "registro center", "sWidth": "100%"},
            {"sClass": "registro center", "sWidth": "1%"},
            {"sClass": "registro center", "sWidth": "1%"},
            {"sClass": "registro center", "sWidth": "1%"},
            {"sClass": "registro center", "sWidth": "1%"},
            {"sClass": "registro center", "sWidth": "1%"},
            {"sClass": "registro center", "sWidth": "1%"},
            ]
        });


        //////////// Actualizacion de registro de acciones /////////////////////
        $("table#tabla_acciones_especificas").on('click', 'img.editar_accion', function (e) {
            //e.preventDefault();
            var id = this.getAttribute('id');
            $("label#div_acc_es").text("Actualizar Acción Específica");

            $.post('<?php echo base_url(); ?>acciones/proyecto/ControllersProyecto/cargar/10/' + id + '', function (response) {

                $.each(response, function (i) {
                    $("#id_act").val(response[i]['id']);
                    $("#acc_esp").val(response[i]['acc_esp']);
                    $("#unidad_medida").val(response[i]['unidad_medida']);
                    $("#medio_verificacion").val(response[i]['medio_verificacion']);
                    $("#trimestre_i").val(response[i]['trimestre_i']);
                    $("#trimestre_ii").val(response[i]['trimestre_ii']);
                    $("#trimestre_iii").val(response[i]['trimestre_iii']);
                    $("#trimestre_iv").val(response[i]['trimestre_iv']);
                    $("#total").val(response[i]['total']);
                });
            }, 'json');

            $.fancybox.open({
                'autoScale': false,
                'href': '#form_acciones_especificas',
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

        ////////////////////////////////////////////////////////////////////////




        $("#registrar").click(function (e) {

            e.preventDefault();  // Para evitar que se envíe por defecto
            var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

            if ($('#reg_registro').val().trim() == '') {

                bootbox.alert("Seleccione el registrado", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#reg_registro").parent('div').addClass('has-error');
                    $("#reg_registro").select2('open');
                });

            } else if ($('#ente').val().trim() == '') {
                bootbox.alert("Seleccione el Organismo/Ente o Empresa", function () {
                    $('.nav-tabs a[href=#tabs_identificacion]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#ente").parent('div').addClass('has-error');
                    $("#ente").select2('open');
                });
            } else if ($('#domicilio').val().trim() == '') {
                bootbox.alert("Ingrese el Domicilio", function () {
                    $('.nav-tabs a[href=#tabs_identificacion]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#domicilio").parent('div').addClass('has-error');
                    $("#domicilio").focus();
                });
            } else if ($('#cargo_id').val().trim() == '') {
                bootbox.alert("Ingrese el Cargo", function () {
                    $('.nav-tabs a[href=#tabs_identificacion]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#cargo_id").parent('div').addClass('has-error');
                    $("#cargo_id").focus();
                });
            } else if ($('#tlf_id').val().trim() == '') {
                bootbox.alert("Ingrese el Teléfono, Ejemplo: (412)-000-0000", function () {
                    $('.nav-tabs a[href=#tabs_identificacion]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#tlf_id").parent('div').addClass('has-error');
                    $("#tlf_id").focus();
                });
            } else if ($('#responsable_id').val().trim() == '') {
                bootbox.alert("Ingrese el Responsable", function () {
                    $('.nav-tabs a[href=#tabs_identificacion]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#responsable_id").parent('div').addClass('has-error');
                    $("#responsable_id").focus();
                });
            } else if (regex.test($('#correo_id').val().trim()) == "") {

                //Se utiliza la funcion test() nativa de JavaScript
                if (regex.test($('#correo_id').val().trim())) {

                    return false;

                } else {

                    bootbox.alert("Formato incorrecto, ingrese un correo valido", function () {
                        $('.nav-tabs a[href=#tabs_identificacion]').tab('show');
                    }).on('hidden.bs.modal', function (event) {
                        $('#correo_id').parent('div').addClass('has-error');
                        $("#correo_id").focus();
                    });
                }

            } else if ($('#nom_proyecto').val().trim() == '') {
                bootbox.alert("Asigne el Nombre del Proyecto", function () {
                    $('.nav-tabs a[href=#tabs_proyecto]').tab('show');
                    $('.nav-tabs a[href=#tabs_datos_proyecto]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#nom_proyecto").parent('div').addClass('has-error');
                    $("#nom_proyecto").focus();
                });
            } else if ($('#descripcion_proy').val().trim() == '') {
                bootbox.alert("Ingrese la descripcion del Proyecto", function () {
                    $('.nav-tabs a[href=#tabs_proyecto]').tab('show');
                    $('.nav-tabs a[href=#tabs_datos_proyecto]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#descripcion_proy").parent('div').addClass('has-error');
                    $("#descripcion_proy").focus();
                });
            } else if ($('#ubicacion').val().trim() == '') {
                bootbox.alert("Ingrese la Ubicación", function () {
                    $('.nav-tabs a[href=#tabs_proyecto]').tab('show');
                    $('.nav-tabs a[href=#tabs_datos_proyecto]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#ubicacion").parent('div').addClass('has-error');
                    $("#ubicacion").focus();
                });
            } else if ($('#inicio').val().trim() == '') {
                bootbox.alert("Ingrese la Apertura del Proyecto", function () {
                    $('.nav-tabs a[href=#tabs_proyecto]').tab('show');
                    $('.nav-tabs a[href=#tabs_datos_proyecto]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#inicio").parent('div').addClass('has-error');
                    $("#inicio").focus();
                });
            } else if ($('#fin').val().trim() == '') {
                bootbox.alert("Ingrese el Cierre del Proyecto", function () {
                    $('.nav-tabs a[href=#tabs_proyecto]').tab('show');
                    $('.nav-tabs a[href=#tabs_datos_proyecto]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#fin").parent('div').addClass('has-error');
                    $("#fin").focus();
                });
            } else if ($('#ano_fiscal').val().trim() == '') {
                bootbox.alert("Ingrese el Año Fiscal", function () {
                    $('.nav-tabs a[href=#tabs_proyecto]').tab('show');
                    $('.nav-tabs a[href=#tabs_datos_proyecto]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#ano_fiscal").parent('div').addClass('has-error');
                    $("#ano_fiscal").select2('open');
                });
            } else if ($('#duracion').val().trim() == '') {
                bootbox.alert("Ingrese la duración del Proyecto", function () {
                    $('.nav-tabs a[href=#tabs_proyecto]').tab('show');
                    $('.nav-tabs a[href=#tabs_datos_proyecto]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#duracion").parent('div').addClass('has-error');
                    $("#duracion").focus();
                });
            } else if ($('#etapa').val().trim() == '') {
                bootbox.alert("Asigne la Etapa", function () {
                    $('.nav-tabs a[href=#tabs_proyecto]').tab('show');
                    $('.nav-tabs a[href=#tabs_datos_proyecto]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#etapa").parent('div').addClass('has-error');
                    $("#etapa").select2('open');
                });
            } else if ($('#f_financiamiento').val().trim() == '') {
                bootbox.alert("Seleccione la Fuente de Financiamiento", function () {
                    $('.nav-tabs a[href=#tabs_proyecto]').tab('show');
                    $('.nav-tabs a[href=#tabs_datos_proyecto]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#f_financiamiento").parent('div').addClass('has-error');
                    $("#f_financiamiento").select2('open');
                });
            } else if ($('#indicador_g').val().trim() == '') {
                bootbox.alert("Seleccione el Indicador General", function () {
                    $('.nav-tabs a[href=#tabs_proyecto]').tab('show');
                    $('.nav-tabs a[href=#tabs_datos_proyecto]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#indicador_g").parent('div').addClass('has-error');
                    $("#indicador_g").focus();
                });
            } else if ($('#identificador').val().trim() == '') {
                bootbox.alert("Ingrese la Fórmula del Identificador", function () {
                    $('.nav-tabs a[href=#tabs_proyecto]').tab('show');
                    $('.nav-tabs a[href=#tabs_datos_proyecto]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#identificador").parent('div').addClass('has-error');
                    $("#identificador").focus();
                });
            } else if ($('#m_verificacion').val().trim() == '') {
                bootbox.alert("Ingrese el Medio de Verificación", function () {
                    $('.nav-tabs a[href=#tabs_proyecto]').tab('show');
                    $('.nav-tabs a[href=#tabs_datos_proyecto]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#m_verificacion").parent('div').addClass('has-error');
                    $("#m_verificacion").focus();
                });
            } else if ($('#ambito').val().trim() == '') {
                bootbox.alert("Seleccione el Ambito", function () {
                    $('.nav-tabs a[href=#tabs_proyecto]').tab('show');
                    $('.nav-tabs a[href=#tabs_localizacion]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#ambito").parent('div').addClass('has-error');
                    $("#ambito").select2('open');
                });
            } else if ($('#especifique_amb').val().trim() == '') {
                bootbox.alert("Ingrese la Especificación del Ambito", function () {
                    $('.nav-tabs a[href=#tabs_proyecto]').tab('show');
                    $('.nav-tabs a[href=#tabs_localizacion]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#especifique_amb").parent('div').addClass('has-error');
                    $("#especifique_amb").focus();
                });
            } else if ($('#plan_patria').val().trim() == '') {
                bootbox.alert("Seleccione el Plan de la Patria", function () {
                    $('.nav-tabs a[href=#tabs_area_estrategico]').tab('show');
                    $('.nav-tabs a[href=#tabs_plan_patria]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#plan_patria").parent('div').addClass('has-error');
                    $("#plan_patria").select2('open');
                });
            } else if ($('#objetivo_historico').val().trim() == '') {
                bootbox.alert("Seleccione el Objetivo Histórico", function () {
                    $('.nav-tabs a[href=#tabs_area_estrategico]').tab('show');
                    $('.nav-tabs a[href=#tabs_plan_patria]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#objetivo_historico").parent('div').addClass('has-error');
                    $("#objetivo_historico").select2('open');
                });
            } else if ($('#objetivo_nacional').val().trim() == '') {
                bootbox.alert("Seleccione el Objetivo Nacional", function () {
                    $('.nav-tabs a[href=#tabs_area_estrategico]').tab('show');
                    $('.nav-tabs a[href=#tabs_plan_patria]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#objetivo_nacional").parent('div').addClass('has-error');
                    $("#objetivo_nacional").select2('open');
                });
            } else if ($('#objetivo_estrategico').val().trim() == '') {
                bootbox.alert("Seleccione el Objetivo Estratégico", function () {
                    $('.nav-tabs a[href=#tabs_area_estrategico]').tab('show');
                    $('.nav-tabs a[href=#tabs_plan_patria]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#objetivo_estrategico").parent('div').addClass('has-error');
                    $("#objetivo_estrategico").select2('open');
                });
            } else if ($('#objetivo_general').val().trim() == '') {
                bootbox.alert("Seleccione el Objetivo General", function () {
                    $('.nav-tabs a[href=#tabs_area_estrategico]').tab('show');
                    $('.nav-tabs a[href=#tabs_plan_patria]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#objetivo_general").parent('div').addClass('has-error');
                    $("#objetivo_general").select2('open');
                });
            } else if ($('#objetivo_institucional').val().trim() == '') {
                bootbox.alert("Ingrese el Objetivo General Institucional", function () {
                    $('.nav-tabs a[href=#tabs_area_estrategico]').tab('show');
                    $('.nav-tabs a[href=#tabs_plan_patria]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#objetivo_institucional").parent('div').addClass('has-error');
                    $("#objetivo_institucional").focus();
                });
            } else if ($('#plan_gobierno').val().trim() == '') {
                bootbox.alert("Seleccione el Plan de Gobierno", function () {
                    $('.nav-tabs a[href=#tabs_area_estrategico]').tab('show');
                    $('.nav-tabs a[href=#tabs_plan_gobierno]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#plan_gobierno").parent('div').addClass('has-error');
                    $("#plan_gobierno").select2('open');
                });
            } else if ($('#linea_estrategica').val().trim() == '') {
                bootbox.alert("Seleccione la Linea Estratégica", function () {
                    $('.nav-tabs a[href=#tabs_area_estrategico]').tab('show');
                    $('.nav-tabs a[href=#tabs_plan_gobierno]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#linea_estrategica").parent('div').addClass('has-error');
                    $("#linea_estrategica").select2('open');
                });
            } else if ($('#area_inversion').val().trim() == '') {
                bootbox.alert("Ingrese el Área de Inversión", function () {
                    $('.nav-tabs a[href=#tabs_area_estrategico]').tab('show');
                    $('.nav-tabs a[href=#tabs_plan_gobierno]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#area_inversion").parent('div').addClass('has-error');
                    $("#area_inversion").focus();
                });
            } else if ($('#sector').val().trim() == '') {
                bootbox.alert("Seleccione el Sector", function () {
                    $('.nav-tabs a[href=#tabs_area_estrategico]').tab('show');
                    $('.nav-tabs a[href=#tabs_plan_gobierno]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#sector").parent('div').addClass('has-error');
                    $("#sector").select2('open');
                });
            } else if ($('#tipo_inversion').val().trim() == '') {
                bootbox.alert("Seleccione un Tipo de Inversión", function () {
                    $('.nav-tabs a[href=#tabs_area_estrategico]').tab('show');
                    $('.nav-tabs a[href=#tabs_plan_gobierno]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#tipo_inversion").parent('div').addClass('has-error');
                    $("#tipo_inversion").select2('open');
                });
            } else if ($('#desc_problema').val().trim() == '') {
                bootbox.alert("Ingrese la Descripción del Problema", function () {
                    $('.nav-tabs a[href=#tabs_desc]').tab('show');
                    $('.nav-tabs a[href=#tabs_problema_justificacion]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#desc_problema").parent('div').addClass('has-error');
                    $("#desc_problema").focus();
                });
            } else if ($('#obj_general').val().trim() == '') {
                bootbox.alert("Ingrese el Objetivo General", function () {
                    $('.nav-tabs a[href=#tabs_desc]').tab('show');
                    $('.nav-tabs a[href=#tabs_problema_justificacion]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#obj_general").parent('div').addClass('has-error');
                    $("#obj_general").focus();
                });
            } else if ($('#imp_impacto').val().trim() == '') {
                bootbox.alert("Especifique la Importancia e Impacto del Proyecto", function () {
                    $('.nav-tabs a[href=#tabs_desc]').tab('show');
                    $('.nav-tabs a[href=#tabs_problema_justificacion]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#imp_impacto").parent('div').addClass('has-error');
                    $("#imp_impacto").focus();
                });
            } else if ($('#ben_femeninos').val().trim() == '') {
                bootbox.alert("Ingrese los Beneficiarios Femeninos", function () {
                    $('.nav-tabs a[href=#tabs_desc]').tab('show');
                    $('.nav-tabs a[href=#tabs_beneficios]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#ben_femeninos").parent('div').addClass('has-error');
                    $("#ben_femeninos").focus();
                });
            } else if ($('#ben_masculinos').val().trim() == '') {
                bootbox.alert("Ingrese los Beneficiarios Masculinos", function () {
                    $('.nav-tabs a[href=#tabs_desc]').tab('show');
                    $('.nav-tabs a[href=#tabs_beneficios]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#ben_masculinos").parent('div').addClass('has-error');
                    $("#ben_masculinos").focus();
                });
            } else if ($('#req_acciones').val().trim() == '') {
                bootbox.alert("¿Requiere acciones (no financieras) de otra institución?", function () {
                    $('.nav-tabs a[href=#tabs_desc]').tab('show');
                    $('.nav-tabs a[href=#tabs_conexiones]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#req_acciones").parent('div').addClass('has-error');
                    $("#req_acciones").select2('open');
                });
            } else if ($('#req_acciones').val() == "1" && $('#acc_institucion').val().trim() == '') {
                bootbox.alert("Ingrese la Institución", function () {
                    $('.nav-tabs a[href=#tabs_desc]').tab('show');
                    $('.nav-tabs a[href=#tabs_conexiones]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#acc_institucion").parent('div').addClass('has-error');
                    $("#acc_institucion").select2('open');
                });
            } else if ($('#req_acciones').val() == "1" && $('#acc_especifique').val().trim() == '') {
                bootbox.alert("Especifique la Acción no Financiera", function () {
                    $('.nav-tabs a[href=#tabs_desc]').tab('show');
                    $('.nav-tabs a[href=#tabs_conexiones]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#acc_especifique").parent('div').addClass('has-error');
                    $("#acc_especifique").focus();
                });
            } else if ($('#con_acciones').val().trim() == '') {
                bootbox.alert("¿Constribuye o complementa acciones de otras Instituciones?", function () {
                    $('.nav-tabs a[href=#tabs_desc]').tab('show');
                    $('.nav-tabs a[href=#tabs_conexiones]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#con_acciones").parent('div').addClass('has-error');
                    $("#con_acciones").select2('open');
                });
            } else if ($("#con_acciones").val() == "1" && $('#con_institucion').val().trim() == '') {
                bootbox.alert("Seleccione la Institución", function () {
                    $('.nav-tabs a[href=#tabs_desc]').tab('show');
                    $('.nav-tabs a[href=#tabs_conexiones]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#con_institucion").parent('div').addClass('has-error');
                    $("#con_institucion").select2('open');
                });
            } else if ($("#con_acciones").val() == "1" && $('#con_especifique').val().trim() == '') {
                bootbox.alert("Especifique la Acción Complementaria", function () {
                    $('.nav-tabs a[href=#tabs_desc]').tab('show');
                    $('.nav-tabs a[href=#tabs_conexiones]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#con_especifique").parent('div').addClass('has-error');
                    $("#con_especifique").focus();
                });
            } else if ($('#en_acciones').val().trim() == '') {
                bootbox.alert("¿Entra en conflicto con otra Institución?", function () {
                    $('.nav-tabs a[href=#tabs_desc]').tab('show');
                    $('.nav-tabs a[href=#tabs_conexiones]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#en_acciones").parent('div').addClass('has-error');
                    $("#en_acciones").select2('open');
                });
            } else if ($("#en_acciones").val() == "1" && $('#en_institucion').val().trim() == '') {
                bootbox.alert("Seleccione la Institución", function () {
                    $('.nav-tabs a[href=#tabs_desc]').tab('show');
                    $('.nav-tabs a[href=#tabs_conexiones]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#en_institucion").parent('div').addClass('has-error');
                    $("#en_institucion").select2('open');
                });
            } else if ($("#en_acciones").val() == "1" && $('#en_especifique').val().trim() == '') {
                bootbox.alert("Especifique el Conflicto", function () {
                    $('.nav-tabs a[href=#tabs_desc]').tab('show');
                    $('.nav-tabs a[href=#tabs_conexiones]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#en_especifique").parent('div').addClass('has-error');
                    $("#en_especifique").focus();
                });
            } else if ($('#estimado_fem').val().trim() == '') {
                bootbox.alert("Ingrese el estimado de empleos Directos Femeninos", function () {
                    $('.nav-tabs a[href=#tabs_desc]').tab('show');
                    $('.nav-tabs a[href=#tabs_empleos]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#estimado_fem").parent('div').addClass('has-error');
                    $("#estimado_fem").focus();
                });
            } else if ($('#estimado_mas').val().trim() == '') {
                bootbox.alert("Ingrese el estimado de empleos Directos Masculinos", function () {
                    $('.nav-tabs a[href=#tabs_desc]').tab('show');
                    $('.nav-tabs a[href=#tabs_empleos]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#estimado_mas").parent('div').addClass('has-error');
                    $("#estimado_mas").focus();
                });
            } else if ($('#estimado_t_indirec').val().trim() == '') {
                bootbox.alert("Ingrese el estimado total de Empleos Indirectos", function () {
                    $('.nav-tabs a[href=#tabs_desc]').tab('show');
                    $('.nav-tabs a[href=#tabs_empleos]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#estimado_t_indirec").parent('div').addClass('has-error');
                    $("#estimado_t_indirec").focus();
                });
            } else {
                $("#codigo").val().trim();
                /*var fecha = new Date();
                 var fecha_actual = fecha.getFullYear() + "-" + fecha.getMonth() + 1 + "-" + fecha.getDate();
                 //$("#fecha_elaboracion").val(fecha_actual);*/

                 $.post('<?php echo base_url(); ?>acciones/proyecto/ControllersProyecto/modificar', $('#form_registro_proyecto').serialize(), function (response) {

                    if (response == '1') {

                        bootbox.alert("Disculpe, ya existe un código o Plan de la Patria registrado, verifique los datos ", function () {
                        }).on('hidden.bs.modal', function (event) {
                            $("#plan_patria").parent('div').addClass('has-error');
                            $("#plan_patria").focus();
                        });

                    } else {
                        bootbox.alert("Se actualizo con exito", function () {
                        }).on('hidden.bs.modal', function (event) {
                            //url = '<?php echo base_url(); ?>acciones/proyecto/ControllersProyecto/procesar_list/' + $("#codigo").val() + '';
                            url = window.location.href;
                            window.location = url;
                        });
                    }
                });
             }
         });

        // Validacion ajax para reflejar los datos en formato json para las Acciones Especifica
        $("#acc_centralizada").change(function (e) {

            var acc_centralizada = $(this).val();

            $('#nom_especifica').val("");
            $.post('<?php echo base_url(); ?>acciones/registro/ControllersRegistro/ajax_search/' + acc_centralizada + '', function (response) {
                var option = "";
                $.each(response, function (i) {
                    option += response[i]['accion_especifica'] + ",";
                });
                $('#nom_especifica').val(option).trim("");
            }, 'json');
        });

        // Validacion ajax para reflejar los datos en formato json
        $("#plan_patria").click(function (e) {

            var plan_p = $(this).val();
            $('#objetivo_historico,#objetivo_nacional').find('option:gt(0)').remove().end().select2('val', "");
            $.post('<?php echo base_url(); ?>objetivo_general/ControllersObjG/ajax_search/' + plan_p + '', function (response) {

                var option = "";
                $.each(response, function (i) {

                    option += "<option value=" + response[i]['id'] + ">" + response[i]['objetivo_historico'] + "</option>";
                });
                $('#objetivo_historico').append(option);
            }, 'json');
        });


        // Validacion ajax para reflejar los datos en formato json
        $("#plan_patria,#objetivo_historico").click(function (e) {

            var plan_p = $("#plan_patria").val();
            var obj_h = $("#objetivo_historico").val();
            $('#objetivo_nacional').find('option:gt(0)').remove().end().select2('val', "");
            $.post('<?php echo base_url(); ?>objetivo_general/ControllersObjG/ajax_search_multiple_two/' + plan_p + '/' + obj_h + '', function (response) {

                var option = "";
                $.each(response, function (i) {

                    option += "<option value=" + response[i]['id'] + ">" + response[i]['objetivo_nacional'] + "</option>";
                });
                $('#objetivo_nacional').append(option);
            }, 'json');
        });

        // Validacion ajax para reflejar los datos en formato json
        $("#plan_patria,#objetivo_historico,#objetivo_nacional").click(function (e) {

            var plan_p = $("#plan_patria").val();
            var obj_h = $("#objetivo_historico").val();
            var obj_n = $("#objetivo_nacional").val();
            $('#objetivo_estrategico').find('option:gt(0)').remove().end().select2('val', "");
            $.post('<?php echo base_url(); ?>objetivo_general/ControllersObjG/ajax_search_multiple_three/' + plan_p + '/' + obj_h + '/' + obj_n + '', function (response) {

                var option = "";
                $.each(response, function (i) {

                    option += "<option value=" + response[i]['id'] + ">" + response[i]['objetivo_estrategico'] + "</option>";
                });
                $('#objetivo_estrategico').append(option);
            }, 'json');
        });

        // Validacion ajax para reflejar los datos en formato json
        $("#plan_patria,#objetivo_historico,#objetivo_nacional,#objetivo_estrategico").click(function (e) {

            var plan_p = $("#plan_patria").val();
            var obj_h = $("#objetivo_historico").val();
            var obj_n = $("#objetivo_nacional").val();
            var obj_e = $("#objetivo_estrategico").val();
            $('#objetivo_general').find('option:gt(0)').remove().end().select2('val', "");
            $.post('<?php echo base_url(); ?>acciones/proyecto/ControllersProyecto/ajax_search_multiple_four/' + plan_p + '/' + obj_h + '/' + obj_n + '/' + obj_e + '', function (response) {

                var option = "";
                $.each(response, function (i) {

                    option += "<option value=" + response[i]['id'] + ">" + response[i]['objetivo_general'] + "</option>";
                });
                $('#objetivo_general').append(option);
            }, 'json');
        });

        // Validacion ajax para reflejar los datos en formato json
        $("#plan_gobierno").click(function (e) {

            var plan_gobierno = $(this).val();
            $('#linea_estrategica').find('option:gt(0)').remove().end().select2('val', "");
            $.post('<?php echo base_url(); ?>acciones/proyecto/ControllersProyecto/ajax_search_lineas_e_planG/' + plan_gobierno + '', function (response) {

                var option = "";
                $.each(response, function (i) {

                    option += "<option value=" + response[i]['id'] + ">" + response[i]['linea_estrategica'] + "</option>";
                });
                $('#linea_estrategica').append(option);
            }, 'json');
        });


        $("#ben_femeninos,#ben_masculinos,#estimado_fem,#estimado_mas").keyup(function () {
            // *****************************************************************
            var total = 0;
            var ben_femeninos = $("#ben_femeninos").val();
            var ben_masculinos = $("#ben_masculinos").val();

            var ben_femeninos = (ben_femeninos == "") ? 0.00 : ben_femeninos;
            var ben_masculinos = (ben_masculinos == "") ? 0.00 : ben_masculinos;

            total += parseFloat(ben_femeninos) + parseFloat(ben_masculinos);
            $("#total_ben").val(total);
            // *****************************************************************
            var total_directo = 0;
            var estimado_fem = $("#estimado_fem").val();
            var estimado_mas = $("#estimado_mas").val();

            var estimado_fem = (estimado_fem == "") ? 0.00 : estimado_fem;
            var estimado_mas = (estimado_mas == "") ? 0.00 : estimado_mas;
            total_directo += parseFloat(estimado_fem) + parseFloat(estimado_mas);
            $("#estimado_t_direc").val(total_directo);
            // *****************************************************************

        });

        $("#ente").change(function () {
            var ente = $(this).val();
            $("#domicilio,#cargo,#tlf,#responsable,#correo").val("");
            $.post('<?php echo base_url(); ?>acciones/proyecto/ControllersProyecto/search_table/id/organos_entes/' + ente + '', function (response) {
                $("#domicilio").val(response[0]['direccion']);
                $("#cargo_id").val(response[0]['cargo']);
                $("#tlf_id").val(response[0]['tlf']);
                $("#responsable_id").val(response[0]['nom_resp']);
                $("#correo_id").val(response[0]['correo']);
            }, 'json');
        });

        // Validacion respectiva para añadir una nueva Accion Especifica (7. CONEXIONES)
        $(".anadir_accion_esp").click(function () {
            $("#id_act,#acc_esp,#unidad_medida,#medio_verificacion,#trimestre_i,#trimestre_ii,#trimestre_iii,#trimestre_iv,#total,#pk").val("");
            $.fancybox.open({
                'autoScale': false,
                'href': '#form_acciones_especificas',
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

        $("#trimestre_i,#trimestre_ii,#trimestre_iii,#trimestre_iv").keyup(function () {
            var trimestre_i = $("#trimestre_i").val();
            var trimestre_ii = $("#trimestre_ii").val();
            var trimestre_iii = $("#trimestre_iii").val();
            var trimestre_iv = $("#trimestre_iv").val();

            var trimestre_i = (trimestre_i == "") ? 0.00 : trimestre_i;
            var trimestre_ii = (trimestre_ii == "") ? 0.00 : trimestre_ii;
            var trimestre_iii = (trimestre_iii == "") ? 0.00 : trimestre_iii;
            var trimestre_iv = (trimestre_iv == "") ? 0.00 : trimestre_iv;

            suma = parseFloat(trimestre_i) + parseFloat(trimestre_ii) + parseFloat(trimestre_iii) + parseFloat(trimestre_iv);
            $("#total").val(suma);
        });

        $("#I,#II,#III,#IV").keyup(function () {
            var trimestre_i = $("#I").val();
            var trimestre_ii = $("#II").val();
            var trimestre_iii = $("#III").val();
            var trimestre_iv = $("#IV").val();

            var trimestre_i = (trimestre_i == "") ? 0.00 : trimestre_i;
            var trimestre_ii = (trimestre_ii == "") ? 0.00 : trimestre_ii;
            var trimestre_iii = (trimestre_iii == "") ? 0.00 : trimestre_iii;
            var trimestre_iv = (trimestre_iv == "") ? 0.00 : trimestre_iv;

            suma = parseFloat(trimestre_i) + parseFloat(trimestre_ii) + parseFloat(trimestre_iii) + parseFloat(trimestre_iv);
            $("#cantidad,#asignacion").val(suma);
        });

        $("#registrar_acc_esp").click(function (e) {

            e.preventDefault();  // Para evitar que se envíe por defecto

            if ($('#acc_esp').val().trim() == '') {

                bootbox.alert("Ingrese la Acción Específica", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#acc_esp").parent('div').addClass('has-error');
                    $("#acc_esp").focus();
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
            } else if ($('#trimestre_i').val().trim() == '') {
                bootbox.alert("Ingrese el monto del Primer Trimestre", function () {

                }).on('hidden.bs.modal', function (event) {
                    $("#trimestre_i").parent('div').addClass('has-error');
                    $("#trimestre_i").focus();
                });
            } else if ($('#trimestre_ii').val().trim() == '') {
                bootbox.alert("Ingrese el monto del Segundo Trimestre", function () {

                }).on('hidden.bs.modal', function (event) {
                    $("#trimestre_ii").parent('div').addClass('has-error');
                    $("#trimestre_ii").focus();
                });
            } else if ($('#trimestre_iii').val().trim() == '') {
                bootbox.alert("Ingrese el monto del Tercer Trimestre", function () {

                }).on('hidden.bs.modal', function (event) {
                    $("#trimestre_iii").parent('div').addClass('has-error');
                    $("#trimestre_iii").focus();
                });
            } else if ($('#trimestre_iv').val().trim() == '') {
                bootbox.alert("Ingrese el monto del Cuarto Trimestre", function () {

                }).on('hidden.bs.modal', function (event) {
                    $("#trimestre_iv").parent('div').addClass('has-error');
                    $("#trimestre_iv").focus();
                });
            } else {

                if ($("#id_act").val() == "") {

                    $.post('<?php echo base_url(); ?>acciones/proyecto/ControllersProyecto/cargar/2/0', $('#form_acciones_especificas').serialize(), function (response) {

                        if (response == '1') {

                            bootbox.alert("Disculpe, ya se encuentra una Acción Específica asignada con este nombre...", function () {
                            }).on('hidden.bs.modal', function (event) {
                                $("#acc_esp").parent('div').addClass('has-error');
                                $("#acc_esp").focus();
                            });

                        } else {
                            bootbox.alert("Se registro la Acción Específica", function () {
                            }).on('hidden.bs.modal', function (event) {
                                url = '<?php echo base_url(); ?>acciones/proyecto/ControllersProyecto/procesar_list/' + $("#codigo").val() + '';
                                window.location = url;
                            });
                        }
                    });
                } else {
                    var id = $("#id_act").val();
                    $.post('<?php echo base_url(); ?>acciones/proyecto/ControllersProyecto/cargar/2/' + id + '', $('#form_acciones_especificas').serialize(), function (response) {
                        bootbox.alert("Se actualizo la Acción Específica", function () {
                        }).on('hidden.bs.modal', function (event) {
                            url = '<?php echo base_url(); ?>acciones/proyecto/ControllersProyecto/procesar_list/' + $("#codigo").val() + '';
                            window.location = url;
                        });
                    });
                }
            }
        });


$("#registrar_imp_pres").click(function (e) {

            e.preventDefault();  // Para evitar que se envíe por defecto

            if ($('#denominacion').val().trim() == '') {

                bootbox.alert("Ingrese la Denominación", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#denominacion").parent('div').addClass('has-error');
                    $("#denominacion").select2('open');
                });

            } else if ($('#I').val().trim() == '') {
                bootbox.alert("Ingrese el monto del Primer Trimestre", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#I").parent('div').addClass('has-error');
                    $("#I").focus();
                });
            } else if ($('#II').val().trim() == '') {
                bootbox.alert("Ingrese el monto del Segundo Trimestre", function () {

                }).on('hidden.bs.modal', function (event) {
                    $("#II").parent('div').addClass('has-error');
                    $("#II").focus();
                });
            } else if ($('#III').val().trim() == '') {
                bootbox.alert("Ingrese el monto del Tercer Trimestre", function () {

                }).on('hidden.bs.modal', function (event) {
                    $("#III").parent('div').addClass('has-error');
                    $("#III").focus();
                });
            } else if ($('#IV').val().trim() == '') {
                bootbox.alert("Ingrese el monto del Cuarto Trimestre", function () {

                }).on('hidden.bs.modal', function (event) {
                    $("#IV").parent('div').addClass('has-error');
                    $("#IV").focus();
                });
            } else {
                $.post('<?php echo base_url(); ?>acciones/proyecto/ControllersProyecto/cargar/4/0', $('#form_imp_pres').serialize(), function (response) {
                    bootbox.alert("Se registro la Imputación Presupuestaria", function () {
                    }).on('hidden.bs.modal', function (event) {
                        url = '<?php echo base_url(); ?>acciones/proyecto/ControllersProyecto/procesar_list/' + $("#codigo").val() + ''
                        window.location = url;
                    });
                });
            }
        });


        /*var fecha = new Date();
        var fecha_actual = fecha.getDate() + "/" + fecha.getMonth() + 1 + "/" + fecha.getFullYear() */
        //$("#fecha_elaboracion").val(fecha_actual);
        var codigo = $("#codigo").val().trim();
        $("#codigo").val(codigo);


    });

</script>
<script src="<?php echo base_url('assets/js/proyecto.js'); ?>"></script>
<style>

    button:before {
        content:'';
        position: absolute;
        top: 0px;
        left: 0px;
        width: 0px;
        height: 42px;
        background: rgba(255,255,255,0.3);
        border-radius: 5px;
        transition: all 2s ease;
    }
</style>
<br/>
<br/>
<br/>
<br/>
<form id='form_registro_proyecto' action="" method="POST">
    <div style="width: 95%;text-transform:uppercase;box-shadow: 0 1px 5px rgba(0,0,0,.85);margin: auto;" class="panel panel-default">
        <div class="panel-heading" style='background: linear-gradient(#2F9292, #3B7272);color:#FFFFFF;'>
            <label style="float: left" class="panel-title " ><!--<a href="<?php echo base_url(); ?>acciones/registro/ControllersRegistro" >Configuraciones</a>-->
                Modificar Proyecto</label>
                <br>
            </div>
            <fieldset><legend class="titulo text-center">Datos del Ante Proyecto</legend></fieldset>
            <br/>
            <div class="panel-body">
                <div class="col-xs-2" hidden='hidden'>ID</div>
                <div class="col-xs-4" hidden='hidden'>
                    <input readonly="" id="codigo" value="<?php echo $row->codigo; ?>" style="width: 25%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="" name="codigo" type="text" class="form-control" />
                    <input type="hidden" id="id_model" value="<?php echo $row->id ?>"/>
                </div>
                <div class="col-xs-2" style="">Elaboración</div>
                <div class="col-xs-2">
                    <input id="fecha_elaboracion" value="<?php
                    $fecha = explode('-', $row->fecha_elaboracion);
                    echo $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
                    ?>" readonly="" style="width: 80%;" placeholder="" type="text" class="form-control" />
                    <input id="fecha_elaboracion" value="<?php echo $row->fecha_elaboracion ?>" style="width: 80%;" placeholder="" name="fecha_elaboracion" type="hidden" class="form-control" />
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
                    <input type="hidden" id="estatus" name="estatus" value="<?php echo $row->estatus; ?>"/>
                    <!-- Acciones centralizada y Proyectos -->
                    <?php if ($row->estatus == 1) { ?>
                    <span class="label label-success" style='width: 65%;color: #FFFFFF;'>Revisando</span>
                    <?php } ?>
                    <?php if ($row->estatus == 2) { ?>
                    <span class="label label-success" style='width: 65%;color: #FFFFFF;'>Rechazado</span>
                    <?php } ?>
                    <?php if ($row->estatus == 3) { ?>
                    <span class="label label-success" style='width: 65%;color: #FFFFFF;'>Para Ajuste</span>
                    <?php } ?>
                    <?php if ($row->estatus == 4) { ?>
                    <span class="label label-success" style='width: 65%;color: #FFFFFF;'>Aprobado</span>
                    <?php } ?>
                    <!-- Ingresos Propios -->
                    <?php if ($row->estatus == 5) { ?>
                        <span class="label label-success" style='width: 65%;color: #FFFFFF;'>Ingresos Propios</span>
                    <?php }/* ?>
                    <?php if ($row->estatus == 6) { ?>
                        <span class="label label-success" style='width: 65%;color: #FFFFFF;'>Rechazado | Ingresos Propios</span>
                    <?php } ?>
                    <?php if ($row->estatus == 7) { ?>
                        <span class="label label-success" style='width: 65%;color: #FFFFFF;'>Para Ajuste | Ingresos Propios</span>
                    <?php } ?>
                    <?php if ($row->estatus == 8) { ?>
                        <span class="label label-success" style='width: 65%;color: #FFFFFF;'>Aprobado | Ingresos Propios</span>
                    <?php } */?>
                </div>
            </div>
            <!-- Apertura de Tabs (Secciones) -->
            <ul class="nav nav-tabs">
                <li class="active" data-toggle="popover" data-trigger="focus" title="Identificación" data-placement="top">
                    <a data-toggle="tab" href="#tabs_identificacion">Identificación</a>
                </li>
                <li id="#tabs_2" data-toggle="popover" data-trigger="focus" title="Proyecto" data-placement="top">
                    <a data-toggle="tab" href="#tabs_proyecto">Proyecto</a>
                </li>
                <li id="#tabs_2" data-toggle="popover" data-trigger="focus" title="Área Estratégica" data-placement="top">
                    <a data-toggle="tab" href="#tabs_area_estrategico">Área Estratégica</a>
                </li>
                <li id="#tabs_2" data-toggle="popover" data-trigger="focus" title="Descripción" data-placement="top">
                    <a data-toggle="tab" href="#tabs_desc">Descripción</a>
                </li>
                <li id="#tabs_2" data-toggle="popover" data-trigger="focus" title="Acciones" data-placement="top">
                    <a data-toggle="tab" href="#tabs_acciones">Acciones</a>
                </li>
                <li id="#tabs_2" data-toggle="popover" data-trigger="focus" title="Metas" data-placement="top">
                    <a data-toggle="tab" href="#tabs_metas">Metas</a>
                </li>
                <li id="#tabs_2" data-toggle="popover" data-trigger="focus" title="Imputación" data-placement="top">
                    <a data-toggle="tab" href="#tabs_imputacion">Imputación</a>
                </li>
                <li id="#tabs_2" data-toggle="popover" data-trigger="focus" title="Imputación Especifica" data-placement="top">
                    <a data-toggle="tab" href="#tabs_imputacion_es">Imputación Especifica</a>
                </li>
                <li id="#tabs_2" data-toggle="popover" data-trigger="focus" title="Observaciones" data-placement="top">
                    <a data-toggle="tab" href="#tabs_observaciones">Observaciones</a>
                </li>
            </ul>
            <br>
            <div class="tab-content">
                <div id="tabs_identificacion" class="tab-pane fade in active">
                    <div class="panel-body">
                        <fieldset>1. Identificación del proponente</fieldset>
                        <br/>
                    </div>
                    <div class="panel-body">
                        <div class="col-xs-2" >1.1 Organismo/Ente/Empresa</div>
                        <div class="col-xs-8">
                            <select id='ente' name='ente' style='width: 96%;'>
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
                        <div class="col-xs-2" >1.3 Domicilio</div>
                        <div class="col-xs-8">
                            <textarea maxlength="450" readonly id="domicilio" style="width: 96%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Ingrese el domicilio" name="domicilio" type="text" class="form-control"><?= $row->domicilio ?></textarea>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-xs-2" >1.5 Cargo</div>
                        <div class="col-xs-4">
                            <input maxlength="25" readonly id="cargo_id" value="<?= $row->cargo ?>" style="width: 100%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Ingrese el cargo" name="cargo" type="text" class="form-control" />
                        </div>
                        <div class="col-xs-1">1.6 Teléfono</div>
                        <div class="col-xs-4">
                            <input maxlength="15" readonly id="tlf_id" value="<?= $row->tlf ?>" style="width: 65%;" placeholder="Ingrese el teléfono" name="tlf" type="text" class="form-control" />
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-xs-2" >1.4 Responsable</div>
                        <div class="col-xs-4">
                            <input maxlength="25" readonly id="responsable_id" value="<?= $row->responsable ?>" style="width: 100%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Ingrese el responsable" name="responsable" type="text" class="form-control" />
                        </div>
                        <div class="col-xs-1">1.7 Correo</div>
                        <div class="col-xs-4">
                            <input id="correo_id" readonly value="<?= $row->correo ?>" style="width: 65%;" placeholder="Ingrese el correo" name="correo" type="text" class="form-control" />
                        </div>
                    </div>

                </div>
                <div id="tabs_proyecto" class="tab-pane fade">
                    <ul class="nav nav-tabs">
                        <li class="active" data-toggle="popover" data-trigger="focus" title="2 Datos principales del Proyecto" data-placement="top">
                            <a data-toggle="tab" href="#tabs_datos_proyecto">2 Datos principales del Proyecto</a>
                        </li>
                        <li data-toggle="popover" data-trigger="focus" title="3 Localización Política Administrativa" data-placement="top">
                            <a data-toggle="tab" href="#tabs_localizacion">3 Localización Política Administrativa</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="tabs_datos_proyecto" class="tab-pane fade in active">
                            <div class="panel-body">
                                <div class="col-xs-2" >2.1 Nombre del Proyecto</div>
                                <div class="col-xs-9">
                                    <textarea rows="1" id='nom_proyecto' name='nom_proyecto' style='width: 96%;height: 20%;text-transform:uppercase;' onblur="javascript:this.value = this.value.toUpperCase();" class="form-control"><?= $row->nom_proyecto ?></textarea>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-2">Descripción del Proyecto</div>
                                <div class="col-xs-9">
                                    <textarea rows="10" id='descripcion_proy' name='descripcion_proy' style='width: 96%;text-transform:uppercase;' onblur="javascript:this.value = this.value.toUpperCase();" class="form-control"><?= $row->descripcion_proy ?></textarea>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-2" >2.2 Ubicación</div>
                                <div class="col-xs-9">
                                    <input id="ubicacion" value="<?= $row->ubicacion ?>" name="ubicacion" class="form-control" style='width: 96.5%;text-transform:uppercase;' onblur="javascript:this.value = this.value.toUpperCase();"/>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-2" >Fecha Inicio/Culminación</div>
                                <div class="col-xs-4">
                                    <div style="float: left">
                                        <input
                                        value="<?php
                                        $fecha = explode('-', $row->inicio);
                                        echo $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
                                        ?>"
                                        maxlength="11" id="inicio" style="width: 60%;" placeholder="00/00/0000" type="text" class="form-control" />
                                        <input type="hidden" name="inicio" value="<?= $row->inicio ?>"/>
                                    </div>
                                    <div style="float: left">
                                        <input
                                        value="<?php
                                        $fecha = explode('-', $row->fin);
                                        echo $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
                                        ?>"
                                        maxlength="11" id="fin" style="width: 60%;" placeholder="00/00/0000" type="text" class="form-control" />
                                        <input type="hidden" name="fin" value="<?= $row->fin ?>"/>
                                    </div>
                                </div>
                                <div class="col-xs-2">2.6 Fuente de Financiamiento</div>
                                <div class="col-xs-4">
                                    <select id="f_financiamiento" name="f_financiamiento" style="width: 65%;">
                                        <option value="">Seleccione</option>
                                        <option value="1">Situado Constitucional</option>
                                        <option value="2">F.C.I</option>
                                        <option value="3">Ingresos Propios</option>
                                        <option value="4">Transferencias Corrientes Internas de la República</option>
                                    </select>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-2" >Año Fiscal</div>
                                <div class="col-xs-4">
                                    <!--<input readonly="" maxlength="4" id="ano_fiscal" style="width: 20%;" placeholder="0000" name="ano_fiscal" type="text" class="form-control" value="<?= $row->ano_fiscal ?>" readonly=''/>-->
                                    <select id='ano_fiscal' name='ano_fiscal' style='width: 23%;'>
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
                                <div class="col-xs-2">2.7 Indicador General</div>
                                <div class="col-xs-4">
                                    <input id="indicador_g" value="<?= $row->indicador_g ?>" style="width: 65%;text-transform:uppercase;" placeholder="Ingrese el Indicador" name="indicador_g" type="text" class="form-control" />
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-2" >2.3 Duración</div>
                                <div class="col-xs-4">
                                    <input maxlength="2" id="duracion" value="<?= $row->duracion ?>" style="width: 20%;" placeholder="" name="duracion" type="text" class="form-control" />
                                </div>
                                <div class="col-xs-2">2.8 Fórmula del Indentificador</div>
                                <div class="col-xs-4">
                                    <input id="identificador" value="<?= $row->identificador ?>" style="width: 65%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Ingrese el Identificador general" name="identificador" type="text" class="form-control" />
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-2" >2.4 Etapa</div>
                                <div class="col-xs-4">
                                    <select id="etapa" name="etapa" style="width: 62%;" class="form-control">
                                        <option value="">Seleccione</option>
                                        <option value="1">Nueva</option>
                                        <option value="2">Continuación</option>
                                    </select>
                                </div>
                                <div class="col-xs-2">2.9 Medio Verificación</div>
                                <div class="col-xs-4">
                                    <input id="m_verificacion" value="<?= $row->m_verificacion ?>" style="width: 65%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Ingrese el Medio de Verificación" name="m_verificacion" type="text" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div id="tabs_localizacion" class="tab-pane fade in">
                            <div class="panel-body">
                                <div class="col-xs-2" >3.1 Ámbito</div>
                                <div class="col-xs-8">
                                    <select id='ambito' name='ambito' style='width: 96%;'>
                                        <option value=''>Seleccione</option>
                                        <option value='1'>Estadal</option>
                                        <option value='2'>Nacional</option>
                                        <option value='3'>Internacional</option>
                                        <option value='4'>Municipal</option>
                                        <option value='5'>Parroquial</option>
                                        <option value='6'>Sin Extensión Territorial</option>
                                        <option value='7'>Comunal</option>
                                    </select>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-2" >3.2 Especifique el Ámbito</div>
                                <div class="col-xs-8">
                                    <textarea rows="10" id='especifique_amb' name='especifique_amb' style='width: 96%;text-transform:uppercase;' onblur="javascript:this.value = this.value.toUpperCase();" class="form-control"><?= $row->especifique_amb ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tabs_area_estrategico" class="tab-pane fade">
                    <ul class="nav nav-tabs">
                        <li class="active" data-toggle="popover" data-trigger="focus" title="4.1 Plan de la PAtria" data-placement="top">
                            <a data-toggle="tab" href="#tabs_plan_patria">4.1 Plan de la PAtria</a>
                        </li>
                        <li data-toggle="popover" data-trigger="focus" title="4.2 Plan de Gobierno" data-placement="top">
                            <a data-toggle="tab" href="#tabs_plan_gobierno">4.2 Plan de Gobierno</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="tabs_plan_patria" class="tab-pane fade in active">
                            <div class="panel-body">
                                <div class="col-xs-2" >4.1 Plan de la patria</div>
                                <div class="col-xs-8">
                                    <select id='plan_patria' name='plan_patria' style='width: 96%;'>
                                        <option value=''>Seleccione</option>
                                        <?php foreach ($plan_patria as $value) { ?>
                                        <option value="<?php echo $value->id; ?>"><?php echo $value->plan_patria; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-2" >4.1.1 Objetivo Histórico</div>
                                <div class="col-xs-8">
                                    <select id='objetivo_historico' name='objetivo_historico' style='width: 96%;'>
                                        <option value=''>Seleccione</option>
                                    </select>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-2" >4.1.2 Objetivo Nacional</div>
                                <div class="col-xs-8">
                                    <select id='objetivo_nacional' name='objetivo_nacional' style='width: 96%;'>
                                        <option value=''>Seleccione</option>
                                    </select>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-2" >4.1.3 Objetivo Estratégico</div>
                                <div class="col-xs-8">
                                    <select id='objetivo_estrategico' name='objetivo_estrategico' style='width: 96%;'>
                                        <option value=''>Seleccione</option>
                                    </select>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-2" >4.1.4 Objetivo Estratégico Institucional:</div>
                                <div class="col-xs-8">
                                    <select id='objetivo_general' name='objetivo_general' style='width: 96%;'>
                                        <option value=''>Seleccione</option>
                                    </select>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-2" >Objetivo General Institucional</div>
                                <div class="col-xs-8">
                                    <textarea rows="10" maxlength="450" id="objetivo_institucional" style="width: 96%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Objetivo General Institucional" name="objetivo_institucional" type="text" class="form-control"><?= $row->objetivo_institucional ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div id="tabs_plan_gobierno" class="tab-pane fade in">
                            <div class="panel-body">
                                <div class="col-xs-2" >4.2.1 Plan de Gobierno</div>
                                <div class="col-xs-8">
                                    <select id='plan_gobierno' name='plan_gobierno' style='width: 96%;'>
                                        <option value=''>Seleccione</option>
                                        <?php foreach ($plan_gobierno as $value) { ?>
                                        <option value="<?php echo $value->id; ?>"><?php echo $value->plan_gobierno; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-2" >4.2.2 Lineas Estratégicas</div>
                                <div class="col-xs-8">
                                    <select id='linea_estrategica' name='linea_estrategica' style='width: 96%;'>
                                        <option value=''>Seleccione</option>
                                    </select>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-2" >4.2.2 Área de Inversión</div>
                                <div class="col-xs-8">
                                    <input id="area_inversion" value="<?= $row->area_inversion ?>" name="area_inversion" placeholder="Ingrese el Área de Inversión" class="form-control" style='width: 96%;text-transform:uppercase;' onblur="javascript:this.value = this.value.toUpperCase();"/>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-2" >4.2.3 Sector</div>
                                <div class="col-xs-8">
                                    <select id='sector' name='sector' style='width: 96%;'>
                                        <option value=''>Seleccione</option>
                                        <?php foreach ($sectores as $value) { ?>
                                        <option value="<?php echo $value->id; ?>"><?php echo $value->sector; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-2" >4.2.4 Tipo de Inversión</div>
                                <div class="col-xs-8">
                                    <select id='tipo_inversion' name='tipo_inversion' style='width: 96%;'>
                                        <option value=''>Seleccione</option>
                                        <option value='1'>Inversión Productiva</option>
                                        <option value='2'>Fortalecimiento Institucional</option>
                                        <option value='3'>Infraestructura</option>
                                        <option value='4'>Servicios</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tabs_desc" class="tab-pane fade">
                    <ul class="nav nav-tabs">
                        <li class="active" data-toggle="popover" data-trigger="focus" title="5.Problema y Justificación" data-placement="top">
                            <a data-toggle="tab" href="#tabs_problema_justificacion">5.Problema y Justificación</a>
                        </li>
                        <li data-toggle="popover" data-trigger="focus" title="6. Beneficios" data-placement="top">
                            <a data-toggle="tab" href="#tabs_beneficios">6. Beneficios</a>
                        </li>
                        <li data-toggle="popover" data-trigger="focus" title="7. Conexiones" data-placement="top">
                            <a data-toggle="tab" href="#tabs_conexiones">7. Conexiones</a>
                        </li>
                        <li data-toggle="popover" data-trigger="focus" title="8. Empleos" data-placement="top">
                            <a data-toggle="tab" href="#tabs_empleos">8. Empleos</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="tabs_problema_justificacion" class="tab-pane fade in active">
                            <div class="panel-body">
                                <div class="col-xs-2" >5.1 Descripción del problema</div>
                                <div class="col-xs-8">
                                    <textarea rows="10" maxlength="450" id="desc_problema" style="width: 96%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Ingrese la descripción del problema" name="desc_problema" type="text" class="form-control"><?= $row->desc_problema ?></textarea>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-2" >5.2 Objetivo General</div>
                                <div class="col-xs-8">
                                    <textarea rows="10" maxlength="450" id="obj_general" style="width: 96%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Ingrese el Objetivo General" name="obj_general" type="text" class="form-control"><?= $row->obj_general ?></textarea>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-2" >5.3 Importancia e Impacto</div>
                                <div class="col-xs-8">
                                    <textarea rows="10" maxlength="450" id="imp_impacto" style="width: 96%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Ingrese la Importancia e Impacto" name="imp_impacto" type="text" class="form-control"><?= $row->imp_impacto ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div id="tabs_beneficios" class="tab-pane fade in">
                            <div class="panel-body">
                                <div class="col-xs-2" >6.1 Beneficios Femeninos</div>
                                <div class="col-xs-4">
                                    <input maxlength="10" id="ben_femeninos" style="width: 20%;" placeholder="0.00" name="ben_femeninos" type="text" class="form-control" value="<?= $row->ben_femeninos ?>" />
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-2" >6.2 Beneficios Masculinos</div>
                                <div class="col-xs-4">
                                    <input maxlength="10" id="ben_masculinos" style="width: 20%;" placeholder="0.00" name="ben_masculinos" type="text" class="form-control" value="<?= $row->ben_masculinos ?>" />
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-2" >6.3 Total de Beneficiarios</div>
                                <div class="col-xs-4">
                                    <input readonly="" maxlength="10" id="total_ben" style="width: 20%;" placeholder="0.00" name="total_ben" type="text" class="form-control" value="<?= $row->total_ben ?>" />
                                </div>
                            </div>
                        </div>
                        <div id="tabs_conexiones" class="tab-pane fade in">
                            <div class="panel-body">
                                <div class="col-xs-4">7.1 Requiere acciones (no financieras) de otra institución</div>
                                <div class="col-xs-4">
                                    <select id="req_acciones" name="req_acciones" style="width: 20%;">
                                        <option value="">Seleccione</option>
                                        <option value="1">Si</option>
                                        <option value="2">No</option>
                                    </select>
                                </div>
                                <div class="col-xs-2" style="margin-left:-25%">7.1.1 Institución</div>
                                <div class="col-xs-5" style="margin-left:-15%">
                                    <select id='acc_institucion' name='acc_institucion' style='width: 95%;'>
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
                                <div class="col-xs-4"></div>
                                <div class="col-xs-4"></div>
                                <div class="col-xs-2" style="margin-left:-25%">7.1.2 Especifique</div>
                                <div class="col-xs-5" style="margin-left:-15%">
                                    <input id="acc_especifique" value="<?= $row->acc_especifique ?>" name="acc_especifique" style='width: 95%;text-transform:uppercase;' class="form-control" onblur="javascript:this.value = this.value.toUpperCase();"/>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-4">7.2 Constribuye o complementa acciones de otras Instituciones</div>
                                <div class="col-xs-4">
                                    <select id="con_acciones" name="con_acciones" style="width: 20%;">
                                        <option value="">Seleccione</option>
                                        <option value="1">Si</option>
                                        <option value="2">No</option>
                                    </select>
                                </div>
                                <div class="col-xs-2" style="margin-left:-25%">7.2.1 Institución</div>
                                <div class="col-xs-5" style="margin-left:-15%">
                                    <select id='con_institucion' name='con_institucion' style='width: 95%;'>
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
                                <div class="col-xs-4"></div>
                                <div class="col-xs-4"></div>
                                <div class="col-xs-2" style="margin-left:-25%">7.2.2 Especifique</div>
                                <div class="col-xs-5" style="margin-left:-15%">
                                    <input id="con_especifique" value="<?= $row->con_especifique ?>" name="con_especifique" style='width: 95%;text-transform:uppercase;' onblur="javascript:this.value = this.value.toUpperCase();" class="form-control"/>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-4">7.3 Entra en conflicto con otra Institución</div>
                                <div class="col-xs-4">
                                    <select id="en_acciones" name="en_acciones" style="width: 20%;">
                                        <option value="">Seleccione</option>
                                        <option value="1">Si</option>
                                        <option value="2">No</option>
                                    </select>
                                </div>
                                <div class="col-xs-2" style="margin-left:-25%">7.3.1 Institución</div>
                                <div class="col-xs-5" style="margin-left:-15%">
                                    <select id='en_institucion' name='en_institucion' style='width: 95%;'>
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
                                <div class="col-xs-4"></div>
                                <div class="col-xs-4"></div>
                                <div class="col-xs-2" style="margin-left:-25%">7.3.2 Especifique</div>
                                <div class="col-xs-5" style="margin-left:-15%">
                                    <input id="en_especifique" value="<?= $row->en_especifique ?>" name="en_especifique" style='width: 95%;text-transform:uppercase;' class="form-control" onblur="javascript:this.value = this.value.toUpperCase();"/>
                                </div>
                            </div>
                        </div>
                        <div id="tabs_empleos" class="tab-pane fade in">

                            <div class="panel-body">
                                <div class="col-xs-3">8.1 Estimados de empleos directos femeninos</div>
                                <div class="col-xs-4">
                                    <input maxlength="10" value="<?= $row->estimado_fem ?>" id="estimado_fem" style="width: 20%;" placeholder="0.00" name="estimado_fem" type="text" class="form-control" />
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-3">8.2 Estimados de empleos directos masculinos</div>
                                <div class="col-xs-4">
                                    <input maxlength="10" value="<?= $row->estimado_mas ?>" id="estimado_mas" style="width: 20%;" placeholder="0.00" name="estimado_mas" type="text" class="form-control" />
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-3">8.3 Estimado total de empleos directos</div>
                                <div class="col-xs-4">
                                    <input readonly="" value="<?= $row->estimado_t_direc ?>" maxlength="10" id="estimado_t_direc" style="width: 20%;" placeholder="0.00" name="estimado_t_direc" type="text" class="form-control" />
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-3">8.4 Estimado total de empleos indirectos</div>
                                <div class="col-xs-4">
                                    <input maxlength="10" id="estimado_t_indirec" value="<?= $row->estimado_t_indirec ?>" style="width: 20%;" placeholder="0.00" name="estimado_t_indirec" type="text" class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tabs_acciones" class="tab-pane fade">
                    <div class="panel-body">
                        <table style="width:100%;background-color: #FFFFFF;" border="0" align="center" cellspacing="1" id="tabla_acciones_especificas" align="center"
                        class="table table-bordered table-striped table-hover table-condensed dt-responsive table-responsive" style="width:20%;">
                        <thead style="font-size: 12px">
                            <tr class="background-first"  style="color:#FFFFFF;">
                                <th></th>
                                <th style='text-align: center;width: 40%'>Acción Específica</th>
                                <th style='text-align: center'>Unidad/Medida</th>
                                <th style='text-align: center'>Medio/Verificación</th>
                                <th style='text-align: center'>Trimestre I</th>
                                <th style='text-align: center'>Trimestre II</th>
                                <th style='text-align: center'>Trimestre III</th>
                                <th style='text-align: center'>Trimestre IV</th>
                                <th style='text-align: center'>Total</th>
                                <th style='text-align: center'>Editar</th>
                            </tr>
                        </thead>
                        <tbody style="background-color: #FFFFFF;">
                            <?php
                            $i = 1;
                            foreach ($distribucion_acc as $value) {
                                ?>
                                <tr style="font-size: 12px;" id="tr_<?php echo $value->id; ?>">
                                    <td></td>
                                    <td style='text-align: left;width: 50%'>
                                        <?php echo $value->acc_esp; ?>
                                    </td>
                                    <td style="text-align: left;">
                                        <?php echo $value->unidad_medida; ?>
                                    </td>
                                    <td style="text-align: left;">
                                        <?php echo $value->medio_verificacion; ?>
                                    </td>
                                    <td style="text-align: right;">
                                        <?php echo $value->trimestre_i; ?>
                                    </td>
                                    <td style="text-align: right;">
                                        <?php echo $value->trimestre_ii; ?>
                                    </td>
                                    <td style="text-align: right;">
                                        <?php echo $value->trimestre_iii; ?>
                                    </td>
                                    <td style="text-align: right;">
                                        <?php echo $value->trimestre_iv; ?>
                                    </td>
                                    <td style="text-align: right;">
                                        <?php echo $value->total; ?>
                                    </td>
                                    <td>
                                        <img id='<?php echo $value->id; ?>' title="Editar Acción..." class="editar_accion" style="width:25px;height: 25px;cursor:pointer;" src="<?php echo base_url("assets/image/editar.png"); ?>"/>
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
                                <td><a class="anadir_accion_esp" style="text-decoration:none;text-align: left"><button type="button" class="btn btn-default">Añadir elemento</button></a></td>
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
            <div id="tabs_metas" class="tab-pane fade">
                <div class="panel-body">
					<div style='color:000000;' class='alert alert-info'>Celda resaltada en verde, es que se ha guardado la información, no es necesario dar clic al botón Guardar cambios...</div>
                    <table style="width:100%;background-color: #FFFFFF;" border="0" align="center" cellspacing="1" id="tabla_metas_financieras" align="center"
                    class="table table-bordered table-striped table-hover table-condensed dt-responsive table-responsive" style="width:20%;">
                    <thead style="font-size: 16px">
                        <tr class="background-first"  style="color:#FFFFFF;">
                            <th></th>
                            <th style='text-align: center;width: 50%'>Acción Específica</th>
                            <th style='text-align: center'>Trimestre I</th>
                            <th style='text-align: center'>Trimestre II</th>
                            <th style='text-align: center'>Trimestre III</th>
                            <th style='text-align: center'>Trimestre IV</th>
                            <th style='text-align: center'>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: #FFFFFF;">
                        <?php
                        $i = 1;
                        foreach ($dist_tri_acc as $value) {
                            ?>
                            <tr style="font-size: 16px;font-size: 14px;" id="tr_<?php echo $value->id_acc; ?>">
                                <td></td>
                                <td style='text-align: left;width: 50%'><?php echo $value->acc_esp; ?></td>
                                <td style='width: 5% !important;'>
                                    <textarea style="height: 38px;text-transform:uppercase;text-align: right;" class="form-control capturar numeric" id='I_<?= $value->id_acc ?>' name='<?= $value->id_acc ?>' onblur="javascript:this.value = this.value.toUpperCase();"><?php echo $value->trimestre_i; ?></textarea>
                                </td>
                                <td style='width: 5% !important;'>
                                    <textarea style="height: 38px;text-transform:uppercase;text-align: right;" class="form-control capturar numeric" id='II_<?= $value->id_acc ?>' name='<?= $value->id_acc ?>' onblur="javascript:this.value = this.value.toUpperCase();"><?php echo $value->trimestre_ii; ?></textarea>
                                </td>
                                <td style='width: 5% !important;'>
                                    <textarea style="height: 38px;width: 120px;text-align: right;" class="form-control capturar numeric" id='III_<?= $value->id_acc ?>' name='<?= $value->id_acc ?>'><?php echo $value->trimestre_iii; ?></textarea>
                                </td>
                                <td style='width: 5% !important;'>
                                    <textarea style="height: 38px;width: 120px;text-align: right;" class=" form-control capturar numeric" id='IV_<?= $value->id_acc ?>' name='<?= $value->id_acc ?>'><?php echo $value->trimestre_iv; ?></textarea>
                                </td>
                                <td style='width: 5% !important;'>
                                    <textarea readonly='' style="height: 38px;width: 120px;color: red;text-align: right;" class=" form-control capturar" id='cantidad_<?= $value->id_acc ?>' name='<?= $value->id_acc ?>'><?php echo $value->total; ?></textarea>
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
        <div id="tabs_imputacion" class="tab-pane fade">
            <div class="panel-body">
				<div style='color:000000;' class='alert alert-info'>Celda resaltada en verde, es que se ha guardado la información, no es necesario dar clic al botón Guardar cambios...</div>
                <table style="width:100%;background-color: #FFFFFF;" border="0" align="center" cellspacing="1" id="tabla_imputacion_presupuestaria" align="center"
                class="table table-bordered table-striped table-hover table-condensed dt-responsive table-responsive" style="width:20%;">
                <thead style="font-size: 16px">
                    <tr class="background-first"  style="color:#FFFFFF;">
                        <th></th>
                        <th style='text-align: center'>Denominación</th>
                        <th style='text-align: center'>Trimestre I</th>
                        <th style='text-align: center'>Trimestre II</th>
                        <th style='text-align: center'>Trimestre III</th>
                        <th style='text-align: center'>Trimestre IV</th>
                        <th style='text-align: center'>Cantidad</th>
                        <th style='text-align: center'>Solicitud</th>
                    </tr>
                </thead>
                <tbody style="background-color: #FFFFFF;">
                    <?php
                    $i = 1;
                    foreach ($distribucion_imp as $value) {
                        ?>
                        <tr style="font-size: 16px;font-size: 14px;" id="tr_<?php echo $value->id; ?>">
                            <td></td>
                            <td style='text-align: center;width: 50%'>
                                (<?php echo $value->codigo; ?>)  
                                <?php echo $value->partida_presupuestaria; ?>
                            </td>
                            <td>
                                <textarea style="height: 38px;text-align: right;" class="form-control capturar" id='IP_<?= $value->id ?>' name='<?= $value->id ?>'><?php echo $value->trimestre_i; ?></textarea>
                            </td>
                            <td>
                                <textarea style="height: 38px;text-align: right;" class="form-control capturar" id='IIP_<?= $value->id ?>' name='<?= $value->id ?>'><?php echo $value->trimestre_ii; ?></textarea>
                            </td>
                            <td>
                                <textarea style="height: 38px;width: 120px;" class="form-control capturar numeric" id='IIIP_<?= $value->id ?>' name='<?= $value->id ?>'><?php echo $value->trimestre_iii; ?></textarea>
                            </td>
                            <td>
                                <textarea style="height: 38px;width: 120px;" class=" form-control capturar numeric" id='IVP_<?= $value->id ?>' name='<?= $value->id ?>'><?php echo $value->trimestre_iv; ?></textarea>
                            </td>
                            <td>
                                <textarea readonly='' style="height: 38px;width: 120px;" class=" form-control capturar numeric" id='CANTIDADP_<?= $value->id ?>' name='<?= $value->id ?>'><?php echo $value->cantidad; ?></textarea>
                            </td>
                            <td>
                                <textarea readonly="" style="height: 38px;width: 120px;color: red;" class=" form-control capturar numeric" id='ASIGNACIONP_<?= $value->id ?>' name='<?= $value->id ?>'><?php echo $value->asignacion; ?></textarea>
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
                        <td><a class="anadir_imp_pre" style="text-decoration:none;text-align: left"><button class="btn btn-default">Añadir elemento</button></a></td>
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
    <div id="tabs_imputacion_es" class="tab-pane fade">
        <div class="panel-body">
            <div class="panel-body">
                <div class="form-inline">
                <div class="form-group col-xs-12">
                    <!--<object type="application/php" data='<?php echo base_url("acciones/proyecto/ControllersProyecto/lista/$row->id");?>' style="width:100%; height:600px;"></object>-->
                    <object type="application/php" data='<?php echo base_url("acciones/proyecto/ControllersProyecto/lista/$row->id");?>'  style="width:100%; height:600px;">
					  <embed src='<?php echo base_url("acciones/proyecto/ControllersProyecto/lista/$row->id");?>'  style="width:100%; height:600px;" frameborder="0" style="border:0;">
					</object>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="tabs_observaciones" class="tab-pane fade">
        <div class="panel-body">                    
            <div class="col-xs-2" >Revisado por</div>
            <div class="col-xs-4">
                <select id='reg_res' style='width: 90%;' disabled=''>
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
                <input id="fecha_revision" <?php if ($row->fecha_revision == "") { ?> value="" <?php } else { ?> value="<?php
                $fecha = explode('-', $row->fecha_revision);
                echo $fecha[2] . "/" . $fecha[1] . "/" . $fecha[0]
                ?>" <?php } ?> style="width:33%;text-transform:uppercase" placeholder="Fecha de revisión" readonly="" type="text" class="form-control" />
            </div>
        </div>
        <div class="panel-body">                    
            <div class="col-xs-2">Estructura Presupuestaria</div>
            <div class="col-xs-4">
                <input id="estruc_presupuestaria" value="<?php echo $row->estruc_presupuestaria; ?>" style="width:50%;text-transform:uppercase" placeholder="Estructura Presupuestaria" readonly="" name="estruc_presupuestaria" type="text" class="form-control" />
            </div>
        </div>
        <div class="panel-body">                    
            <div class="col-xs-2">Observaciones</div>
            <div class="col-xs-10">
                <textarea maxlength="1000" id="observaciones" name="observaciones" cols="2" rows="5" style="width: 74%;text-transform:uppercase" onblur="javascript:this.value = this.value.toUpperCase();" readonly="" placeholder="Observaciones" class='form-control'><?php echo $row->observaciones; ?></textarea>
            </div>
        </div>
    </div>
</div>
<br/>
<br/>
<div class="row" style="text-align: center">
    <a href='<?php echo base_url("acciones/proyecto/ControllersProyecto$bandera"); ?>'>
        <button type="button" id="volver" style="font-weight: bold;font-size: 13px" class="btn btn-warning " >
            &nbsp;<span class="glyphicon glyphicon-chevron-left"></span>&nbsp;Volver
        </button>
    </a>
    <?php if ($preliminar != 1) { ?>
    <input type="submit" id="registrar" style="font-weight: bold;font-size: 13px" class="btn btn-success" value="Guardar cambios"/>
    <button type="reset" id="limpiar" style="font-weight: bold;font-size: 13px; background: -moz-linear-gradient(#f4eb2f, #e5a32d); color: white " class="btn"/>
    &nbsp;<span class="glyphicon glyphicon-retweet"></span>&nbsp;&nbsp;Limpiar
</button>
<?php } ?>
</div>
<br/>
</div>
<input type="hidden" id="accion_id" value="<?php echo $row->id ?>"/>
<input type="hidden" id="id_reg_registro" value="<?php echo $row->reg_registro ?>"/>
<input type="hidden" id="id_f_financiamiento" value="<?php echo $row->f_financiamiento ?>"/>
<input type="hidden" id="id_etapa" value="<?php echo $row->etapa ?>"/>
<input type="hidden" id="id_ambito" value="<?php echo $row->ambito ?>"/>
<input type="hidden" id="id_plan_patria" value="<?php echo $row->plan_patria ?>"/>
<input type="hidden" id="id_objetivo_historico" value="<?php echo $row->objetivo_historico ?>"/>
<input type="hidden" id="id_objetivo_nacional" value="<?php echo $row->objetivo_nacional ?>"/>
<input type="hidden" id="id_objetivo_estrategico" value="<?php echo $row->objetivo_estrategico ?>"/>
<input type="hidden" id="id_objetivo_general" value="<?php echo $row->objetivo_general ?>"/>
<input type="hidden" id="id_plan_gobierno" value="<?php echo $row->plan_gobierno ?>"/>
<input type="hidden" id="id_linea_estrategica" value="<?php echo $row->linea_estrategica ?>"/>
<input type="hidden" id="id_sector" value="<?php echo $row->sector ?>"/>
<input type="hidden" id="id_tipo_inversion" value="<?php echo $row->tipo_inversion ?>"/>
<input type="hidden" id="id_req_acciones" value="<?php echo $row->req_acciones ?>"/>
<input type="hidden" id="id_acc_institucion" value="<?php echo $row->acc_institucion ?>"/>
<input type="hidden" id="id_con_acciones" value="<?php echo $row->con_acciones ?>"/>
<input type="hidden" id="id_en_acciones" value="<?php echo $row->en_acciones ?>"/>
<input type="hidden" id="id_con_institucion" value="<?php echo $row->con_institucion ?>"/>
<input type="hidden" id="id_en_institucion" value="<?php echo $row->en_institucion ?>"/>
<input type="hidden" id="id_reg_res" value="<?php echo $row->reg_res ?>"/>
<input type="hidden" id="id_ano_fiscal" value="<?php echo $row->ano_fiscal ?>"/>
<input id="id_estatus" type="hidden" value="<?php echo $row->estatus ?>"/>
<input type="hidden" id="last_id" value="<?php echo $last_id ?>" />



</form>
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
<form id='form_acciones_especificas' action="" method="POST" style='display: none;'>
    <div style="width: 95%;text-transform:uppercase;box-shadow: 0 1px 5px rgba(0,0,0,.85);margin: auto;" class="panel panel-default">
        <div class="panel-heading" style='background: linear-gradient(#2F9292, #3B7272);color:#FFFFFF;' >
            <label id='div_acc_es'>Registrar Acción Específica</label>
            <br>
        </div>
        <fieldset><legend class="titulo text-center">Datos de la Acción Específica</legend></fieldset>
        <div class="panel-body">
            <div class="col-xs-1" >Acción Específica</div>
            <div class="col-xs-10">
                <input id="id_act" type="hidden" class="form-control"/>
                <input name="pk" type="hidden" value="<?= $row->id ?>"/>
                <textarea maxlength="198" id='acc_esp' name='acc_esp' style='width: 90%;float:right;text-transform:uppercase' onblur="javascript:this.value = this.value.toUpperCase();" placeholder='Maximo de caracteres permitidos 198' class="form-control"></textarea>
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
        <div class="panel-body" style="margin-left: 18%">
            <div class="col-xs-0"></div>
            <div class="col-xs-2">
                <input maxlength="10" id="trimestre_i" style="width: 120%;float:right;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" name="trimestre_i" type="text" class="form-control" placeholder="I" />
            </div>
            <div class="col-xs-0"></div>
            <div class="col-xs-2">
                <input maxlength="10" id="trimestre_ii" style="width: 120%;float:right;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" name="trimestre_ii" type="text" class="form-control" placeholder="II"/>
            </div>
            <div class="col-xs-0"></div>
            <div class="col-xs-2">
                <input maxlength="10" id="trimestre_iii" style="width: 120%;float:right;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" name="trimestre_iii" type="text" class="form-control" placeholder="III"/>
            </div>
            <div class="col-xs-0"></div>
            <div class="col-xs-2">
                <input maxlength="10" id="trimestre_iv" style="width: 120%;float:right;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" name="trimestre_iv" type="text" class="form-control" placeholder="IV"/>
            </div>
            <div class="col-xs-0"></div>
            <div class="col-xs-2">
                <input maxlength="10" id="total" style="width: 120%;float:right;" name="total" type="text" class="form-control" placeholder="Total" readonly="" />
            </div>
        </div>
        <br/>
        <div class="row" style="text-align: center">
            <input type="submit" id="registrar_acc_esp" style="font-weight: bold;font-size: 13px" class="btn btn-success" value="Guardar cambios"/>
        </div>
        <br/>
    </div>
</form>

<!--$("#empresa").find('option').filter(':selected').text().split('--')[1] -->
<form id='form_imp_pres' action="" method="POST" style='display: none;'>
    <div style="width: 95%;text-transform:uppercase;box-shadow: 0 1px 5px rgba(0,0,0,.85);margin: auto;" class="panel panel-default">
        <div class="panel-heading" style='background: linear-gradient(#2F9292, #3B7272);color:#FFFFFF;' >
            <label>Registrar Imputación</label>
            <br>
        </div>
        <fieldset><legend class="titulo text-center">Datos de la Imputación Presupuestaria</legend></fieldset>
        <div class="panel-body">
            <div class="col-xs-2" >Denominación</div>
            <div class="col-xs-10">
                <input name="pk" type="hidden" value="<?= $row->id ?>"/>
                <select id='denominacion' name='denominacion' style='width: 90%;'>
                    <option value=''>Seleccione</option>
                    <?php foreach ($partida as $row): ?>
                        <option value="<?php echo $row->id; ?>">
                            (<?php echo $row->codigo; ?>) <?php echo $row->partida_presupuestaria; ?>
                        </option>
                    <?php endforeach ?>
                </select>

            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-1" >Trimestres</div>
            <div style="float: left;">
                <input maxlength="10" id="I" style="width: 52%;float:right;" name="trimestre_i" type="text" class="form-control" placeholder="I" />
            </div>
            <div style="float: left;">
                <input maxlength="10" id="II" style="width: 52%;float:right;" name="trimestre_ii" type="text" class="form-control" placeholder="II"/>
            </div>
            <div style="float: left;">
                <input maxlength="10" id="III" style="width: 52%;float:right;" name="trimestre_iii" type="text" class="form-control" placeholder="III"/>
            </div>
            <div style="float: left;">
                <input maxlength="10" id="IV" style="width: 52%;float:right;" name="trimestre_iv" type="text" class="form-control" placeholder="IV"/>
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-1" >Cantidad/Asignación</div>
            <div style="float: left;">
                <input readonly='' maxlength="10" id="cantidad" style="width: 52%;float:right;" name="cantidad" type="text" class="form-control" placeholder="0.00" />
            </div>
            <div style="float: left;">
                <input readonly="" maxlength="10" id="asignacion" style="width: 52%;float:right;" name="asignacion" type="text" class="form-control" placeholder="0.00"/>
            </div>
        </div>
        <br/>
        <div class="row" style="text-align: center">
            <input type="submit" id="registrar_imp_pres" style="font-weight: bold;font-size: 13px" class="btn btn-success" value="Guardar cambios"/>
        </div>
        <br/>
    </div>
</form>


