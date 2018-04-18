var carcular_edad = function (fecha) {
    var fechaActual = new Date();
    var diaActual = fechaActual.getDate();
    var mmActual = fechaActual.getMonth() + 1;
    var yyyyActual = fechaActual.getFullYear();
    var FechaNac = fecha.split("/");
    var diaCumple = FechaNac[0];
    var mmCumple = FechaNac[1];
    var yyyyCumple = FechaNac[2];

    if (mmCumple.substr(0, 1) == 0) {
        mmCumple = mmCumple.substring(1, 2);
    }

    if (diaCumple.substr(0, 1) == 0) {
        diaCumple = diaCumple.substring(1, 2);
    }
    var edad = yyyyActual - yyyyCumple;

    if ((mmActual < mmCumple) || (mmActual == mmCumple && diaActual < diaCumple)) {
        edad--;
    }
    return edad;
};

var validateSteps = function (stepnumber) {
    var isStepValid = true;
    if (stepnumber == 1) {
        var nombreAnimate = 'animated shake';
        var finanimated = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        if ($('#ci').val() == '') {
            isStepValid = false;
            bootbox.alert({
                size: 'small',
                closeButton: false,
                message: 'Debe ingresar la Cedula',
                callback: function (result) {
                    $('#ci').parent('div').addClass('has-error').addClass(nombreAnimate).one(finanimated,
                            function () {
                                $(this).removeClass(nombreAnimate);
                            });
                },
            });
            $(document).on('hidden.bs.modal', '.bootbox', function () {
                $('#ci').focus();
            });
        }
        return isStepValid;
    }
}

var leaveAStepCallback = function (obj, context) {
    return validateSteps(context.fromStep);
};

var onFinishCallback = function (obj, context) {
    $('#wizard').smartWizard('setError', {stepnum: 1, iserror: true});
    if (validateAllSteps()) {

        /*$('#nombres, #apellidos').prop('disabled', false);
         var accion = 'guardar';

         var fd = new FormData();

         var data_send = new FormData($("#frmresena")[0]);
         var $url = 'resena/' + accion;
         $.ajax({
         url: $url,
         type: 'POST',
         cache: false,
         data: data_send,
         processData: false,
         contentType: false,
         });*/
    }
}

var validateAllSteps = function () {
    var isStepValid = true;

    var nombreAnimate = 'animated shake';
    var finanimated = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
    if ($('#ci').val() == '') {
        isStepValid = false;
        bootbox.alert({
            size: 'small',
            closeButton: false,
            message: 'Debe ingresar la Cedula',
            callback: function (result) {
                $('#ci').parent('div').addClass('has-error').addClass(nombreAnimate).one(finanimated,
                        function () {
                            $(this).removeClass(nombreAnimate);
                        });
            },
        });
        $(document).on('hidden.bs.modal', '.bootbox', function () {
            $('#ci').focus();
        });
    }

    return isStepValid;
}
var setError = function (stepnumber) {
    $('#wizard').smartWizard('setError', {stepnum: stepnumber, iserror: true});
}

