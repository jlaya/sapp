$(document).ready(function () {

    // Imputacion financiera

    var table = $('.table-gestion-financiera').DataTable({
            "pageLength": 50,
            "iDisplayLength": 10,
            "iDisplayStart": 0,
            "sPaginationType": "full_numbers",
            "aLengthMenu": [25, 50, 75, 100],
            "oLanguage": {"sUrl": assets_url('assets/js/es.txt')},
            "order": [[1, "desc"]],
        });

        var $url = base_url("/acciones/proyecto/ControllersProyecto/search");
        var $url_e = base_url("/acciones/proyecto/ControllersProyecto/list_estructura");
        var value = $("#accion_id").val();
        $.buscar($url, {id: value, acc: 1}, function (data, textStatus, xhr) {
            // Ejecucion financiera de Acciones
            $.each(data.financiero_acc, function (i, o) {
                var $count = table.rows().data().length;
                // alert($count);
                var $ind = o.indice;
                var add_row = '<span title="Guadar" class="btn btn-info glyphicon glyphicon-floppy-saved add-row"></span>';
                var remove_row = '<span title="Eliminar" class="btn btn-danger glyphicon glyphicon-trash delete-row"></span>';
                var partida = "<select style='width:100%' id='estructura_" + $ind + "' class='data-estructura' class='form-control'><option value='0'>Seleccione</option></select>";
                table.row.add([partida, o.compromiso, add_row+"&nbsp;"+remove_row]).draw(false)
                var $row = table.row($count).nodes().to$();
                table.row($count).nodes().to$().attr({'id': o.id, 'data-id': o.id, 'param-name': 'update-row'});
                $row.find('td:eq(1)').attr({
                    'id': 'compromiso',
                    'title': 'Proporciona a las empresas información a tiempo sobre el flujo de caja anticipado y los modelos de gastos. Cuando se registran las órdenes de compra como compromisos en relación a un presupuesto.'
                }).addClass('data-element-financiero');

                var $count = table.rows().data().length;

                var option = "";
                $.estructura_presupuestaria($url_e, function (data, textStatus, xhr) {

                    $.each(data.estructura, function (i, item) {
                        option += '<option value="' + item.id + '">(' + item.partida + ') ' + item.descripcion + '</option>';
                    });

                    $("#estructura_" + $ind).append(option)
                    $("#estructura_"+$ind).val(o.partida_id);
                });
            });
        });


        $('span.add-plus').on('click', function () {
            var $url = base_url("/gestion/estructura");
            var $ind = $("#last_id").val();
            var partida = "<select style='width:100%' id='estructura_" + $ind + "' class='data-estructura' class='form-control'><option value='0'>Seleccione</option></select>";
            var add_row = '<span title="Guadar" class="btn btn-info glyphicon glyphicon-floppy-saved add-row"></span>';
            var remove_row = '<span title="Eliminar" class="btn btn-danger glyphicon glyphicon-trash delete-row"></span>';
            var $count = table.rows().data().length;
            var id = 0;

            $.estructura_presupuestaria($url, function (data, textStatus, xhr) {
                $.each(data.estructura, function (i, item) {
                    $("select.data-estructura").append('<option value="' + item.id + '">(' + item.partida + ') ' + item.descripcion + '</option>');
                });
            });

            table.row.add([partida, 0.00, add_row+"&nbsp;"+remove_row]).draw(false)
            var $row = table.row($count).nodes().to$();
            table.row($count).nodes().to$().attr({'id': $count + 1, 'data-id': $count + 1, 'param-name': 'new-row'});
            $row.find('td:eq(1)').attr({
                'id': 'compromiso',
                'title': 'Proporciona a las empresas información a tiempo sobre el flujo de caja anticipado y los modelos de gastos. Cuando se registran las órdenes de compra como compromisos en relación a un presupuesto.'
            }).addClass('data-element-financiero');
        });

        $('.table-gestion-financiera tbody').on('click', 'span.add-row', function () {
            var $cl_td = $(this).closest('td');
            var $cl_tr = $(this).closest('tr');
            var id_col = $cl_td.attr('id');
            var ind_col = $cl_td.index();
            var last_id = $.search_id("/acciones/proyecto/ControllersProyecto/last_id", "ejecucion_financiera_acc");
            var id_row = $cl_tr.attr('id');
            var $param_name = $(this).closest('tr').attr('param-name');

            var datos = {};
            if($param_name == "new-row"){
                $param_name = $(this).closest('tr').attr('param-name', 'param-modifify');
                datos['id'] = 0;
                indice = last_id;
                $cl_tr.attr('id', last_id);
            }else if($param_name == "update-row" || $param_name == "param-modifify"){
                datos['id'] = id_row;
                indice = id_row;
            }
            datos['accion_id'] = $("#accion_id").val();
            datos['partida_id'] = $cl_tr.find('td').find('.data-estructura').find('option').filter(':selected').val();
                        
            datos['indice'] = indice;
            
            $cl_tr.find("td:not(:eq(ind_col)).data-element-financiero").each(function () {
                datos[$(this).attr('id')] = $(this).text();
            })
            var valor = $(this).val();
            datos[id_col] = valor

            var compromiso = parseFloat($cl_tr.find('td').eq(1).text());

            if (parseInt(compromiso) == "" || String(compromiso) == "NaN") {
                bandera = false;
            } else {
                bandera = true;
            }

            if (bandera == true) {
                $.post(base_url('/acciones/proyecto/ControllersProyecto/updateActionFAcc'), datos, function (response) {
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
                new PNotify({
                    title: 'Gestión de Control',
                    text: 'El campo <b>monto</b> no puede estar vacio...',
                    type: 'error',
                });
            }
        });

        $('.table-gestion-financiera tbody').on('click', 'span.delete-row', function () {
            var $url = base_url("/acciones/proyecto/ControllersProyecto/deleteActionFAcc");
            var $id   = $(this).closest('tr').attr('id');
            var $param_name = $(this).closest('tr').attr('param-name');
            var $this = $(this);

            if($param_name == "new-row"){

                table
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
                        table
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

                var $input = '<input class="form-control" style="width: 110%;text-align: right;" autofocus type="text" id="change_value_financiero" value="' + valor + '">'
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
                datos['accion_id'] = $("#accion_id").val();
                datos['partida_id'] = $cl_tr.find('td').find('.data-estructura').find('option').filter(':selected').val();
                datos['indice'] = id_row;

                $cl_tr.find("td:not(:eq(ind_col)).data-element-financiero").each(function () {
                    datos[$(this).attr('id')] = $(this).text();
                })
                var valor = $(this).val();
                datos[id_col] = valor
                $cl_tr.find('td').eq(ind_col).text(valor);

                var compromiso = parseFloat($cl_tr.find('td').eq(1).text());

                if (parseInt(compromiso) == "" || String(compromiso) == "NaN") {
                    bandera = false;
                } else {
                    bandera = true;
                }

                if (bandera == true) {
                    $.post(base_url('/acciones/proyecto/ControllersProyecto/updateActionFAcc'), datos, function (response) {
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
                    new PNotify({
                        title: 'Gestión de Control',
                        text: 'El campo <b>monto</b> no puede estar vacio...',
                        type: 'error',
                    });
                }
            }
        }

    }, '#change_value_financiero');

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

