var editor; // use a global for the submit and return data rendering in the example


$(document).ready(function () {
    $("select").select2();

    var url_accion = location.protocol;
    window.url_buscar = url_accion + '/buscar';
    window.url_eliminar = url_accion + '/eliminar';
    var $formulario = $(".frmcuestionario");
    var $guardar = $('#guardar');
    var $search = $('.search');
    var $open_report = $('.open_report');
    var $email = $('button.open_report_email');
    var $this = $(this);
    //$("#proyecto_id").select2('val',);
    
    // Table gestion accion
    var table = $('.table-gestion-acc, .table-gestion-proy').DataTable({
        "iDisplayLength": 10,
        "iDisplayStart": 0,
        "sPaginationType": "full_numbers",
        "aLengthMenu": [25, 50, 75, 100],
        "oLanguage": {"sUrl": assets_url('assets/js/es.txt')},
        "order": [[1, "asc"]],
        "aoColumns": [
        {"sClass": "registro left", "sWidth": "80%"},
        {"sClass": "registro left", "sWidth": "1%"},
        {"sClass": "registro right", "sWidth": "1%"},
        {"sClass": "registro right", "sWidth": "1%"},
        ]
    });

    var table_org = $('#tbl_organismo').DataTable({
		"iDisplayLength": 10,
		"iDisplayStart": 0,
		"sPaginationType": "full_numbers",
		"aLengthMenu": [25, 50, 75, 100],
		"oLanguage": {"sUrl": assets_url('assets/js/es.txt')},
		"order": [[1, "asc"]],
		"aoColumns": [
		{"sClass": "control", "sWidth": "1%"},
		{"sClass": "registro center", "sWidth": "1%"},
		{"sClass": "registro center", "sWidth": "10%"}
		]
	});

    // Ver detalles del registro (Accion)
    $('.table-gestion-acc, .table-gestion-proy tbody').on('click', 'tr.row-detail', function () {
        //$("#frm_accion").show(1000);
        $.fancybox.open({
            'autoScale': false,
            'href': '#table_es_ej',
            'type': 'inline',
            'hideOnContentClick': false,
            'transitionIn': 'fade',
            'transitionOut': 'fade',
            'openSpeed': 1000,
            'closeSpeed': 1000,
            'width': '960px',
            'height': '400px',
            'autoSize': false,
            helpers: {
                overlay: {
                    closeClick: false
                } // prevents closing when clicking OUTSIDE fancybox
            }
        });
        var $cl_tr = $(this).closest('tr');
        var id = $(this).attr("data-id");
        $(".actividad").text($cl_tr.find('td').eq(0).text().trim());
        var programado    = $cl_tr.find('td').eq(2).text().trim();
        var cumplido      = $cl_tr.find('td').eq(3).text().trim();
        var porcentaje    = $cl_tr.find('td').eq(4).text().trim();
        var ejecutado     = $(this).attr("data-anual");
        var trimestre_i   = $(this).attr("data-trimestre_i");
        var trimestre_ii  = $(this).attr("data-trimestre_ii");
        var trimestre_iii = $(this).attr("data-trimestre_iii");
        var trimestre_iv  = $(this).attr("data-trimestre_iv");

        var I   = $(this).attr("data-I");
        var II  = $(this).attr("data-II");
        var III = $(this).attr("data-III");
        var IV  = $(this).attr("data-IV");

        $("span.programado").text(programado);
        $("#cumplido").val(cumplido);
        $("#ejecutado").val(ejecutado);
        $("#id_acc").val(id);
        
        por_trimestre_i = (I / trimestre_i) * 100
        por_trimestre_i = por_trimestre_i.number_format(0, 3, '', '.') + '%'
        por_trimestre_ii = (II / trimestre_ii) * 100
        por_trimestre_ii = por_trimestre_ii.number_format(0, 3, '', '.') + '%'
        por_trimestre_iii = (II / trimestre_iii) * 100
        por_trimestre_iii = por_trimestre_iii.number_format(0, 3, '', '.') + '%'
        por_trimestre_iv = (IV / trimestre_iv) * 100
        por_trimestre_iv = por_trimestre_iv.number_format(0, 3, '', '.') + '%'

        $("span.trimestre_I").text(trimestre_i);
        $("span.trimestre_II").text(trimestre_ii);
        $("span.trimestre_III").text(trimestre_iii);
        $("span.trimestre_IV").text(trimestre_iv);

        $("input.I").val(I);
        $("input.II").val(II);
        $("input.III").val(III);
        $("input.IV").val(IV);
        
        $("span.porcentaje_I").text(por_trimestre_i);
        $("span.porcentaje_II").text(por_trimestre_ii);
        $("span.porcentaje_III").text(por_trimestre_iii);
        $("span.porcentaje_IV").text(por_trimestre_iv);
    });
    
    // Evento para el calculo de los porcentajes
    $("input.I, input.II, input.III, input.IV").on('change', function () {
		
		var trimestre_i   = $("span.trimestre_I").text();
		var trimestre_ii   = $("span.trimestre_II").text();
		var trimestre_iii   = $("span.trimestre_III").text();
		var trimestre_iv   = $("span.trimestre_IV").text();
		
        var I    = $("input.I").val();
        var II   = $("input.II").val();
        var III  = $("input.III").val();
        var IV   = $("input.IV").val();
        
        
        por_trimestre_i = (I / trimestre_i) * 100
        por_trimestre_i = por_trimestre_i.number_format(0, 3, '', '.') + '%'
        
        por_trimestre_ii = (II / trimestre_ii) * 100
        por_trimestre_ii = por_trimestre_ii.number_format(0, 3, '', '.') + '%'
        
        por_trimestre_iii = (III / trimestre_iii) * 100
        por_trimestre_iii = por_trimestre_iii.number_format(0, 3, '', '.') + '%'
        
        por_trimestre_iv = (IV / trimestre_iv) * 100
        por_trimestre_iv = por_trimestre_iv.number_format(0, 3, '', '.') + '%'

        $("span.porcentaje_I").text(por_trimestre_i);
        $("span.porcentaje_II").text(por_trimestre_ii);
        $("span.porcentaje_III").text(por_trimestre_iii);
        $("span.porcentaje_IV").text(por_trimestre_iv);
		
	});

    // Ver detalles del registro (Proyecto)
    /*$('.table-gestion-proy tbody').on('click', 'tr.row-detail', function () {
        //$("div.div-proy").show(1000);
        $.fancybox.open({
            'autoScale': false,
            'href': '#table_es_ej',
            'type': 'inline',
            'hideOnContentClick': false,
            'transitionIn': 'fade',
            'transitionOut': 'fade',
            'openSpeed': 1000,
            'closeSpeed': 1000,
            'width': '960px',
            'height': '400px',
            'autoSize': false,
            helpers: {
                overlay: {
                    closeClick: false
                } // prevents closing when clicking OUTSIDE fancybox
            }
        });

        var $cl_tr = $(this).closest('tr');
        var id = $(this).attr("data-id");
        $(".actividad").text($cl_tr.find('td').eq(0).text().trim());
        var programado = $cl_tr.find('td').eq(2).text().trim();
        var cumplido = $cl_tr.find('td').eq(3).text().trim();
        var porcentaje = $cl_tr.find('td').eq(4).text().trim();
        var ejecutado = $(this).attr("data-anual");
        $("#programado").val(programado);
        $("#cumplido").val(cumplido);
        $("#ejecutado").val(ejecutado);
        var I          = $(this).attr("data-I");
        var II         = $(this).attr("data-II");
        var III        = $(this).attr("data-III");
        var IV         = $(this).attr("data-IV");
        $("#programado").val(programado);
        $("#cumplido").val(cumplido);
        $("#ejecutado").val(ejecutado);
        $("#id_acc").val(id);
        por = (cumplido / programado) * 100
        por = por.number_format(2, 3, '', ',') + '%'
        $("#porcentaje").val(por);
        $("#I").val(I);
        $("#II").val(II);
        $("#III").val(III);
        $("#IV").val(IV);
    }); */

    // Proceso para reportar la accion
    $("#estatus").on('click', function () {
        var checked = $('input#estatus').is(':checked');
        $("button.open_report_email").prop('disabled', false);
        //$("input.guardar").parent().prev().prop('disabled', false);

        $("input.guardar").parent().parent().prev().find("input").prop('checked', false);

        if(checked == true){
            $("button.open_report_email").prop('disabled', true);
            $("input.guardar").parent().parent().prev().find("input").prop('checked', false);
        }
    });

    // Calculo de porcentaje cuando exista un cambio en el campo cumplido (Accion)
    $("#cumplido").on('change', function () {
        var cumplido = $(this).val();
        var programado = $("#programado").val();

        por = (cumplido / programado) * 100
        por = por.number_format(2, 3, '', ',') + '%'
        $("#porcentaje").val(por);
    });

    // Cerrar form de accion de ejecucion financiera
    $('span.trash-ej').on('click', function (e) {
        $("#frm_accion").hide(1000);
    });

    // Cerrar form de proyecto de ejecucion financiera
    $('span.trash-ej-proy').on('click', function (e) {
        $("div.div-proy").hide(1000);
    });

    // Procesar la informacion de la Ejecucion Fisica (Accion)
    $('button.send-acc-ej').on('click', function (e) {
        e.preventDefault();
        var I = $("input[name=I]").val();
        var II = $("input[name=II]").val();
        var III = $("input[name=III]").val();
        var IV = $("input[name=IV]").val();
        
        //if(I == "" || II == "" || III == "" || IV == ""){
        //    new PNotify({
        //        title: 'Gestión de Control',
        //        text: "Indique algún valor, no puede estar vacio",
        //        type: 'danger',
        //    });

        //return true;
        //}
        
        new PNotify({
          title: 'Gestión',
          text: '¿Realmente desea guardar la información trimestral ?',
          icon: 'glyphicon glyphicon-question-sign',
          hide: false,
          confirm: {
            confirm: true
          },
          buttons: {
            closer: false,
            sticker: false
          },
          history: {
            history: false
          }
        }).get().on('pnotify.confirm', function(){
          $.post(base_url('/gestion/update_accion'), $("#frmtrimestre").serialize(), function (response) {
				if (response.success == "ok") {
					new PNotify({
						title: 'Gestión de Control',
						text: "Se ha procesado la información...",
						type: 'info',
					});
				}
			}).then(function () {//return true;
				window.location.reload(1);
				//$.fancybox.close();
			});
        }).on('pnotify.cancel', function(){
          new PNotify({
				title: 'Gestión de Control',
				text: "Puede corregir algún dato faltante...",
				type: 'warning',
			});
        });
    });

    // Procesar la informacion de la Ejecucion Fisica (Proyecto)
    $('span.send-proy-ej').on('click', function (e) {
        e.preventDefault();

        $.post(base_url('/gestion/update_accion'), $("#frm_proy").serialize(), function (response) {
            if (response.success == "ok") {
                new PNotify({
                    title: 'Gestión de Control',
                    text: "Se ha procesado la información...",
                    type: 'info',
                });
            }

        }).then(function () {
            setTimeout(function () {
                window.location.reload(1);
            }, 3000);
        });
    });

    




    var table_acc_financiera = $('.table-gestion-financiera').DataTable({
        "iDisplayLength": 10,
        "iDisplayStart": 0,
        "sPaginationType": "full_numbers",
        "aLengthMenu": [25, 50, 75, 100],
        "oLanguage": {"sUrl": assets_url('assets/js/es.txt')},
        "order": [[1, "desc"]],
        "aoColumns": [
        {"sClass": "registro center", "sWidth": "100%"},
        {"sClass": "registro center", "sWidth": "5%"},
        {"sClass": "registro center", "sWidth": "5%"},
        {"sClass": "registro center", "sWidth": "5%"},
        {"sClass": "registro center", "sWidth": "5%"},
        ]
    });

    var table_municipios = $('#table-municipios').DataTable({
        "iDisplayLength": 10,
        "iDisplayStart": 0,
        "sPaginationType": "full_numbers",
        "bLengthChange": false,
        "oLanguage": {"sUrl": assets_url('assets/js/es.txt')},
        "order": [[1, "asc"]],
        "aoColumns": [
        {"sClass": "registro center", "sWidth": "10%"},
        {"sClass": "registro center", "sWidth": "80%"}

        ]
    });

    $email.on('click', function () {
        var $url = base_url("/gestion/send_email");
        var $id  = $("#nom_acc").val();
        var $codigo = $("select#nom_acc option:selected").text();

        if($id > 0){
            new PNotify({
                title: 'Reportar',
                text: '¿Esta usted de acuerdo en reportar La información a la Dirección de Planificación y Presupuesto, bajo las siguientes especificaciones, considerando que la información contenida es de responsabilidad directa del emisor y que una vez que alla sido reportada no puede ser manipulado por ninguna razón agena a su voluntad.?',
                icon: 'glyphicon glyphicon-question-sign',
                hide: false,
                confirm: {
                    confirm: true
                },
                buttons: {
                    closer: false,
                    sticker: false
                },
                history: {
                    history: false
                }
            }).get().on('pnotify.confirm', function () {
                $.get($url, { id: $id, codigo: $codigo, acc: 1 }, function (response) {
                    if (response.success == "ok") {

                        new PNotify({
                            title: 'Gestión de Control',
                            text: "Se ha reportado con exito...",
                            type: 'info',
                        });
                    }
                }, 'json').success(function () {
                    $.please(2000);
                });
            }).on('pnotify.cancel', function () {
                return true;
            });

        }else{
            new PNotify({
                title: 'Gestión de Control',
                text: "Disculpe, debe seleccionar un numero de Acción",
                type: 'info',
            });
        }
    });

    $('span.add-plus').on('click', function () {
        var $url = base_url("/gestion/estructura");
        var $ind = $(".data-estructura").length + 1;
        var partida = "<select style='width:100%' id='estructura_" + $ind + "' class='data-estructura' class='form-control'><option value='0'>Seleccione</option></select>";
        var remove_row = '<span title="Eliminar" class="btn btn-danger glyphicon glyphicon-remove delete-row"></span>';
        var $count = table_acc_financiera.rows().data().length;
        var id = 0;

        $.estructura_presupuestaria($url, function (data, textStatus, xhr) {
            $.each(data.estructura, function (i, item) {
                $("select.data-estructura").append('<option value="' + item.id + '">(' + item.partida + ') ' + item.descripcion + '</option>');
            });
        });

        table_acc_financiera.row.add([partida, 0.00, 0.00, 0.00, remove_row]).draw(false)
        var $row = table_acc_financiera.row($count).nodes().to$();
        table_acc_financiera.row($count).nodes().to$().attr({'id': $count + 1, 'data-id': $count + 1, 'param-name': 'new-row'});
        $row.find('td:eq(1)').attr({
            'id': 'compromiso',
            'title': 'Proporciona a las empresas información a tiempo sobre el flujo de caja anticipado y los modelos de gastos. Cuando se registran las órdenes de compra como compromisos en relación a un presupuesto.'
        }).addClass('data-element-financiero');
        $row.find('td:eq(2)').attr({
            'id': 'causado',
            'title': 'Gastos tales como salarios de empleados e intereses sobre documentos por pagar que se han acumulado día a día, pero que no se han registrado ni pagado al final del período. También se denominan gastos no registrados.'
        }).addClass('data-element-financiero');
        $row.find('td:eq(3)').attr({
            'id': 'pagado',
            'title': 'Son los valores invertidos en una sociedad anónima por sus accionistas.'
        }).addClass('data-element-financiero');
    });

    // Eliminar fila
    $('.table-gestion-financiera tbody').on('click', 'span.delete-row', function () {
        var $url = base_url("/gestion/delete_financiero");
        var $id   = $(this).closest('tr').attr('id');
        var $param_name = $(this).closest('tr').attr('param-name');
        var $this = $(this);

        if($param_name == "new-row"){

            table_acc_financiera
            .row($this.parents('tr'))
            .remove()
            .draw();

        }else {

            $.get($url,{id:$id}, function (response) {
                if(response.success == "ok"){
                    new PNotify({
                        title: 'Gestión de Control',
                        text: "Registro borrado con exito...",
                        type: 'info',
                    });
                    table_acc_financiera
                    .row($this.parents('tr'))
                    .remove()
                    .draw();
                }
            },'json');
        }


    });

    $('.table-gestion-financiera tbody').on('click', 'td.data-element-financiero', function () {

        var ind_col = $(this).closest('td').index()
        var valor = $(this).closest('tr').find('td').eq(ind_col).text()
        if (isNaN(valor) == false && $("#change_value-financiero").length == 0) {

            var $input = '<input class="form-control" style="width: 100%;" autofocus type="text" id="change_value_financiero" value="' + valor + '">'
            $(this).closest('tr').find('td').eq(ind_col).html($input)

        }
        $('#change_value_financiero').focus();
    });


    $(".table-gestion-financiera tbody").on({
        blur: function () {
            var ind_col = $(this).closest('td').index()
            var valor = $(this).closest('tr').find('td').find('input').val();
            $(this).closest('tr').find('td').eq(ind_col).text(valor);
        },
        keypress: function (ev) {
            var keycode = (ev.keyCode ? ev.keyCode : ev.which);
            if (keycode == '13') {
                var $cl_td = $(this).closest('td')
                var $cl_tr = $(this).closest('tr')
                var id_col = $cl_td.attr('id');
                var ind_col = $cl_td.index();
                var id_row = $cl_tr.attr('id');
                var $param_name = $(this).closest('tr').attr('param-name');

                var datos = {};
                if($param_name == "new-row"){
                    $param_name = $(this).closest('tr').attr('param-name', 'param-modifify');
                    datos['id'] = 0;
                }else if($param_name == "update-row" || $param_name == "param-modifify"){
                    datos['id'] = id_row;
                }

                datos['accion_id'] = $("#nom_acc").val();
                datos['partida_id'] = $cl_tr.find('td').find('.data-estructura').find('option').filter(':selected').val();
                datos['indice'] = id_row;

                $cl_tr.find("td:not(:eq(ind_col)).data-element-financiero").each(function () {
                    datos[$(this).attr('id')] = $(this).text();
                })
                var valor = $(this).val();
                datos[id_col] = valor
                $cl_tr.find('td').eq(ind_col).text(valor);

                var compromiso = parseFloat($cl_tr.find('td').eq(1).text());
                var causado = parseFloat($cl_tr.find('td').eq(2).text());
                var pagado = parseFloat($cl_tr.find('td').eq(3).text());

                if (parseFloat(compromiso) != 0.00 && parseFloat(causado) != 0.00 && parseFloat(pagado) != 0.00) {
                    bandera = true;
                } else {
                    bandera = false;
                }

                if (bandera != true) {
                    $.post(base_url('/gestion/update_financiero'), datos, function (response) {
                        new PNotify({
                            title: 'Gestión de Control',
                            text: 'Se ha guardo la información con exito...',
                            type: 'info',
                            after_close: function () {
                                //alert('Closed!');

                            }
                        });

                    }, 'json');
                } else {
                    var data_value = $cl_td.attr('data-value');
                    $cl_tr.find('td').eq(ind_col).text(data_value);
                    new PNotify({
                        title: 'Gestión de Control',
                        text: 'El valor de la meta cumplida no debe ser mayor a la programada...',
                        type: 'error',
                    });
                }
            }
        }

    }, '#change_value_financiero');


    $open_report.click(function (event) {
        event.preventDefault();
        var $value = $("#nom_acc");
        if ($value.val() == 0) {
            new PNotify({
                title: 'Gestión de Control',
                text: 'Seleccione un número de Acción...',
                type: 'info',
                after_close: function () {
                    $search.select2('open');
                }
            });
        } else {
            url = base_url("/pdf/" + $value.val());
            $.open_pdf(url);
        }

    });

    // Busqueda de registro de Accion
    $("#ano_fiscal, #nom_acc").change(function (event) {
        var value = $(this).val();
        var ano_fiscal = $("#ano_fiscal").val();
        var url = base_url("/gestion/acc/" + value + "?ano_fiscal=" + ano_fiscal);
        if (value > 0) {
            window.location = url;
        }
    });

    // Busqueda de registro de Proyecto
    $("#ano_fiscal, #proyecto_id").change(function (event) {
        var value = $(this).val();
        var ano_fiscal = $("#ano_fiscal").val();
        var url = base_url("/gestion/proy/" + value + "?ano_fiscal=" + ano_fiscal);
        if (value > 0) {
            window.location = url;
        }
    });

$('.table-gestion tbody').on('click', 'td.prueba', function () {

    var ind_col = $(this).closest('td').index()
    var valor = $(this).closest('tr').find('td').eq(ind_col).text()
    if (isNaN(valor) == false && $("#change_value").length == 0) {

        var $input = '<input class="form-control" style="width: 100%;" autofocus type="text" id="change_value" value="' + valor + '">'
        $(this).closest('tr').find('td').eq(ind_col).html($input)

    }
    $('#change_value').focus();
});


$(".table-gestion tbody").on({
    blur: function () {
        var ind_col = $(this).closest('td').index()
        var valor = $(this).closest('tr').find('td').find('input').val();
        $(this).closest('tr').find('td').eq(ind_col).text(valor);
    },
    keypress: function (ev) {
        var keycode = (ev.keyCode ? ev.keyCode : ev.which);
        if (keycode == '13') {
            var $cl_td = $(this).closest('td')
            var $cl_tr = $(this).closest('tr')
            var id_col = $cl_td.attr('id');

            var ind_col = $cl_td.index();
            var id_row = $cl_tr.attr('id');
            var datos = {};
            datos['id'] = id_row;

            $cl_tr.find("td:not(:eq(ind_col)).prueba").each(function () {
                datos[$(this).attr('id')] = $(this).text();
            })
            var valor = $(this).val();
            datos[id_col] = valor
            $cl_tr.find('td').eq(ind_col).text(valor);

            var programado = parseFloat($cl_tr.find('td').eq(2).text());
            var cumplido = parseFloat($cl_tr.find('td').eq(3).text());

            if (cumplido > programado) {
                bandera = true;
            } else {
                bandera = false;
            }

            if (bandera != true) {
                $.post(base_url('/gestion/update_activity'), datos, function (response) {

                    var por = 0;

                    if (cumplido > 0) {

                        por = (cumplido / programado) * 100
                        por = por.number_format(2, 3, '', ',') + '%'
                    }
                    $cl_tr.find('td').eq(4).text(por);
                    new PNotify({
                        title: 'Gestión de Control',
                        text: 'Se ha guardo la información con exito...',
                        type: 'info',
                        after_close: function () {
                                //alert('Closed!');

                            }
                        });

                }, 'json');
            } else {
                var data_value = $cl_td.attr('data-value');
                var data_message = $cl_td.attr('data-message');
                $cl_tr.find('td').eq(ind_col).text(data_value);
                new PNotify({
                    title: 'Gestión de Control',
                    text: data_message,
                    type: 'error',
                });
            }
        }
    }

}, '#change_value');

$('#mun').click(function () {
    $.fancybox.open({
        'autoScale': false,
        'href': '#table_mun',
        'type': 'inline',
        'hideOnContentClick': false,
        'transitionIn': 'fade',
        'transitionOut': 'fade',
        'openSpeed': 1000,
        'closeSpeed': 1000,
        'width': '960px',
        'height': '400px',
        'autoSize': false,
        helpers: {
            overlay: {
                closeClick: false
                } // prevents closing when clicking OUTSIDE fancybox
            }
        });

});


var mun = ''
$('input:checkbox.check:checked').each(function () {
    mun += $(this).closest('tr').find('td:eq(1)').text() + ', '
});
    $('#mun').val(mun);
    

$('#seleccionar_mun').click(function () {
    var c = $('input:checkbox.check:checked').length;
    if (c > 0) {
        var ids = '';
        var mu = ''
        $('input:checkbox.check:checked').each(function () {
            mu += $(this).closest('tr').find('td:eq(1)').text() + ', '
            ids += $(this).attr('id') + ','

        });
        
        mu = mu.substring(0, mu.length - 2);
        ids = ids.substring(0, ids.length - 1);
        $('#mun').val(mu);
        $("#municipio_ids").val(ids);
        $.fancybox.close();
        $('input:checkbox.check').prop('checked', false);
    }
});





$('button.send-proy').click(function (e) {
    e.preventDefault();

    var $url = '/gestion/send_proy';
    var data_send = new FormData($("#frm-proy-send")[0]);
    $.ajax({
        url: base_url($url),
        type: 'POST',
        cache: false,
        data: data_send,
        processData: false,
        contentType: false,
        dataType: "json"
    }).done(function (data) {
        if (data.success == 'ok') {
            swal(data.msg);
            location.reload();

        } else if (data.success == 'existe') {
            swal(data.msg);
        } else if (data.success == 'verif') {
            swal(data.msg);
        }
    });
    
});





});

$.extend({
    buscar: function (url, data_send, callbackFnk) {
        $.get(url, data_send, function (data) {
            if (typeof callbackFnk == 'function') {
                callbackFnk.call(this, data);
            }
        }, 'json').success(function () {
            $.please(2000);
        });
    }
});


$.extend({
    estructura_presupuestaria: function (url, callbackFnk) {
        $.get(url, function (data) {
            if (typeof callbackFnk == 'function') {
                callbackFnk.call(this, data);
            }
        }, 'json').success(function () {
            // $.please(2000);
        });
    }
});

$.fn.enterKey = function (fnc) {
    return this.each(function () {
        $(this).on('keypress', function (ev) {
            var keycode = (ev.keyCode ? ev.keyCode : ev.which);
            if (keycode == '13') {
                fnc.call(this, ev);
            }
        })
    })
}

Number.prototype.number_format = function (n, x, s, c) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
    num = this.toFixed(Math.max(0, ~~n));

    return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
};