function showWizardMessage() {
    var myMessage = 'Hello this is my message';

    $('#wizard').smartWizard('showMessage', myMessage);
}
$(document).ready(function () {
    var Tabla = $('.tabla').DataTable({
        "bLengthChange": false,
        "iDisplayLength": 10,
        "iDisplayStart": 0,
        "order": [[0, "asc"]],
        "language": {"url": assets_url('js/es.json')},
        "aoColumns": [
            {"sClass": "right", "sWidth": "4%"},
            {"sWidth": "15%"},
            {"sWidth": "35%"},
            {"sWidth": "15%"},
            {"sWidth": "10%"},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
        ]
    });
    $('#ci').change(function () {
        $('#nombres, #apellidos').prop('disabled', 'disabled').val('');
        $.get('http://consultaelectoral.bva.org.ve/cedula=' + $(this).val(), function (data) {
            var nombres = data[0].p_nombre;
            nombres += data[0].s_nombre != '' ? ' ' + data[0].s_nombre : '';
            var apellidos = data[0].p_apellido;
            apellidos += data[0].s_apellido != '' ? ' ' + data[0].s_apellido : '';

            $('#nombres').val(nombres);
            $('#apellidos').val(apellidos);
        }).fail(function () {
            $('#nombres, #apellidos').prop('disabled', false);

        });
    });

    $(".foto").fileinput({
        overwriteInitial: true,
        maxFileSize: 1500,
        showClose: false,
        showCaption: false,
        showBrowse: false,
        browseOnZoneClick: true,
        removeLabel: '',
        removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
        removeTitle: 'Cancel or reset changes',
        elErrorContainer: '#kv-avatar-errors-2',
        msgErrorClass: 'alert alert-block alert-danger',
        defaultPreviewContent: '<img src="' + assets_url("images/default_avatar_male.jpg") + '" alt="Foto" style="width:160px"><h6 class="text-muted">Click para seleccionar</h6>',
        layoutTemplates: {main2: '{preview} {remove} {browse}'},
        allowedFileExtensions: ["jpg", "png", "gif"]
    });

    $('#wizard').smartWizard({
        labelNext: 'Siguiente',
        labelPrevious: 'Anterior',
        labelFinish: 'Guardar',
        onLeaveStep: function () {
            var nombreAnimate = 'animated shake';
            var finanimated = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
            if ($('#ci').val() == '') {
                bootbox.alert({
                    size: 'small',
                    closeButton: false,
                    message: 'Debe ingresar la Cedula',
                    callback: function (result) {
                        $('#ci').parent('div').addClass('has-error').addClass(nombreAnimate).one(finanimated,
                                function () {
                                    $(this).removeClass(nombreAnimate);
                                });
                    },
                });
                $(document).on('hidden.bs.modal', '.bootbox', function () {
                    $('#ci').focus();
                });
            } else if ($('#nombres').is(':disabled') == false && $('#nombres').val() == '') {
                bootbox.alert({
                    size: 'small',
                    closeButton: false,
                    message: 'Debe ingresar el nombre',
                    callback: function (result) {
                        $('#nombres').parent('div').addClass('has-error').addClass(nombreAnimate).one(finanimated,
                                function () {
                                    $(this).removeClass(nombreAnimate);
                                });
                    },
                });
                $(document).on('hidden.bs.modal', '.bootbox', function () {
                    $('#nombres').focus();
                });
            } else if ($('#apellidos').is(':disabled') == false && $('#apellidos').val() == '') {
                bootbox.alert({
                    size: 'small',
                    closeButton: false,
                    message: 'Debe ingresar el nombre',
                    callback: function (result) {
                        $('#apellidos').parent('div').addClass('has-error').addClass(nombreAnimate).one(finanimated,
                                function () {
                                    $(this).removeClass(nombreAnimate);
                                });
                    },
                });
                $(document).on('hidden.bs.modal', '.bootbox', function () {
                    $('#apellidos').focus();
                });
            } else if ($('#estado_civil').val() == 0) {
                bootbox.alert({
                    size: 'small',
                    closeButton: false,
                    message: 'Debe seleccionar el estado civil',
                    callback: function (result) {
                        $('#estado_civil').parent('div').addClass('has-error').addClass(nombreAnimate).one(finanimated,
                                function () {
                                    $(this).removeClass(nombreAnimate);
                                });
                    },
                });
            } else if ($('#funcionario').val() == 0) {
                bootbox.alert({
                    size: 'small',
                    closeButton: false,
                    message: 'Debe seleccionar el funcionario',
                    callback: function (result) {
                        $('#funcionario').parent('div').addClass('has-error').addClass(nombreAnimate).one(finanimated,
                                function () {
                                    $(this).removeClass(nombreAnimate);
                                });
                    },
                });
            } else if ($('#funcionario').val() == 0) {
                bootbox.alert({
                    size: 'small',
                    closeButton: false,
                    message: 'Debe ingresar la Cedula',
                    callback: function (result) {
                        $('#funcionario').parent('div').addClass('has-error').addClass(nombreAnimate).one(finanimated,
                                function () {
                                    $(this).removeClass(nombreAnimate);
                                });
                    },
                });
            } else if ($('#fecha_de_nacimiento').val() == '') {
                bootbox.alert({
                    size: 'small',
                    closeButton: false,
                    message: 'Debe ingresar la Fecha de Nacimiento',
                    onEscape: function () {
                        alert('fff');
                    },
                    callback: function (result) {
                        $('#fecha_de_nacimiento').parent('div').addClass('has-error').addClass(nombreAnimate).one(finanimated,
                                function () {
                                    $(this).removeClass(nombreAnimate);
                                });
                    },
                });
            } else {
                return true;
            }
        },
        onFinish: function (result) {
            $('#nombres, #apellidos').prop('disabled', false);
            if($("#accion").val() == ""){
                var accion = 'guardar';
            }else{
                var accion = 'modificar';
            }
            var fd = new FormData();

            var data_send = new FormData($("#frmresena")[0]);
            var $url = 'resena/' + accion;
            $.ajax({
                url: $url,
                type: 'POST',
                cache: false,
                data: data_send,
                processData: false,
                contentType: false,
                dataType: "json"
            }).done(function (data) {
                if (data.success == 'ok') {
                    bootbox.alert({
                        size: 'small',
                        closeButton: false,
                        message: data.msg,
                        callback: function (result) {
                            location.reload();
                        }
                    });
                } else {
                    bootbox.alert({
                        size: 'small',
                        closeButton: false,
                        message: data.msg,
                        callback: function (result) {
                            $('#wizard').smartWizard('setError', {stepnum: 1, iserror: true});
                        }

                    });
                    $(document).on('hidden.bs.modal', '.bootbox', function () {
                        $('#ci').focus().select();
                    });
                }
            })
                    .fail(function (data) {
                        //console.log(data);
                        /* bootbox.alert({
                         size:'small',
                         closeButton :false,
                         message: data.msg,
                         callback: function(result){
                         $('#wizard').smartWizard('setError',{stepnum:1,iserror:true});
                         }

                         });*/
                        $(document).on('hidden.bs.modal', '.bootbox', function () {
                            $('#ci').focus().select();
                        });
                    });

            /*$.guardar($url, data_send, accion, function (data) {
             if(data.success=='ok'){
             bootbox.alert({
             size:'small',
             closeButton :false,
             message: data.msg,
             callback: function(result){
             location.reload();
             }
             });
             }else{
             bootbox.alert({
             size:'small',
             closeButton :false,
             message: data.msg,
             callback: function(result){
             $('#wizard').smartWizard('setError',{stepnum:1,iserror:true});
             }

             });
             $(document).on('hidden.bs.modal','.bootbox', function () {
             $('#ci').focus().select();
             });
             }
             });*/
        }
    });

    $('.buttonNext').addClass('btn btn-success');
    $('.buttonPrevious').addClass('btn btn-primary');
    $('.buttonFinish').addClass('btn btn-default');

    $('.modificar').tooltip({
        html: true,
        placement: 'top',
        title: 'Modificar'
    });

    $('.eliminar').tooltip({
        html: true,
        placement: 'top',
        title: 'Eliminar'
    });

    $('#fecha_de_nacimiento').datepicker({
        language: "es",
        format: 'dd/mm/yyyy',
        startDate: '-110y',
        endDate: '-11y',
        autoclose: true,
        clearBtn: true,
        orientation: "top auto"
    }).
            on('changeDate', function (ev) {
                var edad = calcular_edad($(this).val());
                $('#edad').val(edad);
            })

    $('.tabla').on('click', 'img.modificar', function () {
        var id = $(this).closest('tr').attr('id');

        $.get(base_url('registro/estacion/buscar'), {id: id}, function (data, textStatus, xhr) {
            $('#id').val(id);
            $('#estacion').val(data.estacion);
            $('#guardar').attr('data-accion', 'modificar').val('Modificar');
        }, 'json');
    });


    $('.tabla').on('click', 'img.eliminar', function () {
        var id = $(this).closest('tr').attr('id');

        bootbox.confirm({
            size: 'small',
            closeButton: false,
            message: '<div style="text-align: center" class="text-danger">¿Desea eliminar el registro?</div>',
            callback: function (result) {
                if (result) {
                    $.get(base_url('registro/estacion/eliminar'), {id: id}, function (data, textStatus, xhr) {
                        if (data.success == 'ok') {
                            bootbox.alert({
                                size: 'small',
                                closeButton: false,
                                message: data.msg,
                                callback: function (result) {
                                    location.reload();
                                }
                            });
                        }
                    }, 'json');
                } else {
                    $('#cancelar').trigger('click');
                }
            }
        });
    });

    $('.tabla').on('click', 'img.modificar', function () {
        var id = $(this).closest('tr').attr('id');
        $.get(base_url('registro/resena/buscar'), {id: id}, function (data, textStatus, xhr) {
            $.each(data, function (i, valor) {
                var tipo = $('#' + i).prop('tagName');
                if (tipo !== undefined) {
                    if (tipo.toLowerCase() == 'input') {
                        $('#' + i).val(valor);
                    } else if (tipo.toLowerCase() == 'select') {
                        $('#' + i).select2('val', valor);
                    }else if (tipo.toLowerCase() == 'textarea') {
                        $('#' + i).val(valor);
                    }
                } else {
                    if (valor == 'f') {
                        $("#fallecidos").select2('val', '0');
                    }else{
                        $("#fallecidos").select2('val', '1');
                    }

                }
            });
            var fecha_de_nacimiento = data.fecha_de_nacimiento.split('-');
            var fecha_de_nacimiento = fecha_de_nacimiento[2]+"/"+fecha_de_nacimiento[1]+"/"+fecha_de_nacimiento[0];
            $("#fecha_de_nacimiento").val(fecha_de_nacimiento);
            var edad = calcular_edad(fecha_de_nacimiento);
            $('#edad').val(edad);
           // $('#guardar').attr('data-accion', 'modificar').val('Modificar');
           $("#accion").val(1);
        }, 'json');
    });

    $('.pdf_resena').click(function(event) {
        var cedula = $(this).attr('id');
        var url = base_url('reportes/reporte/resena?ci='+cedula);
        window.open(url)
    });
    $('#cancelar').click(function () {
        var $count = Tabla.rows().data().length;
        $('#id').val($count + 1);
        $('#estacion').val('');
        $('#guardar').attr('data-accion', 'guardar').val('Guardar');
    });
});